<?php

/**
 * The meta fields functionality of the plugin.
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 * @package    TT_Meta
 * @subpackage TT_Meta/admin
 */
class TT_Meta_Admin_Fields
{
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
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of the plugin.
     * @param string $version     The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Alter the attachment field args
     *
     * @param $args
     * @param $field
     *
     * @return array
     */
    public function field_attachment_custom_args($args, $field)
    {
        $args = wp_parse_args(array(
            'td_class'          => $args['td_class'] . ' ttmeta--media--attachment',
            'image_dimensions'  => '200x200',
            'placeholder_width' => '200px',
            'image_size'        => 'tt-meta-attachment-thumbnail',
        ), $args);

        return $args;
    }

    /**
     * Render the add form partial
     *
     * @param string $field
     * @param array  $args
     */
    public function display_field_add_form($field, $args = array())
    {
        $filename = 'tt-media-admin-' . strtolower(str_replace('_', '-', $field->type)) . '-div.php';
        $default_template_location = plugin_dir_path(dirname(__FILE__)) . 'admin/partials/' . $filename;
        if (file_exists($default_template_location)) {
            include $default_template_location;
        }
    }

    /**
     * Render the edit form partial
     *
     * @param string $field
     * @param array  $args
     * @param mixed  $term
     */
    public function display_field_edit_form($field, $args = array(), $term = false)
    {
        $filename = 'tt-media-admin-' . strtolower(str_replace('_', '-', $field->type)) . '-tr.php';
        $default_template_location = plugin_dir_path(dirname(__FILE__)) . 'admin/partials/' . $filename;
        if (file_exists($default_template_location)) {
            include $default_template_location;
        }
    }
}
