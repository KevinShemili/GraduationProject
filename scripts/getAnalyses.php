<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../database/config.php";

if (isset($_POST['functionName'])) {
    $functionName = $_POST['functionName'];
    switch ($functionName) {
        case 'getAllAnalyses':
            getAllAnalyses($_POST['id']);
            break;
        case 'getSentiment':
            updateBasic($_POST['id'], $_POST['username'], $_POST['email']);
            break;
    }
}

function getJson($message)
{
    return json_encode($message);
}

function getAllAnalyses($id)
{
    global $connection;

    $sql_query = " SELECT * FROM analysis WHERE user_id	= '$id' ";
    $query_result = mysqli_query($connection, $sql_query);

    if ($query_result == false) {
        $error = "Query failure.";
        echo getJson($error);
        die();
    }

    if (mysqli_num_rows($query_result) > 0) {

        while ($row = $query_result->fetch_assoc()) {
            $array[] = $row;
        }


        $returnObj = array(
            "status" => 200,
            "data" => $array
        );

        echo getJson($returnObj);
    } else {
        $returnObj = array(
            "status" => 500,
            "error" => "Fatal Error"
        );
        echo getJson($returnObj);
    }
}


function getSentiment($id)
{
}
