<?php

require('config.inc.php');
require('functions.inc.php');
require('init.inc.php');

$return = array();

if(isset($_POST) && count($_POST) > 0) {
	// POST request
} else {
	$where = 'WHERE 1 ';
	if(isset($_GET['category']) && !empty($_GET['category'])) {
		$where .= 'AND Categories.CategoryID = '.$_GET['category'];
	}

	if(isset($_GET['top']) && !empty($_GET['top'])) {
		$top = (int)$_GET['top'];
		$sql = 'SELECT *, COUNT(*) FROM Categories NATURAL JOIN ItemCategories '.$where.' GROUP BY CategoryID ORDER BY COUNT(*) DESC LIMIT '.$top;
	} else {
		$sql = 'SELECT *, COUNT(*) FROM Categories NATURAL JOIN ItemCategories '.$where.' GROUP BY CategoryID';
	}
	foreach($db->query($sql) as $row) {
		$row['CategoryID'] = (int)$row['CategoryID'];
		$row['NumberOfItems'] = (int)$row['COUNT(*)'];
		unset($row['COUNT(*)']);
		$return[] = $row;
	}
}

echo json_encode($return);