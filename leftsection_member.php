   <div class="body_left">
        	<div class="side_angl"><img src="images/side_angl.png" /></div>
            <div class="left_navigation">
                  <div class="left_nav_heading">My Account</div>
                    <ul id="left_menu">
                        <li><a href="<?php echo siteURL;?>?p=update_account">Change Account Info</a></li>
                        <li><a href="<?php echo siteURL;?>?p=member_guestbook">My Guest Book</a></li>
                        <li><a href="<?php echo siteURL;?>?p=member_favorites">My Favorites</a></li>
                        <li><a href="<?php echo siteURL;?>?p=member_orders">My Orders</a></li>
                    </ul>
                     <div style="margin-left:50px;width:106px;padding:3px; border:1px solid #ccc"><img src="<?php echo $profile_pic_path; // value being set in update_acount.php as this file has been included there?>" width="100px"></div>
                  </div><!--left_navigation-->
            <div class="top_selling_wrapp" style="margin-top:40px">
                    <div class="top_selling_heading">Top Selling Invitation</div>
                    <div class="top_selling_container">
                            <div class="topselling_product">
                                    <img src="images/top_selling.png" style="width: 158px; height: 224px;" />
                            </div>
                            <div class="top_selling_product_info">
                                Vision Of Love<br /> <span>Weddig Invitation <br /> As low as $1.74</span>
                            </div>
                    </div>
            </div><!--top_selling-->
            <div class="news_letter_wrapp">
                    <div class="newsletter_heading">Newsletter Signup</div>
                    <div class="newsletter_text">To Receive a FREE Etiquette Guide and More!</div>
                    <p>
                    <input name="" type="text" class="signup_field" value="First time customers only" />
                    <input name="" type="button" class="newsletter_signup_btn" />
                    </p>
            </div>
            <div class="news_letter_bottom"></div>
  </div><!--body_left-->