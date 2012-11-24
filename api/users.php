<?php

require('config.inc.php');
require('functions.inc.php');
require('init.inc.php');

$return = array();
$status = 200;

switch($_SERVER['REQUEST_METHOD']) {
	case 'POST':

		$status = 403;

		if(isset($_GET['login']) && isset($json_data['UserID'])) {
			$stmt = $db->query("SELECT * FROM Users WHERE UserID = '".$json_data['UserID']."'");
			$result = $stmt->fetch();

			if(is_array($result)) {
				if(isset($json_data['Password']) && $json_data['UserID'] == $json_data['Password']) {
					$status = 200;
					setcookie('auctionbase_user', $json_data['UserID'], 0, '/');
				}
			}
		} else {
			$stmt = $db->query("SELECT * FROM Users WHERE UserID = '".$json_data['UserID']."'");
			$result = $stmt->fetch();

			if(is_array($result) || empty($json_data['UserID'])) {
				$status = 403;
			} else {
				$status = 200;
				$db->query("INSERT INTO Users (UserID, Rating, Location, Country) VALUES ('".$json_data['UserID']."', 0, '".$json_data['Location']."', '".$json_data['Country']."');");
			}
		}

		break;

	case 'GET':

		$sql = 'SELECT * FROM Users WHERE 1 ';

		if(isset($_GET['UserID']) && !empty($_GET['UserID'])) {
			$sql .= 'AND UserID = "'.$_GET['UserID'].'" ';
		}

		if(isset($_GET['UserIDLike']) && !empty($_GET['UserIDLike'])) {
			$sql .= 'AND UserID LIKE "%'.$_GET['UserIDLike'].'%" ';
		}

		if(isset($_GET['CountryLike']) && !empty($_GET['CountryLike'])) {
			$sql .= 'AND Country LIKE "%'.$_GET['CountryLike'].'%" ';
		}

		if(isset($_GET['LocationLike']) && !empty($_GET['LocationLike'])) {
			$sql .= 'AND Location LIKE "%'.$_GET['LocationLike'].'%" ';
		}

		if(isset($_GET['MinRep']) && !empty($_GET['MinRep'])) {
			$sql .= 'AND Rating >= '.$_GET['MinRep'].' ';
		}

		if(isset($_GET['MaxRep']) && !empty($_GET['MaxRep'])) {
			$sql .= 'AND Rating >= '.$_GET['MaxRep'].' ';
		}

		if(isset($_GET['orderby']) && !empty($_GET['orderby'])) {
			$sql .= 'ORDER BY '.$_GET['orderby'].' ';
		}

		if(isset($_GET['numitems']) && !empty($_GET['numitems'])) {
			$sql .= 'LIMIT '.$_GET['numitems'];
		}	

		foreach($db->query($sql) as $row) {
			$return[] = $row;
		}

		if(isset($_GET['UserID']) && !empty($_GET['UserID'])) {
			$return = $return[0];
		}

		break;
}

header("HTTP/1.0 ".$status);
header("Status: ".$status);

echo json_encode($return);