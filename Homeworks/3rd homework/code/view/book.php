<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Book an Appointment</title>
    <link rel="stylesheet" href="../../view/css/styles.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/smoothness/jquery-ui.css">
</head>
<body>
    <header class="banner">
        <h1 class="banner-title">Hospital XYZ</h1>
    </header>

    <section class="container">
        <h1 class="main-title">Book an Appointment</h1>

        <?php if(!isset($speciality)){ ?>
            <form action="<?= BASE_URL . "healthcare/book" ?>" method="post">
                <label for="speciality">Select Speciality:</label>
                <select id="speciality" name="speciality" required>
                    <?php foreach ($specialities as $speciality): ?>
                        <option value="<?= $speciality ?>"><?= $speciality ?></option>
                    <?php endforeach; ?>
                </select>
                <br><br>

                <input type="submit" value="Next">
            </form>

        <?php } else if(!isset($date)) { ?>
            <form action="<?= BASE_URL . "healthcare/book" ?>" method="post" id="dateForm">
                <label for="date">Select Date:</label>
                <input type="text" id="datepicker" name="date" required>
                <br><br>

                <input type="hidden" name="speciality" value="<?= $speciality ?>">

                <input type="submit" value="Next">
            </form>

        <?php } else { ?>
            <form action="<?= BASE_URL . "healthcare/book" ?>" method="post" 
                onsubmit="return confirm('Are you sure you want to book this appointment?');">
                <label for="doctor">Select Doctor:</label>
                <select id="id_doctor_and_hour" name="id_doctor_and_hour" required>
                    <optgroup label="<?= date('d/m/Y', strtotime($date)); ?>">
                        <?php foreach ($doctors as $doctor): ?>
                            <option value="<?= $doctor['id_doctor'] . '|' . $doctor['hour'] ?>">
                                Dr. <?= $doctor['name'] ?> <?= $doctor['last_name'] ?> - Hour: <?= $doctor['hour'] ?>
                            </option>
                        <?php endforeach; ?>
                    </optgroup>
                </select>
                <br><br>

                <input type="hidden" name="speciality" value="<?= $speciality ?>">
                <input type="hidden" name="date" value="<?= $date ?>">

                <input type="submit" value="Next">
            </form>
        <?php } ?>
    </section>

    <footer> 
        <p> <a href="<?= BASE_URL . "main" ?>">Main Menu</a> </p> <br>
        <p> Hospital XYZ - More than a Hospital </p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
              $("#datepicker").datepicker({
                     dateFormat: "yy-mm-dd",
                     beforeShowDay: highlightAvailableDays
              });

              function highlightAvailableDays(date) {
                     var dateString = $.datepicker.formatDate("yy-mm-dd", date);
                     return [($.inArray(dateString, <?= json_encode($dates) ?>) != -1)];
              }
       });
    </script>
</body>
</html>

<?php
/*     Select date with select
              <form action="<?= BASE_URL . "healthcare/book" ?>" method="post" id="dateForm">
                     <label for="date">Select Date:</label>
                     <select id="date" name="date" required>
                     <?php foreach ($dates as $date): ?>
                            <option value="<?= $date ?>"><?= $date ?></option>
                     <?php endforeach; ?>
                     </select>
                     <br><br>

                     <input type="hidden" name="speciality" value="<?= $speciality ?>">

                     <input type="submit" value="Next">
              </form>
*/
?>
