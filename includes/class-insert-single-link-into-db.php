<?php

// disable direct file access
if (!defined('ABSPATH')) {

	exit;

}

class InsertSingleLinkIntoDB {

	public function __construct($page_link_single) {
		$this->page_link_single = $page_link_single;
	}

	//insert single link into db if not exists
	public function insert_single_link() {

		$single_link = $this->page_link_single;

		global $table_name;
		global $wpdb;

		$sql = "INSERT INTO ${table_name} (single_link) SELECT * FROM (SELECT %s) AS tmp WHERE NOT EXISTS ( SELECT single_link FROM ${table_name} WHERE single_link = %s ) LIMIT 1";

		$sql = $wpdb->prepare($sql, $single_link, $single_link);

		$result = $wpdb->query($sql);

	}

}

function run_db_import() {

	$new_insert = new GetAllLinksFromSite;
	$links_arr = $new_insert->get_all_links();

	foreach ($links_arr as $page_link_single) {

		$get_all_links = new InsertSingleLinkIntoDB($page_link_single);
		$get_all_links->insert_single_link();
	}
}
