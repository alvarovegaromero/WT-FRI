<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>My Bookings</title>
    <link rel="stylesheet" href="../../view/css/styles.css">
</head>
<body>
    <header class="banner">
        <h1 class="banner-title">Hospital XYZ</h1>
    </header>

    <section class="container">
        <h1 class="main-title">My Bookings</h1>

        <?php
        if (isset($patient)) {
            print "Hello: " . $patient["name"] . "\n";
            echo "<p>Your appointments are:</p>";
            foreach ($appointments as $appointment) { ?>
                <p>Date: <?php echo(date('d/m/Y', strtotime($appointment['date']))); ?> 
                    - Hour: <?php echo($appointment['hour']); ?> 
                    - Doctor: <?php echo $appointment['name'] . ' ' . $appointment['last_name']; ?> 
                    <form action="<?= BASE_URL . "healthcare/cancel_booking" ?>" method="post" 
                            onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                        <input type="hidden" name="id_appointment" value="<?php echo $appointment['id_appointment']; ?>">
                        <button type="submit">Cancel Booking</button>
                    </form>
                </p> 
            <?php }
        } else if(isset($doctor)) {
            print "Hello Dr. " . $doctor["name"] . "\n";
            echo "<p>Your appointments are:</p>";
            foreach ($appointments as $appointment) { ?>
                <p>Date: <?php echo(date('d/m/Y', strtotime($appointment['date']))); ?> 
                    - Hour: <?php echo($appointment['hour']); ?> 
                    - Patient: <?php echo $appointment['name'] . ' ' . $appointment['last_name']; ?>

                    <form action="<?= BASE_URL . "healthcare/cancel_booking" ?>" method="post" 
                            onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                        <input type="hidden" name="id_appointment" value="<?php echo $appointment['id_appointment']; ?>">
                        <button type="submit">Cancel Booking</button>
                    </form>
                </p> 
            <?php }
        }
        ?>
    </section>

    <footer> 
        <p> <a href="<?= BASE_URL . "main" ?>">Main Menu</a> </p> <br>
        <p> Hospital XYZ - More than a Hospital </p>
    </footer>
</body>
</html>

