<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../database/config.php";
require "../vendor/autoload.php";
require "../Credentials/smtp_config.php";

use PHPMailer\PHPMailer\PHPMailer;

$errors = array(); // store errors to return to js

$PASSWORD_PATTERN = "/^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9]{8,}$/";

function getJson($error)
{
    return json_encode($error);
}

if (!isset($_POST['username']) || $_POST['username'] == "") {
    $error = 'Fill in all fields.';
    echo getJson($error);
    die();
} else {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
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

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Please put a valid email. (example@mail.com).";
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

$sql_query = " SELECT * FROM user WHERE email = '$email' ";
$query_result = mysqli_query($connection, $sql_query);

if ($query_result == false) {
    $error = "Query result error.";
    echo getJson($error);
    die();
}

if (mysqli_num_rows($query_result) > 0) {
    $error = "Email already exists.";
    echo getJson($error);
    die();
}

$sql_insert_query = " INSERT INTO user(username, email, password) VALUES ('$username','$email', '$hashed_password')";
$mysqliResult = mysqli_query($connection, $sql_insert_query);

if ($mysqliResult == false) {
    $error = "Could not create new signup.";
    echo getJson($error);
    die();
}

    /*
            // Sent email for new registration
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;

            $mail->Username = $SMTP_USERNAME;
            $mail->Password = $SMTP_PASSWORD;

            $mail->SMTPSecure = "ssl";
            $mail->Port = 465;

            $mail->setFrom($SMTP_USERNAME, "Twitter Sentiment Analysis");
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Successful Registration.";
            $mail->Body = "Successful Registration for twitter sentiment analysis.";

            try {
                $mail->send();
            } catch (Exception $e) {
                $errors[] = $e;
            }
            */
