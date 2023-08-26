# Concatène tous les arguments passés avec un "/"
url=""
for word in "$@"; do
    url="$url/$word"
done

# Ouvre le navigateur avec l'URL construite à partir des arguments
start http://localhost/System_Auth_Manage_User_PHP/system$url
chmod +x exe.sh

# Pour lancer le script dans le terminal directement de la racine faire la commande "./exe.sh nom_du_fichier"
# Pour lancer d'une adresse ou d'un dossier différent "./exe.sh nom_du_dossier nom_du_fichier"