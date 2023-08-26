<!DOCTYPE html>
<html>
<head>
    <title>Page d'Accueil</title>
</head>
<body>
    <h2>Page d'Accueil</h2>
    <?php
    session_start();

    if (isset($_SESSION['user_auth']) && $_SESSION['user_auth']) {
        echo "<p>Bienvenue, vous êtes connecté en tant qu'utilisateur : " . $_SESSION['username'] . "</p>";
        echo "<p>Niveau de l'utilisateur : " . $_SESSION['user_level'] . "</p>";
        echo "<a href=\"profil.php\">Voir le profil</a><br>";
        echo "<a href=\"deconnexion.php\">Se déconnecter</a>";

        // Vérifier le niveau de l'utilisateur en fonction de la session
        if ($_SESSION['user_level'] === "Administrateur") {
            echo "<p><a href=\"creationProfil.php\">Créer un utilisateur</a></p>";
        }
    } else {
        echo "<p>Vous n'êtes pas connecté.</p>";
        echo "<a href=\"connexion.php\">Se connecter</a>";
    }
    ?>
</body>
</html>
