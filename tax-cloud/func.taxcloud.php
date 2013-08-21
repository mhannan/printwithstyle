<?php
require("classes.php");
$client = new SoapClient("https://api.taxcloud.net/1.0/TaxCloud.asmx?wsdl");

/**
 * TaxCloud code examples
 *
 * The basic process is:
 *
 * 1. Verify your store's address as well as the customer's shipping address through the address verification service
 *
 * 2. Call the lookup service to look up the tax amount for each item in the cart
 *
 * 3. When the customer completes the transaction call the authorized and capture web service to complete the transaction
 *
 * This code assumes that you have already set up a Merchant account at www.TaxCloud.net
 */

/**
 * Verify an address using TaxCloud service. Addresses need to be verified through this service
 * before they are used for other web service calls since they require the complete 9 digit zip code
 * to look up the tax accurately. 
 *
 * @param $address
 * @param $err
 */
function func_taxcloud_verify_address($address, &$err) {

	global $client;

	// Verify the address through the TaxCloud verify address service
	$params = array( "uspsUserID" => TAXCLOUD_USPS_ID,
				 "address1" => $address->getAddress1(),
				 "address2" => $address->getAddress2(),
				 "city" => $address->getCity(),
				 "state" => $address->getState(),
				 "zip5" => $address->getZip5(),
				 "zip4" => $address->getZip4());

	try {

		$verifyaddressresponse = $client->verifyAddress( $params );

	} catch (Exception $e) {

		//retry in case of timeout
		try {
			$verifyaddressresponse = $client->verifyAddress( $params );
		} catch (Exception $e) {

			$err[] = "Error encountered while verifying address ".$address->getAddress1().
			" ".$address->getState()." ".$address->getCity()." "." ".$address->getZip5().
			" ".$e->getMessage();
			//irreparable, return
			return null;
		}
	}

	if($verifyaddressresponse->{'VerifyAddressResult'}->ErrNumber == 0) {
		// Use the verified address values
		$address->setAddress1($verifyaddressresponse->{'VerifyAddressResult'}->Address1);
		$address->setAddress2($verifyaddressresponse->{'VerifyAddressResult'}->Address2);
		$address->setCity($verifyaddressresponse->{'VerifyAddressResult'}->City);
		$address->setState($verifyaddressresponse->{'VerifyAddressResult'}->State);
		$address->setZip5($verifyaddressresponse->{'VerifyAddressResult'}->Zip5);
		$address->setZip4($verifyaddressresponse->{'VerifyAddressResult'}->Zip4);

	} else {

		$err[] = "Error encountered while verifying address ".$address->getAddress1().
			" ".$address->getState()." ".$address->getCity()." "." ".$address->getZip5().
			" ".$verifyaddressresponse->{'VerifyAddressResult'}->ErrDescription;

		return null;
	}
	return $address;
}


/**
 * Retrieves a product's TIC ID.
 * @param $product_id
 */
function func_taxcloud_get_tic($product_id) {
	global $db;

	// Note - this is just an example. The TIC IDs will have to be maintained somehow for each product in the catalog, or for each product category
	// TIC IDs can be looked up at www.TaxCloud.net/tic

	$query = "select tax_class_description from ".TABLE_PRODUCTS .", ".TABLE_TAX_CLASS." where products_tax_class_id = tax_class_id and products_id = ".$product_id;
	$result = $db->Execute($query);
	$tic = $result->fields['tax_class_description'];
	$i = preg_match("/^(\d+)/", $tic);
	if($i != 0)
		return $tic;
	else
		return $i;
}

/**
 * Look up tax using TaxCloud web services
 * @param $product
 * @param $origin
 * @param $destination
 * @param $shipping
 * @param $errMsg
 */
function func_taxcloud_lookup_tax($customerID, $products, $origin, $destination, $shipping, &$errMsg) {
	global $client;

	if(is_null($origin)) return -1;


	// These address checks are sometimes needed to ensure that the user has logged in. This may not be necessary for your cart.
	if(is_null($destination)) return -1;  

	if(!is_null($origin) && !is_null($destination)) {

		$cartItems = Array();

		$index = 0;


		foreach ($products as $k => $product) {

			$cartItem = new CartItem();

			$cartItem->setItemID($product['productid']); //change this to how your cart stores the product ID
			$cartItem->setIndex($index); // Each cart item must have a unique index

			$tic = $product['tic']; //func_taxcloud_get_tic($match[0]);
			if(!$tic) {
				//no TIC has been assigned to this product, use default
				$tic = "00000";
			}

			$cartItem->setTIC("00000");

			$price = $product['price']; // change this to how your cart stores the price for the product

			$cartItem->setPrice($price); // Price of each item
			$cartItem->setQty($product['qty']); // Quantity - change this to how your cart stores the quantity

			$cartItems[$index] = $cartItem;

			$index++;

		}

		//Shipping as a cart item - shipping needs to be taxed
		$cartItem = new CartItem();
		$cartItem->setItemID('shipping');
		$cartItem->setIndex($index);
		$cartItem->setTIC("11010");
		$cartItem->setPrice($shipping);  // The shipping cost from your cart
		$cartItem->setQty(1);
		$cartItems[$index] = $cartItem;

		// Here we are loading a stored exemption certificate. You will probably want to allow the user to select from a list
		// of stored exemption certificates and pass that certificate into this method. 
		//$exemptCert = func_taxcloud_get_exemption_certificates($customerID);

		$params = array( "apiLoginID" => TAXCLOUD_API_ID,
				 "apiKey" => TAXCLOUD_API_KEY,
				 "customerID" => $customerID,
				 "cartID" => $_SESSION['session_id'],
				 "cartItems" => $cartItems,
				 "origin" => $origin,
				 "destination" => $destination,
				 "deliveredBySeller" => FALSE
		);
		
                
                //var_dump($params);

		//Call the TaxCloud web service
		try {

			$lookupResponse = $client->lookup( $params );

		} catch (Exception $e) {

			//retry
			try {
				$lookupResponse = $client->lookup( $params );
			} catch (Exception $e) {

				$errMsg[] = "Try - 1: Error encountered looking up exemption certificates ".$e->getMessage();

				//irreparable, return
				//Handle the error appropriately 
				//return -1;
			}
		}
                
                //var_dump($lookupResponse);

		$lookupResult = $lookupResponse->{'LookupResult'};
                
                //var_dump($lookupResult);

		if($lookupResult->ResponseType == 'OK' || $lookupResult->ResponseType == 'Informational') {
			$cartItemsResponse = $lookupResult->{'CartItemsResponse'};
			$cartItemResponse = $cartItemsResponse->{'CartItemResponse'};
			$taxes = Array();
			$index = 0;

			//response may be an array
			if ( is_array($cartItemResponse) ) {
				foreach ($cartItemResponse as $c) {
					$amount = ($c->TaxAmount);
					$taxes[$index] = $amount;
					$index++;
				}
			} else {
				$amount = ($cartItemResponse->TaxAmount);
				$taxes[0] = $amount;
			}
			
			// Here you will need to determine what to do with the results. Usually you would return
			// the tax array and assign the tax amount to each item in the cart and then recalculate 
			// the totals. Here we are just returning the total tax amount.

			return array_sum($taxes);

		} else {
			$errMsgs = $lookupResult->{'Messages'};
                        //var_dump($errMsgs);
			foreach($errMsgs as $err) {
				$errMsg[] = "Try 2: Error encountered looking up tax amount ".$err->{'Message'};
			}
			
			//Handle the error appropriately 
		}
	} else {

		return -1;
	}
}

/**
 * Authorized with Capture
 * This represents the combination of the Authorized and Captured process in one step. You can 
 * also make these calls separately if you use a two stepped commit. 
 * @param $orderID
 * @param $errMsg
 */

function func_taxcloud_authorized_with_capture($orderID, &$errMsg) {
	global $client;

	$result = 0;

	$dup = "This purchase has already been marked as authorized";

	// Current date - example of format: '2010-09-08T00:00:00';
	$dateAuthorized = date("Y-m-d");
	$dateAuthorized = $dateAuthorized . "T00:00:00";

	$params = array( "apiLoginID" => TAXCLOUD_API_ID,
					 "apiKey" => TAXCLOUD_API_KEY,
					 "customerID" => 10,
					 "cartID" => 2,
					 "orderID" => $orderID,
					 "dateAuthorized" => $dateAuthorized,
					 "dateCaptured" => $dateAuthorized);

	// The authorizedResponse array contains the response verification (Error, OK, ...)
	$authorizedResponse = null;
	try {
		$authorizedResponse = $client->authorizedWithCapture( $params );
	} catch (Exception $e) {

		//infrastructure error, try again
		try {
			$authorizedResponse = $client->authorizedWithCapture( $params );

			$authorizedResult = $authorizedResponse->{'AuthorizedWithCaptureResult'};
			if ($authorizedResult->ResponseType != 'OK') {
				$msgs = $authorizedResult->{'Messages'};
				$respMsg = $msgs->{'ResponseMessage'};

				//duplicate means the the previous call was good. Therefore, consider this to be good
				if (trim ($respMsg->Message) == $dup) {
					return 1;
				}
			} else if ($authorizedResult->ResponseType == 'Error') {
				$msgs = $authorizedResult->{'Messages'};
				$respMsg = $msgs->{'ResponseMessage'};
				//duplicate means the the previous call was good. Therefore, consider this to be good
				if (trim ($respMsg->Message) == $dup) {
					return 1;
				} else {
					$errMsg[] = "Error encountered looking up tax amount ".$respMsg;
					return -1;
				}
			} else {
				return -1;
			}

		} catch (Exception $e) {
			//give up
			$errMsg[] = $e->getMessage();
			
			// Handle this error appropriately
			return 0;
		}
	}

	$authorizedResult = $authorizedResponse->{'AuthorizedWithCaptureResult'};
	if ($authorizedResult->ResponseType == 'OK') {
		return 1;
	} else {
		$msgs = $authorizedResult->{'Messages'};
		$respMsg = $msgs->{'ResponseMessage'};

		$errMsg [] = $respMsg->Message;
		
		// Handle this error appropriately
		
		return 0;
	}

	return $result;
}


function func_taxcloud_capture($orderID, &$errMsg) {
	global $client;

	$result = 0;

	$dup = "This purchase has already been marked as authorized";

	// Current date - example of format: '2010-09-08T00:00:00';
	$dateAuthorized = date("Y-m-d");
	$dateAuthorized = $dateAuthorized . "T00:00:00";

	$params = array( "apiLoginID" => TAXCLOUD_API_ID,
					 "apiKey" => TAXCLOUD_API_KEY,
					 "orderID" => $orderID,
					 );

	// The authorizedResponse array contains the response verification (Error, OK, ...)
	$authorizedResponse = null;
	try {
		$authorizedResponse = $client->Captured( $params );
	} catch (Exception $e) {

		//infrastructure error, try again
		try {
			$authorizedResponse = $client->authorizedWithCapture( $params );

			$authorizedResult = $authorizedResponse->{'AuthorizedWithCaptureResult'};
			if ($authorizedResult->ResponseType != 'OK') {
				$msgs = $authorizedResult->{'Messages'};
				$respMsg = $msgs->{'ResponseMessage'};

				//duplicate means the the previous call was good. Therefore, consider this to be good
				if (trim ($respMsg->Message) == $dup) {
					return 1;
				}
			} else if ($authorizedResult->ResponseType == 'Error') {
				$msgs = $authorizedResult->{'Messages'};
				$respMsg = $msgs->{'ResponseMessage'};
				//duplicate means the the previous call was good. Therefore, consider this to be good
				if (trim ($respMsg->Message) == $dup) {
					return 1;
				} else {
					$errMsg[] = "Error encountered looking up tax amount ".$respMsg;
					return -1;
				}
			} else {
				return -1;
			}

		} catch (Exception $e) {
			//give up
			$errMsg[] = $e->getMessage();
			
			// Handle this error appropriately
			return 0;
		}
	}

	$authorizedResult = $authorizedResponse->{'AuthorizedWithCaptureResult'};
	if ($authorizedResult->ResponseType == 'OK') {
		return 1;
	} else {
		$msgs = $authorizedResult->{'Messages'};
		$respMsg = $msgs->{'ResponseMessage'};

		$errMsg [] = $respMsg->Message;
		
		// Handle this error appropriately
		
		return 0;
	}

	return $result;
}

/**
 * func_taxcloud_add_exemption_certificate
 *
 * Added a completed exemption certificate to the customer's list for this store
 * @param $exemptionCertificate
 * @param $customerID
 */
function func_taxcloud_add_exemption_certificate($exemptionCertificate,$customerID) {
	global $client;
	
	$params = array( "apiLoginID" => TAXCLOUD_API_ID,
					 "apiKey" => TAXCLOUD_API_KEY,
					 "customerID" => $customerID,
				 	 "exemptCert" => $exemptionCertificate 
				 	 );
	
	try {
		$addExemptionResponse = $client->addExemptCertificate( $params );

	} catch (Exception $e) {
		// Handle this error appropriately
		return -1;
	}

}

/**
 * func_taxcloud_get_exemption_certificates
 *
 * Get a list of exemption certificates for the given customer. 
 * This list contains blanket and single use certificates. Normally you would only display blanket certificates to the users.
 * @param $customerID
 */
function func_taxcloud_get_exemption_certificates($customerID) {
	global $client;
	
	$params = array( "apiLoginID" => TAXCLOUD_API_ID,
					 "apiKey" => TAXCLOUD_API_KEY,
					 "customerID" => $customerID
				 	 );
		
	try {
		$getExemptCertificatesResponse = $client->getExemptCertificates( $params );
		$getCertificatesRsp = $getExemptCertificatesResponse->{'GetExemptCertificatesResult'};
		$exemptCertificatesArray = $getCertificatesRsp->{'ExemptCertificates'};
                if ( isset($exemptCertificatesArray->{'ExemptionCertificate'})) {
                    $exemptCertificates = $exemptCertificatesArray->{'ExemptionCertificate'};
                }
		
		if (isset($exemptCertificates) && is_array($exemptCertificates)) {
			return $exemptCertificates;
		} else {
			return $exemptCertificatesArray;
		}
		
	} catch (Exception $e) {
		return Array();
	}
	return Array();
}

/**
 * func_taxcloud_delete_exemption_certificate
 *
 * Delete a stored exemption certificate for a customer.
 * @param $certificateID
 */
function func_taxcloud_delete_exemption_certificate($certID) {
	
	global $client;
	
	$params = array( 
	 	"apiLoginID" => TAXCLOUD_API_ID,
		"apiKey" => TAXCLOUD_API_KEY,
		"certificateID" => $certID
	);
	
	try {
		$deleteExemptCertificateResponse = $client->deleteExemptCertificate( $params );

	} catch (Exception $e) {
		return -1;
	}
}

/** 
 * An example of returning an order. This method assumes that the order can be retrieved using the 
 * query below. This will likely have to be modified to work with your sortware. 
 * 
 * It is possible to return individual items in an order. In that case you would pass in just the items
 * to be returned and not all the items as in this example.
 *
 */
function func_taxcloud_return_order($order_id) {   

	global $client;
	
	global $db;
	
	$results = $db->Execute("select products_id, products_quantity, final_price
	                             from " . TABLE_ORDERS_PRODUCTS . "
                             where orders_id = '" . (int)$order_id . "'");
        
	$cartItems = Array();

	$index = 0;
        
        while ( !$results->EOF ) {
        	$fields = $results->fields;
      		
      		$cartItem = new CartItem();
		$cartItem->setItemID($fields['products_id']);
		$cartItem->setIndex($index);
		$cartItem->setTIC(func_taxcloud_get_tic($fields['products_id']));  
		$cartItem->setPrice($fields['final_price']);
		$cartItem->setQty($fields['products_quantity']);
		$cartItems[$index] = $cartItem;
      		
      		$index++;
      		$results->MoveNext();
      		
        }
        
	$returnDate = date("Y-m-d");
	$returnDate = $returnDate . "T00:00:00";
	
	$params = array(
		"apiLoginID" => TAXCLOUD_API_ID,
		"apiKey" => TAXCLOUD_API_KEY,
		"orderID" => $order_id,
		"cartItems" => $cartItems,
		"returnedDate" => $returnDate); 
	
	try {
		$client = func_taxcloud_get_client();
		$returnResponse = $client->Returned($params);	
	} catch (Exception $e) { 
		return -1;
	}

}

?>