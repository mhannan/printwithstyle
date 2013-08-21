/*
 * SimpleModal Basic Modal Dialog
 * http://www.ericmmartin.com/projects/simplemodal/
 * http://code.google.com/p/simplemodal/
 *
 * Copyright (c) 2010 Eric Martin - http://ericmmartin.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Revision: $Id: basic.js 254 2010-07-23 05:14:44Z emartin24 $
 */

jQuery(function ($) {

        // display register benefit popup on register-thankyou page
       /* $('#popup_dialog_register_benefit').modal({
            close: true,
                        minWidth: 400,
                        minHeight: 200,
                        //overlayCss: {backgroundColor:"#000"},
                        containerCss: {backgroundColor:"#EAEDDC", minHeight:200, minWidth: 400}
        }); */







	// Load dialog on click
	$('.design_popup').click(function (e) {


              // 1. get ID of clicked 'submitDesign_popup'
              // 2. get eventTitle against this retreived ID (this is actually the unique event_id PK)
              // 3. display the retreived Title

             var event_id_attribute = $(this).attr('id');

              var eventTitle = $('#eventTitle_'+event_id_attribute).text();
              $('.popup_eventTitle').html(eventTitle);
              $('.popup_eventDesc').html($('#eventDesc_'+event_id_attribute).text());
              $('#popup_eventPrize').html($('#eventPrize_'+event_id_attribute).text());
              $('#popup_event_id').val(event_id_attribute);

		$('#event_upload_modal_content').modal({
                        close: true,
                        minWidth: 600,
                        minHeight: 450,
                        //overlayCss: {backgroundColor:"#000"},
                        containerCss: {backgroundColor:"#ccc", minHeight:450, minWidth: 600},


                        
                      
                        onClose: function (dialog) {
                            
                            $.modal.close(); // must call this!
                            
                     }});

		return false;
	});



        // for the Testimonial Posting

        $('.popup_post_testimonial').click(function (e) {

		$('#testimonial_post_modal_content').modal({
                        close: true,
                        minWidth: 500,
                        minHeight: 260,
                        //overlayCss: {backgroundColor:"#000"},
                        containerCss: {backgroundColor:"#eee", minHeight:260, minWidth: 500},

                        onClose: function (dialog) {
                            $.modal.close(); // must call this!
                     }});

		return false;
	});

        

});