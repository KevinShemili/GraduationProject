<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../database/config.php";
require "../vendor/autoload.php";
require "../Credentials/smtp_config.php";

use PHPMailer\PHPMailer\PHPMailer;

if (
    isset($_POST['username']) &&
    isset($_POST['email']) &&
    isset($_POST['password'])
) {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    $errors = array(); // store errors to return to js

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql_query = " SELECT * FROM user WHERE email = '$email' ";
        $query_result = mysqli_query($connection, $sql_query);

        if (mysqli_num_rows($query_result) > 0) {
            $errors[] = 'Email already exists.';
        } else {
            $sql_insert_query = " INSERT INTO user(username, email, password) VALUES ('$username','$email', '$hashed_password')";
            $mysqliResult = mysqli_query($connection, $sql_insert_query);

            if ($mysqliResult == false) {
                $errors[] = "Could not create signup.";
            }

            // Sent email for new registration
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;

            $mail->Username = $SMTP_USERNAME;
            $mail->Password = $SMTP_PASSWORD;

            $mail->SMTPSecure = "ssl";
            $mail->Port = 465;

            $mail->setFrom($SMTP_USERNAME);
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Successful Registration.";
            $mail->Body = "Successful Registration for twitter sentiment analysis.";

            try {
                $mail->send();
            } catch (Exception $e) {
                $errors[] = $e;
            }
        }
    } else {
        $errors[] = "Please put a valid email. (example@mail.com)";
    }

    $response = array(
        'errors' => $errors
    );

    $response_json = json_encode($response);

    echo $response_json;
}
