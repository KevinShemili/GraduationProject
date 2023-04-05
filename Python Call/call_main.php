<?php
// Call the Python script
$command = "python main.py";
$output = shell_exec($command);
$data = json_decode($output, true);

// Now, you can use the data in your PHP web app to create the charts
print_r($data);
