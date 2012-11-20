<?php

require('config.inc.php');
require('functions.inc.php');
require('init.inc.php');

$return = array();

switch($_SERVER['REQUEST_METHOD']) {
	case 'GET':

		$sql = 'SELECT * FROM Bids WHERE 1 ';

		if(isset($_GET['itemid'])) {
			$sql .= 'AND ItemID = "'.$_GET['itemid'].'" ';
		}

		$sql .= ' ORDER BY Time DESC ';

		foreach($db->query($sql) as $row) {
			$row['Amount'] = sprintf("%.2f", $row['Amount']);
			$return[] = $row;
		}

		break;
}

echo json_encode($return);