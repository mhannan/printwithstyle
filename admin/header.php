<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
		<script type="text/javascript" src="<?php echo siteURL;?>admin/js/validation.js"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
		<title>SEND WITH STYLE | admin</title>
		
		<!--                       CSS                       -->
	  
		<!-- Reset Stylesheet -->
		<link rel="stylesheet" href="<?php echo siteURL;?>admin/resources/css/reset.css" type="text/css" media="screen" />
	  
		<!-- Main Stylesheet -->
		<link rel="stylesheet" href="<?php echo siteURL;?>admin/resources/css/style.css" type="text/css" media="screen" />
		
		<!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
		<link rel="stylesheet" href="<?php echo siteURL;?>admin/resources/css/invalid.css" type="text/css" media="screen" />	
		
		<!-- Card Designer section Stylesheet -->
		<link rel="stylesheet" href="<?php echo siteURL;?>admin/resources/css/card_designer.css" type="text/css" media="screen" />


        <link rel="stylesheet" href="<?php echo siteURL;?>admin/js/date/themes/base/jquery.ui.all.css">
	  <!-- Colour Schemes
		Default colour scheme is green. Uncomment prefered stylesheet to use it.
		
		<link rel="stylesheet" href="resources/css/blue.css" type="text/css" media="screen" />
		
		<link rel="stylesheet" href="resources/css/red.css" type="text/css" media="screen" />  
	 
		-->
		
		<!-- Internet Explorer Fixes Stylesheet -->
		
		<!--[if lte IE 7]>
			<link rel="stylesheet" href="resources/css/ie.css" type="text/css" media="screen" />
		<![endif]-->
		
		<!--                       Javascripts                       -->
  
		<!-- jQuery -->
		<script type="text/javascript" src="<?php echo siteURL;?>admin/resources/scripts/jquery-1.3.2.min.js"></script>
		
		<!-- jQuery Configuration -->
		<script type="text/javascript" src="<?php echo siteURL;?>admin/resources/scripts/simpla.jquery.configuration.js"></script>
		
		<!-- Facebox jQuery Plugin -->
		<script type="text/javascript" src="<?php echo siteURL;?>admin/resources/scripts/facebox.js"></script>
		
		<!-- jQuery WYSIWYG Plugin -->
		<script type="text/javascript" src="<?php echo siteURL;?>admin/resources/scripts/jquery.wysiwyg.js"></script>
		
		<!-- jQuery Datepicker Plugin -->
		<script type="text/javascript" src="<?php echo siteURL;?>admin/resources/scripts/jquery.datePicker.js"></script>
		<script type="text/javascript" src="<?php echo siteURL;?>admin/resources/scripts/jquery.date.js"></script>
		<!--[if IE]><script type="text/javascript" src="resources/scripts/jquery.bgiframe.js"></script><![endif]-->
 
	    <script src="<?php echo siteURL;?>admin/js/date/ui/jquery.ui.core.js"></script>
 	    <script src="<?php echo siteURL;?>admin/js/date/ui/jquery.ui.datepicker.js"></script>
	
		<!-- Internet Explorer .png-fix -->
		
		<!--[if IE 6]>
			<script type="text/javascript" src="resources/scripts/DD_belatedPNG_0.0.7a.js"></script>
			<script type="text/javascript">
				DD_belatedPNG.fix('.png_bg, img, li');
			</script>
		<![endif]-->
		
	</head>
  
	<body> 
	 <?php
	 	
		$url = $_SERVER['PHP_SELF']; // url received example:: /gas_new/admin/supplier/nomination_form_all.php
		$urlSet = explode('/', $url);
		$setArraySize = count($urlSet);
		$pageName = explode('.', $urlSet[$setArraySize-1]);		// $pageName[0]; has the page name and $pageName[1] has '.php'
		$pageBody_width = "";
		// we need to increase the page body width to 1700px only for Nomination_form_all page
		if(($pageName[0] == "nomination_form_all") ||($pageName[0] == "invoices"))
			$pageBody_width = "style='width:1710px'";
		
	 ?>
	 <div id="body-wrapper" <?php echo $pageBody_width; ?>> <!-- Wrapper for the radial gradient background -->
	  <!-- End #sidebar --> 
     <div id="header" style="padding-top:2px;background-image:url(<?php echo siteURL?>admin/resources/images/page.jpg); background-repeat:repeat; height:100px">
	 <span style="color:#70B300"><img src="<?php echo siteURL?>/images/logo2.png"/></span>
         
	 <?php
            if(isset($_SESSION['admin_id']))
            {
	 ?>
	      <div style="width:100px; float:right; font:14px arial; color:#00CC00;">
                  <span style="color:#999999; font-size:18px; font-weight:normal">Admin Panel</span><br/><br/><br/><br/>
		  <a href="<?php echo siteURL?>admin/logout.php" onmouseover="this.style.color='red';" onmouseout="this.style.color='#00CC00';"> Logout</a></div>
	<?php
            }
	?>

         <!--<div style="float:right; margin-right:200px;-webkit-border-radius: 20px;-moz-border-radius: 20px;border-radius: 20px; padding:4px 10px; background-color:#fafafa; border:1px solid #ccc; font-size:11px; color:#888; margin-top:60px">0 New Orders</div>
         <div style="float:right; margin-right:200px;-webkit-border-radius: 20px;-moz-border-radius: 20px;border-radius: 20px; padding:4px 10px; background-color:#fafafa; border:1px solid #ccc; font-size:11px; color:#888; margin-top:60px">0 New Customers</div>
         <div style="float:right; margin-right:200px;-webkit-border-radius: 20px;-moz-border-radius: 20px;border-radius: 20px; padding:4px 10px; background-color:#fafafa; border:1px solid #ccc; font-size:11px; color:#888; margin-top:60px">0 New Blog Comments</div>
         <div style="float:right; margin-right:200px;-webkit-border-radius: 20px;-moz-border-radius: 20px;border-radius: 20px; padding:4px 10px; background-color:#fafafa; border:1px solid #ccc; font-size:11px; color:#888; margin-top:60px">0 New Affiliates</div>
	-->
<style >
#navigation .hoverselected
{
	background:#FFFFFF;
	color:#70B300 !important;
}


</style>
	<?php $url =  $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'] ?>	  
	 </div>	 
	 <div style="clear:both; "> </div>
	 <div style="clear:both"></div>
			<div style="clear:both"></div>
	   <div id="navigation" style="padding-right: 0px ! important; padding-left:0px !important; background-image:url(<?php echo siteURL?>admin/resources/images/preview11.jpg)">
		<ul>
        	<li> <a href="<?php echo siteURL;?>admin/admin_mgt.php" <?php if($_SESSION['urlselected'] == 'adminManagement') echo 'class="hoverselected"'; ?> >Home </a> </li>

                <?php  /*if(checkPermission($_SESSION['admin_id'] , 'view_papers', 'admin')) { ?>
                <li> <a href="<?php echo siteURL;?>admin/papers/" <?php if($_SESSION['urlselected'] == 'papers') echo 'class="hoverselected"'; ?>> Paper Types </a></li>
			<?php }*/

                       if(checkPermission($_SESSION['admin_id'] , 'view_envelops', 'admin')) { ?>
                <li> <a href="<?php echo siteURL;?>admin/envelops/" <?php if($_SESSION['urlselected'] == 'envelops') echo 'class="hoverselected"'; ?>> Envelops </a></li>
			<?php }

                 if(checkPermission($_SESSION['admin_id'] , 'view_categories', 'admin')) { ?>
                <li> <a href="<?php echo siteURL;?>admin/categories/" <?php if($_SESSION['urlselected'] == 'categories') echo 'class="hoverselected"'; ?>> Card Categories </a></li>
                            <?php }
                 if(checkPermission($_SESSION['admin_id'] , 'view_customers', 'admin')) { ?>
                <li> <a href="<?php echo siteURL;?>admin/customers/" <?php if($_SESSION['urlselected'] == 'customers') echo 'class="hoverselected"'; ?>> Customers </a></li>
                            <?php }

                 if(checkPermission($_SESSION['admin_id'] , 'view_orders', 'admin')) { ?>
                <li> <a href="<?php echo siteURL;?>admin/orders" <?php if($_SESSION['urlselected'] == 'oders') echo 'class="hoverselected"'; ?>> Orders </a></li>
                            <?php }
                 if(checkPermission($_SESSION['admin_id'] , 'view_design_events', 'admin')) { ?>
                <li> <a href="<?php echo siteURL;?>admin/designevents" <?php if($_SESSION['urlselected'] == 'designevents') echo 'class="hoverselected"'; ?>> Designing Events </a></li>
                            <?php }
                  /*if(checkPermission($_SESSION['admin_id'] , 'view_testimonials', 'admin')) { ?>
                <li> <a href="<?php echo siteURL;?>admin/testimonials" <?php if($_SESSION['urlselected'] == 'testimonials') echo 'class="hoverselected"'; ?>> Testimonials </a></li>
                            <?php }*/
                 if(checkPermission($_SESSION['admin_id'] , 'view_affiliates', 'admin')) { ?>
                <li> <a href="<?php echo siteURL;?>admin/affiliates" <?php if($_SESSION['urlselected'] == 'affiliates') echo 'class="hoverselected"'; ?>> Affiliates </a></li>
                            <?php }
                if(checkPermission($_SESSION['admin_id'] , 'manage_pages', 'admin')) { ?>
                <li> <a href="<?php echo siteURL;?>admin/front_pages" <?php if($_SESSION['urlselected'] == 'pages') echo 'class="hoverselected"'; ?>> Front Pages </a></li>
                            <?php }
                if(checkPermission($_SESSION['admin_id'] , 'view_blog', 'admin')) { ?>
                <li> <a href="<?php echo siteURL;?>admin/blogsection" <?php if($_SESSION['urlselected'] == 'blog') echo 'class="hoverselected"'; ?>> Blog Section </a></li>
                            <?php }
                            ?>

            
            
          
 		</ul>
		</div>	
	  