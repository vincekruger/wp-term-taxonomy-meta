<tr class="form-field <?php echo $args['tr_class']; ?>">
	<th scope="row"><label
			for="ttm--textarea--<?php echo $args['meta_key_id']; ?>"><?php _e($args['meta_title']); ?></label></th>
	<td>
		<input type="hidden" name="ttm[<?php echo $args['meta_key_id']; ?>][taxonomy]"
			   value="<?php echo $args['taxonomy']; ?>"/>
		<textarea name="ttm[<?php echo $args['meta_key_id']; ?>][value]"
				  id="ttm--textarea--<?php echo $args['meta_key_id']; ?>" rows="5"
				  cols="40"><?php echo get_metadata($args['meta_type'], $term->term_taxonomy_id, $args['meta_key_id'], true); ?></textarea>
	</td>
</tr>