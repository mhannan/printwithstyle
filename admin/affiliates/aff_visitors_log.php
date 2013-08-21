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
					<h3>Visitors Log</h3>
					<ul class="content-box-tabs">
						<li> <a href="#tab1" class="<?php echo $tab_show_class;?>">Visitors Log </a> </li> <!-- href must be unique and match the id of target div -->
						
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
                                                       <th><b>Activity Date</b>	</th>
                                                       <th><b>Visitor IP</b></th>
                                                       <th><b>Commission</b></th>
                                                       <th><b>Commission Status</b></th>
                                                       <th><b>Commission Payment Date</b></th>
                                                     </tr>
                                                 </thead>
			
							<?php
							 	$rSet = getVisits_byAffiliatID($_GET['af_id'], $dateFilterSql='');	// filter is being initialized on top of page and bein updated in filter part
								
								$i = 1;
								while($row = mysql_fetch_array($rSet))
								{
									
							 ?>
								<tr>
									<!--<td><input type="checkbox" name="customer_id[]" value="< ?php //echo $supply['supplier_id']?>"/></td>-->
									 
									<td><?php echo $i ?></td>
									<td><?php echo date('d M-Y', strtotime($row['activity_time'])); ?></td>
									<td><?php echo $row['visitor_ip']; ?></td>
                                                                        <td><?php echo '$'.$row['commission_earned']; ?></td>
                                                                        <td><?php if($row['is_commission_paid'] == '1')
                                                                                    echo '<span style="color:green"><b>PAID</b></span>';
                                                                                  else
                                                                                      echo '<span style="color:red"><b>PENDING</b></span>'; ?></td>
                                                                        <td><?php if($row['is_commission_paid'] == '1') // if commission paid then display the date
                                                                                    echo date('d M-Y', strtotime($row['commission_payment_date'])); ?></td>
 								</tr>
							 
                            <?php					 
									$i++;
								}
                                                                if($i ==1)
                                                                    echo "<tr><td colspan='6'>(No record found) </td></tr>";
							?>
					</table>
		

<!--						</form> -->
					</div> <!-- End #tab1 -->
					
					
					
					
					
					
					
					
					
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

