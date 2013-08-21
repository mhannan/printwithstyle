<?php
require("config/conf.php");
include_once("lib/func.user.php");

        if(isset($_POST['useremail']) && isset($_POST['password']))
        {
            $flag = validate_login($_POST['useremail'], $_POST['password']);

            if($flag)
              echo "<script> window.location = 'admin_mgt.php';</script>";

            else {
                    $errmsg = base64_encode(" Invalid Username or Password "); 
                     echo "<script> window.location = 'index.php?errmsg=$errmsg';</script>";
                }
        }
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
		<title>Admin Panel| Sign In</title>
		
		<!--                       CSS                       -->
	  
		<!-- Reset Stylesheet -->
		<link rel="stylesheet" href="resources/css/reset.css" type="text/css" media="screen" />
	  
		<!-- Main Stylesheet -->
		<link rel="stylesheet" href="resources/css/style.css" type="text/css" media="screen" />
		
		<!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
		<link rel="stylesheet" href="resources/css/invalid.css" type="text/css" media="screen" />	
 
		
	</head>
  
	<body id="login">
		
		<div id="login-wrapper" class="png_bg">
			<div id="login-top">
			
				<h1>Admin Login</h1>
				<!-- Logo (221px width) -->
				<img id="logo" src="resources/images/logo.png" alt="Simpla Admin logo" />
			</div> <!-- End #logn-top -->
			
			<div id="login-content">
								<?php
		if(isset($_GET['okmsg']))
		{
?>
   <br /><div class="notification success png_bg" style="height:30px">
				<a href="#" class="close"><img src="<?php echo siteURL?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>
					<?php echo base64_decode($_GET['okmsg']);?>
				</div>
			</div><br />

<?php			
		}
		

?>

<?php
		if(isset($_GET['errmsg']))
		{
?>
   <div class="notification error png_bg">
				<a href="#" class="close"><img src="<?php echo siteURL?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>
					<?php echo base64_decode($_GET['errmsg']);?>
				</div>
			</div> 

<?php			
		}
		

?>
	
				<form action="" name="login" method="post">
				
				
					<p>
						<label>Login</label>
						<input class="text-input" type="text"  name="useremail" id="username"/>
					</p>
					<div class="clear"></div>
					<p>
						<label>Password</label>
						<input class="text-input" type="password"  name="password" id="password"/>
					</p>
					<div class="clear"></div>
					
					<div class="clear"></div>
					<p>
						<input class="button" type="submit" value="Sign In" />
					</p>
					
				</form>
			</div> <!-- End #login-content -->
			
		</div> <!-- End #login-wrapper -->
		
  </body>
  </html>

