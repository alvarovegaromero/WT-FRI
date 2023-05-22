<!DOCTYPE html>

<meta charset="UTF-8" />
<title> Register - Patients </title>

<h1> Register for Patients </h1>

<form action="../healthcare/register" method="POST">
    <p>
        <label for="email">Email</label>
        <input type="text" id="email" name="email" required/>
    </p>
    <p>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required/>
    </p>
    <p>
        <label for="name">Name</label>
        <input type="name" id="name" name="name" required/>
    </p>
    <p>
        <label for="last_name">Last name</label>
        <input type="text" id="last_name" name="last_name" required/>
    </p>
    <p>
        <label for="id">ID</label>
        <input type="text" id="id" name="id" required/>
    </p>
    <p>
        <label for="phone">Phone</label>
        <input type="tel" id="phone" name="phone" required/>
    </p>
    <p>
        <label for="birthday">Birthday</label>
        <input type="date" id="birthday" name="birthday" required/>
    </p>
    <p>
        <label for="gender">Gender</label>
        <select id="gender" name="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
    </p>
    <p>
        <input type="submit" value="Register">
    </p>
</form>

<?php
?>