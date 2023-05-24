<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <link rel="stylesheet" href="../../view/css/styles.css">
</head>
<body>
    
    <header class="banner">
        <h1 class="banner-title">Hospital XYZ</h1>
    </header>

    <section class="container">
        <h1 class="main-title">My Profile</h1>

        <p class="profile-att">Name: <?php echo htmlspecialchars($doctor["name"]); ?></p>
        <p class="profile-att">Last name: <?php echo htmlspecialchars($doctor["last_name"]); ?></p>
        <p class="profile-att">ID: <?php echo htmlspecialchars($doctor["id"]); ?></p>
        <p class="profile-att">Email: <?php echo htmlspecialchars($doctor["email"]); ?></p>
        <!-- <p>Password: <?php //echo htmlspecialchars($doctor["password"]); ?></p> -->
        <p class="profile-att">Phone: <?php echo htmlspecialchars($doctor["phone"]); ?></p>
        <p class="profile-att">Birthday: <?php echo htmlspecialchars(date('d/m/Y', strtotime($doctor['birthday']))); ?></p>
        <p class="profile-att">Speciality: <?php echo htmlspecialchars($doctor["speciality"]); ?></p>
    </section>

    <footer> 
        <p> <a href="<?= BASE_URL . "main" ?>">Main Menu</a> </p> <br>
        <p> Hospital XYZ - More than a Hospital </p>
    </footer>
</body>
</html>

