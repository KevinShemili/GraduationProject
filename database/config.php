<?php

// database

$connection = mysqli_connect('localhost', 'root', '', 'sentiment_analysis');

if (!$connection) {
    die("Connection error: " . mysqli_connect_error());
}
