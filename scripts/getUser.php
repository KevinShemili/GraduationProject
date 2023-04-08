<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function getUserByEmail_SelectAll($email, $connection)
{
    $sql_query = " SELECT * FROM user WHERE email = '$email' ";
    $query_result = mysqli_query($connection, $sql_query);

    if ($query_result == false) {
        $error = "Query result error.";
        throw new Exception($error);
    }

    if (mysqli_num_rows($query_result) > 0) {
        $row = mysqli_fetch_array($query_result);
        return $row;
    } else {
        return false;   // no users with the provided email 
    }
}

function getUserById_SelectAll($id, $connection)
{
    $sql_query = " SELECT * FROM user WHERE id = '$id' ";
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
