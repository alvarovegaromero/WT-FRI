
<meta charset="UTF-8" />
<title> My Profile </title>

<h1> My Profile </h1>

    <p>Name: <?php print($doctor["name"]); ?></p>
    <p>Last name: <?php print($doctor["last_name"]); ?></p>
    <p>ID: <?php print($doctor["id"]); ?></p>
    <p>Email: <?php print($doctor["email"]); ?></p>
    <!-- <p>Password: <?php //print($doctor["password"]); ?></p> -->
    <p>Phone: <?php print($doctor["phone"]); ?></p>
    <p>Birthday: <?php print(date('d/m/Y', strtotime($doctor['birthday']))); ?></p>
    <p>Speciality: <?php print($doctor["speciality"]); ?></p>

    <a href="<?= BASE_URL . "main" ?>">Main Menu </a>
