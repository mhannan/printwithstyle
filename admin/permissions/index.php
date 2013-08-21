<?php
require('include/gatekeeper.php');
$_SESSION['urlselected'] = "";
require('../header.php');
require_once('../lib/func.common.php');
require_once('../lib/func.user.php');

if (!checkPermission($_SESSION['admin_id'], 'manage_permission', 'admin')) {
    $errmsg = base64_encode('You are not allowed to view that Page');
    echo "<script> window.location = '../index.php?errmsg=$errmsg';</script>";
    exit;
}
?>
<link rel="stylesheet" href="<?php echo siteURL; ?>../resources/css/style.css" type="text/css" media="screen" />
<div id="main-content"> <!-- Main Content Section with everything -->
    <div class="clear"></div>
    <!-- End .clear -->
    <?php
    if (isset($_GET['okmsg'])) {
    ?>
        <div class="notification success png_bg"> <a href="#" class="close"><img src="<?php echo siteURL ?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
            <div> <?php echo base64_decode($_GET['okmsg']); ?> </div>
        </div>
    <?php
    }
    ?>
    <?php
    if (isset($_GET['errmsg'])) {
    ?>
        <div class="notification error png_bg"> <a href="#" class="close"><img src="<?php echo siteURL ?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
            <div> <?php echo base64_decode($_GET['errmsg']); ?> </div>
        </div>
    <?php
    }
    ?>

    <div class="content-box">
        <!-- Start Content Box -->
        <div class="content-box-header">
            <h3>Set Permissions </h3>
        </div>
        <!-- End .content-box-header -->
        <div class="content-box-content">
            <form action="do_save_permissions.php" method="post">
                <table>
                    <thead>
                        <tr bgcolor="#CCFFCC">
                            <th> Admin Users </th>
                            <th> Admin Accounts </th>
                            <th> Agents </th>
                            <th> Permissions </th>
                            <th> Bank Accounts </th>
                        </tr>
                    </thead>
                    <?php
                    $userRs = getAdmin_users();
                    while ($userRow = mysql_fetch_array($userRs)) {
                    ?>
                        <tr style="font-size:10px">
                            <td style="font-size:12px"> <strong><?php echo $userRow['first_name'].' '.$userRow['last_name']; ?></strong></td>
                            <td style="border-left:1px solid #ddd"><input type="checkbox" name="view_admins[<?php echo $userRow['user_id']; ?>]" value="view_admins" <?php if (checkPermission($userRow['user_id'], 'view_admins', 'admin'))
                                echo 'checked = "checked"'; ?>/>
                                View <br />
                                <input type="checkbox" name="create_admins[<?php echo $userRow['user_id']; ?>]" value="create_admins"  <?php if (checkPermission($userRow['user_id'], 'create_admins', 'admin'))
                                                                          echo 'checked = "checked"'; ?>/>
                                   Create<br />
                                   <input type="checkbox" name="update_admins[<?php echo $userRow['user_id']; ?>]" value="update_admins"  <?php if (checkPermission($userRow['user_id'], 'update_admins', 'admin'))
                                              echo 'checked = "checked"'; ?>/>
                                   Update<br />
                                   <input type="checkbox" name="delete_admins[<?php echo $userRow['user_id']; ?>]" value="delete_admins"  <?php if (checkPermission($userRow['user_id'], 'delete_admins', 'admin'))
                                              echo 'checked = "checked"'; ?>/>
                                   Delete<br />
                               </td>

                               <td style="border-left:1px solid #ddd"><input type="checkbox" name="view_agent[<?php echo $userRow['user_id']; ?>]" value="view_agent"  <?php if (checkPermission($userRow['user_id'], 'view_agent', 'admin'))
                                              echo 'checked = "checked"'; ?>/>
                                    View<br />
                                    <input type="checkbox" name="create_agent[<?php echo $userRow['user_id']; ?>]" value="create_agent" <?php if (checkPermission($userRow['user_id'], 'create_agent', 'admin'))
                                                                              echo 'checked = "checked"'; ?>/>
                                   Create<br />
                                   <input type="checkbox" name="update_agent[<?php echo $userRow['user_id']; ?>]" value="update_agent"  <?php if (checkPermission($userRow['user_id'], 'update_agent', 'admin'))
                                              echo 'checked = "checked"'; ?>/>
                                   Update <br />
                                   <input type="checkbox" name="delete_agent[<?php echo $userRow['user_id']; ?>]" value="delete_agent"  <?php if (checkPermission($userRow['user_id'], 'delete_agent', 'admin'))
                                              echo 'checked = "checked"'; ?>/>
                                   Delete </td>

                               <td style="border-left:1px solid #ddd"><input type="checkbox" name="manage_permission[<?php echo $userRow['user_id']; ?>]" value="manage_permission"  <?php if (checkPermission($userRow['user_id'], 'manage_permission', 'admin'))
                                              echo 'checked = "checked"'; ?>/>
                                Manage Permissions </td>

                               <td style="border-left:1px solid #ddd"><input type="checkbox" name="view_bankaccounts[<?php echo $userRow['user_id']; ?>]" value="view_bankaccounts"  <?php if (checkPermission($userRow['user_id'], 'view_bankaccounts', 'admin'))
                                              echo 'checked = "checked"'; ?>/>
                                    View<br />
                                    <input type="checkbox" name="add_bankaccounts[<?php echo $userRow['user_id']; ?>]" value="add_bankaccounts" <?php if (checkPermission($userRow['user_id'], 'add_bankaccounts', 'admin'))
                                                                              echo 'checked = "checked"'; ?>/>
                                   Create<br />
                                   <input type="checkbox" name="edit_bankaccounts[<?php echo $userRow['user_id']; ?>]" value="edit_bankaccounts"  <?php if (checkPermission($userRow['user_id'], 'edit_bankaccounts', 'admin'))
                                              echo 'checked = "checked"'; ?>/>
                                   Update <br />
                                   <input type="checkbox" name="delete_bankaccounts[<?php echo $userRow['user_id']; ?>]" value="delete_bankaccounts"  <?php if (checkPermission($userRow['user_id'], 'delete_bankaccounts', 'admin'))
                                              echo 'checked = "checked"'; ?>/>
                                   Delete </td>
                    </tr>

                    <?php
                       }
                    ?>

                    <tr>
                        <td colspan="10">
                            <input name="submit" type="submit" value="Save Permissions"  class="button"/>
                        </td>
                    </tr>
                </table>
            </form>
            <div class="clear">&nbsp;</div>

            <!-- End .clear -->

        </div>
        <!-- End .content-box-content -->
    </div>
    <!-- End .content-box -->
    <!-- End .content-box -->
    <!-- End .content-box -->
    <div class="clear"></div>
    <!-- Start Notifications -->
    <!-- End Notifications -->
    <div id="footer"> <small>
            <!-- Remove this notice or replace it with whatever you want -->
        </small> </div>
    <!-- End #footer -->
</div>
<!-- End #main-content -->
</div>
</body><!-- Download From www.exet.tk-->
</html>