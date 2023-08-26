<!DOCTYPE html>
<html>
<head>
    <title>Profil de l'utilisateur</title>
</head>
<body>
    <h2>Profil de l'utilisateur</h2>
    <?php
    // Démarrer la session pour gérer les variables de session
    session_start();

    if (isset($_SESSION['user_auth']) && $_SESSION['user_auth']) {
        // Inclure le fichier de configuration pour obtenir les informations de la base de données
        require_once('./config.php');
        
        try {
            // Créer une nouvelle instance PDO pour se connecter à la base de données
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Préparer une requête SQL pour sélectionner les données de l'utilisateur
            $stmt = $pdo->prepare("SELECT * FROM member WHERE pseudo = :pseudo");
            $stmt->execute(array(':pseudo' => $_SESSION['username']));
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Afficher les informations du profil de l'utilisateur
            echo "<p>Nom d'utilisateur : " . $user['pseudo'] . "</p>";
            echo "<p>Nom : " . $user['name'] . "</p>";
            echo "<p>Prénom : " . $user['firstname'] . "</p>";
            echo "<p>Courriel : " . $user['courriel'] . "</p>";
            echo "<p><a href=\"index.php\">Retour à l'accueil</a></p>";
            echo "<p><a href=\"deconnexion.php\">Se déconnecter</a></p>";
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        echo "<p>Vous n'êtes pas connecté.</p>";
        echo "<a href=\"connexion.php\">Se connecter</a>";
    }
    ?>
</body>
</html>
