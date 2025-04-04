<?php
require_once './models/database.php';

$database = new Database();
$conn = $database->getConnection();
$conn->query("SET time_zone = '+03:30'");