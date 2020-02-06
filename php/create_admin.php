<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'db_connection.php';
$dbh = connectToDb();
$username = 'bkvasha05';
$password = password_hash('katanzhek055',PASSWORD_DEFAULT);
$stmt = $dbh->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
$stmt->bindParam(1, $username);
$stmt->bindParam(2, $password);
$stmt->execute();