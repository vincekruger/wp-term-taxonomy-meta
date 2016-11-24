<tr class="form-field <?php echo $args['tr_class']; ?>">
    <th scope="row">
        <label for="ttm--text--<?php echo $args['meta_key_id']; ?>"><?php _e($args['meta_title']); ?></label>
    </th>
    <td>
        <fieldset>
            <legend class="screen-reader-text"><span><?php _e($args['meta_title']); ?></span></legend>
            <label for="ttm--text--<?php echo $args['meta_key_id']; ?>">
                <input type="checkbox"
                       name="ttm[<?php echo $args['meta_key_id']; ?>][value]"
                       id="ttm--text--<?php echo $args['meta_key_id']; ?>"
                       <?php checked(get_metadata($args['meta_type'], $term->term_taxonomy_id, $args['meta_key_id'], true), 'true'); ?>>

                <?php _e(isset($args['meta_description']) ? $args['meta_description'] : $args['meta_title']); ?>
            </label>
            <input type="hidden" name="ttm[<?php echo $args['meta_key_id']; ?>][taxonomy]"
                   value="<?php echo $args['taxonomy']; ?>"/>
            <input type="hidden" name="ttm[<?php echo $args['meta_key_id']; ?>][type]"
                   value="checkbox"/>
        </fieldset>
    </td>
</tr>