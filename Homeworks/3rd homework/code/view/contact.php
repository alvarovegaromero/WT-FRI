<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Contact</title>
    <script>
        function showAlert() {
            alert("The message has been sent");
            window.location.href = "<?= BASE_URL . "healthcare/main" ?>";
        }
    </script>
</head>
<body>
    <h1>Contact</h1>
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

    <a href="<?= BASE_URL . "main" ?>">Main Menu </a>
</body>
</html>
