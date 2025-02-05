<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Identification</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <img src="logo.png" alt="Logo" class="logo">
        <h2>Connexion</h2>
        
        <?php
        if (isset($_SESSION["error"])) {
            echo "<p style='color:red'>" . $_SESSION["error"] . "</p>";
            unset($_SESSION["error"]); 
        }
        ?>

        <form action="login.php" method="POST">
            <label for="username">Identifiant :</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>

            <div class="buttons">
                <button type="reset">Reset</button>
                <button type="submit">OK</button>
                <button type="button" onclick="window.location.href='register.php'">Ajout Compte</button>
            </div>
        </form>
    </div>

</body>
</html>
