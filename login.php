<?php
session_start();
require "db.php"; // Connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = htmlspecialchars(trim($_POST["username"]));
        $password = trim($_POST["password"]);

        if (empty($username) || empty($password)) {
            $_SESSION["error"] = "Tous les champs sont requis!";
            header("Location: index.php");
            exit;
        }

        try {
            // Vérifier si l'utilisateur existe
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            // Vérifier si l'utilisateur existe et comparer le mot de passe haché
            if (!$user || !password_verify($password, $user["password"])) {
                $_SESSION["error"] = "Identifiant ou mot de passe incorrect!";
                header("Location: index.php");
                exit;
            }

            // Connexion réussie
            $_SESSION["username"] = $user["username"];
            header("Location: welcome.php"); // Redirige vers la page d'accueil
            exit;

        } catch (PDOException $e) {
            $_SESSION["error"] = "Erreur de connexion : " . $e->getMessage();
            header("Location: index.php");
            exit;
        }
    }
}
?>
