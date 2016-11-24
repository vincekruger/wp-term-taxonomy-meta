<tr class="form-field <?php echo $args['tr_class']; ?>">
	<th scope="row" valign="top"><?php _e($args['meta_title']) ?></th>
	<td class="<?php echo $args['td_class']; ?>">
		<input type="hidden" name="ttm[<?php echo $args['meta_key_id']; ?>][taxonomy]" value="<?php echo $args['taxonomy']; ?>"/>
		<input type="hidden" name="ttm[<?php echo $args['meta_key_id']; ?>][value]" class="ttm--attachment--id"
			   value="<?php echo get_metadata($args['meta_type'], $term->term_taxonomy_id, $args['meta_key_id'], true); ?>"/>

		<div class="image__wrapper container">
			<?php $image_attributes = wp_get_attachment_image_src(get_metadata($args['meta_type'], $term->term_taxonomy_id, $args['meta_key_id'], true), $args['image_size']); ?>
			<img
				src="<?php echo ($image_attributes) ? $image_attributes[0] : "http://placehold.it/{$args['image_dimensions']}"; ?>"
				class="ttm--attachment--preview"
				data-placeholder="http://placehold.it/<?php echo $args['image_dimensions']; ?>"
				data-width="<?php echo $args['placeholder_width']; ?>"
				style="width:<?php echo $args['placeholder_width']; ?>;">

			<div class="loader__wrapper" style="display: none;">
				<div class="loader"></div>
			</div>
		</div>
		<p>
			<input type="button" class="button upload-button upload--ttm--attachment"
				   value="<?php _e('Upload'); ?>"
				   data-media-title="<?php echo $args['meta_title']; ?>"/>

			<?php $remove_button_class = !($image_attributes) ? 'display: none;' : ''; ?>
			<input type="button" class="button remove-button remove--ttm--attachment"
				   value="<?php _e('Remove'); ?>" style="<?php echo $remove_button_class; ?>"/>
		</p>

	</td>
</tr>
<script type="text/javascript">
	jQuery('tr.<?php echo $args['tr_class']; ?>').mediaUpload();
</script>