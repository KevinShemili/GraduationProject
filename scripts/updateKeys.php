<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../database/config.php";

function getJson($message)
{
    return json_encode($message);
}

if (!isset($_POST['id'])) {
    $error = 'Fatal error.';
    echo getJson($error);
    die();
}

$id = $_POST['id'];

if (!isset($_POST["consumerKey"]) || $_POST["consumerKey"] == "") {
    $error = 'Fill in all fields.';
    echo getJson($error);
    die();
} else {
    $consumerKey = mysqli_real_escape_string($connection, $_POST["consumerKey"]);
}

if (!isset($_POST["consumerSecret"]) || $_POST["consumerSecret"] == "") {
    $error = 'Fill in all fields.';
    echo getJson($error);
    die();
} else {
    $consumerSecret = mysqli_real_escape_string($connection, $_POST["consumerSecret"]);
}

if (!isset($_POST["accessToken"]) || $_POST["accessToken"] == "") {
    $error = 'Fill in all fields.';
    echo getJson($error);
    die();
} else {
    $accessToken = mysqli_real_escape_string($connection, $_POST["accessToken"]);
}

if (!isset($_POST["accessTokenSecret"]) || $_POST["accessTokenSecret"] == "") {
    $error = 'Fill in all fields.';
    echo getJson($error);
    die();
} else {
    $accessTokenSecret = mysqli_real_escape_string($connection, $_POST["accessTokenSecret"]);
}

$sql_query = " UPDATE `twitter_keys` SET `consumer_key`='$consumerKey',`consumer_secret`='$consumerSecret',`access_token`='$accessToken',`access_token_secret`='$accessTokenSecret' WHERE `user_id`='$id' ";
$query_result = mysqli_query($connection, $sql_query);

if ($query_result == false) {
    $error = "Error updating, please try again.";
    echo getJson($error);
    die();
} else {
    echo getJson("200");
}
