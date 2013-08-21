<?php
require('include/gatekeeper.php');
require('../header.php');
require_once('../lib/func.common.php');
include( "../lib/func.blogsection.php" );
       if(isset($_REQUEST['articleId']))
	   $blogRes = getBlog_info($_REQUEST['articleId']);
           $blogRow = mysql_fetch_array($blogRes);// print_r($blogRow);
           
?>
<link rel="stylesheet" href="<?php echo siteURL;?>admin/resources/css/tiny_mce_css.css" type="text/css" media="screen" />
<script language="javascript" type="text/javascript" src="../js/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="../js/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
 $().ready(function() {
		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			//script_url : 'tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			// Example content CSS (should be your site CSS)
			content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});

		// initialize question editor
		window.misachotes.questionseditor.init();
		
	});
</script>




<script type="text/javascript">

    function validate_bank_account()
    {
        var flag = true;

        if($('#title').val() =="")
        {
            $('#title').css('border', '1px solid #FF1111');
            flag = false;
        }
        else
            $('#title').css('border', '1px solid #d8d9db');
	
        if($('#description').val() =="")
        {
            $('#description').css('border', '1px solid #FF1111');
            flag = false;
        }
        else
            $('#description').css('border', '1px solid #d8d9db');
	
        if($('#summary').val() =="")
        {
            $('#summary').css('border', '1px solid #FF1111');
            flag = false;
        }
        else
            $('#summary').css('border', '1px solid #d8d9db');

        return flag;
    }

</script>

<div id="main-content">
<!-- Main Content Section with everything -->
<div class="tab-content">

    <div class="content-box-header">
        <h3>Manage  Blog</h3></div><div class="content-box-content">
 
      <h3> Edit  Articles</h3>
       <form action="do_edit_blog.php" enctype="multipart/form-data" method="post" name="manage_account" id="manage_account" onsubmit="return validate_bank_account()">

                <table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
                  <tr>
                         <td width="22%" style="padding:4px">Title</td>
                         <td width="78%" style="padding:4px"> <input class="text-input small-input" type="text" id="title" name="title" value="<?php echo $blogRow['title']; ?>"   />
                            <input  type="hidden" id="articleId" name="articleId" value="<?php echo $_REQUEST['articleId']; ?>"   /></td>
                  </tr>

                  <tr>
                    <td style="padding:4px">Description</td>
                    <td style="padding:4px">
                                 <textarea name="postContent" id="tinymce" class="tinymce required" cols="50" rows="20"><?php echo $blogRow['description']; ?></textarea> </td>
                  </tr>
                  <tr>
                         <td style="padding:4px">Image</td>
                         <td style="padding:4px">
						<input id="image" class="text-input small-input" name="blog_image"  type="file" /> <span style="color:#888; font-size: 10px">(Leave blank to keep old picture unchanged)</span>
                                                 <input id="oldimage" name="oldImg_name"  type="hidden" value="<?php echo $blogRow['image'];?>" />    <br>
                                            <?php
                                                if($blogRow['image']!='')
                                                    echo "<img src='../../uploads/blog_images/".$blogRow['image']."' style='border:1px solid #ccc; padding:3px;' width='120px'>";
                                             ?>
                       </td>
                  </tr>
                
                  <tr><td></td> <td>&nbsp;<br /><input class="button" type="submit" value="Submit" /></td></tr>
                </table>

      <!-- End .clear -->
        </form>
    </div>
</div>
</div>
 <script type="text/javascript">

function validate_user()
{
	var flag = true;
	
	if($('#fullname').val() =="")
	 {
		$('#fullname').css('border', '1px solid #FF1111');
		flag = false;
	 }
	else
		$('#fullname').css('border', '1px solid #d8d9db');
		
	if($('#username').val() =="")
	 {
		$('#username').css('border', '1px solid #FF1111');
		flag = false;
	 }
	 else
		$('#username').css('border', '1px solid #d8d9db');
		
	if($('#password').val() =="")
	 {
		$('#password').css('border', '1px solid #FF1111');
		flag = false;
	 }
	 else
		$('#password').css('border', '1px solid #d8d9db');
		
	if($('#email').val() =="")
	 {
		$('#email').css('border', '1px solid #FF1111');
		flag = false;
	 }
	 else
		$('#emai').css('border', '1px solid #d8d9db');
		
	 

	return flag;
}
 
</script>
</body>
</html>
