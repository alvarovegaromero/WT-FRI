<!DOCTYPE html>
<meta charset="utf-8">
<title>Processing GET parameters</title>

<?php 

// var_dump($var) simply outputs the contents of $var, its type and size
// var_dump($_GET);

/*
 * The script should output the following string:
 *  - check if parameters are provided -- if not the script should display an error;
 *      - you can check if a value exists with http://php.net/manual/en/function.isset.php
 *      - you can test if a value is empty with http://php.net/manual/en/function.empty.php
 *  - and output a nicely formatted string using the send variables, for instance:
 *        "Hello $first_name $last_name, the time is <current_time_in_H:i_format>."
*/

if (!isset($_GET['first_name']) || !isset($_GET['last_name'])) { //check if both exist
  echo 'Error: first_name and last_name parameters are required.';
} 
else if (empty($_GET['first_name']) || empty($_GET['last_name'])) { //check if empty
  echo 'Error: first_name and last_name parameters cannot be empty.';
} 
else { //if correct, print it
    $current_time = new DateTime();
    $time_string = $current_time->format('H:i');
    echo "Hello {$_GET['first_name']} {$_GET['last_name']}, the time is $time_string.";
}