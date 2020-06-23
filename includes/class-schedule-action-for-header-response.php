<?php
// disable direct file access
if (!defined('ABSPATH')) {

	exit;
}

class ScheduleActionForHeaderResponse {

/**
 * Schedule an action with the hook 'eg_midnight_log' to run at midnight each day
 * so that our callback is run then.
 */

	public function schedule_daily_check() {
		if (false === as_next_scheduled_action('check_all_links_daily')) {
			as_schedule_recurring_action(strtotime('tomorrow 4am'), DAY_IN_SECONDS, 'check_all_links_daily');
		}
	}

	public function unschedule_all_lc_actions() {
		as_unschedule_all_actions('check_all_links_daily');
	}

}

function run_action_data() {

	run_db_import();
	$run_4am = new Schedule_Single_Action_And_Run_Check;
	$run_4am->schedule_single_action_based_on_link_id();
}
add_action('check_all_links_daily', 'run_action_data');

$set_to_run_4am = new ScheduleActionForHeaderResponse;
//$set_to_run_4am->schedule_daily_check();
//$set_to_run_4am->unschedule_all_lc_actions();