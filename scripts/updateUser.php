<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../database/config.php";
$PASSWORD_PATTERN = "/^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9]{8,}$/";

if (isset($_POST['functionName'])) {
    $functionName = $_POST['functionName'];
    switch ($functionName) {
        case 'updateFull':
            updateFull($_POST['id'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['cpassword']);
            break;
        case 'updateBasic':
            updateBasic($_POST['id'], $_POST['username'], $_POST['email']);
            break;
    }
}

function getJson($message)
{
    return json_encode($message);
}

function updateBasic($id, $username, $email)
{
    global $connection;

    if (!isset($username) || $username == "") {
        $error = 'Fill in all fields.';
        echo getJson($error);
        die();
    } else {
        $username = mysqli_real_escape_string($connection, $username);
    }

    if (!isset($email) || $email == "") {
        $error = 'Fill in all fields.';
        echo getJson($error);
        die();
    } else {
        $email = mysqli_real_escape_string($connection, $email);
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please change to a valid email. (example@mail.com).";
        echo getJson($error);
        die();
    }

    $sql_query = " UPDATE `user` SET `username`='$username',`email`='$email' WHERE `id`='$id' ";
    $query_result = mysqli_query($connection, $sql_query);

    if ($query_result == false) {
        $error = "Error updating, please try again.";
        echo getJson($error);
        die();
    } else {
        echo getJson("200");
    }
}

function updateFull($id, $username, $email, $password, $cpassword)
{
    global $connection;
    global $PASSWORD_PATTERN;

    if (!isset($username) || $username == "") {
        $error = 'Fill in all fields.';
        echo getJson($error);
        die();
    } else {
        $username = mysqli_real_escape_string($connection, $username);
    }

    if (!isset($email) || $email == "") {
        $error = 'Fill in all fields.';
        echo getJson($error);
        die();
    } else {
        $email = mysqli_real_escape_string($connection, $email);
    }

    if (!isset($password) || $password == "") {
        $error = 'Fill in all fields.';
        echo getJson($error);
        die();
    } else {
        $password = mysqli_real_escape_string($connection, $password);
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please change to a valid email. (example@mail.com).";
        echo getJson($error);
        die();
    }

    if ($password != $cpassword) {
        $error = "Passwords don't match.";
        echo getJson($error);
        die();
    }

    if (!preg_match($PASSWORD_PATTERN, $password)) {
        $error = "Invalid password format." . PHP_EOL . "At least 8 characters and 1 number.";
        echo getJson($error);
        die();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if ($hashed_password == false || $hashed_password == null) {
        $error = "Hash error.";
        echo getJson($error);
        die();
    }

    $sql_query = " UPDATE `user` SET `username`='$username',`email`='$email',`password`='$hashed_password' WHERE `id`='$id' ";
    $query_result = mysqli_query($connection, $sql_query);

    if ($query_result == false) {
        $error = "Error updating, please try again.";
        echo getJson($error);
        die();
    } else {
        echo getJson("200");
    }
}
