<?php

global $wpdb;

global $table_name;

$charset_collate = $wpdb->get_charset_collate();

$table_name = $wpdb->prefix . "list_links";

$sql = "CREATE TABLE $table_name (
  id int(11) NOT NULL AUTO_INCREMENT,
  single_link varchar(256) DEFAULT '' NOT NULL,
  status_code varchar(256) DEFAULT '' NOT NULL,
  timestamp varchar(256) DEFAULT '' NOT NULL,
  PRIMARY KEY  (id)
) $charset_collate;";

require_once ABSPATH . 'wp-admin/includes/upgrade.php';
dbDelta($sql);
