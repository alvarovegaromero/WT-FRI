<!DOCTYPE html>

<meta charset="UTF-8" />
<title> Log in - Patients </title>

<h1> Log in for Patients </h1>

<form method="POST" id="login" action="../healthcare/login_patient">
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
?>

<a href="<?= BASE_URL . "main" ?>">Main Menu </a>