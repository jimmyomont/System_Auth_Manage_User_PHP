<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <title>Création de Profil</title>
</head>

<body>
    <h2>Création de Profil</h2>

    <?php
    // Démarrer la session pour gérer les variables de session
    session_start();

    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['user_auth']) || !$_SESSION['user_auth']) {
        // Rediriger vers la page de connexion
        header("Location: connexion.php");
        exit();
    }

    // Vérifier si l'utilisateur a le statut "Administrateur"
    if (isset($_SESSION['user_level']) && $_SESSION['user_level'] !== "Administrateur") {
        // Afficher le message d'erreur et le lien vers la page de connexion
        echo "Vous n'avez pas accès à cette page. Seul les administrateurs du site peuvent acceder à cette page ";
        echo "<a href=\"connexion.php\">Connectez-vous</a>";
        exit();
    }
    // Vérifier si le formulaire de création de profil a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $pseudo = $_POST["pseudo"];
        $password = $_POST["password"];
        $name = $_POST["name"];
        $firstname = $_POST["firstname"];
        $courriel = $_POST["courriel"];
        $level = $_POST["level"];
        $type = $_POST["type"];
        $genre = $_POST["genre"];
        $status = $_POST["status"];

        // Inclure le fichier de configuration pour obtenir les informations de la base de données
        require_once('./config.php');

        try {
            // Créer une nouvelle instance PDO pour se connecter à la base de données
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $motDePasseHache = md5($password); // Hachage du mot de passe (à des fins de démonstration seulement)

            // Préparer une requête SQL pour insérer un nouvel utilisateur dans la table "member"
            $stmt = $pdo->prepare("INSERT INTO member (pseudo, password, name, firstname, courriel, status) VALUES (:pseudo, :password, :name, :firstname, :courriel, :status)");
            $stmt->execute(array(':pseudo' => $pseudo, ':password' => $motDePasseHache, ':name' => $name, ':firstname' => $firstname, ':courriel' => $courriel, ':status' => $status));

            // Récupérer l'ID de l'utilisateur nouvellement créé
            $userId = $pdo->lastInsertId();

            // Insérer les informations de profil dans la table "profil" et récupérer le profil_id
            $stmt = $pdo->prepare("INSERT INTO profil (level, type, genre) VALUES (:level, :type, :genre)");
            $stmt->execute(array(':level' => $level, ':type' => $type, ':genre' => $genre));
            $profilId = $pdo->lastInsertId();

            // Mettre à jour le profil_id dans la table member avec la valeur de $profilId
            $stmt = $pdo->prepare("UPDATE member SET profil_id = :profil_id WHERE id = :user_id");
            $stmt->execute(array(':profil_id' => $profilId, ':user_id' => $userId));

            // Stocker le niveau du profil dans la session
            $_SESSION['user_level'] = $level;

            // Afficher un message de succès
            echo "<p>Profil créé avec succès.</p>";
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
    ?>

    <form action="creationProfil.php" method="post">
        <input type="text" name="pseudo" placeholder="Pseudo" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <input type="text" name="name" placeholder="Nom" required>
        <input type="text" name="firstname" placeholder="Prénom" required>
        <input type="email" name="courriel" placeholder="Courriel" required>
        <label for="status">Statut :</label>
        <select name="status" required>
            <option value="Actif">Actif</option>
            <option value="Désactivé">Désactivé</option>
            <option value="Bloqué">Bloqué</option>
        </select>
        <label for="level">Niveau :</label>
        <select name="level" required>
            <option value="Administrateur">Administrateur</option>
            <option value="Utilisateur">Utilisateur</option>
            <option value="Contributeur">Contributeur</option>
        </select>

        <label for="type">Type :</label>
        <select name="type" required>
            <option value="Professeur">Professeur</option>
            <option value="Chercheur">Chercheur</option>
            <option value="Etudiant">Etudiant</option>
            <option value="Collaborateur">Collaborateur</option>
        </select>

        <label for="genre">Genre :</label>
        <select name="genre" required>
            <option value="homme">Homme</option>
            <option value="femme">Femme</option>
            <option value="neutre">Neutre</option>
        </select>

        <button type="submit">Créer le profil</button>
    </form>
    <a href="profil.php">Retour à mon profil</a>
</body>

</html>