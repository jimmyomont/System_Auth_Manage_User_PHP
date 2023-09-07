<?php
// Démarrer la session pour gérer les variables de session
session_start();

// Vérification si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudo = $_POST["pseudo"];
    $password = $_POST["password"];

    // Inclure le fichier de configuration pour obtenir les informations de la base de données
    require_once('./config.php');

    try {
        // Créer une nouvelle instance PDO pour se connecter à la base de données
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);

        // Définir le mode d'erreur PDO pour afficher les exceptions en cas d'erreur
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparer une requête SQL pour sélectionner les données de l'utilisateur
        $stmt = $pdo->prepare("SELECT * FROM member WHERE pseudo = :pseudo");
        $stmt->execute(array(':pseudo' => $pseudo));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si les informations d'identification sont valides en utilisant md5()
        // Vérifier si les informations d'identification sont valides en utilisant md5()
        if ($user && md5($password) == $user['password']) {
            $_SESSION['user_auth'] = true; // Crée une session d'utilisateur authentifié
            $_SESSION['username'] = $pseudo; // Stocke le nom d'utilisateur dans la session

            // Récupérer le niveau du profil à partir de la table "profil"
            $stmt = $pdo->prepare("SELECT level FROM profil WHERE id = :profil_id");
            $stmt->execute(array(':profil_id' => $user['profil_id']));
            $userLevel = $stmt->fetchColumn();

            // Stocker le niveau du profil dans la session
            $_SESSION['user_level'] = $userLevel;

            header("Location: index.php");
            exit();
        } else {
            $error_message = "Pseudo ou mot de passe incorrect.";
        }
    } catch (PDOException $e) {
        $error_message = "Erreur : " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <title>Page de Connexion</title>
</head>

<body>
    <h2>Connexion</h2>
    <?php if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    } ?>
    <form action="connexion.php" method="post">
        <input type="text" name="pseudo" placeholder="Pseudo" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>
    </form>
</body>

</html>