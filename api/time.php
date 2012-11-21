<?php

require('config.inc.php');
require('functions.inc.php');
require('init.inc.php');

$return = array();

if(!is_null($json_data)) {
	$time = date("Y-m-d H:i:s", strtotime($json_data->time));
	$db->query("UPDATE Time SET cur_time = '".$time."'");
} 

$return['time'] = get_current_time();
echo json_encode($return);