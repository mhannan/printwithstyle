<div class="body_internal_wrapper">
    <?php
    include ("lib/func.products.php");
    include ("leftsection1.php");
    ?>

    <div class="body_right">
        <!--body_right-->
        <div class="banner_wrapp">
            <!--banner_wrapp-->
            <img src="images/banner.png" />
            <div class="banner_btns">
                <a href="index.php?p=products&cid=1"><img src="images/shop_wed_btn.png" border="0"/></a><a href="index.php?p=products&cid=2"><img src="images/save_date_btn.png" border="0"/></a>
            </div>
        </div><!--banner_wrapp-->
        <div class="home_wedng_inv_wrapp">
            <!--home_invitatins_wrapp-->
            <div class="home_wedng_inv_heading">
                <a href="<?php echo siteURL; ?>index.php?p=products&cid=1">Our Wedding Invitations</a>
            </div>

            <?php
            $res = getLatest_addedCards(3, $objDb);
            while ($row = mysql_fetch_array($res)) :
                $url = get_card_url($row['cat_id'], $row['card_id']);
                $img_path = !empty($row['card_thumbnail_path']) ? $row['card_thumbnail_path'] : $row['card_sample_path'];
                ?>
                <div class="home_product_post" style="width:auto; height: auto;">
                    <!--product_post-->
                    <div class="home_product_display" style="width:auto; height: auto;">
                        <a href="<?php echo $url; ?>"><img src="<?php echo SAMPLE_CARDS . $img_path; ?>"/></a>
                    </div>
                    <div class="top_selling_product_info">
                        <?php echo '<a href="' . $url . '">' . $row['card_title'] . '</a>'; ?>
                        <br />
                        <span><?php echo $row['cat_title']; ?>
                            <br />
                            <?php
                            $lowestUnit_price = getCard_unitLowestPrice($row['card_id'], $objDb);
                            if ($lowestUnit_price)
                                echo 'As low as $' . $lowestUnit_price;
                            ?></span>
                    </div>
                </div><!--product_post-->
            <?php endwhile; ?>
            <a style="clear:both; float: right; text-decoration: underline;" href="<?php echo siteURL; ?>index.php?p=products&cid=1">See All Invitations</a>
        </div><!--home_invitatins_wrapp-->
        <!--lower_body_content-->
        <div class="lower_right_conent">
            <!--testimonial_wrapp-->
            <script type="text/javascript" src="js/testimonial_slider/js/jquery.bxslider.min.js"></script>
            <link rel="stylesheet" href="js/testimonial_slider/css/style.css"/>

            <div class="bx-wrapper">
                <div class="home_wedng_inv_heading">
                    <a href="index.php?p=testimonials">What People are Saying</a>
                </div>
                <div class="testimonials-slider">
                    <?php
                    $sql = "
                            SELECT testimonial, date_posted, u_name 
                            FROM testimonials
                            INNER JOIN register_users ON register_users.id = testimonials.user_id 
                            WHERE testimonials.is_approved = 1 ORDER BY rand()";
                    $testimonial = mysql_query($sql);
                    if (is_resource($testimonial) && mysql_num_rows($testimonial)) {
                        while ($testi = mysql_fetch_object($testimonial)) {
                            ?>
                            <div class="slide">
                                <div class="testimonials-carousel-thumbnail"><a href="index.php?p=testimonials"><img src="images/testimonial_thumb.png" border="0" /></a></div>
                                <div class="testimonials-carousel-context">
                                    <div class="testimonials-name">
                                        <?php echo "<strong>{$testi->u_name}</strong><span>" . date('F j, Y', strtotime($testi->date_posted)) . "</span>"; ?>
                                    </div>
                                    <div class="testimonials-carousel-content">
                                        <p>
                                            <?php echo $testi->testimonial; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>


                <div class="clear"></div>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('.testimonials-slider').bxSlider({
                            slideWidth: 800,
                            minSlides: 1,
                            maxSlides: 1,
                            slideMargin: 32,
                            auto: true,
                            autoControls: true
                        });
                    });
                </script>
                <?php if (FALSE): ?>
                    <div class="testimonail_content">
                        <a href="index.php?p=testimonials"><img src="images/testimonial_thumb.png" border="0" /></a>
                        <?php
                        $sql = "
					SELECT testimonial, date_posted, u_name 
					FROM testimonials
					INNER JOIN register_users ON register_users.id = testimonials.user_id 
					WHERE testimonials.is_approved = 1 ORDER BY rand() LIMIT 1";
                        $testimonial = mysql_query($sql);
                        if (is_resource($testimonial) && mysql_num_rows($testimonial)) {
                            $testi = mysql_fetch_object($testimonial);
                            echo "<strong>{$testi->u_name}</strong><span>" . date('F j, Y', strtotime($testi->date_posted)) . "</span>";
                            echo "<p>{$testi->testimonial}</p>";
                        }
                        ?>
                        <div class="readmore_btn">
                            <a href="index.php?p=testimonials"><img src="images/readmore_btn.png" border="0" /></a>
                        </div>
                    </div>
                <?php endif; ?>
            </div><!--testimonial_wrapp-->
            <div class="social-wrapper">
                <a href="http://twitter.com/weddingprintings" target="_blank" title="Twitter"><img width="50"src="images/twitter-round-64.png" /></a>
                <a href="http://www.facebook.com/weddingprintings" target="_blank" title="Facebook Page"><img width="50" src="images/facebook-round-64.png" /></a>
                <a href="https://plus.google.com/weddingprintings" target="_blank" title="Google Plus"><img width="50" src="images/google_plus-round-64.png" /></a>
            </div>

            <!--social_media_wrapp-- >
            <div class="social_connect_wrapp">
                    <div class="home_wedng_inv_heading">
                            Connect With Us
                    </div>
                    <div class="social_content">
                            <div class="socisl_post">
                                    <a href="http://www.facebook.com/pages/Send-With-Style/304666636256713" target="_blank">
                                    <div class="social_icon"><img src="images/fb.png" />
                                    </div>
                                    <div class="social_text">
                                            Follow On Facebook
                                    </div> </a>
                            </div>
                            <div class="socisl_post">
                                    <a href="https://twitter.com/#!/SendWithStyle" target="_blank">
                                    <div class="social_icon"><img src="images/tw.png" />
                                    </div>
                                    <div class="social_text">
                                            Follow On Twitter
                                    </div> </a>
                            </div>
                            <div class="socisl_post">
                                    <div class="social_icon">
                                            <a href="index.php?p=blog"><img src="images/blog.png" border="0" /></a>
                                    </div>
                                    <div class="social_text">
                                            <a href="index.php?p=blog">Check Out Our Blog</a>
                                    </div>
                            </div>
                    </div>
            </div><!--social_media_wrapp-->
        </div><!--lower_body_content-->
    </div><!--body_right-->
</div><!--body_internal_wrapp-->
</div><!--body_conetnt-->
<!--bottom_advertisment-->

<?php if (FALSE): //commented    ?>
    <div class="btm_advertise_wrapper">
        <!--advertisment-->
        <div class="advertisment">
            <a href="index.php?p=affiliate"><img src="images/btm_advertise.png" border="0" /></a>
        </div><!--advertisment-->
        <!--advertisment-->
        <div class="advertisment2">
            <a href="index.php?p=be_designer"><img src="images/btm_advertise2.png" border="0" /></a>
        </div><!--advertisment-->
    </div><!--bottom_advertisment-->
<?php endif; ?>