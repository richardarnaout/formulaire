<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
        //
        // Validation des champs
        if (empty($username) || empty($password)) {
            echo "Tous les champs sont requis!";
            exit;
        }

        try {
            // Vérifier si l'utilisateur existe déjà avec COUNT(*)
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $userExists = $stmt->fetchColumn();

            if ($userExists > 0) {
                echo "Cet utilisateur existe déjà!";
                exit;
            }

            // Hachage du mot de passe
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);

            // Insertion dans la base de données
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            if ($stmt->execute([$username, $password_hashed])) {
                echo "<script>
                    alert('Compte créé avec succès !');
                    window.location.href = 'index.php';
                </script>";
                exit;
            } else {
                echo "Erreur lors de l'ajout du compte!";
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de compte</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Créer un nouveau compte</h2>
        <form id="registerForm" method="POST" action="register.php">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" required><br><br>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required><br><br>

            <button type="submit">Créer le compte</button>
        </form>

        <!-- Bouton pour revenir à la connexion -->
        <a href="index.php"><button>Retour à la connexion</button></a>

        <!-- Bloc pour afficher la réponse du serveur -->
        <div id="response"></div>
    </div>
</body>
</html>
