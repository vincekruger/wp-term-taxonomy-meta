<?php

/**
 * The admin-specific functionality of the plugin.
 * @package    TT_Meta
 * @subpackage TT_Meta/admin
 */

/**
 * The admin-specific functionality of the plugin.
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 * @package    TT_Meta
 * @subpackage TT_Meta/admin
 */
class TT_Meta_Admin
{
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     * @var TT_Meta_Loader $loader Maintains and registers all hooks for the plugin.
     */
    private $loader;
    /**
     * The ID of this plugin.
     * @var string $plugin_name The ID of this plugin.
     */
    private $plugin_name;
    /**
     * The version of this plugin.
     * @var string $version The current version of this plugin.
     */
    private $version;
    /**
     * Taxonomies to use this plugin on
     * Temp solution as there is no time to build
     * an admin interface for this
     * @var array
     */
    public $taxonomy_meta_data = array();
    /**
     * @var array
     */
    public $taxonomy_meta_expect = array();
    /**
     * Default taxonomy meta keys if none are defined
     * @var array
     */
    public $taxonomy_meta_keys = array(
        'field_attachment' => '_thumbnail_id',
        'field_textbox'    => '_text_box',
        'field_wysiwyg'    => '_text_wysiwyg',
        'field_text'       => '_text_text',
        'field_switch'     => '_switch',
    );

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version     The version of this plugin.
     */
    public function __construct($plugin_name, $version, $loader)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->loader = $loader;
        $this->fields = new TT_Meta_Admin_Fields($this->plugin_name, $this->version);
        $this->setup_field_hooks();
    }

    /**
     * Setup the action hooks for the multiple taxonomies
     */
    public function setup_field_hooks()
    {
        global $wpdb;
        $meta_taxonomies = $wpdb->get_results("SELECT * FROM {$wpdb->posts}
		WHERE {$wpdb->posts}.post_type = 'tt-meta'
		AND {$wpdb->posts}.post_status = 'publish'
		ORDER BY {$wpdb->posts}.menu_order ASC");

        // Check if there are relationships to create
        if (!is_array($meta_taxonomies)) {
            return;
        }

        // Load the relationships
        foreach ($meta_taxonomies as $taxonomy) {
            // Setup taxonomy data
            $taxonomy_data = json_decode($taxonomy->post_content);
            $taxonomy_data->title = $taxonomy->post_title;

            // Check if the except is empty
            if (!empty($taxonomy->post_excerpt)) {
                $taxonomy_data->description = $taxonomy->post_excerpt;
            }

            // Check for default options
            if (!isset($taxonomy_data->type)) {
                continue;
            }

            // Default meta key
            if (!isset($taxonomy_data->meta_key)) {
                $taxonomy_data->meta_key = $this->taxonomy_meta_keys[$taxonomy_data->type];
            }

            // Creation
            $this->taxonomy_meta_data[$taxonomy_data->taxonomy][] = $taxonomy_data;

            // Expectation
            $this->taxonomy_meta_expect[$taxonomy_data->taxonomy][] = $taxonomy_data->meta_key;

            // Add actions
            $this->loader->add_action($taxonomy_data->taxonomy . '_add_form_fields', $this, 'add_form_fields');
            $this->loader->add_action($taxonomy_data->taxonomy . '_edit_form_fields', $this, 'edit_form_fields');
        }

        // Load the save, edit and delete hooks
        foreach ($meta_taxonomies as $taxonomy) {
            $taxonomy_data = json_decode($taxonomy->post_content);

            if (isset($taxonomy_data)) {
                $this->loader->add_action('create_' . $taxonomy_data->taxonomy, $this, 'save_tt_meta', 10, 2);
                $this->loader->add_action('edited_' . $taxonomy_data->taxonomy, $this, 'save_tt_meta', 10, 2);
                $this->loader->add_action('delete_' . $taxonomy_data->taxonomy, $this, 'remove_tt_meta', 10, 3);
            }
        }

        // Field attachment
        $this->loader->add_filter('ttmeta_field_attachment_custom_args', $this->fields, 'field_attachment_custom_args', 10, 2);
        $this->loader->add_action('ttmeta_field_attachment_add', $this->fields, 'display_field_add_form', 10, 2);
        $this->loader->add_action('ttmeta_field_attachment_edit', $this->fields, 'display_field_edit_form', 10, 3);

        // Field: Text rea
        $this->loader->add_action('ttmeta_field_textarea_add', $this->fields, 'display_field_add_form', 10, 2);
        $this->loader->add_action('ttmeta_field_textarea_edit', $this->fields, 'display_field_edit_form', 10, 3);

        // Field: Textarea
        $this->loader->add_action('ttmeta_field_textarea_add', $this->fields, 'display_field_add_form', 10, 2);
        $this->loader->add_action('ttmeta_field_textarea_edit', $this->fields, 'display_field_edit_form', 10, 3);

        // Field: Text
        $this->loader->add_action('ttmeta_field_text_add', $this->fields, 'display_field_add_form', 10, 2);
        $this->loader->add_action('ttmeta_field_text_edit', $this->fields, 'display_field_edit_form', 10, 3);

        // Field: Switch
        $this->loader->add_action('ttmeta_field_switch_add', $this->fields, 'display_field_add_form', 10, 2);
        $this->loader->add_action('ttmeta_field_switch_edit', $this->fields, 'display_field_edit_form', 10, 3);
    }

    /**
     * Register the JavaScript for the admin area.
     */
    public function enqueue_scripts()
    {
        wp_enqueue_media();
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/tt-meta-media-upload.min.js', array('jquery'), $this->version, false);
    }

    /**
     * Add an image size so that a display image can be shown in the wp-admin
     * and this will not affect the sizes of the custom image sizes setup
     * in a theme.  This image will not be cropped, however the placeholder
     * will be a square place holder
     */
    public function add_attachment_image_size()
    {
        add_image_size('tt-meta-attachment-thumbnail', 200, 200, false);
    }

    /**
     * Render the template for the field type based on the action type
     * add / edit.
     * Reason for this method is because the edit and add actions send
     * through different information
     *
     * @param string $taxonomy
     * @param string $action
     * @param mixed  $term
     */
    private function render_taxonomy_form_fields($taxonomy, $action = 'add', $term = false)
    {
        if (is_array($this->taxonomy_meta_data[$taxonomy])) {
            foreach ($this->taxonomy_meta_data[$taxonomy] as $field) {
                // Build the args via a filter
                $args = apply_filters('ttmeta_' . $field->type . '_custom_args', array(
                    'taxonomy'    => $taxonomy,
                    'tr_class'    => strtolower($taxonomy) . '--' . strtolower(str_replace('_', '--', $field->type)) . '--ttm--row',
                    'td_class'    => strtolower($taxonomy) . '--' . strtolower(str_replace('_', '--', $field->type)) . '--ttm--row', // was container class
                    'meta_key_id' => $field->meta_key,
                    'meta_type'   => 'term_taxonomy',
                    'meta_title'  => $field->title, // Was media title
                ), $field);

                if (isset($field->description)) {
                    $args['meta_description'] = $field->description;
                }

                // Action the render
                do_action('ttmeta_' . $field->type . '_' . $action, $field, $args, $term);
            }
        }
    }

    /**
     * Add form fields for taxonomy
     * @uses  self::render_taxonomy_form_fields()
     *
     * @param $taxonomy
     */
    public function add_form_fields($taxonomy)
    {
        wp_nonce_field('ttm-save-data', 'ttm_save_nonce');
        $this->render_taxonomy_form_fields($taxonomy, 'add');
    }

    /**
     * Edit form fields for taxonomy.
     * @uses  self::render_taxonomy_form_fields()
     *
     * @param $term
     */
    public function edit_form_fields($term)
    {
        wp_nonce_field('ttm-save-data', 'ttm_save_nonce');
        $this->render_taxonomy_form_fields($term->taxonomy, 'edit', $term);
    }

    /**
     * Save term taxonomy meta
     *
     * @param $term_id
     * @param $tt_id
     */
    public function save_tt_meta($term_id, $tt_id)
    {
        // Validate our nonce
        if (!isset($_POST['ttm_save_nonce']) || !wp_verify_nonce($_POST['ttm_save_nonce'], 'ttm-save-data')) {
            return;
        }

        // Validate post ttm key
        if (!isset($_POST['ttm']) || !is_array($_POST['ttm'])) {
            return;
        }

        // Iterate through the posted ttm data
        foreach ($_POST['ttm'] as $meta_key => $meta_data) {
            // Default for text values
            $value = isset($meta_data['value']) ? $meta_data['value'] : '';

            // Check if the type of field is a checkbox
            if (isset($meta_data['type']) && $meta_data['type'] === 'checkbox') {
                $value = isset($meta_data['value']) ? 'true' : 'false';
            }

            // Update the meta data
            update_metadata('term_taxonomy', $tt_id, $meta_key, $value);
        }
    }

    /**
     * Remove term taxonomy meta
     *
     * @param $term
     * @param $tt_id
     */
    public function remove_tt_meta($term, $tt_id, $deleted_term)
    {
        // Remove all meta data for the term in this taxonomy
        if (is_array($this->taxonomy_meta_data[$deleted_term->taxonomy])) {
            foreach ($this->taxonomy_meta_data[$deleted_term->taxonomy] as $field) {
                // Remove this meta data using the key if key exists
                if (isset($field->meta_key)) {
                    delete_metadata('term_taxonomy', $tt_id, $field->meta_key);
                }
            }
        }
    }
}