<?php
require('include/gatekeeper.php');

$_SESSION['urlselected'] = 'envelops';
require('../header.php');

#require_once("../lib/func.customer.packages.php");
require_once("../lib/func.envelop.php");


if(!checkPermission($_SESSION['admin_id'] , 'view_envelops', 'admin'))
{ 
    $errmsg = base64_encode('You are not allowed to view that Page');
    echo "<script> window.location = '../index.php?errmsg=$errmsg';</script>";
    exit;
 
} 
    
     
	 $customerFilter = "";
?>
<script type="text/javascript">
  /* <-- to do --> */
</script>
 
 
<!-- that's IT-->	 
<div id="main-content"> <!-- Main Content Section with everything --> 
<?php 	
 if(isset($_GET['okmsg']))
{
?>
   <div class="notification success png_bg">
				<a href="#" class="close"><img src="<?php echo siteURL?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div><?php echo base64_decode($_GET['okmsg']);?></div>
			</div>

<?php			
	}
		
	if(isset($_GET['errmsg']))
		{
?>
  		  <div class="notification error png_bg">
			 <a href="#" class="close"><img src="<?php echo siteURL?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>					<?php echo base64_decode($_GET['errmsg']);?>				</div>
			</div>

<?php			
		}
		
		$tab_show_class='default-tab';
		$show_my_tab= "";
		if(isset($_REQUEST['customer']))
		{
			$tab_show_class='';	  
			$show_my_tab= "default-tab";
			//echo ""
			$customer=$_REQUEST['select_customer'];
		}
?>
	
			<div class="content-box"><!-- Start Content Box --> 
				
				<div class="content-box-header">
					<h3>Card Envelops</h3>
					<ul class="content-box-tabs">
						<li> <a href="#tab1" class="<?php echo $tab_show_class;?>">Listing </a> </li> <!-- href must be unique and match the id of target div -->
						<?php
                                                  if(checkPermission($_SESSION['admin_id'] , 'add_envelops', 'admin'))
                                                       echo "<li><a href='#tab2' >Add New</a></li>";
                                                ?>
						<!-- Customer Search tab -->
						<!-- <li><a href="#tab3" class="< ?php echo $show_my_tab;?>">Search</a></li> -->
					</ul>
					<div class="clear:both"></div>
				</div> <!-- End .content-box-header -->

				<div class="content-box-content">
					<div class="tab-content <?php echo $tab_show_class;?>" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
					 
                        
                                        <table>
                                                <thead>
                                                    <tr bgcolor="#CCFFCC">
                                                       <!--<th><input class="check-all" type="checkbox" /></th>-->

                                                       <th><b>S.No</b>	</th>
                                                       <th><b>Envelop Name</b>	</th>
                                                       <th><b>Preview</b></th>
                                                       <th><b>Price per Card</b></th>
                                                       <th><b>Extra Envelop Price</b></th>
                                                      
                                                       <th><b>Action</b></th>
                                                    </tr>
                                                 </thead>
			
							<?php
							 	$envelopSet = getEnvelops_info();	// filter is being initialized on top of page and bein updated in filter part
								
								$i = 1;
								while($row = mysql_fetch_array($envelopSet))
								{
									
							 ?>
								<tr>
									<!--<td><input type="checkbox" name="customer_id[]" value="< ?php //echo $supply['supplier_id']?>"/></td>-->
									 
									<td><?php echo $i ?></td>
									<td><?php echo $row['envelop_title']; ?> </td>
                                                                                  
                                                                        <td><?php echo "<img src='../../uploads/card_envelops/".$row['envelop_picture']."' width='100px' style='border:1px solid #ccc'>"; ?></td>
									<td><?php if($row['envelop_price_per_card'] == ''|| $row['envelop_price_per_card'] == '0'||$row['envelop_price_per_card'] == '0.00')
                                                                                        echo 'FREE';
                                                                                  else
                                                                                        echo '$ '.$row['envelop_price_per_card']; ?> </td>

                                                                        <td><?php if($row['extra_envelop_price'] == ''|| $row['extra_envelop_price'] == '0'||$row['extra_envelop_price'] == '0.00')
                                                                                        echo 'FREE';
                                                                                  else
                                                                                        echo '$ '.$row['extra_envelop_price']; ?> </td>
									<td><?php
                                                                            if(checkPermission($_SESSION['admin_id'] , 'update_envelops', 'admin'))
                                                                                echo "<a href='edit.php?envelop_id=".$row['envelop_id']."' title='Edit'><img src='".siteURL."admin/resources/images/icons/pencil.png' alt='Edit' /></a>";
                                                                            if(checkPermission($_SESSION['admin_id'] , 'delete_envelops', 'admin'))
                                                                                echo "&nbsp;&nbsp;&nbsp;<a href='do_delete.php?envelop_id=".$row['envelop_id']."' title='Delete'  onclick=\"return confirm('Are you sure to delete?')\"><img src='".siteURL."admin/resources/images/icons/cross.png' alt='Delete' /></a>";
                                                                            ?>
                              
                                                                      </td>
 								</tr>
							 
                            <?php			
									 
									$i++;
								}
							?>
					</table>
		

<!--						</form> -->
					</div> <!-- End #tab1 -->
					
					<div class="tab-content" id="tab2">
                                            <h3 style="height:38px; padding:8px 0px 0px 52px;   background-repeat: no-repeat; background-position:left top;background-image:url(<?php echo siteURL?>admin/resources/images/icons/envelop_small.png)"> Add New Envelop </h3>

                                           <form action="do_add.php" method="post" name="manage_account" id="myform" enctype="multipart/form-data" >
                                                        
                                              <table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
                                                  <tr>
                                                         <td style="padding:4px">Envelop Name</td>
                                                         <td style="padding:4px"> <input class="text-input small-input required" type="text" id="txtField" name="title"   /></td>
                                                  </tr>

                                                  <tr>
                                                    <td style="padding:4px">Select Envelop Preview Picture</td>
                                                    <td style="padding:4px"><input class="text-input small-input required" type="file" id="txtField" name="picture"  /></td>
                                                  </tr>
                                                  <tr>
                                                         <td style="padding:4px">Envelop Price per Card</td>
                                                         <td style="padding:4px"> $ <input class="text-input small-input required" type="text" id="txtField" name="envelop_price_per_card" style="width:120px !important"  /> <span style="color:#666; font-size:10px">(Enter '0' to give this envelop free with card)</span></td>
                                                  </tr>
                                                  <tr>
                                                         <td style="padding:4px">Extra Envelop Price</td>
                                                         <td style="padding:4px"> $ <input class="text-input small-input required" type="text" id="txtField" name="extra_envelop_price"  style="width:120px !important" /> <span style="color:#666; font-size:10px">(If customer need extra envelops along then its unit price. Enter '0' to give free unlimited extra envelops)</span></td>
                                                  </tr>
    
                                                  <tr><td></td> <td>&nbsp;<br /><input class="button" type="submit" value="Submit" /></td></tr>
                                                </table>

                                          <!-- End .clear -->
                                            </form>
						
					</div> <!-- End #tab2 -->        
					
					<!-- #tab 3> -->
					<div class="tab-content <?php echo $show_my_tab;?>" id="tab3">
						<!-- ===================== Dummy Block =================== -->
					</div>	
				
					
					<!-- End of tab 3 -->
					
					
					
					
					
					
					
					
					
					
					
					
				</div> <!-- End .content-box-content -->
				
			</div> <!-- End .content-box -->
			<!-- End .content-box -->
			<!-- End .content-box -->
<div class="clear"></div>
			
			
			<!-- Start Notifications -->
			<!-- End Notifications -->
<div id="footer">
				<small> <!-- Remove this notice or replace it with whatever you want -->
		</small>		</div>
<!-- End #footer -->
			
	  </div> <!-- End #main-content -->
		
	</div></body>
  

<!-- Download From www.exet.tk-->
</html>

