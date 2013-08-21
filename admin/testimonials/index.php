<?php
require('include/gatekeeper.php');

$_SESSION['urlselected'] = 'testimonials';
require('../header.php');
//require_once('../lib/func.common.php');
require_once("../lib/func.testimonial.php");



if(!checkPermission($_SESSION['admin_id'] , 'view_testimonials', 'admin'))
{ 
    $errmsg = base64_encode('You are not allowed to view that Page');
    echo "<script> window.location = '../index.php?errmsg=$errmsg';</script>";
    exit;
 
} 
    
     
	 $customerFilter = "";
?>
<script type="text/javascript">
  $(function() {
		$( "#start_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
		$( "#end_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
	});
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
					<h3>Testimonials</h3>
					<ul class="content-box-tabs">
						<li> <a href="#tab1" class="<?php echo $tab_show_class;?>">Listing </a> </li> <!-- href must be unique and match the id of target div -->
						<?php
                                                  if(checkPermission($_SESSION['admin_id'] , 'add_testimonial', 'admin'))
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
                                                       <th><b>Author Name</b>	</th>
                                                       <th><b>Date Posted</b></th>
                                                       <th><b>Author Photo</b></th>
                                                       <th><b>Testimonial</b></th>
                                                       <th><b>Status</b></th>
                                                       <th><b>Action</b></th>
                                                    </tr>
                                                 </thead>
			
							<?php
							 	$testimonials_rSet = getTestimonial_info();	// filter is being initialized on top of page and bein updated in filter part
								
								$i = 1;
								while($row = mysql_fetch_array($testimonials_rSet))
								{
									$profile_pic_path = siteURL."images/no-photo.jpg";
                                                                        if($row['profile_pic_path'] !='')
                                                                            $profile_pic_path = siteURL."uploads/customer_profile_pics/".$row['profile_pic_path'];
							 ?>
								<tr valign="middle">
									<!--<td><input type="checkbox" name="customer_id[]" value="< ?php //echo $supply['supplier_id']?>"/></td>-->
									 
									<td><?php echo $i ?></td>
									<td><?php echo $row['u_name']; ?> </td>
                                                                        <td><?php echo date('d M Y', strtotime($row['date_posted'])); ?> </td>
                                                                        
                                                                        <td><img src="<?php echo $profile_pic_path; ?>" width="110px" /></td>
                                                                        <td><?php echo $row['testimonial']; ?></td>
                                                                        <td><?php if($row['is_approved']=='1')
                                                                                        echo '<a href="do_deactivate_testimonial.php?testimonial_id='.$row['testimonial_id'].'"><img title="Click to Activate" src="'.siteURL.'admin/resources/images/icons/icon_active.png"/></a>';
                                                                                  else
                                                                                        echo '<a href="do_activate_testimonial.php?testimonial_id='.$row['testimonial_id'].'"><img title="Click to Deactivate" src="'.siteURL.'admin/resources/images/icons/icon_inactive.png"/></a>';?></td>
                                                                        <td><?php
                                                                            if(checkPermission($_SESSION['admin_id'] , 'update_testimonial', 'admin'))
                                                                                echo "<a href='edit_testimonial.php?testimonial_id=".$row['testimonial_id']."' title='Edit'><img src='".siteURL."admin/resources/images/icons/pencil.png' alt='Edit' /></a>";
                                                                            if(checkPermission($_SESSION['admin_id'] , 'delete_testimonial', 'admin'))
                                                                                echo "&nbsp;&nbsp;&nbsp;<a href='do_delete_testimonial.php?testimonial_id=".$row['testimonial_id']."' title='Delete'  onclick=\"return confirm('Are you sure to delete?')\"><img src='".siteURL."admin/resources/images/icons/cross.png' alt='Delete' /></a>";
                                                                            ?>
                              
                                                                      </td>
 								</tr>
							 
                            <?php			
									 
									$i++;
								}
                                                                 if($i ==1)
                                                                         echo "<tr><td colspan='7'> ( No Record Found ) </td></tr>";
							?>
					</table>
		

<!--						</form> -->
					</div> <!-- End #tab1 -->
					
					<div class="tab-content" id="tab2">
                                            <h3> Add New Design Event </h3>

                                           <form action="do_add_event.php" method="post" name="manage_account" id="myform"  enctype="multipart/form-data">
                                                        
                                              <table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
                                                  <tr>
                                                         <td style="padding:4px" width="30%">Event Title <input type="hidden" name="cat_id" value="<?php echo $_GET['cat_id']; ?>"></td>
                                                         <td style="padding:4px" width="60%"> <input class="text-input small-input required" type="text" id="txtField" name="event_title"   /></td>
                                                  </tr>
                                                  <tr>
                                                         <td style="padding:4px" width="30%">Start Date</td>
                                                         <td style="padding:4px" width="60%"> <input class="text-input small-input required" type="text" id="start_date" name="start_date"   /></td>
                                                  </tr>
                                                  <tr>
                                                         <td style="padding:4px" width="30%">End Date</td>
                                                         <td style="padding:4px" width="60%"> <input class="text-input small-input required" type="text" id="end_date" name="end_date"   /></td>
                                                  </tr>
                                                  <tr>
                                                         <td style="padding:4px" width="30%">Winner Prize</td>
                                                         <td style="padding:4px" width="60%"> $ <input class="text-input small-input required" type="text" name="winner_prize"   /></td>
                                                  </tr>
                                                   <tr valign="top">
                                                         <td style="padding:4px; vertical-align: top" width="30%">Event Description</td>
                                                         <td style="padding:4px" width="60%"> <textarea class="text-input small-input required" id="txtField" name="event_description" style="width:350px !important; height: 100px"  ></textarea></td>
                                                  </tr>

                                                  <!--<tr>
                                                    <td style="padding:4px">Select Card Background</td>
                                                    <td style="padding:4px"><input class="text-input small-input required" type="file" id="txtField" name="card_bg"  /></td>
                                                  </tr> -->
                                                  

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

