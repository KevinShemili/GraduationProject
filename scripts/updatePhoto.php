<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../database/config.php";

function getJson($message)
{
    return json_encode($message);
}

if (!isset($_FILES['photoForm'])) {
    $error = 'No photo uploaded.';
    echo getJson($error);
    die();
}

if (!isset($_POST['id'])) {
    $error = 'Fatal error.';
    echo getJson($error);
    die();
}

$id = $_POST['id'];

$file_name = $_FILES['photoForm']['name'];
$file_tmp = $_FILES['photoForm']['tmp_name'];

$file_ext_arr = explode('.', $_FILES['photoForm']['name']);
$file_ext = strtolower(end($file_ext_arr));

$extensions = array("jpeg", "jpg", "png");

if (in_array($file_ext, $extensions) === false) {
    $error = 'Only jpeg, jpg, png supported.';
    echo getJson($error);
    die();
}

$new_file_name = uniqid() . '.' . $file_ext;
$file_path = '../img/uploads/' . $new_file_name;

move_uploaded_file($file_tmp, $file_path);

$query = " UPDATE `user` SET `profilePhoto`='$new_file_name' WHERE `id` = '$id' ";
$query_result = mysqli_query($connection, $query);

if ($query_result == false) {
    $error = "Error updating, please try again.";
    echo getJson($error);
    die();
} else {
    echo getJson("200");
}
