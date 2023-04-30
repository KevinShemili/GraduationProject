<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require "../database/config.php";

if (isset($_SESSION["user_id"])) {
    $userId = $_SESSION["user_id"];
}

if (!isset($_GET['analyseId'])) {
    die();
}

$analyseId = $_GET['analyseId'];

$sql_query = " DELETE FROM `analysis` WHERE id = '$analyseId' ";
$query_result = mysqli_query($connection, $sql_query);
header("location:../views/analyse.php?id=$userId");
