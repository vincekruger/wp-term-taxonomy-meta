<div class="form-field <?php echo $args['tr_class']; ?>">
	<label for="ttm--text--<?php echo $args['meta_key_id']; ?>"><?php _e($args['meta_title']); ?></label>
	<input type="hidden" name="ttm[<?php echo $args['meta_key_id']; ?>][taxonomy]" value="<?php echo $args['taxonomy']; ?>"/>
	<input type="text" name="ttm[<?php echo $args['meta_key_id']; ?>][value]" id="ttm--text--<?php echo $args['meta_key_id']; ?>" />
</div>