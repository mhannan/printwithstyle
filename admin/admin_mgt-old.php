<?php  
require('include/gatekeeper.php');
$_SESSION['urlselected'] = 'adminManagement'; 
require('header.php');

 
?>

<div class="clear"></div>
<!-- End .clear -->
<?php
    if(isset($_GET['okmsg']))
    {
?>
        <div class="notification success png_bg"> <a href="#" class="close"><img src="<?php echo siteURL?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
          <div> <?php echo base64_decode($_GET['okmsg']);?> </div>
        </div>
<?php			
    }
		
    if(isset($_GET['errmsg']))
    {
?>
        <div class="notification error png_bg"> <a href="#" class="close"><img src="<?php echo siteURL?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
          <div> <?php echo base64_decode($_GET['errmsg']);?> </div>
        </div>
<?php			
    }
?>
<br />
<br />
<div class="content-box" style='width:1100px; margin-left:auto; margin-right:auto' align='center'>
  <!-- Start Content Box -->
  <div class="content-box-header">
    <h3>Home</h3>
    <div class="clear"></div>
  </div>
  <!-- End .content-box-header -->
  <div class="content-box-content" >
   	<table border="0" cellpadding="10" cellspacing="4" width="100%" style="padding:10px !important">
		<tr>
			<td style="padding:10px !important">
				<div style="float:left;"><a href="<?php echo siteURL;?>admin/manage_account.php"><img src="<?php echo siteURL?>admin/resources/images/icons/my_account.png" border="0"/></a></div>
                                <div style="float:left;margin-top:8px;"><a href="<?php echo siteURL;?>admin/manage_account.php">My Account</a></div>
                                <div style="clear:both"></div> </td>
                                
                	<?php  if(checkPermission($_SESSION['admin_id'] , 'view_customers', 'admin')) { ?>
             		<td style="padding:10px !important">
                            <div style="float:left;"><a href="<?php echo siteURL;?>admin/customers/"><img  src="<?php echo siteURL?>admin/resources/images/icons/admin_users.png" border="0" /></a></div>
                            <div style="float:left; margin-top:8px;"><a href="<?php echo siteURL;?>admin/customers/">Customers</a></div>
                            <div style="clear:both"></div> </td>
			<?php }
                        
			  if(checkPermission($_SESSION['admin_id'] , 'view_orders', 'admin')) { ?>
			<td style="padding:10px !important">
				<div style="float:left;"><a href="<?php echo siteURL;?>admin/orders/index.php">
					<img src="<?php echo siteURL?>admin/resources/images/icons/wooden-box-label.png" width="30px" border="0" /></a></div>
                                <div style="float:left;margin-top:8px"><a href="<?php echo siteURL;?>admin/orders/index.php">&nbsp;Orders</a></div>
                                <div style="clear:both"></div>
                          </td>
			<?php } ?>
		</tr>
		<tr>
			<?php if(checkPermission($_SESSION['admin_id'] , 'view_papers','admin')) { ?>
			<td style="padding:10px !important">
				<div style="float:left;"><a href="<?php echo siteURL;?>admin/papers/"><img width="50px" src="<?php echo siteURL?>admin/resources/images/icons/paper_scissors.png" border="0" /></a></div>
                                <div style="float:left; margin-top:10px;"><a href="<?php echo siteURL;?>admin/papers/">&nbsp;Paper Types</a></div>
                                <div style="clear:both"></div>
                        </td>
			<?php }

			  if(checkPermission($_SESSION['admin_id'] , 'view_categories', 'admin')) { ?>
			<td style="padding:10px !important">
				<div style="float:left;"><a href="<?php echo siteURL;?>admin/categories/"><img src="<?php echo siteURL?>admin/resources/images/icons/content.png" width="36px" border="0" /></a></div>
                                <div style="float:left;margin-top:10px;"><a href="<?php echo siteURL;?>admin/categories/">&nbsp;Card Categories</a></div>
                                <div style="clear:both"></div>
                        </td>
			<?php }
                        
			  if(checkPermission($_SESSION['admin_id'] , 'view_design_events', 'admin')) {?>
			<td style="padding:10px !important">
				<div style="float:left;"><a href="<?php echo siteURL;?>admin/designevents/index.php"><img src="<?php echo siteURL?>admin/resources/images/icons/design_event.png" border="0" width="38px"/></a></div>
                                <div style="float:left;margin-top: 12px"><a href="<?php echo siteURL;?>admin/designevents/index.php">&nbsp;Designing Events</a></div>
                                <div style="clear:both"></div>
                        </td>
			<?php }?>
		</tr>
		<tr>
                        <?php  if(checkPermission($_SESSION['admin_id'] , 'view_fonts', 'admin')) { ?>
			<td style="padding:10px !important">
				<div style="float:left;"><a href="<?php echo siteURL;?>admin/affiliates/"><img src="<?php echo siteURL?>admin/resources/images/icons/font_type.png" border="0" width="48px"/></a></div>
                                <div style="float:left;margin-top: 16px"><a href="<?php echo siteURL;?>admin/fonts/">&nbsp;Fonts</a></div>
                                <div style="clear:both"></div>
                        </td>
			<?php }
			
                            if(checkPermission($_SESSION['admin_id'] , 'view_affiliates', 'admin')) { ?>
                        
			<td style="padding:10px !important">
				<div style="float:left;"><a href="<?php echo siteURL;?>admin/affiliates/"><img src="<?php echo siteURL?>admin/resources/images/icons/affiliate.png" border="0" width="48px"/></a></div>
                                <div style="float:left;margin-top: 16px"><a href="<?php echo siteURL;?>admin/affiliates/">&nbsp;Affiliates</a></div>
                                <div style="clear:both"></div>
                        </td>
			<?php 
				}

			  if(checkPermission($_SESSION['admin_id'] , 'view_banners', 'admin')) { ?>
			<td style="padding:10px !important; vertical-align: middle">
				<div style="float:left;"><a href="<?php echo siteURL;?>admin/affiliates/index.php?tab=banner"><img src="<?php echo siteURL?>admin/resources/images/icons/banner-icon.png" border="0" width="48px"/></a></div>
                                <div style="float:left;margin-top: 12px"><a href="<?php echo siteURL;?>admin/affiliates/index.php?tab=banner">Affiliate Banners</a></div>
                                <div style="clear:both"></div>
                        </td>
			<?php } ?>
		 </tr>
		 
		<tr>
			
		</tr>
	</table>
  </div>
  <!-- End .content-box-content -->
</div>
<!-- End .content-box -->
<!-- End .content-box -->
<!-- End .content-box -->
<div class="clear"></div>
<!-- Start Notifications -->
<!-- End Notifications -->
<div id="footer"> <small>
  <!-- Remove this notice or replace it with whatever you want -->
  </small> </div>
<!-- End #footer -->
</div>
<!-- End #main-content -->
</div>
</body><!-- Download From www.exet.tk-->
</html>