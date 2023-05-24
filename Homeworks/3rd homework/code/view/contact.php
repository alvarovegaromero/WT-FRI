<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Contact</title>
    <link rel="stylesheet" href="../../view/css/styles.css">
    <script>
        function showAlert() {
            alert("The message has been sent");
            window.location.href = "<?= BASE_URL . "healthcare/main" ?>";
        }
    </script>
</head>
<body>
    <header class="banner">
        <h1 class="banner-title">Hospital XYZ</h1>
    </header>

    <section class="container">
        <h1 class="main-title">Contact</h1>

        <div class="contact-form">
            <!-- We don't do anything with the consultations because it was not a main goal of this version -->
            <form action="<?= BASE_URL . "main" ?>" method="post">
                <!-- In future versions, for logged in users, this wouldn't be necessary -->
                <label for="email">Email:</label> 
                <input type="email" id="email" name="email" required><br><br>
                
                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" required><br><br>
                
                <label for="message">Message:</label><br>
                <textarea id="message" name="message" rows="4" cols="50" required></textarea><br><br>
                
                <input type="submit" value="Send" onclick="showAlert()">
            </form>
        </section>
    </div>

    <footer> 
        <p> <a href="<?= BASE_URL . "main" ?>">Main Menu</a> </p> <br>
        <p> Hospital XYZ - More than a Hospital </p>
    </footer>  
</body>
</html>
