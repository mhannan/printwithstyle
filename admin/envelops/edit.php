<?php
require('include/gatekeeper.php');
require('../header.php');
require_once('../lib/func.envelop.php');
#require_once("../lib/func.customer.packages.php");
	   
       if(isset($_REQUEST['envelop_id']))
	   $envelopSet =  getEnvelops_info($_REQUEST['envelop_id']);
           $row = mysql_fetch_array($envelopSet);// print_r($bankAccountRec);
?>

<script type="text/javascript">

 /* <-- To Do --> */

</script>

<div id="main-content">
<!-- Main Content Section with everything -->
<div class="tab-content">

    <div class="content-box-header">
        <h3>Card Envelops</h3>

    </div>
  	
    <div class="content-box-content">
 
      <h3 style="height:38px; padding:8px 0px 0px 52px;   background-repeat: no-repeat; background-position:left top;background-image:url(<?php echo siteURL?>admin/resources/images/icons/envelop_small.png)"> Edit Envelop </h3>
       <form action="do_edit.php" method="post" name="manage_account" id="myform"  enctype="multipart/form-data" >

                 <table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
                      <tr>
                             <td style="padding:4px">Envelop Name
                                                    <input type="hidden" name="envelopId" value="<?php echo $row['envelop_id']; ?>">
                                                    <input type="hidden" name="oldEnvelop_filename" value="<?php echo $row['envelop_picture']; ?>"></td>
                             <td style="padding:4px"> <input class="text-input small-input required" type="text" id="txtField" name="title" value="<?php echo $row['envelop_title']; ?>"   /></td>
                            
                      </tr>

                      <tr>
                            <td style="padding:4px">Select Envelop Preview Picture</td>
                            <td style="padding:4px"><input class="text-input small-input required" type="file" id="txtField" name="picture"  /> <span style="color:#666; font-size:10px">(Leave blank to keep old picture unchanged)</span>
                                <div><img src="../../uploads/card_envelops/<?php echo $row['envelop_picture']; ?>" width="120px"></div>
                            </td>
                      </tr>
                      <tr>
                             <td style="padding:4px">Envelop Price per Card</td>
                             <td style="padding:4px"> $ <input class="text-input small-input required" type="text" id="txtField" name="envelop_price_per_card" value="<?php echo $row['envelop_price_per_card']; ?>" style="width:120px !important"  /> <span style="color:#666; font-size:10px">(Enter '0' to give this envelop free with card)</span></td>
                      </tr>
                      <tr>
                             <td style="padding:4px">Extra Envelop Price</td>
                             <td style="padding:4px"> $ <input class="text-input small-input required" type="text" id="txtField" name="extra_envelop_price"  value="<?php echo $row['extra_envelop_price']; ?>" style="width:120px !important" /> <span style="color:#666; font-size:10px">(If customer need extra envelops along then its unit price. Enter '0' to give free unlimited extra envelops)</span></td>
                      </tr>

                      <tr><td></td> <td>&nbsp;<br /><input class="button" type="submit" value="Submit" /></td></tr>
                    </table>

      <!-- End .clear -->
        </form>
    </div>
</div>
</div>

</body>
</html>
