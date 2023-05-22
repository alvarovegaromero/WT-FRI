<!DOCTYPE html>

<meta charset="UTF-8" />
<title> Log in - Doctor </title>

<h1> Log in for Doctors </h1>

<form method="POST" id="login" action="../healthcare/login_doctor">
        <p>
          <label for="email">Email:</label>
          <input type="text" name="email" required>
        </p>
        <p>
          <label for="password">Password:</label>
          <input type="password" name="password" required>
        </p>
        <p> <input type="submit" value="Send"> </p>

<?php

  /*
    if(isset($variables['succesful_login']))
        echo "Succesful login, doctor";
    else
        echo "xd";
    
    if(isset($_SESSION['doctor']))
      echo "Hello doctor" . $_SESSION['doctor']["name"];
      */
?>
      
    <a href="<?= BASE_URL . "main" ?>">Main Menu </a>