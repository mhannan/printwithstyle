// JavaScript Document

function trim(s){
var str = document.getElementById(s).value;
// return str.replace(/^[\s]+/,'').replace(/[\s]+$/,'').replace(/[\s]{2,}/,' ');
return str.replace(/^\s+|\s+$/g,"");
}

function validate_admin(){
	var flag = true;
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	var email = document.getElementById('email').value;
	
	if (trim('fullname') == ""){
		document.getElementById('fullname').style.border = "1px solid red";
		flag = false;
	}else{
		document.getElementById('fullname').style.border = "1px solid #D5D5D5";
	}
	
	if (reg.test(email) == false){
		document.getElementById('email').style.border = "1px solid red";
		flag = false;
	}else{
		document.getElementById('email').style.border = "1px solid #D5D5D5";
	}
	
	if (document.getElementById('change_pw').checked){
		var pw = document.getElementById('admin_password').value;
		var cpw = document.getElementById('admin_cpassword').value;
		
		if (pw == "" || pw != cpw){
			document.getElementById('admin_cpassword').style.border = "1px solid red";
			flag = false;
		}else{
			document.getElementById('admin_cpassword').style.border = "1px solid #D5D5D5";
		}
	}
	return flag;
}
function validate_supply()
{
	
	var flag = true;
	
	 
	if(trim('from_date')=="")
	{
	document.customer_supply.from_date.style.border = "1px solid red";
	flag = false;
	}
	 
	
	if(trim('to_date')=="")
	{
	document.customer_supply.to_date.style.border = "1px solid red";
	flag = false;
	}
	else
	document.customer_supply.to_date.style.border = "1px solid #94B6BC";
	
	
		
	if(trim('gas_supply')=="" || isNaN(trim('gas_supply')))
	{
	document.customer_supply.gas_supply.style.border = "1px solid red";
	flag = false;
	}
	else
	document.customer_supply.gas_supply.style.border = "1px solid #94B6BC";
	
		
	if(trim('supply_rate')=="" || isNaN(trim('supply_rate')))
	{
	document.customer_supply.supply_rate.style.border = "1px solid red";
	flag = false;
	}
	else
	document.customer_supply.supply_rate.style.border = "1px solid #94B6BC";
	
		
	if(trim('supplier')=="")
	{
	document.customer_supply.supplier.style.border = "1px solid red";
	flag = false;
	}
	else
	document.customer_supply.supplier.style.border = "1px solid #94B6BC";
	
	
	
	return flag;
	
}

function numbersonly(myfield, e, dec)

{
	var key;
	var keychar;
	if (window.event)
	   key = window.event.keyCode;
	else if (e)
	   key = e.which;
	else
	   return true;
	keychar = String.fromCharCode(key);
	// control keys

	if ((key==null) || (key==0) || (key==8) || 

		(key==9) || (key==13) || (key==27) )

	   return true;
	// numbers
	else if ((("0123456789-").indexOf(keychar) > -1))

	   return true;
//decimal point jump

	else if (dec && (keychar == "."))
	   {
	   myfield.form.elements[dec].focus();
	   return false;
	   }
	else
	   return false;

}

function show_this(val){
	if (val.checked){
		document.getElementById('_pw').style.display = '';
		document.getElementById('_cpw').style.display = '';
	}else{
		document.getElementById('_pw').style.display = 'none';
		document.getElementById('_cpw').style.display = 'none';
	}
}
function validate_customer()
{
	var flag = true;
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	var email_address1 = document.add_customer.customer_email.value;
	var email_address2 = document.add_customer.company_email.value;
	
	
	if(trim('customer_name')=="")
	{
	document.add_customer.customer_name.style.border = "1px solid red";
	flag = false;
	}
	else
	document.add_customer.customer_name.style.border = "1px solid #94B6BC";  
	
	if(trim('customer_login')=="")
	{
	document.add_customer.customer_login.style.border = "1px solid red";
	flag = false;
	}
	else
	document.add_customer.customer_login.style.border = "1px solid #94B6BC";
	
	if(trim('customer_phone')=="")
	{
	document.add_customer.customer_phone.style.border = "1px solid red";
	flag = false;
	}
	else
	document.add_customer.customer_phone.style.border = "1px solid #94B6BC";
	
	if(trim('customer_email')=="")
	{
	document.add_customer.customer_email.style.border = "1px solid red";
	flag = false;}
	else
	document.add_customer.customer_email.style.border = "1px solid #94B6BC";
	
	if(trim('customer_address')=="")
	{
	document.add_customer.customer_address.style.border = "1px solid red";
	flag = false;}
	else
	document.add_customer.customer_address.style.border = "1px solid #94B6BC";

 
	if(document.add_customer.Location.value == "")
	{
	document.add_customer.Location.style.border = "1px solid red";
	flag = false;}
	else
	document.add_customer.Location.style.border = "1px solid #94B6BC";
	
	if(trim('company_name')=="")
	{
	document.add_customer.company_name.style.border = "1px solid red";
	flag = false;}
	else
	document.add_customer.company_name.style.border = "1px solid #94B6BC";

	if(trim('company_address')=="")
	{
	document.add_customer.company_address.style.border = "1px solid red";
	flag = false;}
	else
	document.add_customer.company_address.style.border = "1px solid #94B6BC";

	if(trim('company_phone')=="")
	{
	document.add_customer.company_phone.style.border = "1px solid red";
	flag = false;}
	else
	document.add_customer.company_phone.style.border = "1px solid #94B6BC";

   if(('status')=="")
	{
	document.add_customer.status.style.border = "1px solid red";
	flag = false;}
	else
	document.add_customer.status.style.border = "1px solid #94B6BC";

  if((document.add_customer.customer_password.value != document.add_customer.customer_cpassword.value)||(document.add_customer.customer_password.value == "" && document.add_customer.customer_cpassword.value == ""))

	{
	document.add_customer.customer_password.style.border = "1px solid red";
	document.add_customer.customer_cpassword.style.border = "1px solid red";
	flag = false;}
	else
	{
	document.add_customer.customer_cpassword.style.border = "1px solid #94B6BC";
	document.add_customer.customer_password.style.border = "1px solid #94B6BC";}
	
	
	if(reg.test(email_address1) == false) 
	
	{
	document.add_customer.customer_email.style.border = "1px solid red"
	flag = false;}
	else
	document.add_customer.customer_email.style.border = "1px solid #94B6BC";
	
	
	
	if(reg.test(email_address2) == false) 
	
	{
	document.add_customer.company_email.style.border = "1px solid red"
	flag = false;}
	else
	document.add_customer.company_email.style.border = "1px solid #94B6BC";

	return flag;
}

function validate_supplier()
{var flag = true;

	
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	var email_address1 = document.add_supplier.supplier_email.value;
	var email_address2 = document.add_supplier.company_email.value;
	
	
	if(trim('supplier_name')=="")
	{
	document.add_supplier.supplier_name.style.border = "1px solid red";
	flag = false;
	}
	else
	document.add_supplier.supplier_name.style.border = "1px solid #94B6BC";  
	
	if(trim('supplier_login')=="")
	{
	document.add_supplier.supplier_login.style.border = "1px solid red";
	flag = false;
	}
	else
	document.add_supplier.supplier_login.style.border = "1px solid #94B6BC";
	
	
	if(trim('supplier_phone')=="")
	{
	
	document.add_supplier.supplier_phone.style.border = "1px solid red";
	flag = false;
	}
	else
	document.add_supplier.supplier_phone.style.border = "1px solid #94B6BC";
	
	if(trim('supplier_email')=="")
	{
	document.add_supplier.supplier_email.style.border = "1px solid red";
	flag = false;}
	else
	document.add_supplier.supplier_email.style.border = "1px solid #94B6BC";
	
	if(trim('supplier_address')=="")
	{
	document.add_supplier.supplier_address.style.border = "1px solid red";
	flag = false;}
	else
	document.add_supplier.supplier_address.style.border = "1px solid #94B6BC";

 
	if(document.add_supplier.Location.value == "")
	{
	document.add_supplier.Location.style.border = "1px solid red";
	flag = false;}
	else
	document.add_supplier.Location.style.border = "1px solid #94B6BC";
	
	if(trim('company_name')=="")
	{
	document.add_supplier.company_name.style.border = "1px solid red";
	flag = false;}
	else
	document.add_supplier.company_name.style.border = "1px solid #94B6BC";

	if(trim('company_address')=="")
	{
	document.add_supplier.company_address.style.border = "1px solid red";
	flag = false;}
	else
	document.add_supplier.company_address.style.border = "1px solid #94B6BC";

	if(trim('company_phone')=="")
	{
	document.add_supplier.company_phone.style.border = "1px solid red";
	flag = false;}
	else
	document.add_supplier.company_phone.style.border = "1px solid #94B6BC";

	if(trim('rate')=="")
	{
	document.add_supplier.rate.style.border = "1px solid red";
	flag = false;}
	else
	document.add_supplier.rate.style.border = "1px solid #94B6BC";
	

  if((document.add_supplier.supplier_password.value != document.add_supplier.supplier_cpassword.value)||(document.add_supplier.supplier_password.value == "" && document.add_supplier.supplier_cpassword.value == ""))

	{
	document.add_supplier.supplier_password.style.border = "1px solid red";
	document.add_supplier.supplier_cpassword.style.border = "1px solid red";
	flag = false;}
	else
	{
	document.add_supplier.supplier_cpassword.style.border = "1px solid #94B6BC";
	document.add_supplier.supplier_password.style.border = "1px solid #94B6BC";}
	
	
	if(reg.test(email_address1) == false) 
	{
	document.add_supplier.supplier_email.style.border = "1px solid red"
	flag = false;}
	else
	document.add_supplier.supplier_email.style.border = "1px solid #94B6BC";
	
	
	
	if(reg.test(email_address2) == false) 
	{
	document.add_supplier.company_email.style.border = "1px solid red"
	flag = false;}
	else
	document.add_supplier.company_email.style.border = "1px solid #94B6BC";

	return flag;
}
