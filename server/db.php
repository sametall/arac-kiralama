<?php
ob_start();
session_start();
date_default_timezone_set('Europe/Istanbul');
// bütün hataları göster
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../global.php';

$dbName = 'db_ybs2023';
$dbUser = 'root';
$dbPass = '';

try {
    $db = new PDO("mysql:host=localhost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}
