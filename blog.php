<div class="body_internal_wrapper">
<?php 
    include("lib/func.blog.php");
    include("leftsection_blog.php");
       ?>
    
 
    <!--body_right-->
    <div class="body_right">

            <!--banner_wrapp-->
            <div class="blog_Wrapp">

            <?php
                $blogRes = getBlogArticles(); 
                while($postRow = mysql_fetch_array($blogRes))
                {
              ?>
                <!--blog_post-->
                <div class="post">

                    <div class="title"><a href="index.php?p=article&id=<?php echo $postRow['id']; ?>" ><?php echo stripslashes($postRow['title']); ?> </a>
                            <div class="date"><?php echo date('d M-y', strtotime($postRow['last_modified'])); ?></div>
                            <div style="clear:both"></div>
                     </div>
                    <div class="meta" style="float:left; width:60%">Posted by <a style="color:#29748C">Admin</a></div>
                    <div class="meta" style="float:right; height:25px; background-image:url(images/icons/user_comment.png); background-repeat: no-repeat; background-position:left;"><div style="padding:5px 0px 0px 28px"> (<?php echo get_article_comments_count($postRow['id']); ?>) Comments</div></div>
                    <div style="clear:both"></div>
                    
                    <div class="entry">

                        <?php
                            $post_textBlockWidth= '720px';      // if no image then max textual content width
                            if(file_exists('uploads/blog_images/'.$postRow['image']) && $postRow['image'] !='')
                                {
                                    echo '<a href="index.php?p=article&id='.$postRow['id'].'"><img src="uploads/blog_images/'.$postRow['image'].'" style="float:left; padding:3px; border:1px solid #ccc; width:200px; margin-right:15px" border="0"></a>';
                                    $post_textBlockWidth= '500px';
                                } ?>

                        <div style="float:left; width:<?php echo $post_textBlockWidth; ?>">
                            <div style="min-height:80px">
                                    <?php
                                        if(strlen($postRow['description'])>450)
                                            echo stripslashes(substr ($postRow['description'], 0, 450)).'...</p>';    // as data from TINY MCE will have </p> closign tag at end that we better to close to avoide any css problem
                                        else
                                            echo stripslashes($postRow['description']); ?>
                            </div>
                            <a href="index.php?p=article&id=<?php echo $postRow['id']; ?>" style="float:left"><img src="images/readmorebtn.png" border="0" /></a>
                            <a href="index.php?p=article&id=<?php echo $postRow['id']; ?>#reply" style="float:right; background-image:url(images/icons/comment_edit_16.gif); background-position:left; background-repeat:no-repeat; padding-left:20px">Post Reply</a>
                            
                        </div>
                        <div style="clear:both"></div>

                    </div>

                </div><!--blog_post-->
               <?php
                }
                ?>


                

            </div><!--banner_wrapp-->



    </div><!--body_right-->


</div><!--body_internal_wrapp-->
</div><!--body_content-->
