<?php

try {
	$db = new PDO(PDO_CONNECTION);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	die("SQLite connection failed: " . $e->getMessage());
}

header('Content-type: application/json');