<div class="form-field <?php echo $args['tr_class']; ?>">
	<label for="ttm--textarea--<?php echo $args['meta_key_id']; ?>"><?php _e($args['meta_title']); ?></label>
	<input type="hidden" name="ttm[<?php echo $args['meta_key_id']; ?>][taxonomy]" value="<?php echo $args['taxonomy']; ?>"/>
	<textarea name="ttm[<?php echo $args['meta_key_id']; ?>][value]" id="ttm--textarea--<?php echo $args['meta_key_id']; ?>" rows="5" cols="40"></textarea>
</div>