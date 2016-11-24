(function (window, i) {
    'use strict';

    jQuery.fn.mediaUpload = function (args) {

        // Options
        var muo = jQuery.extend({
            loader_wrapper: 'div.loader__wrapper',
            image_placeholder: 'img.ttm--attachment--preview',
            upload_button: 'input.upload--ttm--attachment',
            remove_button: 'input.remove--ttm--attachment',
            field_attachment_id: 'input.ttm--attachment--id'
        }, args);

        return this.each(function () {
            var file_frame = false;
            var container = jQuery(this);
            var placeholder = jQuery(muo.image_placeholder, container);

            // Let's set our open button
            jQuery(muo.upload_button, container).on('click', function (event) {
                event.preventDefault();

                // If the media frame already exists, reopen it.
                if (file_frame) {
                    file_frame.open();
                    return;
                }

                // Create the media frame.
                file_frame = wp.media.frames.file_frame = wp.media({
                    title: jQuery(this).data('media-title'),
                    button: {
                        text: jQuery(this).data('media-button-title')
                    },
                    multiple: false  // Set to true to allow multiple files to be selected
                });

                // When an image is selected, run a callback.
                file_frame.on('select', function () {
                    jQuery(muo.loader_wrapper, container).show();

                    // Fade out
                    //placeholder.data('placeholder', placeholder.attr('src'));//.fadeOut();
                    jQuery(muo.remove_button, container).fadeIn();

                    // We set multiple to false so only get one image from the uploader
                    var attachment = file_frame.state().get('selection').first().toJSON();

                    // Do something with attachment.id and/or attachment.url here
                    jQuery(muo.field_attachment_id, container).val(attachment.id);
                    jQuery(muo.field_attachment_url, container).val(attachment.url);

                    // Show the image
                    placeholder.load(function () {
                        jQuery(muo.loader_wrapper, container).hide();
                        //jQuery(this).hide();

                        jQuery(this).css('width', placeholder.data('width'));
                        jQuery(this).fadeIn();
                    }).attr('src', attachment.url);

                    jQuery(muo.loader_wrapper, container).hide();
                });

                // Finally, open the modal
                file_frame.open();
            });

            // Let's set our remove button
            jQuery(muo.remove_button, container).on('click', function (event) {
                jQuery(muo.field_attachment_id, container).val('');
                jQuery(muo.field_attachment_url, container).val('');

                // Show the place holder again
                placeholder.attr('src', placeholder.data('placeholder'));

                // Hide remove button
                jQuery(this).fadeOut();
            });

        });

    }

})(jQuery, this, 0);