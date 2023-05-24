<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Main Page</title>
  <link rel="stylesheet" href="../view/css/styles.css">
</head>
<body>
    <div class="background-image">
        <?php //echo __FILE__ ?>

        <header class="banner">
            <h1 class="banner-title">Hospital XYZ</h1>
        </header>

        <section class="container">
            <h1 class="main-title">Main Page</h1>

            <?php
            // For users that are not logged in
            if (!isset($doctor) && !isset($patient)) { ?>
            <p> • <a href="<?= BASE_URL . "healthcare/login_patient" ?>" class="menu-link">Log in as Patient</a> </p>
            <p> • <a href="<?= BASE_URL . "healthcare/register" ?>" class="menu-link">Register</a> </p>
            <p> • <a href="<?= BASE_URL . "healthcare/login_doctor" ?>" class="menu-link">Log in as Doctor</a> </p>
            <?php } 

            // For users that are logged in
            if(isset($doctor) || isset($patient)){
                ?>
                    <p> • <a href="<?= BASE_URL . "healthcare/logout" ?>" class="logout-link menu-link">Logout</a> </p>
                    <p> • <a href="<?= BASE_URL . "healthcare/my_bookings" ?>" class="menu-link">My Bookings</a> </p> <?php
        
                    if(isset($doctor)){
                        //echo "Hello: " . $_SESSION['doctor']["name"];
                        ?><p> • <a href="<?= BASE_URL . "healthcare/profile_doctor" ?>" class="menu-link">My Profile</a> </p> <?php
                    } elseif(isset($patient)){ ?> 
                        <p> • <a href="<?= BASE_URL . "healthcare/profile_patient" ?>" class="menu-link">My Profile</a> </p>
                        <p> • <a href="<?= BASE_URL . "healthcare/book" ?>" class="menu-link">Make an Appointment</a> </p> <?php 
                    }
                }

            // For all users
            ?>
            <br> <br>
            <p> • <a href="<?= BASE_URL . "healthcare/contact" ?>" class="menu-link">Contact</a> </p>
            <p> • <a href="<?= BASE_URL . "healthcare/about_us" ?>" class="menu-link">About us</a> </p>
        </section>

        <footer> Hospital XYZ - More than a Hospital </footer>
    </div>
</body>
</html>

     

