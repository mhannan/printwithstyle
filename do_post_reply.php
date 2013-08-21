<?php
include("config/config.php");
//include("admin/classes/upload_class.php");
//include("admin/lib/photo.upload.php");

include('lib/func.blog.php');


	
        if(post_article_comment($_SESSION['user_id'], $_POST['blogPostReplyTxt'], $_POST['article_id']))
        {
             
                 $str = base64_encode('Your comment posted successfully');
                 header('Location: index.php?p=article&id='.$_POST['article_id'].'&msg=succ&str='.$str); exit;
             
             
        }
        else
             $str = base64_encode('Sorry! unable to post comment please try again later');
             header('Location: index.php?p=article&id='.$_POST['article_id'].'&msg=err&str='.$str); exit;
	
?>    
