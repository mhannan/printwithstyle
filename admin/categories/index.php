<?php
require('include/gatekeeper.php');

$_SESSION['urlselected'] = 'categories';
require('../header.php');
//require_once('../lib/func.common.php');
require_once("../lib/func.categories.php");


if(!checkPermission($_SESSION['admin_id'] , 'view_categories', 'admin'))
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
					<h3>Card Categories</h3>
					<ul class="content-box-tabs">
						<!-- <li> <a href="#tab1" class="< ?php echo $tab_show_class;?>">Listing </a> </li> --> <!-- href must be unique and match the id of target div -->
						<?php
                                                  if(checkPermission($_SESSION['admin_id'] , 'add_category', 'admin'))
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
                                                       <th><b>Category Title</b>	</th>
                                                       <th><b>Content Type Allocation</b></th>
                                                       <th><b>View Cards</b></th>
                                                       <!-- <th><b>Action</b></th> -->
                                                    </tr>
                                                 </thead>
			
							<?php
							 	$categorySet = getCategory_info();	// filter is being initialized on top of page and bein updated in filter part
								
								$i = 1;
								while($row = mysql_fetch_array($categorySet))
								{
									
							 ?>
								<tr valign="middle">
									<!--<td><input type="checkbox" name="customer_id[]" value="< ?php //echo $supply['supplier_id']?>"/></td>-->
									 
									<td><?php echo $i ?></td>
									<td><?php echo $row['cat_title']; ?> </td>
                                                                                  
                                                                        <td style="padding:5px 0px 0px 2px; line-height:1"><a href=""><img src='<?php echo siteURL; ?>admin/resources/images/icons/content_format.png' width="42px"></a></td>
									<td><a href="cards.php?cat_id=<?php echo $row['cat_id'];?>"><img src='<?php echo siteURL; ?>admin/resources/images/icons/christmas-card-icon.png' width="32px"><br> <?php echo category_cardscount($row['cat_id']); ?> Cards</a></td>
									
                                                                       
                                                                        <!-- <td>< ?php
                                                                            if(checkPermission($_SESSION['admin_id'] , 'update_package', 'admin'))
                                                                                echo "<a href='edit.php?package_id=".$packageRec['package_id']."' title='Edit'><img src='".siteURL."admin/resources/images/icons/pencil.png' alt='Edit' /></a>";
                                                                            if(checkPermission($_SESSION['admin_id'] , 'delete_package', 'admin'))
                                                                                echo "&nbsp;&nbsp;&nbsp;<a href='do_delete_package.php?package_id=".$packageRec['package_id']."' title='Delete'  onclick=\"return confirm('Are you sure to delete?')\"><img src='".siteURL."admin/resources/images/icons/cross.png' alt='Delete' /></a>";
                                                                            ?>
                              
                                                                      </td> -->
 								</tr>
							 
                            <?php			
									 
									$i++;
								}
							?>
					</table>
		

<!--						</form> -->
					</div> <!-- End #tab1 -->
					
					<div class="tab-content" id="tab2">
                                            <h3> Add New Category </h3>

                                           <form action="do_add_package.php" method="post" name="manage_account" id="myform" >
                                                        
                                              <table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
                                                  <tr>
                                                         <td style="padding:4px">Package Title</td>
                                                         <td style="padding:4px"> <input class="text-input small-input required" type="text" id="txtField" name="packageTitle"   /></td>
                                                  </tr>

                                                  <tr>
                                                    <td style="padding:4px">Description</td>
                                                    <td style="padding:4px"><input class="text-input small-input required" type="text" id="txtField" name="description"  /></td>
                                                  </tr>
                                                  <tr>
                                                     <td style="padding:4px">Price</td>
                                                     <td style="padding:4px"> $ <input  style="width:100px !important" class="text-input small-input required number" type="text" id="numberField" name="price"  /></td>
                                                  </tr>
                                                  <tr>
                                                      <td style="padding:4px">Pages/ Album</td>
                                                      <td style="padding:4px"><input class="text-input small-input required digit" type="text" id="digitField" name="pages_per_album"  /></td>
                                                  </tr>
                                                  <tr>
                                                         <td style="padding:4px">Allowed Total Albums</td>
                                                         <td style="padding:4px"><input class="text-input small-input required digit" type="text" id="digitField" name="allowed_albums"  /></td>
                                                  </tr>
                                                  <tr>
                                                         <td style="padding:4px">Other Features</td>
                                                         <td style="padding:4px"><input type="checkbox" value="1" name="albumEditable"> Allow to Edit Album Pages
                                                                                <input type="checkbox" value="1" name="shareableURL"> Generate Shareable URL <span class="gray10">(i.e. http://www.mykeepsake.com/albumbook/2)</span>
                                                         </td>
                                                  </tr>
                                                  <tr>
                                                         <td style="padding:4px; background-color:#e6db55">Charges for Extra Page</td>
                                                         <td style="padding:4px; background-color: #e6db55"> $ <input  style="width:100px !important" class="text-input small-input number" type="text" id="numberField" name="extraPageCharges"  />
                                                                                <br><span class="gray10">(Leave empty if you don't want to give this feature, put '0' to allow this feature for free)</span></td>
                                                  </tr>
                                                  <tr>
                                                         <td style="padding:4px; background-color:#e6db55">Charges for Extra Album</td>
                                                         <td style="padding:4px; background-color: #e6db55"> $ <input  style="width:100px !important" class="text-input small-input number" type="text" id="numberField" name="extraAlbumCharges"  />
                                                                                <br><span class="gray10">(Leave empty if you don't want to give this feature, put '0' to allow this feature for free)</span></td>
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

