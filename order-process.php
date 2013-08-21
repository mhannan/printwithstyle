<div class="body_internal_wrapper">
<?php include("leftsection1.php");
      include("lib/func.page.php"); ?>
    
 	<div class="body_right"><!--body_right-->
   
        <div class="home_wedng_inv_wrapp"><!--home_invitatins_wrapp-->
            <div class="home_wedng_inv_heading"><?php echo 'Order Processing & Shipment'; ?> </div>
            
                    <?php
                       $content = getPage_content_by_slug($_GET['p']);

                        echo "<div style='margin:10px 0px'>".$content."</div>";
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
        <a href="index.php?p=be_designer"><img border="0" src="images/btm_advertise2.png"></a>
</div><!--advertisment-->
</div><!--bottom_advertisment-->