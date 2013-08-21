<?php
require('include/gatekeeper.php');

$_SESSION['urlselected'] = 'papers';
require('../header.php');
//require_once('../lib/func.common.php');
require_once("../lib/func.paper.php");


if(!checkPermission($_SESSION['admin_id'] , 'view_papers', 'admin'))
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
					<h3>Paper Types</h3>
					<ul class="content-box-tabs">
						<li> <a href="#tab1" class="<?php echo $tab_show_class;?>">Listing </a> </li> <!-- href must be unique and match the id of target div -->
						<?php
                                                  if(checkPermission($_SESSION['admin_id'] , 'add_paper', 'admin'))
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
                                                       <th><b>Paper Name</b>	</th>
                                                       <th><b>Color Name</b></th>
                                                       <th><b>Weight</b></th>
                                                       <th><b>Action</b></th>
                                                    </tr>
                                                 </thead>
			
							<?php
							 	$paper_rSet = getPaper_info();	// filter is being initialized on top of page and bein updated in filter part
								
								$i = 1;
								while($row = mysql_fetch_array($paper_rSet))
								{
									
							 ?>
								<tr>
									<!--<td><input type="checkbox" name="customer_id[]" value="< ?php //echo $supply['supplier_id']?>"/></td>-->
									 
									<td><?php echo $i ?></td>
									<td><?php echo $row['paper_name']; ?> </td>
                                                                                  
                                                                        <td><?php echo $row['paper_color_name']; ?></td>
									<td><?php echo $row['paper_weight']; ?> 	</td>
									
                                                                        <td><?php
                                                                            if(checkPermission($_SESSION['admin_id'] , 'update_paper', 'admin'))
                                                                                echo "<a href='edit.php?paper_id=".$row['paper_id']."' title='Edit'><img src='".siteURL."admin/resources/images/icons/pencil.png' alt='Edit' /></a>";
                                                                            if(checkPermission($_SESSION['admin_id'] , 'delete_paper', 'admin'))
                                                                                echo "&nbsp;&nbsp;&nbsp;<a href='do_delete_paper.php?paper_id=".$row['paper_id']."' title='Delete'  onclick=\"return confirm('Are you sure to delete?')\"><img src='".siteURL."admin/resources/images/icons/cross.png' alt='Delete' /></a>";
                                                                            ?>
                              
                                                                      </td>
 								</tr>
							 
                            <?php			
									 
									$i++;
								}
                                                                if($i == 1)
                                                                    echo "<tr><td colspan='5'> (No Record Found) </td></tr>";
							?>
					</table>
		

<!--						</form> -->
					</div> <!-- End #tab1 -->
					
					<div class="tab-content" id="tab2">
                                            <h3> Add New Paper Type </h3>

                                           <form action="do_add_paper.php" method="post" name="manage_account" id="myform" >
                                                        
                                              <table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
                                                  <tr>
                                                         <td style="padding:4px">Paper Name</td>
                                                         <td style="padding:4px"> <input class="text-input small-input required" type="text" id="txtField" name="paper_name"   /></td>
                                                  </tr>

                                                  <tr>
                                                    <td style="padding:4px">Color Name</td>
                                                    <td style="padding:4px"><input class="text-input small-input" type="text" id="txtField" name="paper_color"  /></td>
                                                  </tr>
                                                  <tr>
                                                     <td style="padding:4px">Weight</td>
                                                     <td style="padding:4px"> <input  style="width:100px !important" class="text-input small-input" type="text" id="numberField" name="paper_weight"  /></td>
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

