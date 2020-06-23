<?php // MyPlugin - Register Settings

// disable direct file access
if (!defined('ABSPATH')) {

	exit;

}

// register plugin settings
function broken_link_checker_register_settings() {

	register_setting(
		'broken_link_checker_options',
		'broken_link_checker_options',
		'broken_link_checker_callback_validate_options'
	);

	add_settings_section(
		'broken_link_checker_section_intro',
		'Broken Link Checker',
		'broken_link_checker_callback_section_intro',
		'broken_link_checker'
	);

	add_settings_section(
		'broken_link_checker_section_admin',
		'Check the links',
		'broken_link_checker_callback_section_admin',
		'broken_link_checker'
	);

	add_settings_field(
		'custom_url',
		'Custom URL',
		'broken_link_checker_callback_field_text',
		'broken_link_checker',
		'broken_link_checker_section_intro'
	);
}

add_action('admin_init', 'broken_link_checker_register_settings');
