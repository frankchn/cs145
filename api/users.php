<?php

require('config.inc.php');
require('functions.inc.php');
require('init.inc.php');

$return = array();
$status = 403;

switch($_SERVER['REQUEST_METHOD']) {
	case 'POST':

		if(isset($_GET['login']) && isset($json_data['UserID'])) {
			$stmt = $db->query("SELECT * FROM Users WHERE UserID = '".$json_data['UserID']."'");
			$result = $stmt->fetch();

			if(is_array($result)) {
				if(isset($json_data['Password']) && $json_data['UserID'] == $json_data['Password']) {
					$status = 200;
					setcookie('auctionbase_user', $json_data['UserID'], 0, '/');
				}
			}
		}

		break;
}

header("HTTP/1.0 ".$status);
header("Status: ".$status);

echo json_encode($return);