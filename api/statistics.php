<?php

require('config.inc.php');
require('functions.inc.php');
require('init.inc.php');

$return = array();

$users_registered = end($db->query("SELECT COUNT(*) FROM Users")->fetch());
$total_auctions = end($db->query("SELECT COUNT(*) FROM Items")->fetch());
$open_auctions = end($db->query("SELECT COUNT(*) FROM Items WHERE Started <= '".get_current_time()."' AND Ends >= '".get_current_time()."'")->fetch());
$max_bid = end($db->query("SELECT MAX(Amount) FROM Bids")->fetch());
$min_bid = end($db->query("SELECT MIN(Amount) FROM Bids")->fetch());

$return['users_registered'] = $users_registered;
$return['total_auctions'] = $total_auctions;
$return['open_auctions'] = $open_auctions;
$return['max_bid'] = sprintf("%.2f", $max_bid);
$return['min_bid'] = sprintf("%.2f", $min_bid);

echo json_encode($return);