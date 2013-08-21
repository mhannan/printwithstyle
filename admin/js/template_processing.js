/*
 *  This file is being used on ADD/ Edit template in admin end
 *  This contains different template generating processings functions
 */

/** Prototype - Add Image Block HTML
 * @param imageBlock_id Essential param, this allocates generate HTML with new element/block ID
 * @param zIndex Its optional param if we need to associate any z-index to our new element
*/
    function generateImageBlock(imageBlock_id, zIndex)
    {
        var imgBlock_html = "<div onclick=\"showAsSelected('"+imageBlock_id+"')\" id='"+imageBlock_id+"' class='flipBook_pagePictureContainer' style='left: 20px; top:10px; position:relative; float:left; width: 300px; height: 200px; border:2px dashed #ccc;'>"+
                                     "<table border='0' cellpadding='0' cellspacing='0' width='100%' height='100%'>"+
                                        "<tr valign='middle'>"+
                                                "<td align='center' style='padding-top:100px; text-align:center'><b>IMAGE AREA</b>"+
                                                        "<div>(<span>select me</span>, then select your picture)</div></td>"+
                                        "</tr></table>"+
                                        "<div id='js_pagePictureContainer'></div></div>";
        return imgBlock_html;
    }


    /** When 'ADD IMAGE block' pressed this method adds Image Block on the Page template area
     * @param outputReceiverElementId '#outputReceiver_elementID'
     */
    function addImageBlock(outputReceiverElementId)
    {
        var newImageBlock_id = '0';     // default initialization
        var zIndex = '0';
        var counterItem_toUpdate = ''

       
        counterItem_toUpdate = '#totalPgElements';              // updating element Counter (of elements on the page work area)
        zIndex = parseInt($(counterItem_toUpdate).val()) +1;
        newImageBlock_id = 'pgElement'+zIndex;              // allocating/preparing     z-index/ newElement block ID
       


        var generated_imgBlock_html = generateImageBlock(newImageBlock_id);
       // alert(generated_imgBlock_html);
                                                //1. return result to relevant page while retaining its old HTML
        $(outputReceiverElementId).html( $(outputReceiverElementId).html() + generated_imgBlock_html );
                                                //2. update that page elementCounter
        $(counterItem_toUpdate).val( parseInt($(counterItem_toUpdate).val()) + 1 );
    }

/** When 'ADD IMAGE block' pressed this method adds Image Block on the Page template area
     * @param outputReceiverElementId '#outputReceiver_elementID'
     */
    function addTextBlock(outputReceiverElementId)
    {
        var counterItem_toUpdate = '#totalPgElements';
        var zIndex = ($(counterItem_toUpdate).val()) +1;        // we could use zIndex if needed
        var newTextBlock_id = 'pgElement'+zIndex;

        var generated_textBlock_html = generateTextBlock(newTextBlock_id);
        $(outputReceiverElementId).html( $(outputReceiverElementId).html() + generated_textBlock_html );
                                                //2. update that page elementCounter
        $(counterItem_toUpdate).val( parseInt($(counterItem_toUpdate).val()) + 1 );

    }
/** Prototype - Add Text Block HTML
 * @param textBlock_id Essential param, this allocates generate HTML with new element/block ID
 * @param zIndex Its optional param if we need to associate any z-index to our new element
*/
    function generateTextBlock(textBlock_id, zIndex)
    {
        var imgBlock_html = "<div onclick=\"showAsSelected('"+textBlock_id+"')\" id='"+textBlock_id+"' class='flipBook_pageTextContainer' style='left: 20px; top:10px; position:relative; float:left; width: 100px; height: 50px; border:2px dashed #ccc;'>"+
                                      "<div id='js_pagetTextContainer'></div></div>";
        return imgBlock_html;
    }


/* ----------------------- Selection Functions list -------------------------- */
    function showAsSelected(flipBookPage_pictureBlock_id)
    {
            removeSelection(); 		// first reset/ unselect all selected PIC-containerBlocks
            $('#'+flipBookPage_pictureBlock_id).css({border:'3px dashed #ccc', '-moz-box-shadow': '0px 0px 5px #888', '-webkit-box-shadow': '0px 0px 5px #888',
                                                                                              'box-shadow': '0px 0px 5px #888'});
            $('#selectedPicContainer').val(flipBookPage_pictureBlock_id);	// keep record of what is selected

                // activate property bar elements, while hiding Span (which contains status msg)
            activatePropertyBar();
    }

    function removeSelection() 			// being called from : removeSelection clickEvent, also from documentClick with IF check
    {
            $('.flipBook_pagePictureContainer').css({border:'2px dashed #ccc',  '-moz-box-shadow': 'none', '-webkit-box-shadow': 'none',
                                                                                                                              'box-shadow': 'none'});
            $('.flipBook_pageTextContainer').css({border:'2px dashed #ccc',  '-moz-box-shadow': 'none', '-webkit-box-shadow': 'none',
                                                                                                                              'box-shadow': 'none'});
            $('#selectedPicContainer').val('');      // in case if its called from 'removSelection' click event then we need to explicitly set this value to empty
            // ----------Deactiveate PropertyBar ------------
            $('#propertyElementsContainer div').hide();
            $('#propertyElementsContainer span, #propertyElementsContainer div:first,').show();
    }

/*  -------------- Property Bar Functions --------------------------- */
    function activatePropertyBar() // @param: element or object ID for which its being activated
    {
        $('#propertyElementsContainer div').show();
        $('#propertyElementsContainer span').hide();
        var selectedObjectId = $('#selectedPicContainer').val();
                                            /* load selected items property in property bar fields
                                                p_xMargin, p_yMargin, p_width, p_height */
        $('#p_xMargin').val($('#'+selectedObjectId).css('left'));
        $('#p_yMargin').val($('#'+selectedObjectId).css('top'));
        $('#p_width').val($('#'+selectedObjectId).css('width'));
        $('#p_height').val($('#'+selectedObjectId).css('height'));
        if($('#'+selectedObjectId).css('clear') =='both')   // if clear:both property set of any attribute
            $('#p_clearBoth').attr('checked', true);
        else
            $('#p_clearBoth').attr('checked', false);
    }

    function applyProperty()
    {
       var selectedObjectId = $('#selectedPicContainer').val();
       /* apply selected items property in property bar fields
                                                p_xMargin, p_yMargin, p_width, p_height */
        $('#'+selectedObjectId).css({'left':$('#p_xMargin').val() ,
                                      'top': $('#p_yMargin').val(),
                                      'width': $('#p_width').val(),
                                      'height': $('#p_height').val()});
        if($('#p_clearBoth').is(':checked'))
            $('#'+selectedObjectId).css('clear','both');
        
       //$('form #mycheckbox').is(':checked');
       // $("form #mycheckbox").attr('checked', true);
    }

    /** Load dimensions to W/H fields to prepare/ ready for apply operation
     * @param dimensionSelectorId string The ID of dropDown field that holds all demntions to be applied to the next 2 param fields
     * @param widthProprtyHoldingField string The ID of the field that will hold the Width
     * @param heightProprtyHoldingField string The ID of the filed that will hold the Height
     */
    function loadDimensions_to_fields(dimensionSelectorId, widthProprtyHoldingField, heightProprtyHoldingField)
    {
       var dimension = $('#'+dimensionSelectorId+' option:selected').val();
       if(dimension != '0')
       {
           var dimensionArray = dimension.split('-');
           $('#'+widthProprtyHoldingField).val(dimensionArray[0]);
           $('#'+heightProprtyHoldingField).val(dimensionArray[1]);
       }
    }

    /** Apply Dimentions setting on the Template block ID
     * @param targetHTMLBlock_mainWrapper
     * @param targetHTMLBlock
     * @param dimensionSaver string Saves the applied template dimension in Hidden field
     * @namespace width, height are received from #t_width,#t_height
     */
    function applyTemplateProperty(targetHTMLBlock_mainWrapper, targetHTMLBlock, dimensionSaver)
    { 
        var newWidth = $('#t_width').val();//+' !important';
        var newHeight = $('#t_height').val(); //+' !important'; alert(newWidth);
        $(targetHTMLBlock_mainWrapper).css({'width':newWidth});

        $(targetHTMLBlock).css({'width':newWidth ,
                                      'height': newHeight});
        $(dimensionSaver).val(newWidth+'-'+newHeight);

    }

    function resetPropertyBar()
    {
        $('#propertyElementsContainer div').hide();
                $('#propertyElementsContainer div:first').show();
    }

    function deleteElement()
    {
        var selectedObjectId = $('#selectedPicContainer').val();
        $('#'+selectedObjectId).remove();
        removeSelection();
    }