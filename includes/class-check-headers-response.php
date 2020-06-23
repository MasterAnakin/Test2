<?php

// disable direct file access
if (!defined('ABSPATH')) {

	exit;
}

class CheckHeadersResponse {

	public $single_link = false;

	//get single URL from the single page from the array of get_single_page_links_arr
	public function __construct($single_link) {

		$this->single_link = $single_link;
	}

	public function get_header_response() {

		//check the status code and return only HTTP response
		$headers = get_headers($this->single_link, 1);

		return $headers[0];
	}

	public function insert_header_reesponse() {

		global $wpdb;
		global $table_name;

		$single_link = $this->single_link;
		$header_response = $this->get_header_response();
		$timestamp = time();

		//insert status code, timestamp and link
		$sql = "Update ${table_name} set status_code=%s, timestamp=%s  WHERE single_link = %s";

		$sql = $wpdb->prepare($sql, $header_response, $timestamp, $single_link);
		// var_dump($sql); // debug
		$result = $wpdb->query($sql);

		if (FALSE === $result) {
			echo ("Failed!");
		} else {
			echo ("Great success!");
		}
	}
}
