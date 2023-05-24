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
        
        <p class="profile-att">Name: <?php echo htmlspecialchars($patient["name"]); ?></p>
        <p class="profile-att">Last name: <?php echo htmlspecialchars($patient["last_name"]); ?></p>
        <p class="profile-att">ID: <?php echo htmlspecialchars($patient["id"]); ?></p>
        <p class="profile-att">Email: <?php echo htmlspecialchars($patient["email"]); ?></p>
        <!-- <p>Password: <?php //print($patient["password"]); ?></p> -->
        <p class="profile-att">Phone: <?php echo htmlspecialchars($patient["phone"]); ?></p>
        <p class="profile-att">Birthday: <?php echo htmlspecialchars(date('d/m/Y', strtotime($patient['birthday']))); ?></p>
        <p class="profile-att">Gender: <?php echo htmlspecialchars($patient["gender"]); ?></p>
    </section>  

    <footer>
        <p> <a href="<?= BASE_URL . "main" ?>">Main Menu</a> </p> <br>
        <p> Hospital XYZ - More than a Hospital </p>
    </footer>
</body>
</html>


