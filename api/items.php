<?php

require('config.inc.php');
require('functions.inc.php');
require('init.inc.php');

$return = array();

if(isset($_GET['numitems'])) {
	$numitems = (int)$_GET['numitems'];
} else{
	$numitems = 50;
}

$current_time = strtotime(get_current_time());

switch($_SERVER['REQUEST_METHOD']) {
	case 'GET':
		$sql = 'SELECT Items.*, MIN(Bids.Amount), MAX(Bids.Amount) FROM Items LEFT JOIN Bids ON (Items.ItemID = Bids.ItemID) WHERE 1 ';

		if(isset($_GET['search']) && !empty($_GET['search'])) {
			$sql .= ' AND (Name LIKE "%'.$_GET['search'].'%" OR Description LIKE "%'.$_GET['search'].'%") ';
		}

		if(!isset($_GET['closed']) || ($_GET['closed'] != 1 && $_GET['closed'] != 'true')) {
			$sql .= 'AND Ends >= "'.get_current_time().'" ';
		}

		if(isset($_GET['itemid']) && !empty($_GET['itemid'])) {
			$sql .= 'AND Items.ItemID = "'.$_GET['itemid'].'" ';
		}

		$having = false;
		$sql .= 'GROUP BY Items.ItemID ';

		if(isset($_GET['min']) && !empty($_GET['min'])) {
			$min_price = round((float)$_GET['min'], 2);
			if(!$having) { $having = true; $sql .= " HAVING "; } else { $sql .= " AND "; }
			$sql .= '(MAX(Bids.Amount) >= '.$min_price.' OR (Bids.Amount IS NULL AND FirstBid >= '.$min_price.')) ';
		}

		if(isset($_GET['max']) && !empty($_GET['max'])) {
			$max_price = round((float)$_GET['max'], 2);
			if(!$having) { $having = true; $sql .= " HAVING "; } else { $sql .= " AND "; }
			$sql .= '(MAX(Bids.Amount) <= '.$max_price.' OR (Bids.Amount IS NULL AND FirstBid <= '.$max_price.')) ';
		}

		$sql .= 'ORDER BY Ends ASC ';

		if(isset($_GET['start'])) {
			$sql .= 'LIMIT '.(int)$_GET['start'].', '.$numitems.' ';
		} else{
			$sql .= 'LIMIT 0,'.$numitems.' ';
		}

		foreach($db->query($sql) as $row) {
			if(is_null($row['MAX(Bids.Amount)'])) 
				$row['CurrentPrice'] = $row['FirstBid'];
			else
				$row['CurrentPrice'] = $row['MAX(Bids.Amount)'];

			$row['CurrentPrice'] = sprintf("%.2f", $row['CurrentPrice']);
			$row['Ending'] = duration(strtotime($row['Ends']) - $current_time);

			$time_end = strtotime($row['Ends']);
			$time_start = strtotime($row['Started']);

			if($current_time < $time_end && $current_time > $time_start && $row['CurrentPrice'] < $row['BuyPrice'])
				$row['Active'] = 1;
			else
				$row['Active'] = 0;

			$return[] = $row;
		}

		break;
	case 'POST':

		break;
}

echo json_encode($return);