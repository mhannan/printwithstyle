<?php
require('include/gatekeeper.php');

$_SESSION['urlselected'] = 'pages';
require('../header.php');

require_once("../lib/func.pages.php");


if(!checkPermission($_SESSION['admin_id'] , 'manage_pages', 'admin'))
{ 
    $errmsg = base64_encode('You are not allowed to view that Page');
    echo "<script> window.location = '../index.php?errmsg=$errmsg';</script>";
    exit;
 
} 

	 $customerFilter = "";
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
 
 
<!-- that's IT-->	 
<div id="main-content"> <!-- Main Content Section with everything --> 
<?php 	
 if(isset($_GET['okmsg']))
{
?>
   <div class="notification success png_bg">
				<a href="#" class="close"><img src="<?php echo siteURL?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div><?php echo base64_decode($_GET['okmsg']);?></div>
			</div>

<?php			
	}
		
	if(isset($_GET['errmsg']))
		{
?>
  		  <div class="notification error png_bg">
			 <a href="#" class="close"><img src="<?php echo siteURL?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>					<?php echo base64_decode($_GET['errmsg']);?>				</div>
			</div>

<?php			
		}
		
		$tab_show_class='default-tab';
		$show_my_tab= "";
		if(isset($_REQUEST['customer']))
		{
			$tab_show_class='';	  
			$show_my_tab= "default-tab";
			//echo ""
			$customer=$_REQUEST['select_customer'];
		}
?>
	
			<div class="content-box"><!-- Start Content Box --> 
				
				<div class="content-box-header">
					<h3>Manage Front Pages</h3>
					<ul class="content-box-tabs">
						<li> <a href="#tab1" class="<?php echo $tab_show_class;?>">Listing </a> </li> <!-- href must be unique and match the id of target div -->
						<?php
                                                  if(checkPermission($_SESSION['admin_id'] , 'add_pages', 'admin'))
                                                       echo "<li><a href='#tab2' >Add New</a></li>";
                                                ?>
						<!-- Customer Search tab -->
						<!-- <li><a href="#tab3" class="< ?php echo $show_my_tab;?>">Search</a></li> -->
					</ul>
					<div class="clear:both"></div>
				</div> <!-- End .content-box-header -->

				<div class="content-box-content">
					<div class="tab-content <?php echo $tab_show_class;?>" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
					 
                        
                                        <table>
                                                <thead>
                                                    <tr bgcolor="#CCFFCC">
                                                       <!--<th><input class="check-all" type="checkbox" /></th>-->

                                                       <th><b>S.No</b>	</th>
                                                       <th><b>Page Name</b>	</th>
                                                       <th><b>Slug</b></th>
                                                       <th><b>Content</b></th>
                                                      
                                                       <th><b>Action</b></th>
                                                    </tr>
                                                 </thead>
			
							<?php
							 	$pagesSet = getPages_info();	// filter is being initialized on top of page and bein updated in filter part
								
								$i = 1;
								while($pageRec = mysql_fetch_array($pagesSet))
								{
									
							 ?>
								<tr>
									<!--<td><input type="checkbox" name="customer_id[]" value="< ?php //echo $supply['supplier_id']?>"/></td>-->
									 
									<td><?php echo $i ?></td>
									<td><?php echo $pageRec['page_name']; ?> </td>
                                                                                  
                                                                        <td><?php echo $pageRec['page_slug']; ?></td>
									
                                                                        <td><?php echo substr($pageRec['page_content'], 0, 100).'...'; ?> 	</td>
									
                                                                        <td><?php
                                                                            if(checkPermission($_SESSION['admin_id'] , 'update_pages', 'admin'))
                                                                                echo "<a href='edit.php?page_id=".$pageRec['page_id']."' title='Edit'><img src='".siteURL."admin/resources/images/icons/pencil.png' alt='Edit' /></a>";
                                                                            if(checkPermission($_SESSION['admin_id'] , 'delete_pages', 'admin'))
                                                                                echo "&nbsp;&nbsp;&nbsp;<a href='do_delete_page.php?page_id=".$pageRec['page_id']."' title='Delete'  onclick=\"return confirm('Are you sure to delete?')\"><img src='".siteURL."admin/resources/images/icons/cross.png' alt='Delete' /></a>";
                                                                            ?>
                              
                                                                      </td>
 								</tr>
							 
                            <?php			
									 
									$i++;
								}
							?>
					</table>
		

<!--						</form> -->
					</div> <!-- End #tab1 -->
					
					<div class="tab-content" id="tab2">
                                            <h3> Create New Page </h3>

                                           <form action="do_add_page.php" method="post" name="manage_account" id="myform" enctype="multipart/form-data" >
                                                        
                                              <table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
                                                  <tr>
                                                         <td style="padding:4px">Page Name</td>
                                                         <td style="padding:4px"> <input class="text-input small-input required" type="text" id="txtField" name="pageName"   /></td>
                                                  </tr>

                                                  <tr>
                                                    <td style="padding:4px">Page Slug</td>
                                                    <td style="padding:4px"><input class="text-input small-input required" type="text" id="txtField" name="pageSlug"  />
                                                                            <span style="color:#b40d0d;font-size:10px">(no spaces or special characters. i.e. about-us, aboutus)</span></td>
                                                  </tr>
                                                  <tr>
                                                    <td style="padding:4px">Page Banner Image</td>
                                                    <td style="padding:4px"><input class="text-input small-input " type="file" id="txtField" name="page_banner"  /> <span style="color:#888;font-size:10px">(Leave empty if you don't want to use image with page contents)</span></td>
                                                  </tr>
                                                  <tr>
                                                    <td style="padding:4px">Image Appearance</td>
                                                    <td style="padding:4px">
                                                        <div style="float:left"><input type="radio" name="banner_position" id="wide_position" value="top" checked="checked"><img src="<?php echo siteURL?>admin/resources/images/icons/align-wide-on-top.png"> Wide on Top </div>
                                                        <div style="float:left"><input type="radio" name="banner_position" id="left_position" value="left"><img src="<?php echo siteURL?>admin/resources/images/icons/align-left.png"> Left Aligned </div>
                                                        <div style="float:left"><input type="radio" name="banner_position" id="right_position" value="right"><img src="<?php echo siteURL?>admin/resources/images/icons/align-right.png"> Right Aligned </div>
                                                        <div style="clear:both"></div>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                     <td style="padding:4px">Page Content</td>
                                                     <td style="padding:4px"> 
                                                         <textarea name="pageContent" id="tinymce" class="tinymce required" cols="50" rows="20">
                                                         </textarea> </td>
                                                  </tr>
    
                                                  <tr><td></td> <td>&nbsp;<br /><input class="button" type="submit" value="Submit" /></td></tr>
                                                </table>

                                          <!-- End .clear -->
                                            </form>
						
					</div> <!-- End #tab2 -->        
					
					<!-- #tab 3> -->
					<div class="tab-content <?php echo $show_my_tab;?>" id="tab3">
						<!-- ===================== Dummy Block =================== -->
					</div>	
				
					
					<!-- End of tab 3 -->
					
					
					
					
					
					
					
					
					
					
					
					
				</div> <!-- End .content-box-content -->
				
			</div> <!-- End .content-box -->
			<!-- End .content-box -->
			<!-- End .content-box -->
<div class="clear"></div>
			
			
			<!-- Start Notifications -->
			<!-- End Notifications -->
<div id="footer">
				<small> <!-- Remove this notice or replace it with whatever you want -->
		</small>		</div>
<!-- End #footer -->
			
	  </div> <!-- End #main-content -->
		
	</div></body>
  

<!-- Download From www.exet.tk-->
</html>

