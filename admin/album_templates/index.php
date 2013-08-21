<?php
require('include/gatekeeper.php');

$_SESSION['urlselected'] = 'albumtpl';
require('../header.php');

require_once("../lib/func.customer.packages.php");
require_once("../lib/func.album.tpl.php");


if(!checkPermission($_SESSION['admin_id'] , 'view_template', 'admin'))
{ 
    $errmsg = base64_encode('You are not allowed to view that Page');
    echo "<script> window.location = '../index.php?errmsg=$errmsg';</script>";
    exit;
 
} 
    
     
	 $customerFilter = "";
?>
<script type="text/javascript">

    /* On page reload refresh and empty the page template layouts */
    $(document).ready(function(){
                $('#totalPgElements').val('0');
                $('#page_workArea').html('');
                // also hid property bar All elements (which are in div) while showing (status span)element
                $('#propertyElementsContainer div').hide();
                $('#propertyElementsContainer div:first').show();     // only show property bar label
            });

    

    /*   Save Procedure  */
    function preparePagesHTML_forSave()
    {
        $('#pageHtml_txt').val($('#page_workArea').html());
    }
</script>
<script src="../js/template_processing.js" type="text/javascript"></script>
 
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
					<h3>Manage Templates</h3>
					<ul class="content-box-tabs">
						<li> <a href="#tab1" class="<?php echo $tab_show_class;?>">Listing </a> </li> <!-- href must be unique and match the id of target div -->
						<?php
                                                  if(checkPermission($_SESSION['admin_id'] , 'add_template', 'admin'))
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
                                                       <th><b>Template Title</b>	</th>
                                                       <th><b>Preview</b></th>
                                                       <th><b>For Packages</b></th>
                                                      
                                                       <th><b>Action</b></th>
                                                    </tr>
                                                 </thead>
			
							<?php
							 	$tplSet = getAlbumTpl_info();	// filter is being initialized on top of page and bein updated in filter part
								
								$i = 1;
								while($tplRec = mysql_fetch_array($tplSet))
								{
									
							 ?>
								<tr>
									<!--<td><input type="checkbox" name="customer_id[]" value="< ?php //echo $supply['supplier_id']?>"/></td>-->
									 
									<td><?php echo $i ?></td>
									<td><?php echo $tplRec['tpl_name']; ?> </td>
                                                                                  
                                                                        <td><?php echo "<img src='../../uploads/core/tpl_shots/".$tplRec['tpl_screenshot_path']."' width='100px' style='border:1px solid #ccc'>"; ?></td>
									
									<td><?php echo getBgSelectedPackages_inHTML($tplRec['tpl_for_packages'], ''); ?> 	</td>
									
                                                                        <td><?php
                                                                            if(checkPermission($_SESSION['admin_id'] , 'update_template', 'admin'))
                                                                                echo "<a href='edit.php?tpl_id=".$tplRec['tpl_id']."' title='Edit'><img src='".siteURL."admin/resources/images/icons/pencil.png' alt='Edit' /></a>";
                                                                            if(checkPermission($_SESSION['admin_id'] , 'delete_template', 'admin'))
                                                                                echo "&nbsp;&nbsp;&nbsp;<a href='do_delete_tpl.php?tpl_id=".$tplRec['tpl_id']."' title='Delete'  onclick=\"return confirm('Are you sure to delete?')\"><img src='".siteURL."admin/resources/images/icons/cross.png' alt='Delete' /></a>";
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
                                            <h3> Add New Template </h3>

                                            <form action="do_add_tpl.php" method="post" name="manage_account" id="myform" enctype="multipart/form-data" onsubmit="preparePagesHTML_forSave()" >
                                                        
                                              <table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
                                                  <tr>
                                                         <td style="padding:4px">Template Title</td>
                                                         <td style="padding:4px"> <input class="text-input small-input required" type="text" id="txtField" name="tplTitle"   /></td>
                                                  </tr>

                                                  <tr>
                                                     <td style="padding:4px">Template for Packages</td>
                                                     <td style="padding:4px"> <?php echo getPackages_inHTML('checkbox','package_types[]'); ?> </td>
                                                  </tr>

                                                  <tr>
                                                         <td style="padding:4px">Template Sample Preview</td>
                                                         <td style="padding:4px"> <input type="file" name="tpl_preview"> &nbsp;&nbsp;&nbsp;&nbsp;<br>
                                                                            <span style="font-size:9px">[Upload your prepared sample screenshot (prepared from front end using this template)]</span></td>
                                                  </tr>
    
                                                  <tr><td><input type="hidden" id="pageHtml_txt" name="pageHtml_txt"></td>
                                                      <td>&nbsp;<br /><input class="button" type="submit" value="Save Template" /></td></tr>

                                                  <tr>
                                                      <td colspan="2">
                                                          <div align="center" style="text-align:center;padding:0px 0px 8px 200px "><div style="float:left"><img src="../resources/images/icons/stock_file-with-objects.png"></div><div style="float:left; margin-top: 4px"> <strong>Create Your Template</strong></div><div style="clear:both"></div><input type="hidden" id="selectedPicContainer" value=""></div>


                                                          <!-- Tool Box Left side -->
                                                          <div style="float:left; width:50px; background-color: #f2f2f2; border:1px solid #666;padding:8px 0px 0px 4px">
                                                              <a href="javascript:addImageBlock('#page_workArea');"><img src="<?php echo siteURL;?>admin/resources/images/icons/icon_drop_imgbox.png" border="0"></a>
                                                              <br><br>
                                                              <a href="javascript:addTextBlock('#page_workArea');"><img src="<?php echo siteURL;?>admin/resources/images/icons/icon_drop_textbox.png" border="0"></a>
                                                              <input type="hidden" value="0" id="totalPgElements" name="totalPgElements">
                                                          </div>

                                                          <!-- Work Space Area -->
                                                          <div style="float:left; width:auto; margin-left: 46px">
                                                              <table border="0" cellpadding="4" cellspacing="0" class="workTbl">
                                                                  <tr><td style="text-align:center; height: 45px; padding:0px; background-color:#fff">
                                                                          <div class="templateDimention" >
                                                                              <div style="float:left; width:180px;border-right: dotted 2px #999; padding-left:5px"><b>Template Dimension </b></div>
                                                                              <div style="float:left; margin-left: 20px">
                                                                                    <select name="existingDimension" id="existingDimension" onchange="loadDimensions_to_fields('existingDimension','t_width', 't_height')">
                                                                                        <option value="0">- Existing Dimensions -</option>
                                                                                        <?php echo getTplDimensions_optionsHTML(); ?>
                                                                                    </select></div>
                                                                              <div style="float:left; margin-left: 20px">
                                                                                    W:<input type="text" id="t_width" value="750px" ></div>
                                                                              <div style="float:left; margin-left: 20px">
                                                                                    H:<input type="text" id="t_height" value="500px"></div>
                                                                              <div style="float:left; margin-left: 20px"> <input type="hidden" name="appliedTemplateDimension" id="appliedTemplateDimension" value="750px-500px">
                                                                                  <a href="javascript:applyTemplateProperty('.workTbl', '#page_workArea', '#appliedTemplateDimension');">Apply Changes</a></div><div style="clear:both"></div>
                                                                          </div></td></tr>

                                                                  <tr><td style="text-align:center; height: 45px; padding:0px; background-color:#fff">
                                                                          <div id="propertyElementsContainer">
                                                                              <span style="margin-left: 50px">No object selected</span>
                                                                              <div style="float:left; width:120px;border-right: dotted 2px #999; padding-left:5px"><b>Property Bar</b></div>
                                                                              <div style="float:left; margin-left: 20px">
                                                                                    X:<input type="text" id="p_xMargin" value="" style="width:60px !important"></div>
                                                                              <div style="float:left; margin-left: 20px">
                                                                                    Y:<input type="text" id="p_yMargin" value="" style="width:60px !important"></div>
                                                                              <div style="float:left; margin-left: 20px; padding-left:20px; border-left:dotted 2px #999">
                                                                                    W:<input type="text" id="p_width" value="" style="width:60px !important"></div>
                                                                              <div style="float:left; margin-left: 20px">
                                                                                    H:<input type="text" id="p_height" value="" style="width:60px !important"></div>
                                                                              <div style="float:left; margin-left: 20px">
                                                                                  <a href="javascript:applyProperty();">Apply Changes</a></div><div style="clear:both"></div>
                                                                                  <div style="float:left; margin: 8px 0px 0px 20px"><a href="javascript:deleteElement();" class="deleteElement">Delete Element</a></div>
                                                                                  <div style="float:left; margin:8px 0px 0px 40px"> <label title="This will break the elements running queue sequence and will bring selected element on new line."><input type="checkbox" id="p_clearBoth"> Break Queue</label></div>
                                                                              <div style="clear:both"></div>
                                                                          </div></td></tr>
                                                                  <tr>
                                                                      <td id="page_workArea">WORK AREA</td>
                                                                  </tr>
                                                              </table>
                                                          </div>


                                                           

                                                          <div style="clear:both"></div>



                                                      </td>
                                                  </tr>
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

