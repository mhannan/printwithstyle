<?php
include ('header_detailpage.php');
if ( !isset($_REQUEST['item_id']) && !is_numeric($_REQUEST['item_id'] ) ) {
	echo "<script language='javascript'> self.location = 'index.php'; </script>";
	exit;
}

$row = getCard_byId( $_REQUEST['item_id'] , $objDb );
?>
<!--body_conetnt-->
<div class="body_content_wrapp">
	<?php
	$cat_id = 'cat_id_'.$row['cat_id'];
	if ( isset( $_REQUEST ) && isset( $_REQUEST['step'] ) && !empty( $_REQUEST['step'] ) ) {
		switch ($_REQUEST['step']) {
			case "step1" :
			default : {
				include ('customize_step1.php');	
				break;
			}
			case "step2" : {
				include ('customize_step2.php');
				break;
			}
			case "step3" : {
				include ('customize_step3.php');
				break;
			}
			case "step33" : {
				include ('customize_step33.php');
				break;
			}
			case "step4" : {
				if ( $row['cat_id'] == 3 ) {
					include ('customize_step4_response.php');
				} else {
					include ('customize_step4.php');
				}
				
				break;
			}
			case "step5" : {
				include ('customize_step5.php');
				break;
			}
			case "step6" : {
				include ('customize_step6.php');
				break;
			}
		}
	} elseif (isset($_REQUEST['item_id'])) {
		include ('customize_step1.php');
	} else {
		echo "<script language='javascript'> self.location = 'index.php'; </script>";
	}
?>
	<!--btm_reviews_wrapp-->
	<div class="btm_reviews_wrapp">
		<?php include 'review-system.php'; ?>
	</div>
	<!--btm_reviews_wrapp-->

</div>
<!--body_content-->

<!--footer_Wrapp-->
<div class="footer_wrapp">

	<div class="footer_btm">
		©2012 Send With Style All Rights Reserved
		<br />
		Web Design BY Design Soft Studios
	</div>

</div><!--footer_Wrapp-->

</div><!--main_wrapp-->

</body>
</html>
