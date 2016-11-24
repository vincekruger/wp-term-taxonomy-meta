<tr class="form-field <?php echo $args['tr_class']; ?>">
	<th scope="row"><label
			for="ttm--text--<?php echo $args['meta_key_id']; ?>"><?php _e($args['meta_title']); ?></label></th>
	<td>
		<input type="hidden" name="ttm[<?php echo $args['meta_key_id']; ?>][taxonomy]"
			   value="<?php echo $args['taxonomy']; ?>"/>
		<input type="text" name="ttm[<?php echo $args['meta_key_id']; ?>][value]"
				  id="ttm--text--<?php echo $args['meta_key_id']; ?>"
				  value="<?php echo get_metadata($args['meta_type'], $term->term_taxonomy_id, $args['meta_key_id'], true); ?>" />
	</td>
</tr>