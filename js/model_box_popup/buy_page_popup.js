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
	

	// Load dialog on click
	$('.customer_book_pagesAdd').click(function (e) {
		$('#pages_to_buy_popup').modal({
                        close: true,
                        minWidth: 500,
                        minHeight: 200,
                        containerCss: {backgroundColor:"#ccc", minHeight:200},
                        onClose: function (dialog) {
                            
                            

                            
                            /*dialog.data.fadeOut('slow', function () {
                                    dialog.container.slideUp('slow', function () {
                                            dialog.overlay.fadeOut('slow', function () {*/
                                                    $.modal.close(); // must call this!
                            /*                });
                                    });
                            }); */
                       }});

		return false;
	});


        

});