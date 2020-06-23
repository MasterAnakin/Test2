	<?php

function progress_bar_query() {

	global $wpdb;
	global $table_name;

	$sql = "SELECT timestamp FROM list_links ORDER BY `timestamp` DESC LIMIT 4";

	//$sql = $wpdb->prepare($sql);
	$array = $wpdb->get_results($sql, ARRAY_A);
	$clean_arr = array_column($array, 'timestamp');

	for ($cnt = count($clean_arr), $res = 0, $i = 1; $i < $cnt; $i++) {
		$res += $clean_arr[$i - 1] - $clean_arr[$i];
	}

	echo $res / $cnt;

	$avg = $res / $cnt;
	return $avg;

}

function calc_total() {
	global $wpdb;
	global $table_name;

	$sql = "SELECT id FROM list_links";

	//$sql = $wpdb->prepare($sql);
	$array = $wpdb->get_results($sql, ARRAY_A);
	$total_count = count($array);

	return $total_count;
}

function calc_needed_time() {

	$avg = progress_bar_query();
	$total_count = calc_total();

	echo $avg . "<br />";
	echo $total_count . "<br />";

	$total_avg = $avg * $total_count;

	print_r($total_avg);

}

function tryme() {

	$ikl = get_option('links_count_position');
	echo '<div id="dom-target" style="display: none;">
         htmlspecialchars(' . $ikl . '); /* You have to escape because the result
                                           will not be valid HTML otherwise. */

</div>';

	echo '
<script>
    var div = document.getElementById("dom-target");
    var myData = div.textContent;
</script>';

	echo '
	<div id="progressbar">
  <script>
  $( function() {
    $( "#progressbar" ).progressbar({
      value: 38
    });
  } );
  </script></div>';

	echo '
  <!-- snip →
 <script>
     function reqListener () {
        console.log(this.responseText);
     }
     var oReq = new XMLHttpRequest(); //New request object
     oReq.onload = function() {
          //This is where you handle what to do with the response.
          //The actual data is found on this.responseText
         alert(this.responseText); //Will alert: 42
     };
     oReq.open("get", "get-data.php", true);
// ^ Dont block the rest of the execution.
// Dont wait until the request finishes to // continue.
oReq.send();
</script>';

}

add_shortcode('shutdown', 'tryme');
