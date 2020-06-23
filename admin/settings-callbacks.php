<?php // MyPlugin - Settings Callbacks

// disable direct file access
if (!defined('ABSPATH')) {

	exit;

}

// callback: login section
function broken_link_checker_callback_section_intro() {

	echo '<p>List of links, status codes and time of the last check.</p>';

}

function broken_link_checker_callback_section_admin() {

	if (isset($_POST['test_button'])) {

		$run1 = new ScheduleActionForHeaderResponse;
		$eg_schedule_midnight_log = $run1->schedule_5_seconds_check();
		//eg_schedule_midnight_log();
	}

	if (isset($_POST['test_button_2'])) {

		//run_db_import();
		//unschedule_all_lc_actions();
		run_db_import();
	}

	if (isset($_POST['test_button_3'])) {

		//run_db_import();
		$run2 = new Schedule_Single_Action_And_Run_Check;
		$run2->schedule_single_action_based_on_link_id();
		//add_action('single_link_check3', array($run2, 'run_check'));

		//$run2 = new Run_Check_On_Demand;
		//add_action('single_link_check2', array($run2, 'run_check'));

	}

}

function test_button_action() {
	echo "likoovcsopc";
}

// callback: text field
function broken_link_checker_callback_field_text($args) {

	global $wpdb;
	global $table_name;

	$links_count = $wpdb->get_var("SELECT COUNT(*) FROM ${table_name}");

	$total = $links_count;
	$items_per_page = 5;
	$page = isset($_GET['cpage']) ? abs((int) $_GET['cpage']) : 1;
	$offset = ($page * $items_per_page) - $items_per_page;
	$query = "SELECT * FROM ${table_name}";
	$rows = $wpdb->get_results($query . " ORDER BY timestamp LIMIT ${offset}, ${items_per_page}");
	echo '<div class="table" style="display:table;">
  <div class="header" style="display:table-header-group;">
    <div class="cell" style="display:table-cell; width:25%; padding-bottom: 10px;">Link</div>
    <div class="cell" style="display:table-cell; width:25%; padding-bottom: 10px;">Status Code</div>
    <div class="cell" style="display:table-cell; width:25%; padding-bottom: 10px;">Time Last Checked</div>
  </div>';
	foreach ($rows as $row) {
		$da_link = $row->single_link;
		$da_title = $row->status_code;
		if (!empty($row->timestamp)) {
			$da_date = date('m/d/Y H:i:s', $row->timestamp);
		} else {
			$da_date = 'not checked yet';
		}

		//$da_date = date('m/d/Y H:i:s', $row->timestamp);
		//$da_date = (null === (date('m/d/Y H:i:s', $row->timestamp))) ?: 'not checked yet';

		echo '

  <div class="rowGroup" style="display:table-row-group;">
    <div class="row" style="display:table-row;">
      <div class="cell" style="display:table-cell; width:60%; padding-bottom: 10px;">' . $da_link . '</div>
      <div class="cell" style="display:table-cell; width:20%; padding-bottom: 10px;">' . $da_title . '</div>
      <div class="cell" style="display:table-cell; width:20%; padding-bottom: 10px;">' . $da_date . '</div>
    </div>
  </div>';

	}
	echo '</div>';
	echo "<div>";
	echo paginate_links(array(
		'base' => add_query_arg('cpage', '%#%'),
		'format' => '',
		'prev_text' => __('&laquo;'),
		'next_text' => __('&raquo;'),
		'total' => ceil($total / $items_per_page),
		'current' => $page,
	));
	echo "</div><br />";

	$ikk = get_option('links_count_position');
	echo "Completed " . $ikk . " checks";

}
