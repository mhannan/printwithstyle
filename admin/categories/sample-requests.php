<?php
extract($_REQUEST);
if ( !isset( $card_id ) && empty($card_id) ) {
	echo "<script> window.location = 'cards.php?cat_id=1;</script>";
	exit ;
}
require ('include/gatekeeper.php');

$_SESSION['urlselected'] = 'categories';
require ('../header.php');
require_once ("../lib/func.categories.php");
require_once ("../lib/func.categories.card.php");
require_once ("../lib/func.paper.php");


$sql = "
SELECT 
	sample_requests.sent, sample_requests.id,	
	cards.card_title, cards.card_description,
 	register_users.u_name, register_users.email, register_users.return_address
FROM sample_requests
INNER JOIN register_users ON register_users.id = sample_requests.id_customer
INNER JOIN cards ON cards.card_id = sample_requests.id_card 
WHERE sample_requests.id_card = $card_id
ORDER BY sample_requests.dated DESC
";
 
$requests = mysql_query($sql) or die ( "get sample requests<br/>$sql</br>" . myqsl_error() );

$customerFilter = "";
?>
 
<!-- that's IT-->	 
<div id="main-content"> <!-- Main Content Section with everything --> 
<?php 	
$tab_show_class='default-tab';
$show_my_tab= "";
?>
<div class="content-box"><!-- Start Content Box --> 
	<div class="content-box-header">
		<h3>Sample Requests</h3>
		<ul class="content-box-tabs">
			<li> <a href="#tab1" class="<?php echo $tab_show_class; ?>">Listing </a> </li>
		</ul>
		<div class="clear:both"></div>
	</div> <!-- End .content-box-header -->

	<div class="content-box-content">
		<div class="tab-content <?php echo $tab_show_class; ?>" id="tab1">
			<table>
				<thead>
					<tr bgcolor="#CCFFCC">
						<th><b>S.No</b>	</th>
                        <th><b>Card Title</b></th>
                        <th><b>Card Description</b></th>
                        <th><b>Customer Name</b></th>
                        <th><b>Customer Email</b></th>
                        <th><b>Customer Address</b></th>
                        <th><b>Status</b></th>
                        <th><b>Action</b></th>
                    </tr>
                </thead>
				<?php
				$i = 1;
				while( $row = mysql_fetch_array( $requests ) ) {
					
					$return_address = unserialize( $row['return_address'] );
					
				?>
					<tr valign="middle">
						<td><?php echo $i ?></td>
						<td><?php echo $row['card_title']; ?> </td>
						<td><?php echo $row['card_description']; ?> </td>
						<td><?php echo $row['u_name']; ?> </td>
						<td><?php echo $row['email']; ?> </td>
						<td><?php echo "{$return_address['return_address']}, {$return_address['return_city']}, {$return_address['return_state']} {$return_address['return_zip']} {$return_address['return_country']}";?></td>
						<td>
							<?php
							if ($row['sent'] == 1)
								echo "<img src='" . siteURL . "admin/resources/images/icons/check.png' width='20px' title='active' >";
							else
								echo "<img src='" . siteURL . "admin/resources/images/icons/hourglass.png' width='20px' title='inactive' >";
	 						?>
 						</td>
 						<td>
 							<?php
 							if ( $row['sent'] == 1 ) {
 								echo "Sent";
 							} else {
 								echo "<a style='cursor: pointer;' class='sample_sent' id='{$row['id']}'>Update Now?</a>";
 							}
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
			<script type='text/javascript'>
				jQuery(document).ready(function($){
					$("a.sample_sent").live ('click', function() {
						$.post(
							'<?php echo siteURL . 'process-ajax.php'; ?>',
							{
								call : 'sample_card_sent',
								id : this.id
							},
							function(ret) {
								if ( ret == 'sent' ) {
									self.location.href = self.location.href;
								} else {
									alert(ret);
								}
							}
						);
					});
				});
			</script>
		</div> <!-- End #tab1 -->
	</div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<div class="clear"></div>
<div id="footer"></div>
</div> <!-- End #main-content -->
</div>
</body>
  

<!-- Download From www.exet.tk-->
</html>

