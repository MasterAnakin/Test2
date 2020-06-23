<?php
/*
Plugin Name:  Josh Link Checker Milos
Description:  Check status codes of links
Plugin URI:   https://valet.io/
Author:       Josh & Milos
Version:      8.1
Text Domain:  wpmilos
Domain Path:  /languages
License:      GPL v2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.txt
 */

// disable direct file access
if (!defined('ABSPATH')) {

	exit;

}

// if admin area
if (is_admin()) {

// include plugin dependencies
	require_once plugin_dir_path(__FILE__) . 'admin/admin-menu.php';
	require_once plugin_dir_path(__FILE__) . 'admin/settings-page.php';
	require_once plugin_dir_path(__FILE__) . 'admin/settings-register.php';
	require_once plugin_dir_path(__FILE__) . 'admin/settings-callbacks.php';

}

require_once plugin_dir_path(__FILE__) . '/libraries/action-scheduler/action-scheduler.php';

//if (is_admin()) {
// include plugin dependencies
require_once plugin_dir_path(__FILE__) . 'includes/class-get-all-links-from-site.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-insert-single-link-into-db.php';
require_once plugin_dir_path(__FILE__) . 'includes/progress-bar.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-check-headers-response.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-schedule-action-for-header-response.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-schedule-single-action-and-run-check.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-count-check.php';
require_once plugin_dir_path(__FILE__) . 'includes/create_table.php';

//}

// default plugin options
function myplugin_options_default() {

	return array(
		'custom_url' => 'https://wordpress.org/',
		'custom_title' => 'Powered by WordPress',
		'custom_style' => 'disable',
		'custom_message' => '<p class="custom-message">My custom message</p>',
		'custom_footer' => 'Special message for users',
		'custom_toolbar' => false,
		'custom_scheme' => 'default',
	);

}

/*

function my_plugin_create_db() {

global $wpdb;
$charset_collate = $wpdb->get_charset_collate();
$table_name = $wpdb->prefix . 'my_analysis';

$sql = "CREATE TABLE $table_name ( `id` INT NOT NULL AUTO_INCREMENT , `single_link` VARCHAR(256) NOT NULL , `status_code` VARCHAR(256) NOT NULL , `timestamp` VARCHAR(256) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";

require_once ABSPATH . 'wp-admin/includes/upgrade.php';
dbDelta($sql);
}

add_shortcode('shutdown', 'my_plugin_create_db');

 */
