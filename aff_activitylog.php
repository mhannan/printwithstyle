<?php 
	include("lib/func.common.php");
	
	
	$user_id = $_SESSION['aff_user_id'];
	$res=$objDb->SelectTable(USERS,"*","id='$user_id'");
	$row=mysql_fetch_array($res);
	
	$username=$row['u_name'];
	$password=$row['password'];
	$email=$row['email'];
	$r_type=$row['r_type'];
	$contact_name=$row['contact_name'];
	$contact_phone=$row['contact_phone'];
	$contact_address=$row['contact_address'];
	$designation=$row['designation'];
	$city=$row['city'];
	$country=$row['country'];
	$region=$row['region'];

        $profile_pic_path = "images/no-photo.jpg";
        if($row['profile_pic_path'] !='')
            $profile_pic_path = "uploads/customer_profile_pics/".$row['profile_pic_path'];



   $visitBlockStyle=""; $visitBlock_menuStyle=" background-color:#E3E7D0 ";
   $regBlockStyle="display:none;"; $regBlock_menuStyle=" background-color:#F6F7F0 ";
   $saleBlockStyle="display:none;"; $saleBlock_menuStyle=" background-color:#F6F7F0 ";

   // visitors Log date filter
    $v_dateFilterSql = "";
    $toDate = date('Y-m-d H:i:s');
    $fromDate = "1970-01-01 10:23:22";	// default oldest date - the default date befor this system launched
    if(isset($_POST) && $_POST['block_selected']=='visit')
    { 
            if(isset($_POST['v_fromDate']) && $_POST['v_fromDate'] != "")
                    $v_fromDate = $_POST['v_fromDate'].' 00:00:00';
            if(isset($_POST['v_toDate']) && $_POST['v_toDate'] != "")
                    $v_toDate = $_POST['v_toDate'].' 23:59:59';

            $v_dateFilterSql = " AND (activity_time BETWEEN '".$v_fromDate."' AND '".$v_toDate."' )";		// WHERE is added by sql statement by itself so we dont' need to do here. just AND required as there are already where checkes placed in the SQL so we will be passing AND along from here
    
            $saleBlockStyle="display:none;"; $saleBlock_menuStyle=" background-color:#F6F7F0 ";
            $regBlockStyle="display:none;"; $regBlock_menuStyle=" background-color:#F6F7F0 ";
    }

    // registrations Log date filter
    $reg_dateFilterSql = "";
    if(isset($_POST) && $_POST['block_selected']=='reg')
    { 
            if(isset($_POST['reg_fromDate']) && $_POST['reg_fromDate'] != "")
                    $reg_fromDate = $_POST['reg_fromDate'].' 00:00:00';
            if(isset($_POST['reg_toDate']) && $_POST['reg_toDate'] != "")
                    $reg_toDate = $_POST['reg_toDate'].' 23:59:59';

            $reg_dateFilterSql = " AND (activity_time BETWEEN '".$reg_fromDate."' AND '".$reg_toDate."' )";		// WHERE is added by sql statement by itself so we dont' need to do here. just AND required as there are already where checkes placed in the SQL so we will be passing AND along from here
    
            $visitBlockStyle="display:none;"; $visitBlock_menuStyle=" background-color:#F6F7F0 ";
            $regBlockStyle=""; $regBlock_menuStyle=" background-color:#E3E7D0 ";
            $saleBlockStyle="display:none;"; $saleBlock_menuStyle=" background-color:#F6F7F0 ";
    }


    // Sales Log date filter
    $sale_dateFilterSql = "";
    if(isset($_POST) && $_POST['block_selected']=='sale')
    {
            if(isset($_POST['sale_fromDate']) && $_POST['sale_fromDate'] != "")
                    $reg_fromDate = $_POST['reg_fromDate'].' 00:00:00';
            if(isset($_POST['sale_toDate']) && $_POST['sale_toDate'] != "")
                    $reg_toDate = $_POST['sale_toDate'].' 23:59:59';

            $reg_dateFilterSql = " AND (activity_time BETWEEN '".$sale_fromDate."' AND '".$sale_toDate."' )";		// WHERE is added by sql statement by itself so we dont' need to do here. just AND required as there are already where checkes placed in the SQL so we will be passing AND along from here

            $visitBlockStyle="display:none;"; $visitBlock_menuStyle=" background-color:#F6F7F0 ";
            $regBlockStyle="display:none;"; $regBlock_menuStyle=" background-color:#F6F7F0 ";
            $saleBlockStyle=""; $saleBlock_menuStyle=" background-color:#E3E7D0 ";
    }


    
?>    

<div class="body_internal_wrapper">
<?php include("leftsection_affiliate.php") ?>
   <div class="body_right"><!--body_right-->
     <div class="home_wedng_inv_wrapp"><!--home_invitatins_wrapp-->
<?php 

 if($_REQUEST['msg'] == "succ")
 {
	echo "<div class='alert_success'><div>Information saved successfully.</div></div>";
 }
?>

<link rel="stylesheet" href="js/date_picker/development-bundle/themes/base/jquery.ui.all.css">
<script src="js/date_picker/development-bundle/jquery-1.7.1.js"></script>
<script src="js/date_picker/development-bundle/external/jquery.bgiframe-2.1.2.js"></script>
<script src="js/date_picker/development-bundle/ui/jquery.ui.core.js"></script>
<script src="js/date_picker/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="js/date_picker/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script src="js/date_picker/development-bundle/ui/i18n/jquery.ui.datepicker-en-GB.js"></script>
<script language="javascript">
	/*$(function() {
		$.datepicker.setDefaults($.extend({showMonthAfterYear: false}, $.datepicker.regional['']));
		$(".ui-dialog-content").remove();
	});*/
	$(function() {
		$( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
		$( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });
                $( "#datepicker3" ).datepicker({ dateFormat: 'yy-mm-dd' });
		$( "#datepicker4" ).datepicker({ dateFormat: 'yy-mm-dd' });
		$( "#datepicker4" ).datepicker({ dateFormat: 'yy-mm-dd' });
		$( "#datepicker5" ).datepicker({ dateFormat: 'yy-mm-dd' });
		$( "#datepicker6" ).datepicker({ dateFormat: 'yy-mm-dd' });

                /*$('#visit').css('background-color','#E3E7D0');
                $('.log_blocks').hide();
                $('#visit_block').show();*/
	});

        function showSelectedBlock(element_clicked)
        {
            $('.log_subMenu').css('background-color','#F6F7F0');
            $('#'+element_clicked).css('background-color','#E3E7D0');

            $('.log_blocks').hide();
            $('#'+element_clicked+'_block').show();
        }


</script>


         <div style="margin-bottom:20px">
             <div class="log_subMenu" id="visit" onclick="showSelectedBlock('visit')" style="<?php echo $visitBlock_menuStyle; ?>">Visits Log</div>
             <div class="log_subMenu" id="reg" onclick="showSelectedBlock('reg')"  style="<?php echo $regBlock_menuStyle; ?>">Registrations Log</div>
             <div class="log_subMenu" id="sale" onclick="showSelectedBlock('sale')" style="<?php echo $saleBlock_menuStyle; ?>">Sales Log</div>
             <div style="clear:both"></div>
         </div>

         

         <div style=" margin-top:10px;margin-bottom:50px; <?php echo $visitBlockStyle; ?>" id="visit_block" class="log_blocks">

                 <div style="border:1px solid #d0d4be; padding:5px; margin-bottom:20px">
                     <form action="" method="post" name="searchForm">
                         <b style="margin-bottom:5px">Search:</b><br>
                         <div style="float:left; margin-top:4px">From: <input type="text" id="datepicker" name="v_from_date" readonly="readonly"></div>

                         <div style="float:left; margin:4px 100px 0px 80px">To: <input type="text" id="datepicker2" name="v_to_date" readonly="readonly"></div>

                         <div style="float:left; "><button style="border:none; background:none"><img src="images/btn_search_blue.png"></button></div>
                         <div style="clear:both"></div>
                         <input type="hidden" name="block_selected" value="visit">
                     </form>
                 </div>
             
                 <!-- ##############Latest Visits############### -->
                 <table border="0" cellpadding="4" cellspacing="1" bgcolor="#eee" width="450px">
                     <tr>
                         <td style="color:#29748C; background-color:#eee; font-size:18px" colspan="2"> Latest Visits</td>
                     </tr>
                     <tr>
                         <td style="color:#29748C; background-color:#f5f5f5;"><b>Activity Time</b></td>
                         <td style="color:#29748C; background-color:#f5f5f5;"><b>Visitor IP</b></td>
                         <!--<td style="color:#29748C; background-color:#f5f5f5;"><b>Visitor Location</b></td>-->
                     </tr>

                     <?php
                        $vRSet = getLatestVisits_byAffiliatID($_SESSION['aff_user_id'],'', $v_dateFilterSql);
                        $i=1;
                        while($vRow = mysql_fetch_array($vRSet))
                        {
                            echo '<td style="background-color:#fff;">'.date('d M-Y',strtotime($vRow['activity_time'])).'</td>
                                  <td style="background-color:#fff;">'.$vRow['visitor_ip'].'</td>
                                ';
                        }
                        if($i==1)
                            echo '<td style="background-color:#fff;" colspan="2">(No record found)</td>';
                     ?>
                     
                 </table>
         </div>






         <div style="margin-top:10px;margin-bottom:50px; <?php echo $regBlockStyle; ?>" id="reg_block" class="log_blocks" style="">

                <div style="border:1px solid #d0d4be; padding:5px; margin-bottom:20px">
                     <form action="" method="post" name="searchForm">
                         <b style="margin-bottom:5px">Search:</b><br>
                         <div style="float:left; margin-top:4px">From: <input type="text" id="datepicker3" name="reg_from_date" readonly="readonly"></div>

                         <div style="float:left; margin:4px 100px 0px 80px">To: <input type="text" id="datepicker4" name="reg_to_date" readonly="readonly"></div>

                         <div style="float:left; "><button style="border:none; background:none"><img src="images/btn_search_blue.png"></button></div>
                         <div style="clear:both"></div>
                         <input type="hidden" name="block_selected" value="reg">
                     </form>
                 </div>

             
                 <!-- ##############Latest Registrations############### -->
                 <table border="0" cellpadding="4" cellspacing="1" bgcolor="#eee" width="560px">
                     <tr>
                         <td style="color:#29748C; background-color:#eee; font-size:18px" colspan="4"> Latest Registrations</td>
                     </tr>
                     <tr>
                         <td style="color:#29748C; background-color:#f5f5f5;"><b>Activity Time</b></td>
                         <td style="color:#29748C; background-color:#f5f5f5;"><b>Visitor IP</b></td>
                         <!--<td style="color:#29748C; background-color:#f5f5f5;"><b>Visitor Location</b></td>-->
                         <td style="color:#29748C; background-color:#f5f5f5;"><b>Name</b></td>
                         <td style="color:#29748C; background-color:#f5f5f5;"><b>Email</b></td>
                     </tr>
                     
                     <?php
                        $rRSet = getLatestRegistered_byAffiliatID($_SESSION['aff_user_id'],'', $reg_dateFilterSql);
                        $i=1;
                        while($rRow = mysql_fetch_array($rRSet))
                        {
                            echo '<td style="background-color:#fff;">'.date('d M-Y',strtotime($rRow['activity_time'])).'</td>
                                  <td style="background-color:#fff;">'.$rRow['visitor_ip'].'</td>
                                  <td style="background-color:#fff;">'.$rRow['u_name'].'</td>
                                  <td style="background-color:#fff;">'.$rRow['email'].'</td>
                                ';
                        }
                        if($i==1)
                            echo '<td style="background-color:#fff;" colspan="4">(No record found)</td>';
                     ?>
                     
                 </table>

         </div>



         <div style="margin-top:10px;margin-bottom:50px; <?php echo $saleBlockStyle; ?>" id="sale_block" class="log_blocks" >

                <div style="border:1px solid #d0d4be; padding:5px; margin-bottom:20px">
                     <form action="" method="post" name="searchForm">
                         <b style="margin-bottom:5px">Search:</b><br>
                         <div style="float:left; margin-top:4px">From: <input type="text" id="datepicker5" name="sale_from_date" readonly="readonly"></div>

                         <div style="float:left; margin:4px 100px 0px 80px">To: <input type="text" id="datepicker6" name="sale_to_date" readonly="readonly"></div>

                         <div style="float:left; "><button style="border:none; background:none"><img src="images/btn_search_blue.png"></button></div>
                         <div style="clear:both"></div>
                         <input type="hidden" name="block_selected" value="sale">
                     </form>
                 </div>

             
                  <!-- ##############Latest Sales############### -->
                 <table border="0" cellpadding="4" cellspacing="1" bgcolor="#eee" width="660px">
                     <tr>
                         <td style="color:#29748C; background-color:#eee; font-size:18px" colspan="4"> Commission Log on Latest Purchases Made by My Users</td>
                     </tr>
                     <tr>
                         <td style="color:#29748C; background-color:#f5f5f5;"><b>Activity Time</b></td>
                         <td style="color:#29748C; background-color:#f5f5f5;"><b>Visitor IP</b></td>
                         <!--<td style="color:#29748C; background-color:#f5f5f5;"><b>Visitor Location</b></td>-->
                         <td style="color:#29748C; background-color:#f5f5f5;"><b>Name</b></td>
                         <td style="color:#29748C; background-color:#f5f5f5;"><b>Email</b></td>
                         <td style="color:#29748C; background-color:#f5f5f5;"><b>Commission Earned</b></td>

                     </tr>

                     <?php
                        $saleRSet = getLatestSalesCommission_byAffiliatID($_SESSION['aff_user_id'],'', $sale_dateFilterSql);
                        $i=1;
                        while($sRow = mysql_fetch_array($saleRSet))
                        {
                            echo '<td style="background-color:#fff;">'.date('d M-Y',strtotime($sRow['activity_time'])).'</td>
                                  <td style="background-color:#fff;">'.$sRow['visitor_ip'].'</td>
                                  <td style="background-color:#fff;">'.$sRow['u_name'].'</td>
                                  <td style="background-color:#fff;">'.$sRow['email'].'</td>
                                  <td style="background-color:#fff;">$'.$sRow['commission_earned'].'</td>
                                ';
                        }
                        if($i==1)
                            echo '<td style="background-color:#fff;" colspan="5">(No record found)</td>';
                     ?>

                 </table>

         </div>
         <div style="clear:both"></div>



      </div><!--home_invitatins_wrapp--> 
    </div><!--body_right--> 
  </div><!--body_internal_wrapp--> <div style="clear:both"></div>

