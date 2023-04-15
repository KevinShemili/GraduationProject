<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../database/config.php";

function getJson($message)
{
    return json_encode($message);
}

if (!isset($_GET['id'])) {
    $error = 'Invalid id format.';
    echo getJson($error);
    die();
} else {
    $id = $_GET['id'];
}

$sql_query = " SELECT * FROM user WHERE id = '$id' ";
$query_result = mysqli_query($connection, $sql_query);

if ($query_result == false) {
    $error = "Query failure.";
    echo getJson($error);
    die();
}

if (mysqli_num_rows($query_result) > 0) {
    $row = mysqli_fetch_array($query_result);
    echo getJson($row);
} else {
    echo getJson("empty");
}
