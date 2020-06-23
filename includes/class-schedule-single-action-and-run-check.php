<?php

class Schedule_Single_Action_And_Run_Check {

	public function get_arr_of_links_ids() {

		global $wpdb;
		global $table_name;

		$get_ids_query = "SELECT id FROM ${table_name}";
		$links_ids_arr = $wpdb->get_results($get_ids_query, ARRAY_A);

		return $links_ids_arr;
	}

	public function schedule_single_action_based_on_link_id() {

		$links_ids_arr = $this->get_arr_of_links_ids();

		if (!empty($links_ids_arr)) {
			foreach ($links_ids_arr as $single_link_id) {
				$single_link_id_clean = $single_link_id['id'];
				as_schedule_single_action(time(), 'single_link_check3', [
					'single_link_id' => ($single_link_id_clean)]);
			}

		}

	}

	public function get_the_single_link_based_on_id($single_link_id_clean) {

		global $wpdb;
		global $table_name;

		$get_link_query = "SELECT single_link FROM ${table_name} WHERE id = $single_link_id_clean";
		$link_row = $wpdb->get_row($get_link_query);
		$single_link_url = $link_row->single_link;
		return $single_link_url;
	}

	public function run_check($single_link_id_clean) {

		$single_link_url = $this->get_the_single_link_based_on_id($single_link_id_clean);

		$new_url_check = new CheckHeadersResponse($single_link_url);
		$new_url_check->get_header_response();
		$new_url_check->insert_header_reesponse();

		$ik = get_option('links_count_position');

		//count - 2
		if ($ik > 6) {
			update_option('links_count_position', 0);
			//return false;
		} else {
			update_option('links_count_position', $ik + 1);
			//return true;
		}

	}

}

$prepare_to_run = new Schedule_Single_Action_And_Run_Check;
add_action('single_link_check3', array($prepare_to_run, 'run_check'));
