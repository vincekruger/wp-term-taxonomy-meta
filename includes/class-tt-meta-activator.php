<?php

/**
 * Fired during plugin activation.
 * This class defines all code necessary to run during the plugin's activation.
 * @package    TT_Meta
 * @subpackage TT_Meta/includes
 */
class TT_Meta_Activator
{
    public static function activate()
    {
        // global
        global $wpdb;
        $prefix = $wpdb->prefix;
        $charset_collate = !empty($wpdb->charset) ? "DEFAULT CHARACTER SET {$wpdb->charset}" : '';
        $charset_collate .= !empty($wpdb->collate) ? " COLLATE {$wpdb->collate}" : "";

        // Build tables
        self::create_termtaxonomymeta($prefix, $charset_collate);
    }

    /**
     * Term Taxonomy Meta table
     *
     * @param $prefix
     * @param $charset_collate
     */
    public static function create_termtaxonomymeta($prefix, $charset_collate)
    {
        $table_name = $prefix . 'term_taxonomymeta';

        $sql = "CREATE TABLE IF NOT EXISTS `{$table_name}` (
			`meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			`term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT '0',
			`meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`meta_value` longtext COLLATE utf8mb4_unicode_ci,
			PRIMARY KEY (`meta_id`),
			KEY `meta_key` (`meta_key`),
			KEY `term_taxonomy_id` (`term_taxonomy_id`)
		) ENGINE=InnoDB {$charset_collate};";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
