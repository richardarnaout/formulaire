<?php
session_start();
require "db.php"; // Connexion à la base de données

// Ajouter un mécanisme pour limiter les tentatives de connexion
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}
//
if ($_SESSION['login_attempts'] > 5) {
    $_SESSION["error"] = "Trop de tentatives de connexion. Essayez plus tard.";
    header("Location: index.php");
    exit;
}

// Vérification de la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["csrf_token"])) {
        // Vérifier si le token CSRF est valide
        if ($_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
            $_SESSION["error"] = "Erreur CSRF!";
            header("Location: index.php");
            exit;
        }

        $username = htmlspecialchars(trim($_POST["username"]));
        $password = trim($_POST["password"]);

        // Vérifier si les champs ne sont pas vides
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
                $_SESSION['login_attempts']++;
                header("Location: index.php");
                exit;
            }

            // Connexion réussie
            $_SESSION["username"] = $user["username"];
            $_SESSION['login_attempts'] = 0; // Réinitialiser les tentatives
            header("Location: welcome.php"); // Redirige vers le dashboard
            exit;

        } catch (PDOException $e) {
            $_SESSION["error"] = "Erreur de connexion : " . $e->getMessage();
            header("Location: index.php");
            exit;
        }
    }
}

// Créer un token CSRF pour protéger le formulaire
$_SESSION["csrf_token"] = bin2hex(random_bytes(32));

?>
