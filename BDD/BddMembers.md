## CREATION DE TABLE UTILISATEURS

**Base de données : members**

### Table : profil

| Champ       | Type         | Description                                                    |
|-------------|--------------|----------------------------------------------------------------|
| id          | INT          | Clé primaire, auto-incrémentée                                 |
| level       | ENUM         | Niveau du profil (Utilisateurs, Contributeurs, Administrateur) |
| type        | ENUM         | Type du profil (Professeur, Chercheur, Etudiant)               |
| genre       | ENUM         | Genre du profil (Homme, Femme, Neutre)                         |

### Table : member

| Champ       | Type         | Description                                          |
|-------------|--------------|------------------------------------------------------|
| id          | INT          | Clé primaire, auto-incrémentée                       |
| name        | VARCHAR(50)  | Nom du membre                                        |
| firstname   | VARCHAR(50)  | Prénom du membre                                     |
| pseudo      | VARCHAR(50)  | Pseudo du membre                                     |
| courriel    | VARCHAR(100) | Adresse email du membre                              |
| password    | VARCHAR(100) | Mot de passe du membre (stocké de manière sécurisée) |
| status      | ENUM         | Statut du membre (Actif, Désactivé, Bloqué)          |
| profil_id   | INT          | Clé étrangère faisant référence à la table "profil"  |

---

Les requêtes :

**Création de la base de données "members" :**

```sql
CREATE DATABASE members;
```

**Création de la table "profil" :**

```sql
USE members;

CREATE TABLE profil (
    id INT AUTO_INCREMENT PRIMARY KEY,
    level ENUM('Utilisateurs', 'Contributeurs', 'Administrateur') NOT NULL,
    type ENUM('Professeur', 'Chercheur', 'Etudiant') NOT NULL,
    genre ENUM('Homme', 'Femme', 'Neutre') NOT NULL
);
```

**Création de la table "member" :**

```sql
CREATE TABLE member (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    pseudo VARCHAR(50) NOT NULL,
    courriel VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    status ENUM('Actif', 'Désactivé', 'Bloqué') NOT NULL,
    profil_id INT,
    -- Assure l'intégrité référentielle entre les tables "member" et "profil"
    -- Contrainte de clé étrangère qui référence la table profil(id)
    FOREIGN KEY (profil_id) REFERENCES profil(id)

    -- LES CONTRAINTES : 
    FOREIGN KEY (profil_id) REFERENCES profil(id)
    -- Contrainte pour l'adresse email au format courriel
    CONSTRAINT chk_email_format CHECK (courriel LIKE '%_@__%.__%'),
    
    -- Contrainte pour le nom : interdiction de chiffres
    CONSTRAINT chk_name_no_digits CHECK (name NOT REGEXP '[0-9]'),
    
    -- Contrainte pour le prénom : interdiction de chiffres
    CONSTRAINT chk_firstname_no_digits CHECK (firstname NOT REGEXP '[0-9]'),
    
    -- Contraintes pour le mot de passe : 
    
    -- Le mot de passe doit avoir au moins 8 caractères
    CONSTRAINT chk_password_length CHECK (CHAR_LENGTH(password) >= 8),
    
    -- Le mot de passe doit contenir au moins une lettre majuscule
    CONSTRAINT chk_password_uppercase CHECK (password REGEXP '[A-Z]'),
    
    -- Le mot de passe doit contenir au moins une lettre minuscule
    CONSTRAINT chk_password_lowercase CHECK (password REGEXP '[a-z]'),
    
    -- Le mot de passe doit contenir au moins un chiffre
    CONSTRAINT chk_password_digit CHECK (password REGEXP '[0-9]')
);
```
