<?php
require('include/gatekeeper.php');
require('../header.php');
require_once("../lib/func.pages.php");
	   
       if(isset($_REQUEST['page_id']))
	   $pageSet =  getPages_info($_REQUEST['page_id']);
           $pageRec = mysql_fetch_array($pageSet);// print_r($bankAccountRec);
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

<div id="main-content">
<!-- Main Content Section with everything -->
<div class="tab-content">

    <div class="content-box-header">
        <h3>Manage Backgrounds</h3>

    </div>
  	
    <div class="content-box-content">
 
      <h3> Edit Background Detail </h3>
       <form action="do_edit_page.php" method="post" name="manage_account" id="myform"  enctype="multipart/form-data" >

                 <table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
                      <tr>
                             <td style="padding:4px">Page Name
                                                    <input type="hidden" name="page_id" value="<?php echo $pageRec['page_id']; ?>">
                                                    </td>
                             <td style="padding:4px"> <input class="text-input small-input required" type="text" id="txtField" name="pageName" value="<?php echo $pageRec['page_name']; ?>"   /></td>
                            
                      </tr>

                      <tr>
                        <td style="padding:4px">Page Slug</td>
                        <td style="padding:4px"><input class="text-input small-input required " type="text" id="txtField" name="pageSlug" value="<?php echo $pageRec['page_slug']; ?>"  />
                                               <span style="color:#b40d0d;font-size:10px">(no spaces or special characters. i.e. about-us, aboutus)</span></td>
                      </tr>
                      <tr>
                            <td style="padding:4px">Page Banner Image</td>
                            <td style="padding:4px"><input class="text-input small-input " type="file" id="txtField" name="page_banner"  /> <span style="color:#888;font-size:10px">(Leave empty to keep old unchanged)</span>
                                <?php if($pageRec['banner_image']!= '')
                                        echo "<br><img src='../../uploads/page_banner/".$pageRec['banner_image']."' style='padding:3px; border:1px solid #ccc' width='120px'>"; ?>
                                <input type="hidden" name="oldpic" value="<?php echo $pageRec['banner_image']; ?>">
                            </td>
                      </tr>
                      <tr>
                            <td style="padding:4px">Image Appearance</td>
                            <td style="padding:4px">
                                <div style="float:left"><input type="radio" name="banner_position" id="wide_position" value="top" <?php if($pageRec['banner_position']== 'top') echo 'checked="checked"' ?> ><img src="<?php echo siteURL?>admin/resources/images/icons/align-wide-on-top.png"> Wide on Top </div>
                                <div style="float:left"><input type="radio" name="banner_position" id="left_position" value="left" <?php if($pageRec['banner_position']== 'left') echo 'checked="checked"' ?>><img src="<?php echo siteURL?>admin/resources/images/icons/align-left.png"> Left Aligned </div>
                                <div style="float:left"><input type="radio" name="banner_position" id="right_position" value="right" <?php if($pageRec['banner_position']== 'right') echo 'checked="checked"' ?>><img src="<?php echo siteURL?>admin/resources/images/icons/align-right.png"> Right Aligned </div>
                                <div style="clear:both"></div>
                            </td>
                      </tr>
                      <tr>
                         <td style="padding:4px">Page Content</td>
                         <td style="padding:4px">
                             <textarea name="pageContent" id="tinymce" class="tinymce required" cols="50" rows="20"><?php echo $pageRec['page_content']; ?>
                             </textarea> </td>
                      </tr>
                      <tr><td></td> <td>&nbsp;<br /><input class="button" type="submit" value="Submit" /></td></tr>
                    </table>

      <!-- End .clear -->
        </form>
    </div>
</div>
</div>

</body>
</html>
