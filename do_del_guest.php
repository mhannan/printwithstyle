<?php 
	include("lib/func.user.php");
        include("lib/func.user.guest.php");
	
	
	$user_id = $_SESSION['user_id'];
	

        if(validate_user($objDb))
        {
             if(isset($_GET['gid']))
             {
                 deleteGuest($_GET['gid'],$user_id, $objDb);
                 $str = base64_encode('Guest contact successfully deleted'); 
                 header('Location: index.php?p=member_guestbook&msg=succ&str='.$str); exit;
             }
             else
              {
                 $str = base64_encode('Sorry! unable to delete guest contact. please try again later');
                 header('Location: index.php?p=member_guestbook&msg=err&str='.$str); exit;
              }
        }
        else
             header('Location: index.php'); exit;
	
?>    
