<!DOCTYPE html>

<meta charset="UTF-8" />
<title> My Bookings </title>

<h1> My Bookings </h1>

<?php

if (isset($patient)) {
    print "Hello: " . $patient["name"] . "\n";
    ?> <p> Your appointments are: </p> <?php

    foreach ($appointments as $appointment): ?>
        <p> Date: <?php echo(date('d/m/Y', strtotime($appointment['date']))); ?> 
            - Hour: <?php echo($appointment['hour']); ?> 
            - Doctor: <?php echo $appointment['name'] . ' ' . $appointment['last_name']; ?>
            <form action="<?= BASE_URL . "healthcare/cancel_booking" ?>" method="post" 
                    onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                <input type="hidden" name="id_appointment" value="<?php echo $appointment['id_appointment']; ?>">
                <button type="submit">Cancel Booking</button>
            </form>
        </p> 
    <?php endforeach;
}

else if(isset($doctor)){
    print "Hello Dr. " . $doctor["name"] . "\n";
    ?> <p> Your appointments are: </p> <?php

    foreach ($appointments as $appointment): ?>
        <p> Date: <?php echo(date('d/m/Y', strtotime())); ?> 
            - Hour: <?php echo($appointment['hour']); ?> 
            - Patient: <?php echo $appointment['name'] . ' ' . $appointment['last_name']; ?>

            <form action="<?= BASE_URL . "healthcare/cancel_booking" ?>" method="post" 
                    onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                <input type="hidden" name="id_appointment" value="<?php echo $appointment['id_appointment']; ?>">
                <button type="submit">Cancel Booking</button>
            </form>
        </p> 
    <?php endforeach;
}
?>

<a href="<?= BASE_URL . "main" ?>">Main Menu </a>
