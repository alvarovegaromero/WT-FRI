<!DOCTYPE html>

<meta charset="UTF-8" />
<title> My Profile </title>

<h1> My Profile </h1>

    <p>Name: <?php print($patient["name"]); ?></p>
    <p>Last name: <?php print($patient["last_name"]); ?></p>
    <p>ID: <?php print($patient["id"]); ?></p>
    <p>Email: <?php print($patient["email"]); ?></p>
    <!-- <p>Password: <?php //print($patient["password"]); ?></p> -->
    <p>Phone: <?php print($patient["phone"]); ?></p>
    <p>Birthday: <?php print(date('d/m/Y', strtotime($patient['birthday']))); ?></p>
    <p>Gender: <?php print($patient["gender"]); ?></p>

    <a href="<?= BASE_URL . "main" ?>">Main Menu </a>
