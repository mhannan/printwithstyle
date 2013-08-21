<?php
require('include/gatekeeper.php');
require('../header.php');
require_once('../lib/func.album.bg.php');
require_once("../lib/func.customer.packages.php");
	   
       if(isset($_REQUEST['bg_id']))
	   $bgSet =  getAlbumBG_info($_REQUEST['bg_id']);
           $bgRec = mysql_fetch_array($bgSet);// print_r($bankAccountRec);
?>

<script type="text/javascript">

 /* <-- To Do --> */

</script>

<div id="main-content">
<!-- Main Content Section with everything -->
<div class="tab-content">

    <div class="content-box-header">
        <h3>Manage Backgrounds</h3>

    </div>
  	
    <div class="content-box-content">
 
      <h3> Edit Background Detail </h3>
       <form action="do_edit_bg.php" method="post" name="manage_account" id="myform">

                 <table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
                      <tr>
                             <td style="padding:4px">Background Title
                                                    <input type="hidden" name="bgId" value="<?php echo $bgRec['bg_id']; ?>">
                                                    <input type="hidden" name="oldBg_filename" value="<?php echo $bgRec['bg_path']; ?>"></td>
                             <td style="padding:4px"> <input class="text-input small-input required" type="text" id="txtField" name="bgTitle" value="<?php echo $bgRec['bg_name']; ?>"   /></td>
                            
                      </tr>

                      <tr>
                        <td style="padding:4px">Select Background</td>
                        <td style="padding:4px"><?php echo "<img src='../../images/album_bg/".$bgRec['bg_path']."' width='200px' style='border:1px solid #ccc'>"; ?><br>
                                                <input class="text-input small-input " type="file" id="txtField" name="bgImage"  />
                                                <br> <span class="gray10">(leave empty if you don't want to change background)</span></td>
                      </tr>
                      <tr>
                         <td style="padding:4px">Background for Packages</td>
                         <td style="padding:4px"> <?php echo getBgSelectedPackages_inHTML($bgRec['bg_for_packages'],'package_types[]', 'checkbox'); ?> </td>
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
