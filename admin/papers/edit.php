<?php
require('include/gatekeeper.php');
require('../header.php');
//require_once('../lib/func.common.php');
require_once("../lib/func.paper.php");
	   
       if(isset($_REQUEST['paper_id']))
	   $paperSet =  getPaper_info($_REQUEST['paper_id']);
           $paperRec = mysql_fetch_array($paperSet);// print_r($bankAccountRec);
?>

<script type="text/javascript">

 /* <-- To Do --> */

</script>

<div id="main-content">
<!-- Main Content Section with everything -->
<div class="tab-content">

    <div class="content-box-header">
        <h3>Paper Type</h3>

    </div>
  	
    <div class="content-box-content">
 
      <h3> Edit Paper Type </h3>
       <form action="do_edit_paper.php" method="post" name="manage_account" id="myform">

                <table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
                  <tr>
                         <td style="padding:4px">Paper Name <input type="hidden" name="paper_id" value="<?php echo $paperRec['paper_id']; ?>"/></td>
                         <td style="padding:4px"> <input class="text-input small-input required" type="text" id="txtField" name="paper_name" value="<?php echo $paperRec['paper_name']; ?>"/></td>
                  </tr>

                  <tr>
                    <td style="padding:4px">Color Name</td>
                    <td style="padding:4px"><input class="text-input small-input" type="text" id="txtField" name="paper_color"  value="<?php echo $paperRec['paper_color_name']; ?>" /></td>
                  </tr>
                  <tr>
                     <td style="padding:4px">Weight</td>
                     <td style="padding:4px"> <input  style="width:100px !important" class="text-input small-input" type="text" id="numberField" name="paper_weight"   value="<?php echo $paperRec['paper_weight']; ?>"/></td>
                  </tr>
                  
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
