<?php
require('include/gatekeeper.php');
$_SESSION['urlselected'] = "affiliates";
require('../header.php');
require_once('../lib/func.common.php');
require_once('../lib/func.affiliate.php');
require_once('../lib/func.banner.php');

if(!checkPermission($_SESSION['admin_id'] , 'view_affiliates', 'admin'))
{ 
    $errmsg = base64_encode('You are not allowed to view that Page');
    echo "<script> window.location = '../index.php?errmsg=$errmsg';</script>";
    exit;
 
} 
    
     
	 $customerFilter = "";
?>
<script type="text/javascript">

function validate_user()
{
	var flag = true;
	
	if($('#firstname').val() =="")
	 {
		$('#firstname').css('border', '1px solid #FF1111');
		flag = false;
	 }
	else
		$('#firstname').css('border', '1px solid #d8d9db');
		
	if($('#lastname').val() =="")
	 {
		$('#lastname').css('border', '1px solid #FF1111');
		flag = false;
	 }
	 else
		$('#lastname').css('border', '1px solid #d8d9db');
		
	if($('#password').val() =="")
	 {
		$('#password').css('border', '1px solid #FF1111');
		flag = false;
	 }
	 else
		$('#password').css('border', '1px solid #d8d9db');
		
	if($('#email').val() =="")
	 {
		$('#email').css('border', '1px solid #FF1111');
		flag = false;
	 }
	 else
		$('#email').css('border', '1px solid #d8d9db');
		
	 

	return flag;
}
 
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
		if(isset($_REQUEST['tab']))
		{
			$tab_show_class='';	  
			$show_my_tab= "default-tab";
			//echo ""
			$customer=$_REQUEST['tab'];
		}
?>

			<div class="content-box"><!-- Start Content Box --> 
				
				<div class="content-box-header">
					<h3>Affiliates</h3>
					<ul class="content-box-tabs">
						<li> <a href="#tab1" class="<?php echo $tab_show_class;?>">Affiliates </a> </li> <!-- href must be unique and match the id of target div -->
						<?php
                                                  if(checkPermission($_SESSION['admin_id'] , 'create_affiliate', 'admin'))
                                                       echo "<li><a href='#tab2' >Add New</a></li>";

                                                  echo "<li style='border-right:1px solid #fff;background-color:#ccc; width:1px !important; height:28px; margin-left:4px; margin-right:4px'>&nbsp;</li>";

                                                  if(checkPermission($_SESSION['admin_id'] , 'view_banners', 'admin'))
                                                       echo "<li><a href='#tab3' class='".$show_my_tab."'>Banners</a></li>";
                                                  if(checkPermission($_SESSION['admin_id'] , 'add_banner', 'admin'))
                                                       echo "<li><a href='#tab4' >Add New</a></li>";
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
                                                       <th><b>Full Name</b>	</th>
                                                       <th><b>Email</b></th>
                                                       
                                                       <th><b>Visitors</b></th>
                                                       <th><b>Registrations</b></th>
                                                       <th><b>Orders</b></th>
                                                       <th><b>Commission</b></th>
                                                       <th><b>Action</b></th>
                                                    </tr>
                                                 </thead>
			
							<?php
							 	$userSet = getAffiliates();	// filter is being initialized on top of page and bein updated in filter part
								
								$i = 1;
								while($userRec = mysql_fetch_array($userSet))
								{
									
							 ?>
								<tr>
									<!--<td><input type="checkbox" name="customer_id[]" value="< ?php //echo $supply['supplier_id']?>"/></td>-->
									 
									<td><?php echo $i ?></td>
									<td><?php echo $userRec['u_name']; ?></td>
									<td><?php echo $userRec['email']; ?></td>
									
                                                                        <td><a href="aff_visitors_log.php?af_id=<?php echo $userRec['id']; ?>"><?php echo getAffiliate_visits_count($userRec['id']); ?> Visits</a></td>
                                                                        <td><a href="aff_regs_log.php?af_id=<?php echo $userRec['id']; ?>"><?php echo getAffiliate_regs_count($userRec['id']); ?> Reg.</a></td>
                                                                        <td><a href="aff_orders_log.php?af_id=<?php echo $userRec['id']; ?>"><?php echo getAffiliate_orders_count($userRec['id']); ?> Orders</a></td>
                                                                        <td><b>$<?php echo $userRec['balance']; ?></b></td>
									<td><?php
                                                                            if(checkPermission($_SESSION['admin_id'] , 'update_affiliate', 'admin'))
                                                                                echo "<a href='edit.php?affiliate_id=".$userRec['id']."' title='Edit'><img src='".siteURL."admin/resources/images/icons/pencil.png' alt='Edit' /></a>";
                                                                            if(checkPermission($_SESSION['admin_id'] , 'delete_affiliate', 'admin'))
                                                                                echo "&nbsp;&nbsp;&nbsp;<a href='do_delete_affiliate.php?affiliate_id=".$userRec['id']."' title='Delete'  onclick=\"return confirm('Are you sure to delete?')\"><img src='".siteURL."admin/resources/images/icons/cross.png' alt='Delete' /></a>";
                                                                            ?>
                              
                                                                      </td>
 								</tr>
							 
                            <?php			
									 
									$i++;
								}
                                                                if($i ==1)
                                                                    echo "<tr><td colspan='9'>(No record found) </td></tr>";
							?>
					</table>
		

<!--						</form> -->
					</div> <!-- End #tab1 -->
					
					<div class="tab-content" id="tab2">
                                                <h3> Create New Affiliate </h3>

                                                 <form action="do_add_affiliate.php" method="post" name="manage_account" id="manage_account" onsubmit="return validate_user()">

                                                        <table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
                                                          <tr>
                                                                 <td style="padding:4px">First Name</td>
                                                                 <td style="padding:4px"> <input class="text-input small-input" type="text" id="firstname" name="firstname"   /></td>
                                                          </tr>

                                                          <tr>
                                                            <td style="padding:4px">Last Name</td>
                                                            <td style="padding:4px"><input class="text-input small-input" type="text" id="lastname" name="lastname"  /></td>
                                                         </tr>
                                                        <tr>
                                                                 <td style="padding:4px">Password</td>
                                                                 <td style="padding:4px"> <input class="text-input small-input" type="password" id="password" name="password"  /></td>
                                                          </tr>
                                                          <tr>
                                                                 <td style="padding:4px">Email</td>
                                                                 <td style="padding:4px"><input class="text-input small-input" type="text" id="email" name="email"  /></td>
                                                          </tr>


                                                  <tr><td></td> <td>&nbsp;<br /><input class="button" type="submit" value="Submit" /></td></tr>
                                                        </table>

                                              <!-- End .clear -->
                                                </form>
						
					</div> <!-- End #tab2 -->        
					
					<!-- #tab 3> -->
					<div class="tab-content <?php echo $show_my_tab;?>" id="tab3">
                                            <h3>Banners</h3>
						<table>
                                                    <thead>
                                                        <tr bgcolor="#CCFFCC">
                                                           <!--<th><input class="check-all" type="checkbox" /></th>-->

                                                           <th><b>S.No</b>	</th>
                                                           <th><b>Banner Name</b>	</th>
                                                           <th><b>Preview</b></th>
                                                           <th><b>Width - Height</b></th>
                                                           <!-- <th><b>Clicks</b></th> -->
                                                           <th><b>Action</b></th>
                                                        </tr>
                                                     </thead>

                                                            <?php
                                                                    $bannerRes = getBanner();	// filter is being initialized on top of page and bein updated in filter part

                                                                    $i = 1;
                                                                    while($row = mysql_fetch_array($bannerRes))
                                                                    {

                                                             ?>
                                                                    <tr>
                                                                            <!--<td><input type="checkbox" name="customer_id[]" value="< ?php //echo $supply['supplier_id']?>"/></td>-->

                                                                            <td><?php echo $i ?></td>
                                                                            <td><?php echo $row['banner_title']; ?></td>
                                                                            <td style="padding-top:0px; padding-bottom:0px"><?php if($row['banner_path'] != "")
                                                                                            echo "<img style='border:1px solid #666; margin-top:3px;' src='../../uploads/affiliate_banners/".$row['banner_path']."' width='50px'>"; ?>
                                                                                </td>
                                                                            <td><?php echo $row['banner_width_px'].'px - '.$row['banner_height_px'].'px'; ?></td>
                                                                            <!-- <td> </td> -->
                                                                            <!--<td><a href="">0 Orders</a></td>-->
                                                                            <td><?php
                                                                                if(checkPermission($_SESSION['admin_id'] , 'update_banner', 'admin'))
                                                                                    echo "<a href='banner_edit.php?banner_id=".$row['affiliate_banner_id']."' title='Edit'><img src='".siteURL."admin/resources/images/icons/pencil.png' alt='Edit' /></a>";
                                                                                if(checkPermission($_SESSION['admin_id'] , 'delete_banner', 'admin'))
                                                                                    echo "&nbsp;&nbsp;&nbsp;<a href='do_delete_banner.php?banner_id=".$row['affiliate_banner_id']."' title='Delete'  onclick=\"return confirm('Are you sure to delete?')\"><img src='".siteURL."admin/resources/images/icons/cross.png' alt='Delete' /></a>";
                                                                                ?>

                                                                           </td>
                                                                     </tr>

                                                        <?php
                                                                       $i++;
                                                                    }
                                                                    if($i ==1)
                                                                        echo "<tr><td colspan='9'>(No record found) </td></tr>";
                                                            ?>
                                            </table>
					</div>	
				
					
					<!-- End of tab 3 -->
					
					
					<div class="tab-content" id="tab4">
                                                <h3> Upload Banner </h3>

                                                 <form action="do_add_banner.php" method="post" name="manage_account" enctype="multipart/form-data" id="manage_account" >

                                                        <table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
                                                          <tr>
                                                                 <td style="padding:4px">Banner Title</td>
                                                                 <td style="padding:4px"> <input class="text-input small-input" type="text" id="banner_title" name="banner_title"   /></td>
                                                          </tr>

                                                          <tr>
                                                            <td style="padding:4px">Banner</td>
                                                            <td style="padding:4px"><input  type="file" id="banner_file" name="banner_file"  /></td>
                                                         </tr>
                                                         <tr>
                                                             <td style="padding:4px">Banner Size</td>
                                                             <td style="padding:4px; line-height: 32px">
                                                                                     Width: &nbsp;<input style="width:60px !important" class="text-input small-input" type="text" name="banner_width"> PX<br>
                                                                                     Height: <input style="width:60px !important" class="text-input small-input" type="text" name="banner_height"> PX</td>
                                                         </tr>

                                                         <tr><td></td> <td>&nbsp;<br /><input class="button" type="submit" value="Submit" /></td></tr>
                                                        </table>

                                              <!-- End .clear -->
                                                </form>

					</div> <!-- End #tab2 -->
					
					
					
					
					
					
					
					
					
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

