<?php
require('include/gatekeeper.php');
require('../header.php');
require_once('../lib/func.album.tpl.php');
require_once("../lib/func.customer.packages.php");
	   
       if(isset($_REQUEST['tpl_id']))
	   $tplSet =  getAlbumTpl_info($_REQUEST['tpl_id']);
           $tplRec = mysql_fetch_array($tplSet);// print_r($bankAccountRec);
           $tplDimensionArray = explode('-', $tplRec['tpl_dimension']);
           $tplWidth = $tplDimensionArray[0];   // w : INDEX-0
           $tplHeight = $tplDimensionArray[1];   // h : INDEX-0
?>

<script type="text/javascript">

    /* On page reload refresh and empty the page template layouts */
    $(document).ready(function(){
                
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


<div id="main-content">
<!-- Main Content Section with everything -->
<div class="tab-content">

    <div class="content-box-header">
        <h3>Manage Templates</h3>

    </div>
  	
    <div class="content-box-content">
 
      <h3> Edit Template Detail </h3>
        <form action="do_edit_tpl.php" method="post" name="manage_account" id="myform" enctype="multipart/form-data" onsubmit="preparePagesHTML_forSave()" >

              <table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
                  <tr>
                         <td style="padding:4px">Template Title <input type="hidden" name="tpl_id" id="tpl_id" value="<?php echo $_GET['tpl_id']; ?>"> </td>
                         <td style="padding:4px"> <input class="text-input small-input required" type="text" id="txtField" name="tplTitle" value="<?php echo $tplRec['tpl_name']; ?>"   /></td>
                  </tr>

                  <tr>
                     <td style="padding:4px">Template for Packages</td>
                     <td style="padding:4px"> <?php echo getBgSelectedPackages_inHTML($tplRec['tpl_for_packages'],'package_types[]', 'checkbox'); ?> </td>
                  </tr>
                  <tr>
                         <td style="padding:4px">Template Sample Preview</td>
                         <td style="padding:4px"> <input type="file" name="tpl_preview"> &nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:9px;"> (Leave blank to retain old file)</span>
                             <div style="font-size:9px; margin-top:8px">[Upload your prepared sample screenshot (prepared from front end using this template)]</div></td>
                  </tr>

                  <tr ><td><input type="hidden" id="pageHtml_txt" name="pageHtml_txt" value=""></td>
                       
                      <td>&nbsp;<br /><input class="button" type="submit" value="Save Template" /></td></tr>

                  <tr>
                      <td colspan="2">
                          <div align="center" style="text-align:center;padding:0px 0px 8px 200px "><div style="float:left"><img src="../resources/images/icons/stock_file-with-objects.png"></div><div style="float:left; margin-top: 4px"> <strong>Create Your Template</strong></div><div style="clear:both"></div><input type="hidden" id="selectedPicContainer" value=""></div>


                          <!-- Tool Box Left side -->
                          <div style="float:left; width:50px; background-color: #f2f2f2; border:1px solid #666;padding:8px 0px 0px 4px">
                              <a href="javascript:addImageBlock('#page_workArea');"><img src="<?php echo siteURL;?>admin/resources/images/icons/icon_drop_imgbox.png" border="0"></a>
                              <br><br>
                              <a href="javascript:addTextBlock('#page_workArea');"><img src="<?php echo siteURL;?>admin/resources/images/icons/icon_drop_textbox.png" border="0"></a>
                              <input type="hidden" value="<?php echo $tplRec['tpl_objects_count']; ?>" id="totalPgElements" name="totalPgElements">
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
                                                    W:<input type="text" id="t_width" value="<?php echo $tplWidth; ?>" ></div>
                                              <div style="float:left; margin-left: 20px">
                                                    H:<input type="text" id="t_height" value="<?php echo $tplHeight; ?>"></div>
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
                                      <td id="page_workArea" style="width:<?php echo $tplWidth; ?>; height:<?php echo $tplHeight; ?>"><?php echo stripslashes($tplRec['tpl_html']); ?></td>
                                  </tr>
                              </table>
                          </div>




                          <div style="clear:both"></div>



                      </td>
                  </tr>
                </table>

          <!-- End .clear -->
            </form>
    </div>
</div>
</div>

</body>
</html>
