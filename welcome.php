<?php
session_start();

// Sécurisation de la session
if (ini_get("session.use_trans_sid")) {
    ini_set("session.use_trans_sid", "0");  // Désactiver le pass-through SID dans l'URL
}
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}

// Expiration de session après un certain temps d'inactivité
$timeout_duration = 1800; // 30 minutes
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();     // Efface toutes les variables de session
    session_destroy();   // Détruit la session
    header("Location: index.php");
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time(); // Met à jour la dernière activité

$username = htmlspecialchars($_SESSION["username"]);

// Sécurisation des headers HTTP
header("X-Content-Type-Options: nosniff");  // Empêche le sniffing de type MIME
header("X-XSS-Protection: 1; mode=block");  // Protection contre les attaques XSS
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");  // Force HTTPS
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <h2>Mon Dashboard</h2>
            <ul>
                <li><a href="#">Accueil</a></li>
                <li><a href="#">Profil</a></li>
                <li><a href="#">Paramètres</a></li>
                <li><a href="change_password.php">Changer mon mot de passe</a></li>
            </ul>
            <form method="POST" action="logout.php">
                <button type="submit" class="logout-btn">Déconnexion</button>
            </form>
        </aside>

        <main class="content">
            <h1>Bonjour, <?php echo $username; ?> ! 👋</h1>
            <p>Bienvenue sur votre espace personnel.</p>
        </main>
    </div>
</body>
</html>
