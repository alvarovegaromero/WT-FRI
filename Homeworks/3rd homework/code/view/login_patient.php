<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Log in - Patients</title>
    <link rel="stylesheet" href="../../view/css/styles.css">
</head>
<body>
    <div class="background-image">

    <header class="banner">
        <h1 class="banner-title">Hospital XYZ</h1>
    </header>

    <section class="container">
        <h1 class="main-title">Login as Patient</h1>

        <?php if(isset($error)){?>
          <p class="error"> <?php print($error); ?> </p> <?php
        }?>

        <form method="POST" id="login" action="../healthcare/login_patient">
            <p>
                <label for="email">Email:</label>
                <input type="email" name="email" required>
            </p>
            <p>
                <label for="password">Password:</label>
                <input type="password" name="password" required>
            </p>
            <p>
                <input type="submit" value="Send">
            </p>
        </form>
    </section>

    <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 

        <footer> 
            <p> <a href="<?= BASE_URL . "main" ?>">Main Menu</a> </p> <br>
            <p> Hospital XYZ - More than a Hospital </p>
        </footer>
    </div>
</body>
</html>
