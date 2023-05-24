<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Register - Patients</title>
  <link rel="stylesheet" href="../../view/css/styles.css">
</head>

<body>
  <div class="background-image">

    <header class="banner">
      <h1 class="banner-title">Hospital XYZ</h1>
    </header>

    <section class="container">
      <h1 class="main-title">Register</h1>

      <?php if(isset($error)){?>
          <p class="error"> <?php print($error); ?> </p> <?php
      }?>

      <form action="../healthcare/register" method="POST">
        <p>
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required />
        </p>
        <p>
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required />
        </p>
        <p>
          <label for="name">Name</label>
          <input type="text" id="name" name="name" required />
        </p>
        <p>
          <label for="last_name">Last name</label>
          <input type="text" id="last_name" name="last_name" required />
        </p>
        <p>
          <label for="id">ID</label>
          <input type="text" id="id" name="id" minlength="8" maxlength="12" required />
        </p>
        <p>
          <label for="phone">Phone</label>
          <input type="tel" id="phone" name="phone" pattern="[0-9]+" required />
        </p>
        <p>
          <label for="birthday">Birthday</label>
          <input type="date" id="birthday" name="birthday" required />
        </p>
        <p>
          <label for="gender">Gender</label>
          <select id="gender" name="gender" required>
            <option value="">Select</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </p>
        <p>
          <input type="submit" value="Register" />
        </p>
      </form>
  </section>


    <footer> 
        <p> <a href="<?= BASE_URL . "main" ?>">Main Menu</a> </p> <br>
        <p> Hospital XYZ - More than a Hospital </p>
    </footer>  
  </div>
</body>

</html>
