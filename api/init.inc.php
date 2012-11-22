<?php

try {
	$db = new PDO(PDO_CONNECTION);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	die("SQLite connection failed: " . $e->getMessage());
}

$raw_data = file_get_contents("php://input");
$json_data = json_decode($raw_data, true);

header('Content-type: application/json');