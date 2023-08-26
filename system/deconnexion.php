<?php
// Démarrer la session pour gérer les variables de session
session_start();

// Détruire la session et rediriger vers la page de connexion
session_destroy();
header("Location: connexion.php");
exit();
?>
