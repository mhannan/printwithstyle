    <div class="body_internal_wrapper">
       <?php include("leftsection1.php") ?>
        <div class="body_right"><!--body_right-->
            <div class="home_wedng_inv_wrapp"><!--home_invitatins_wrapp-->
        <?php
                if(isset($_GET['msg']) && $_GET['msg']  == "succ")
                     {
                         if(isset($_GET['str']))
                             echo "<div class='alert_success'><div>".base64_decode($_GET['str'])."</div></div>";

                     }
                elseif($_REQUEST['msg'] == "err")
                {
                        echo "<div class='alert_err'><div>".base64_decode($_GET['str'])."</div></div>";
                }

            ?>
                <div class="newcontact_information2"><!--Contact Information-->
                    <form name="login" id="login" method="post" action="lib/func.login.php" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="task" value="login">                    
                        <div class="newodd-contact-main">
                        Sign In
                        </div>
                        <div class="neweven-contact">
                            <div class="newtitle-contact">Email  </div>
                            <div class="newvalue-contact"><input name="email" id="email" type="text" class="tscompany_inputfield" /></div>
                        </div>
                        <div class="newodd-contact">
                            <div class="newtitle-contact1">Password</div>
                            <div class="newvalue-contact1"><input name="password2" id="password" type="password" class="tscompany_inputfield" /></div>
                        </div>
                        <div class="neweven-contact">
                            <div class="newtitle-contact"><input type="hidden" name="return_url" id="return_url" value="<?php if(isset($_GET['return_url'])) echo $_GET['return_url']; ?>"> </div>
                            <div class="newvalue-contact"><input name="submit" type="submit" value="" class="tscompany_inputbtn3" /></div>
                            <div style="padding-left:15px; float:left; margin-top:10px; font-family:Arial, Helvetica, sans-serif; padding-top:3px;">
                            	<a href="#lock" id="changep" class="changpass">Forgot Password?</a>&nbsp;&nbsp;
                            	<a href="<?php echo siteURL;?>index.php?p=register" class="changpass">Join Today</a>
                            </div>
                        </div>
                    </form>
<div class="changediv" style="display:none;">                    
               <form name="login" id="login" method="post" action="do_recover_customer_login.php" enctype="multipart/form-data">
                    <div class="newodd-contact">
                        <div class="newtitle-contact1">Email Address</div>
                        <div class="newvalue-contact1"><input name="your_email" id="your_email" type="text" class="tscompany_inputfield" /></div>
                    </div>
                    
                    <div class="neweven-contact">
                        <div class="newtitle-contact"> </div>
                        <div class="newvalue-contact"><button style="border:none; background:none;" name="submit" value="submit"><img src="images/btn_send.png"></button></div>
                    </div>                
               </form>
</div>               
                </div> 
                
                 
            </div><!--home_invitatins_wrapp-->
        </div><!--body_right-->
    </div><!--body_internal_wrapp-->
</div><!--body_conetnt-->
