<!DOCTYPE html>

<meta charset="UTF-8" />
<title> Main Page </title>

<h1> Main Page </h1>

<?php

//For users that are not logged in
if (!isset($doctor) && !isset($patient)) { ?>
    <p>[ <a href="<?= BASE_URL . "healthcare/login_patient" ?>">Log in as Patient </a> | 
    <a href="<?= BASE_URL . "healthcare/register" ?>">Register</a> |
    <a href="<?= BASE_URL . "healthcare/login_doctor" ?>">Log in as Doctor </a> ] </p>
<?php } 

//For all users
?> <a href="<?= BASE_URL . "healthcare/contact" ?>">Contact </a> </p> <?php
?> <a href="<?= BASE_URL . "healthcare/about_us" ?>">About us </a> </p> <?php


//For users that are logged in
if(isset($doctor) || isset($patient)){
    ?>  <a href="<?= BASE_URL . "healthcare/logout" ?>">Logout </a> </p> <?php
    ?> <a href="<?= BASE_URL . "healthcare/my_bookings" ?>"> My Bookings </a> </p> <?php

    if(isset($doctor)){
        //echo "Hello: " . $_SESSION['doctor']["name"];
        ?> <a href="<?= BASE_URL . "healthcare/profile_doctor" ?>"> My Profile </a> </p><?php
    } elseif(isset($patient)){ ?> 
        <a href="<?= BASE_URL . "healthcare/profile_patient" ?>"> My Profile </a> </p>
        <a href="<?= BASE_URL . "healthcare/book" ?>"> Make an Appointment </a> </p> <?php 
    }
}
?>
