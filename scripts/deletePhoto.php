<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../database/config.php";

function getJson($message)
{
    return json_encode($message);
}

function getPhotoName($id, $connection)
{
    $sql_query = " SELECT `profilePhoto` FROM `user` WHERE id = '$id' ";
    $query_result = mysqli_query($connection, $sql_query);

    if ($query_result == false) {
        $error = "Query result error.";
        throw new Exception($error);
    }

    if (mysqli_num_rows($query_result) > 0) {
        $row = mysqli_fetch_array($query_result);
        return $row;
    } else {
        return false;   // no users with the provided id 
    }
}

if (!isset($_POST['id'])) {
    $error = 'Fatal error.';
    echo getJson($error);
    die();
}

$id = $_POST['id'];

try {
    $file_name = getPhotoName($id, $connection);
} catch (Exception $e) {
    $error = $e->getMessage();
    echo getJson($error);
    die();
}

if (!$file_name) {
    $error = 'Fatal error.';
    echo getJson($error);
    die();
}

$file_path = '../img/uploads/' . $file_name['profilePhoto'];

if (!unlink($file_path)) {
    $error = 'Error deleting the file.';
    echo getJson($error);
    die();
}

$query = " UPDATE `user` SET `profilePhoto`='' WHERE `id` = '$id' ";
$query_result = mysqli_query($connection, $query);

if ($query_result == false) {
    $error = "Error updating, please try again.";
    echo getJson($error);
    die();
} else {
    echo getJson("200");
}
