<?php
require('include/gatekeeper.php');
require('../header.php');
require_once("../lib/func.designevent.php");
	   
       if(isset($_REQUEST['event_id']))
	   $eventSet =  getEvent_info($_REQUEST['event_id']);
           $row = mysql_fetch_array($eventSet);// print_r($bankAccountRec);
           
?>

<script type="text/javascript">

  $(function() {
		$( "#start_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
		$( "#end_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
	});

</script>

<div id="main-content">
<!-- Main Content Section with everything -->
<div class="tab-content">

    <div class="content-box-header">
        <h3> <?php echo $row['event_title']; ?></h3>

    </div>
  	
    <div class="content-box-content">
 
      <h3> Edit Event </h3>
      <form action="do_edit_event.php" method="post" name="manage_account" id="myform" enctype="multipart/form-data">

                <table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
                      <tr>
                             <td style="padding:4px" width="30%">Event Title <input type="hidden" name="event_id" value="<?php echo $_GET['event_id']; ?>"></td>
                             <td style="padding:4px" width="60%"> <input class="text-input small-input required" type="text" id="txtField" name="event_title" value="<?php echo $row['event_title']; ?>"  /></td>
                      </tr>
                      <tr>
                             <td style="padding:4px" width="30%">Start Date</td>
                             <td style="padding:4px" width="60%"> <input class="text-input small-input required" type="text" id="start_date" name="start_date" value="<?php echo $row['start_date']; ?>"  /></td>
                      </tr>
                      <tr>
                             <td style="padding:4px" width="30%">End Date</td>
                             <td style="padding:4px" width="60%"> <input class="text-input small-input required" type="text" id="end_date" name="end_date" value="<?php echo $row['end_date']; ?>"  /></td>
                      </tr>
                      <tr>
                             <td style="padding:4px" width="30%">Winner Prize</td>
                             <td style="padding:4px" width="60%"> $ <input class="text-input small-input required" type="text" name="winner_prize"  value="<?php echo $row['prize']; ?>" /></td>
                      </tr>
                       <tr valign="top">
                             <td style="padding:4px; vertical-align: top" width="30%">Event Description</td>
                             <td style="padding:4px" width="60%"> <textarea class="text-input small-input required" id="txtField" name="event_description" style="width:350px !important; height: 100px"  ><?php echo $row['description']; ?></textarea></td>
                      </tr>

                      <!--<tr>
                        <td style="padding:4px">Select Card Background</td>
                        <td style="padding:4px"><input class="text-input small-input required" type="file" id="txtField" name="card_bg"  /></td>
                      </tr> -->


                      <tr><td></td> <td>&nbsp;<br /><input class="button" type="submit" value="Submit" /></td></tr>
                    </table>

      <!-- End .clear -->
        </form>
    </div>
</div>
</div>
 <script type="text/javascript">

function validate_user()
{
	var flag = true;
	
	if($('#fullname').val() =="")
	 {
		$('#fullname').css('border', '1px solid #FF1111');
		flag = false;
	 }
	else
		$('#fullname').css('border', '1px solid #d8d9db');
		
	if($('#username').val() =="")
	 {
		$('#username').css('border', '1px solid #FF1111');
		flag = false;
	 }
	 else
		$('#username').css('border', '1px solid #d8d9db');
		
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
		$('#emai').css('border', '1px solid #d8d9db');
		
	 

	return flag;
}
 
</script>
</body>
</html>
