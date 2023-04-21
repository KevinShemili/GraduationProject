<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../database/config.php";

function getJson($message)
{
    return json_encode($message);
}

if (!isset($_POST['query']) || $_POST['query'] == "") {
    $error = 'Fill in all fields.';
    echo getJson($error);
    die();
} else {
    $query = mysqli_real_escape_string($connection, $_POST['query']);
}

if (!isset($_POST['tweetNr']) || $_POST['tweetNr'] == "") {
    $error = 'Fill in all fields.';
    echo getJson($error);
    die();
} else {
    $tweetNr = $_POST['tweetNr'];
}

if (!isset($_POST['description']) || $_POST['description'] == "") {
    $error = 'Fill in all fields.';
    echo getJson($error);
    die();
} else {
    $description = $_POST['description'];
}

if (!isset($_POST['algorithm']) || $_POST['algorithm'] == "") {
    $error = 'Fill in all fields.';
    echo getJson($error);
    die();
} else {
    $algorithm = $_POST['algorithm'];
}

if (!isset($_POST['consumerKey']) || $_POST['consumerKey'] == "") {
    echo getJson("modal");
    die();
} else {
    $consumerKey = $_POST['consumerKey'];
}

if (!isset($_POST['consumerSecret']) || $_POST['consumerSecret'] == "") {
    echo getJson("modal");
    die();
} else {
    $consumerSecret = $_POST['consumerSecret'];
}

if (!isset($_POST['accessToken']) || $_POST['accessToken'] == "") {
    echo getJson("modal");
    die();
} else {
    $accessToken = $_POST['accessToken'];
}

if (!isset($_POST['accessTokenSecret']) || $_POST['accessTokenSecret'] == "") {
    echo getJson("modal");
    die();
} else {
    $accessTokenSecret = $_POST['accessTokenSecret'];
}

if ($algorithm == "vader") {
    $command = "python ../python/main.py " . escapeshellarg($query . " -filter:retweets") . " " . escapeshellarg($tweetNr) . " " . escapeshellarg($consumerKey) . " " . escapeshellarg($consumerSecret) . " " . escapeshellarg($accessToken) . " " . escapeshellarg($accessTokenSecret);
    $output = shell_exec($command);
    $data = json_decode($output, true);

    if (isset($data['error'])) {
        $response = array(
            "status" => 500,
            "error" => $data['error']
        );
        echo getJson($response);
    } else {
        $id = $_POST["id"];
        $neutral = $data["total_neutral"];
        $positive = $data["total_positive"];
        $negative = $data["total_negative"];
        $date = date('Y-m-d');
        $sql_insert_query = " INSERT INTO `analysis`(`query`, `nrTweets`, `description`, `dateCreated`, `algorithm`, `negative`, `neutral`, `positive`, `user_id`) VALUES ('$query','$tweetNr','$description','$date','$algorithm','$negative','$neutral','$positive','$id') ";
        $mysqliResult = mysqli_query($connection, $sql_insert_query);

        if ($mysqliResult == false) {
            $error = "Fatal error.";
            echo getJson($error);
            die();
        }
        echo getJson("200");
    }
} elseif ($algorithm == "textblob") {
} else {
}
