<?php
// Start PHP session (if needed)
session_start();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> <!-- jQuery -->
</head>
<body>

    <h1>Contactează-ne</h1>
    
    <div class="contact-container">
        <form id="formularContact">
            <label for="nume">Nume:</label>
            <input type="text" id="nume" name="nume" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="mesaj">Mesaj:</label>
            <textarea id="mesaj" name="mesaj" required></textarea>

            <button type="submit">Trimite</button>
        </form>
    </div>
    
    <div id="raspuns"></div> <!-- Aici va apărea răspunsul -->

    <script>
    $(document).ready(function() {
        $("#formularContact").submit(function(event) {
            event.preventDefault(); // Previne trimiterea standard a formularului

            let formData = new FormData(this);

            $.ajax({
                url: "api/process_form.php", // Asigură-te că acest fișier există
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $("#raspuns").html(response);
                },
                error: function(xhr, status, error) {
                    console.error("Eroare AJAX:", error);
                    $("#raspuns").html('<p style="color:red;">A apărut o eroare la trimiterea mesajului.</p>');
                }
            });
        });
    });
    </script>
    
</body>
</html>
