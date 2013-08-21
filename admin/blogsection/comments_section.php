<?php
require('include/gatekeeper.php');

require('../header.php');
//require_once('../lib/func.common.php');
require_once('../lib/func.blogsection.php');
/*require_once('../lib/func.create_user_account.php');

require_once('lib/func.common.php');
require_once('lib/func.blogsection.php');
require_once('lib/func.pages.php');
require_once('lib/func.user.php');

*/

//---- All lib files included in header file end

  

if(!checkPermission($_SESSION['admin_id'] , 'view_blog', 'admin'))
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
            $('#emai').css('border', '1px solid #d8d9db');



        return flag;
    }

</script>	  


<!-- that's IT-->	 
<div id="main-content"> <!-- Main Content Section with everything --> 
        <?php
    if (isset($_GET['okmsg'])) {
    ?>
        <div class="notification success png_bg">
            <a href="#" class="close"><img src="<?php echo siteURL ?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
            <div><?php echo base64_decode($_GET['okmsg']); ?></div>
        </div>

    <?php
    }

    if (isset($_GET['errmsg'])) {
    ?>
        <div class="notification error png_bg">
            <a href="#" class="close"><img src="<?php echo siteURL ?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
            <div>					<?php echo base64_decode($_GET['errmsg']); ?>				</div>
        </div>

<?php
    }

    $tab_show_class = 'default-tab';
    $show_my_tab = "";
    if (isset($_REQUEST['customer'])) {
        $tab_show_class = '';
        $show_my_tab = "default-tab";
//echo ""
        $customer = $_REQUEST['select_customer'];
    }
?>

    <div class="content-box"><!-- Start Content Box -->

        <div class="content-box-header">
            <h3>Manage Blog Comments
            </h3><ul class="content-box-tabs">
                <li> <a href="#tab1" class="<?php echo $tab_show_class; ?>">Listing </a> </li> <!-- href must be unique and match the id of target div -->
                <?php
                if (checkPermission($_SESSION['admin_id'], 'add_nurse_pageX', 'admin'))
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
                        <!--<th><input class="check-all" type="checkbox" /></th>-->

                            <th width="37"><b>S.No</b>	</th>
                            <th width="84">Author</th>
                            <th width="52">Date</th>
                            <th width="71">Comments</th>
                            <th width="78">Status</th>
                            <th width="79">Action</th>
                        </tr>
                    </thead>

                    <?php
                    $commentsSet = getAllCommentsOnThisArticle($_REQUEST['articleId']); // filter is being initialized on top of page and bein updated in filter part

                    $i = 1;
                    while ($row = @mysql_fetch_array($commentsSet)) {// @ added temporarily for client viewing.
                    ?>
                        <tr>
                        <!--<td><input type="checkbox" name="customer_id[]" value="< ?php //echo $supply['supplier_id']?>"/></td>-->

                            <td><?php echo $i ?></td>
                            <td><?php echo $row['u_name']; 
                                        if($row['profile_pic_path']=='')
                                            echo '<br><img src="../../images/no-photo.jpg" style="border:1px solid #ccc; padding:3px" width="40px" />';
                                        else
                                            echo '<br><img src="../../uploads/customer_profile_pic/'.$row['profile_pic_path'].'" style="border:1px solid #ccc; padding:3px"  width="40px"/>';
                                    ?></td>
                            <td><?php echo date('d M-Y', strtotime($row['date_commented'])); ?></td>
                            <td><?php echo $row['comments']; ?></td>
                            <td>
                                <form action="do_edit_blog_comment_status.php" method="post" name="manage_account<?=$i ?>" id="manage_account<?=$i ?>">
                                    <select name="status" onchange="this.form.submit();" id="status">
                                        <option <?php if ($row['status'] == 1) { ?> selected="selected"<?php } ?> value="1">Approved</option>
                                        <option <?php if ($row['status'] == 0) { ?> selected="selected"<?php } ?>  value="0">Pending</option>


                                    </select>

                                    <input type="hidden" name="callbackId" value="<?php echo $_REQUEST['articleId'] ?>">


                                    <input type="hidden" name="id" value="<?php echo $row['Id'] ?>">


                                </form>

                            </td>
                            <td>
<?php
                        if (checkPermission($_SESSION['admin_id'], 'view_blog', 'admin'))
                            echo "&nbsp;&nbsp;&nbsp;<a href='delete_comment.php?comment_id=" . $row['Id'] . "&article_id=".$_GET['articleId']."' title='Delete'  onclick=\"return confirm('Are you sure to delete?')\"><img src='" . siteURL . "admin/resources/images/icons/cross.png' alt='Delete' /></a>";
?>

                            &nbsp;</td>
                    </tr>

<?php
                        $i++;
                    }
                    if($i==1)
                        echo "<tr><td colspan='6'>(No comments posted)</td></tr>";
?>
                </table>


                <!--						</form> -->
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
                            <td style="padding:4px">Phone No.</td>
                            <td style="padding:4px"><input class="text-input small-input" type="text" id="phone_no" name="phone_no"  /></td>
                        </tr>
                        <tr>
                            <td style="padding:4px">Mobile No.</td>
                            <td style="padding:4px"><input class="text-input small-input" type="text" id="mobile" name="mobile"  /></td>
                        </tr>
                        <tr>
                            <td style="padding:4px">Country</td>
                            <td style="padding:4px"><?php echo getCountries_selectList('countryTxt', 'countryTxt'); // display drop down country with saved country id  ?></td>
                        </tr>
                        <tr>
                            <td style="padding:4px">State</td>
                            <td style="padding:4px"><input class="text-input small-input" type="text" id="state" name="state"  /></td>
                        </tr>
                        <tr>
                            <td style="padding:4px">City</td>
                            <td style="padding:4px"><input class="text-input small-input" type="text" id="city" name="city"  /></td>
                        </tr>
                        <tr>
                            <td style="padding:4px">Address</td>
                            <td style="padding:4px"><input class="text-input large-input" type="text" id="address" name="address"  style="width:50% ! important"/></td>
                        </tr>


                        <tr><td></td> <td>&nbsp;<br /><input class="button" type="submit" value="Submit" /></td></tr>
                    </table>

                    <!-- End .clear -->
                </form>

            </div> <!-- End #tab2 -->

            <!-- #tab 3> -->
            <div class="tab-content <?php echo $show_my_tab; ?>" id="tab3">
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

