<?php
session_start();

// Vérification de l'authentification
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}
$username = htmlspecialchars($_SESSION["username"]);
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
