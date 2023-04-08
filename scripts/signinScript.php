<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../database/config.php";
require "getUser.php";

session_start();

function getJson($error)
{
    return json_encode($error);
}

if (!isset($_POST['email']) || $_POST['email'] == "") {
    $error = 'Fill in all fields.';
    echo getJson($error);
    die();
} else {
    $email = mysqli_real_escape_string($connection, $_POST['email']);
}

if (!isset($_POST['password']) || $_POST['password'] == "") {
    $error = 'Fill in all fields.';
    echo getJson($error);
    die();
} else {
    $password = mysqli_real_escape_string($connection, $_POST['password']);
}

$row = getUserByEmail_SelectAll($email, $connection);

if ($row == false) {
    $error = "Incorrect email or password.";
    echo getJson($error);
    die();
}

$hashPassFromDB = $row['password'];

if (password_verify($password, $hashPassFromDB)) {
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['user_name'] = $row['username'];
    echo getJson("200");
    die();
} else {
    $error = 'Incorrect email or password.';
    echo getJson($error);
    die();
}
