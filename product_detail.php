<div class="body_internal_wrapper">
<?php include("leftsection1.php");
      include("lib/func.products.php"); ?>
    
 	<div class="body_right"><!--body_right-->
   
        <div class="home_wedng_inv_wrapp"><!--home_invitatins_wrapp-->
            <div class="home_wedng_inv_heading"><?php echo $cat_title = getCatName_byId($_GET['cid'], $objDb); ?> </div>
            <?php
                        $res = getCards_byCatId($_GET['cid'], $objDb);
                        $i =1; 
                        if(mysql_num_rows($res)>0)
                            while($row = mysql_fetch_array($res))
                            {
                        ?>
                                <div class="home_product_post" style="width:auto"><!--product_post-->
                                    <div class="home_product_display" style="width:auto">
                                       <img src="uploads/sample_cards/<?php echo $row['card_sample_path']; ?>" height="223px"/>
                                    </div>
                                    <div class="top_selling_product_info">
                                            <?php echo $row['card_title']; ?><br /> <span><?php echo $cat_title; ?> <br />
                                                <?php
                                                    $lowestUnit_price = getCard_unitLowestPrice($row['card_id'], $objDb);
                                                    if($lowestUnit_price)
                                                        echo 'As low as $'.$lowestUnit_price; ?>
                                               </span>
                                        </div>
                                </div><!--product_post-->
                        <?php
                                $i++;
                            }
                        if($i==1)
                            echo "<div style='margin:10px 0px'>No item found</div>";
                    ?>

                
        </div><!--home_invitatins_wrapp-->
        
</div><!--body_right-->
</div><!--body_internal_wrapp-->
</div><!--body_conetnt-->
<!--bottom_advertisment-->
<div class="btm_advertise_wrapper">
<!--advertisment-->
<div class="advertisment">
        <img src="images/btm_advertise.png" />
</div><!--advertisment-->
<!--advertisment-->
<div class="advertisment2">
        <a href="index.php?p=be_designer"><img src="images/btm_advertise2.png" border="0" /></a>
</div><!--advertisment-->
</div><!--bottom_advertisment-->