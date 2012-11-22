<?php

require('config.inc.php');
require('functions.inc.php');
require('init.inc.php');

$return = array();

switch($_SERVER['REQUEST_METHOD']) {
	
	case 'POST':
		$bidamount = 0;
		if(!isset($json_data['Amount']) || !is_numeric($json_data['Amount'])) {
			header("Status: 406");
			header("HTTP/1.0 406");
			die();
		} else {
			$bidamount = round($json_data['Amount'] + 0, 2);
		}

		if(!isset($_COOKIE['auctionbase_user']) || empty($_COOKIE['auctionbase_user'])) {
			header("Status: 403");
			header("HTTP/1.0 403");
			die();
		}

		if(!isset($json_data['ItemID']) || !isset($json_data['Amount'])) {
			header("Status: 400");
			header("HTTP/1.0 400");
			die();
		}

		$item_r = $db->query("SELECT * FROM Items WHERE ItemID = '".$json_data['ItemID']."' AND Started <= '".get_current_time()."' AND Ends >= '".get_current_time()."'");
		$item = $item_r->fetch();

		if(!is_array($item)) {
			header("Status: 404");
			header("HTTP/1.0 404");
			die();
		}

		$current_max = $item['FirstBid'] + 0;

		$maxbid_r = $db->query("SELECT MAX(Amount) FROM Bids WHERE ItemID = '".$json_data['ItemID']."'");
		$maxbid = $maxbid_r->fetch();

		if(is_array($maxbid) && is_numeric($maxbid[0])) {
			$current_max = $maxbid[0];
		}

		if($bidamount <= $current_max) {
			header("Status: 406");
			header("HTTP/1.0 406");
			die();
		}

		if(is_numeric($item['BuyPrice']) && $item['BuyPrice'] > 0 && $item['BuyPrice'] < $bidamount)
			$bidamount = $item['BuyPrice'];

		$db->query("INSERT INTO Bids (ItemID, UserID, Time, Amount) VALUES ('".$json_data['ItemID']."', '".$_COOKIE['auctionbase_user']."', '".get_current_time()."', ".$bidamount.")");

		break;

	case 'GET':

		$sql = 'SELECT Bids.*, Items.Name FROM Bids INNER JOIN Items ON(Bids.ItemID = Items.ItemID) WHERE 1 ';

		if(isset($_GET['itemid'])) {
			$sql .= 'AND Bids.ItemID = "'.$_GET['itemid'].'" ';
		}

		if(isset($_GET['userid'])) {
			$sql .= 'AND Bids.UserID = "'.$_GET['userid'].'" ';
		}

		$sql .= ' ORDER BY Bids.Amount DESC ';

		foreach($db->query($sql) as $row) {
			$row['Amount'] = sprintf("%.2f", $row['Amount']);
			$return[] = $row;
		}

		break;
}

echo json_encode($return);