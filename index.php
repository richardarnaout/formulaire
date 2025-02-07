<?php
session_start();

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION["username"])) {
    header("Location: welcome.php"); // Redirige vers le dashboard
    exit;
}

// Affichage des erreurs de connexion si elles existent
if (isset($_SESSION["error"])) {
    echo "<p style='color:red'>" . $_SESSION["error"] . "</p>";
    unset($_SESSION["error"]);
}

// Générer un token CSRF pour protéger le formulaire
$_SESSION["csrf_token"] = bin2hex(random_bytes(32));
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

        <form action="login.php" method="POST">
            <label for="username">Identifiant :</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>

            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION["csrf_token"]; ?>">

            <div class="buttons">
                <button type="reset">Reset</button>
                <button type="submit">OK</button>
                <button type="button" onclick="window.location.href='register.php'">Ajout Compte</button>
            </div>
        </form>
    </div>

</body>
</html>
