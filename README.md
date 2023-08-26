# SYSTEME D'AUTHENTIFICATION ET GESTION DE PROFIL D'UTILISATEUR PHP 

## **Description**:

### 1. **Connexion et Authentification**:
- Lorsqu'un utilisateur soumet le formulaire de connexion, les valeurs `$_POST["pseudo"]` et `$_POST["password"]` sont récupérées.
- Une instance de la classe PDO est créée pour se connecter à la base de données.
- Une requête SQL est préparée pour récupérer les informations de l'utilisateur en utilisant le nom d'utilisateur (`pseudo`) comme paramètre.
- Les informations de l'utilisateur sont récupérées à l'aide de `$stmt->fetch(PDO::FETCH_ASSOC)`.
- Le mot de passe fourni par l'utilisateur est haché avec `md5()` et comparé au mot de passe haché stocké dans la base de données.
- Si les informations de connexion sont valides, des variables de session sont configurées pour indiquer l'authentification de l'utilisateur.

### 2. **Création de Profil**:
- Lorsque le formulaire de création de profil est soumis, les valeurs saisies dans les champs du formulaire sont récupérées (comme `$pseudo`, `$password`, `$name`, etc.).
- Un nouveau hachage de mot de passe est généré avec `md5()`.
- Les informations de profil sont insérées dans la table "member" et "profil" de la base de données à l'aide de requêtes SQL préparées.
- L'ID de l'utilisateur nouvellement créé et l'ID du profil nouvellement créé sont stockés.
- La variable `$_SESSION['user_level']` est configurée avec le niveau de profil nouvellement créé.

### 3. **Affichage du Profil Utilisateur**:
- Si un utilisateur est authentifié, une instance de la classe PDO est créée pour accéder à la base de données.
- Une requête SQL est préparée pour sélectionner les informations de l'utilisateur connecté.
- Les informations de l'utilisateur sont affichées sur la page à l'aide d'échos.

### 4. **Système de Niveaux et de Statuts**:
- Les niveaux et les statuts des utilisateurs sont stockés dans la base de données sous forme de chaînes (comme "Administrateur", "Utilisateur", etc.).
- Ces informations sont utilisées pour déterminer les autorisations d'accès, par exemple, pour vérifier si un utilisateur a le statut "Administrateur" pour accéder à certaines fonctionnalités.

### 5. **Gestion de Session**:
- Les sessions sont utilisées pour maintenir l'état de l'utilisateur connecté entre les pages.
- Lorsque l'utilisateur se connecte avec succès, `$_SESSION['user_auth']` est définie sur `true`, et `$_SESSION['username']` est définie pour stocker le nom d'utilisateur.

### 6. **Fichier exe.sh et fichier config.php**: 
- Un fichier exe.sh pour éxecuter un script ``http://localhost/`` suivi des noms de fichier.php pour construire l'URL et l'ouverture dans le navigateur directement du terminal. 
- Un fichier ``config.php`` est à créer en prenant exemple du fichier ``config.example.php`` pour se connecter à la BDD ett exploiter les données. 
