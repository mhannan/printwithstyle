<?php
require ('include/gatekeeper.php');
$_SESSION['urlselected'] = "customers";
require ('../header.php');
require_once ('../lib/func.common.php');
require_once ('../lib/func.customer.php');

if (!checkPermission($_SESSION['admin_id'], 'view_customers', 'admin')) {
	$errmsg = base64_encode('You are not allowed to view that Page');
	echo "<script> window.location = '../index.php?errmsg=$errmsg';</script>";
	exit ;

}

$customerFilter = "";
?>
<script type="text/javascript">
	function validate_user() {
		var flag = true;

		if ($('#firstname').val() == "") {
			$('#firstname').css('border', '1px solid #FF1111');
			flag = false;
		} else
			$('#firstname').css('border', '1px solid #d8d9db');

		if ($('#lastname').val() == "") {
			$('#lastname').css('border', '1px solid #FF1111');
			flag = false;
		} else
			$('#lastname').css('border', '1px solid #d8d9db');

		if ($('#password').val() == "") {
			$('#password').css('border', '1px solid #FF1111');
			flag = false;
		} else
			$('#password').css('border', '1px solid #d8d9db');

		if ($('#email').val() == "") {
			$('#email').css('border', '1px solid #FF1111');
			flag = false;
		} else
			$('#emai').css('border', '1px solid #d8d9db');

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
				<div><?php echo base64_decode($_GET['okmsg']); ?></div>
			</div>

<?php
	}

	if(isset($_GET['errmsg']))
	{
?>
  		  <div class="notification error png_bg">
			 <a href="#" class="close"><img src="<?php echo siteURL?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>					<?php echo base64_decode($_GET['errmsg']); ?>				</div>
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
					<h3>Customers</h3>
					<ul class="content-box-tabs">
						<li> <a href="#tab1" class="<?php echo $tab_show_class; ?>">Listing </a> </li> <!-- href must be unique and match the id of target div -->
						<?php
						if (checkPermission($_SESSION['admin_id'], 'create_customer', 'admin'))
							echo "<li><a href='#tab2' >Add New</a></li>";
                                                ?>
						<!-- Customer Search tab -->
						<!-- <li><a href="#tab3" class="< ?php echo $show_my_tab;?>">Search</a></li> -->
					</ul>
					<div class="clear:both"></div>
				</div> <!-- End .content-box-header -->

				<div class="content-box-content">
					<div class="tab-content <?php echo $tab_show_class; ?>" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
						<table>
							<thead>
								<tr bgcolor="#CCFFCC">
									<th><b>S.No</b>	</th>
									<th><b>Full Name</b></th>
									<th><b>Email</b></th>
									<th><b>Phone</b></th>
									<th><b>Address</b></th>
								</tr>
							</thead>
							<?php
							 	$userSet = getCustomers();	// filter is being initialized on top of page and bein updated in filter part
								$i = 1;
								while($userRec = mysql_fetch_array($userSet))
								{
							?>
								<tr>
									<td><?php echo $i ?></td>
									<td><?php echo $userRec['u_name']; ?></td>
									<td><?php echo $userRec['email']; ?></td>
									<td><?php echo $userRec['contact_phone'];?></td>
									<td><?php echo $userRec['contact_address'] . ' ' . $userRec['city'];?></td>
										<?php
										/*
										<td>
											echo "<a href='edit.php?customer_id={$userRec['id']}' title='Edit'><img src='" . siteURL . "admin/resources/images/icons/pencil.png' alt='Edit' /></a>";
											echo "<a href='do_delete_customer.php?customer_id={$userRec['id']}' title='Delete'  onclick=\"return confirm('Are you sure to delete?')\"><img src='" . siteURL . "admin/resources/images/icons/cross.png' alt='Delete' /></a>";
										</td>
										 */
										?>
								</tr>
							<?php
								$i++;
								}
								if($i ==1)
								echo "<tr><td colspan='6'>(No record found) </td></tr>";
							?>
						</table>
					</div> <!-- End #tab1 -->
					<div class="tab-content" id="tab2">
						<h3> Create New User </h3>
						<form action="do_add_agent.php" method="post" name="manage_account" id="manage_account" onsubmit="return validate_user()">
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
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;<br /><input class="button" type="submit" value="Submit" /></td>
								</tr>
							</table>
						</form>
					</div>
				</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
			<div class="clear"></div>
		</div> <!-- End #main-content -->
	</div>
</body>
</html>