<?php
/**
 * @wordpress-plugin
 * Plugin Name:     Term Taxonomy Meta
 * Description:     Add metadata to term taxonomy relationships
 * Version:         1.0.0
 * Author:          Vince Kruger
 * Author URI:      https://github.com/vincekruger/wp-term-taxonomy-meta
 * License:         MIT
 * License URI:     http://opensource.org/licenses/MIT
 * Text Domain:     tt-meta
 * Domain Path:     /languages
 */

// If this file is called directly, abort.
defined('WPINC') or die();

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tt-meta-activator.php
 */
function activate_tt_meta()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-tt-meta-activator.php';
    TT_Meta_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tt-meta-deactivator.php
 */
function deactivate_tt_meta()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-tt-meta-deactivator.php';
    TT_Meta_Deactivator::deactivate();
}

/**
 * Add table names to the wpdb class for availability
 * inside your wp installation
 */
function term_taxonomymeta_wpdbfix()
{
    global $wpdb;
    $wpdb->term_taxonomymeta = $wpdb->prefix . 'term_taxonomymeta';
    $wpdb->tables[] = 'term_taxonomymeta';
}

register_activation_hook(__FILE__, 'activate_tt_meta');
register_deactivation_hook(__FILE__, 'deactivate_tt_meta');
add_action('init', 'term_taxonomymeta_wpdbfix', 0);
add_action('switch_blog', 'term_taxonomymeta_wpdbfix', 0);

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-tt-meta.php';

/**
 * Begins execution of the plugin.
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 */
function run_tt_meta()
{
    $plugin = new TT_Meta();
    $plugin->run();
}

run_tt_meta();