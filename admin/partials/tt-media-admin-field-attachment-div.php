<div class="form-field <?php echo $args['tr_class']; ?>">
	<label for="tt--attachment"><?php _e($args['meta_title']); ?></label>

	<!-- Outputs the text field and displays the URL of the image retrieved by the media uploader -->
	<input type="hidden" name="ttm[<?php echo $args['meta_key_id']; ?>][taxonomy]"
		   value="<?php echo $args['taxonomy']; ?>"/>
	<input type="hidden" name="ttm[<?php echo $args['meta_key_id']; ?>][value]" class="ttm--attachment--id"/>

	<div class="image__wrapper container">
		<img
			src="http://placehold.it/<?php echo $args['image_dimensions']; ?>"
			class="ttm--attachment--preview"
			data-placeholder="http://placehold.it/<?php echo $args['image_dimensions']; ?>"
			data-width="<?php echo $args['placeholder_width']; ?>"
			style="width:<?php echo $args['placeholder_width']; ?>;">

		<div class="loader__wrapper" style="display: none;">
			<div class="loader"></div>
		</div>
	</div>

	<!-- Outputs the upload button -->
	<p>
		<input type="button" class="button upload-button upload--ttm--attachment"
			   value="<?php _e('Upload'); ?>" data-media-title="<?php echo $args['meta_title']; ?>"/>

		<input type="button" class="button remove-button remove--ttm--attachment"
			   value="<?php _e('Remove'); ?>" style="display: none;"/>
	</p>

</div>
<script type="text/javascript">
	jQuery('div.<?php echo $args['tr_class']; ?>').mediaUpload();
</script>