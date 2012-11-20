<?php

require('config.inc.php');
require('functions.inc.php');
require('init.inc.php');

$return = array();

if(isset($_POST) && count($_POST) > 0) {
	// POST request
} else {
	$return['time'] = get_current_time();
}

echo json_encode($return);