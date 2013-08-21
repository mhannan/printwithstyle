<div class="body_internal_wrapper">
<?php 
      include("lib/func.blog.php");
      include("leftsection_blog.php");
      ?>
    
 
    <!--body_right-->
    <div class="body_right">

        <?php

             if(isset($_GET['msg']) && $_GET['msg']  == "succ")
             {
                 if(isset($_GET['str']))
                     echo "<div class='alert_success'><div>".base64_decode($_GET['str'])."</div></div>";

             }
              elseif(isset($_GET['msg']) && $_GET['msg'] == 'err')
              {
                  if(isset($_GET['str']))
                      echo "<div class='alert_success'><div>".base64_decode($_GET['str'])."</div></div>";

              }


            ?>

            <!--banner_wrapp-->
            <div class="blog_Wrapp">

            <?php
                update_post_view_counter($_GET['id']);  // this updates the post counter in order to stand it for popularity
                $blogRes = getBlogArticles($_GET['id']);
                $postRow = mysql_fetch_array($blogRes)
                
              ?>
                <!--blog_post-->
                <div class="post" style="float:none">

                    <div class="title"><a href="#" ><?php echo stripslashes($postRow['title']); ?> </a>
                            <div class="date"><?php echo date('d M-y', strtotime($postRow['last_modified'])); ?></div>
                            <div style="clear:both"></div>
                     </div>
                    <div class="meta" style="float:left; width:60%">Posted by <a style="color:#29748C">Admin</a></div>
                    <div class="meta" style="float:right; height:25px; background-image:url(images/icons/user_comment.png); background-repeat: no-repeat; background-position:left;"><div style="padding:5px 0px 0px 28px"> (<?php echo get_article_comments_count($_GET['id']); ?>) Comments</div></div>
                    <div style="clear:both"></div>
                    
                    <div class="entry">
                        <?php if(file_exists('uploads/blog_images/'.$postRow['image']) && $postRow['image'] !='')
                                {
                                    // deciding image dimension to display
                                    list($width, $height) = getimagesize('uploads/blog_images/'.$postRow['image']);
                                    if($width >= 400)
                                    {
                                        $float='none';
                                        if($width >= 715)       // if image width is greater than the page wrapper then restrict to page width
                                            $width = 715;
                                    }
                                    else
                                        $float = 'left';
                                    echo '<img src="uploads/blog_images/'.$postRow['image'].'" style="float:'.$float.'; padding:3px; border:1px solid #ccc; width:'.$width.'; margin-right:15px">';
                                    
                                } ?>
                        <p> <?php echo stripslashes($postRow['description']); ?></p>

                       
                        <a href="#reply" style="float:right; background-image:url(images/icons/comment_edit_16.gif); background-position:left; background-repeat:no-repeat; padding-left:20px">Post Reply</a>
                    </div>

                </div><!--blog_post-->

                <?php
                    $i=1;
                    $commentSet = get_article_comments($_GET['id']);
                    while($row = mysql_fetch_array($commentSet))
                    {

                   ?>
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr valign="top">
                        <td width="140px">
                            <div align="center" style="color:#2B6FB6"><?php echo $row['u_name']; ?></div>
                            <div align="center">
                                <?php
                                    $profile_pic_path = "images/no-photo.jpg";
                                    if($row['profile_pic_path'] !='')
                                        $profile_pic_path = "uploads/customer_profile_pics/".$row['profile_pic_path'];
                                    echo "<img src='".$profile_pic_path."' width='80px' style='padding:3px; border:1px solid #ccc'>";
                                 ?>
                            </div>
                            <div align="center"><?php echo date('d M-Y', strtotime($row['date_commented'])); ?></div>
                        </td>
                        <td width="600px">
                            <table border="0" cellpadding="0" cellspacing="0" style="background-image:url(images/comment_bg_repeat.jpg); background-repeat:repeat-y" width="100%">
                                <tr><td style="background-image:url(images/comment_top.jpg); background-repeat: no-repeat; background-position:top left; padding:20px 10px 0px 40px;">
                                        <div style="min-height:80px"><?php echo nl2br($row['comments']); ?></div>

                                    </td></tr>
                                <tr><td style="background-image:url(images/comment_bottom.jpg); height:14px"></td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <?php
                    $i++;
                    }
                    if($i==1)   // no comment found then give message that no comment posted
                        echo "<div style='background-color:#F6F6F6; padding:8px; border:1px dashed #888;margin-top:20px'>(No comments posted)</div>"
                ?>

                <br><br>

                <form name="replyForm" id="replyForm" action="do_post_reply.php" method="post">
                <table border="0" cellpadding="0" cellspacing="0" style="background-image:url(images/comment_post_reply_middle_bg.jpg); background-repeat:repeat-y; " width="100%">
                    <tr><td style="background-image:url(images/comment_post_reply_bg.jpg); background-repeat: no-repeat; background-position:top left; padding:20px 15px 0px 15px;">
                            <div style="background-image:url(images/comment_edit.png); background-repeat:no-repeat; background-position: top right; height:34px"><b>Post Reply &raquo; </b> <a name="reply" id="reply">&nbsp;</a></div>
                            <textarea name="blogPostReplyTxt" id="blogPostReplyTxt" style="width:700px; height:80px;float:none"></textarea>
                            <input type="hidden" name="article_id" value="<?php echo $_GET['id']; ?>">
                            <?php if( isset($_SESSION['user_id']) && $_SESSION['user_id'] != "NULL" )
                                    {
                                ?>
                                    <div align="right">&nbsp;<br><button style="background:none; border:none" name="submit" id="submit"><img src="images/btn_send_blue.png"/></button></div>
                           <?php
                                    }
                                    else
                                        echo "&nbsp;<br>You need to login in order to post reply. <a href='index.php?p=login&return_url=".base64_encode('index.php?p=article&id='.$_GET['id'])."'>Login Here</a><br>&nbsp;";
                                ?>
                        </td></tr>
                    <tr><td style="background-image:url(images/comment_post_reply_bottom.jpg); background-repeat:no-repeat; height:11px"></td></tr>
                </table>
                </form>


                

            </div><!--banner_wrapp-->



    </div><!--body_right-->


</div><!--body_internal_wrapp-->
</div><!--body_content-->
