# formulaire securisé de connexion
ARNAOUT RICHARD - M1 BD 

Description projet:

Ce projet est une application web de formulaire d'identification sécurisée, développée en PHP avec une base de données MySQL. Il permet aux utilisateurs de s'inscrire, de se connecter et d'accéder à un tableau de bord.


Fonctionalités:

Inscription avec hashage des mots de passe
Connexion avec validation des identifiants
Tableau de bord
Sécurité
Système de déconnexion
Gestion des erreurs


Prérequis
XAMPP, WAMP ou tout serveur Apache avec PHP et MySQL (lancer phpmyadmin sur localhost pour acceder a la base de données)

http://localhost/phpmyadmin/index.php?route=/database/export&db=theorie


Lancer le projet

Accéder via http://localhost/theorie/index.php

entrer les identifiants de test : admin et admin123 ou user et user.
le dashboard apparaitra avec un bouton deconnexion

Technologies utilisées

Frontend : HTML, CSS, JavaScript
Backend : PHP (avec MySQL pour la base de données)
Sécurité : Hashage bcrypt

Respect des consignes OWASP

description de chaque fichier:

db.php => fichier de base de données
index.php => page de connexion
login.php => page de login permettant la validation
logout => permet la deconnexion du dashboard
register => permet de s'inscrire
script.js => methodes javascript appliqués
style.css => design utilisé pour les pages
test_connexion => fichier pour tester la base de donnée
theorie.sql => fichier sql contenant la base et a table
welcome.php => page du dashboard
change_password.php => page de changement de mot de passe

