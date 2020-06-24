<?php
require_once('Connection.php');

$instance = Connection::getInstance();
$conn = $instance->getConnection();

// initialize database file
include_once('initdb.php');
