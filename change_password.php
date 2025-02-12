<?php
session_start();
require "db.php";

// Vérification de l'authentification
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}

$username = htmlspecialchars($_SESSION["username"]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = trim($_POST["current_password"]);
    $new_password = trim($_POST["new_password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    // Vérification des champs
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error = "Tous les champs sont requis!";
    } elseif ($new_password !== $confirm_password) {
        $error = "Les nouveaux mots de passe ne correspondent pas!";
    } else {
        try {
            // Vérification de l'ancien mot de passe
            $stmt = $pdo->prepare("SELECT password FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if (!$user || !password_verify($current_password, $user["password"])) {
                $error = "Mot de passe actuel incorrect!";
            } else {
                // Mise à jour du mot de passe
                $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");

                if ($stmt->execute([$new_password_hashed, $username])) {
                    $success = "Mot de passe mis à jour avec succès!";
                } else {
                    $error = "Erreur lors de la mise à jour du mot de passe!";
                }
            }
        } catch (PDOException $e) {
            $error = "Erreur : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changer le mot de passe</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Changer le mot de passe</h2>
        
        <?php if (isset($error)) : ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (isset($success)) : ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <form method="POST" action="change_password.php">
            <label for="current_password">Mot de passe actuel :</label>
            <input type="password" id="current_password" name="current_password" required><br><br>

            <label for="new_password">Nouveau mot de passe :</label>
            <input type="password" id="new_password" name="new_password" required><br><br>

            <label for="confirm_password">Confirmer le nouveau mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password" required><br><br>

            <button type="submit">Mettre à jour le mot de passe</button>
        </form>

        <!-- Bouton pour revenir au dashboard -->
        <a href="welcome.php"><button>Retour au Dashboard</button></a>
    </div>
</body>
</html>
