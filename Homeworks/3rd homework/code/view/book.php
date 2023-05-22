<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Book an Appointment</title>
</head>
<body>
<h1>Book an Appointment</h1>
       <?php if(!isset($speciality)){ ?>
       <form action="<?= BASE_URL . "healthcare/book" ?>" method="post">
              <label for="speciality">Select Speciality:</label>
              <select id="speciality" name="speciality">
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
              <select id="date" name="date">
              <?php foreach ($dates as $date): ?>
                     <option value="<?= $date ?>"><?= $date ?></option>
              <?php endforeach; ?>
              </select>
              <br><br>

              <input type="hidden" name="speciality" value="<?= $speciality ?>">

              <input type="submit" value="Next">
       </form>

       <?php } else { ?>
              <form action="<?= BASE_URL . "healthcare/book" ?>" method="post" 
                     onsubmit="return confirm('Are you sure you want to book this appointment?');">
                     <label for="doctor">Select Doctor:</label>
                     <select id="id_doctor_and_hour" name="id_doctor_and_hour">
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
       <a href="<?= BASE_URL . "main" ?>"> Go back to main menu </a>
</body>
</html>



