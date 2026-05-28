<?php
# public/index.php


/*
 * Front Controller de la gestion du livre d'or
 */

/*
 * Chargement des dépendances
 */
// chargement de configuration
require_once "../config.php";
// chargement du modèle de la table guestbook
require_once URL_BASE."/model/guestbookModel.php";

/*
 * Connexion à la base de données en utilisant PDO
 * Avec un try catch pour gérer les erreurs de connexion
 * Utilisez les constantes de config.php
 * Activez le mode d'erreur de PDO à Exception et
 * le mode fetch à tableau associatif
 */

try{
    $connectDB = new PDO(DB_DSN, DB_LOGIN, DB_PWD);
    $connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connectDB->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
}catch(Exception $e){
    die($e->getMessage());
}

/*
 * Si le formulaire a été soumis
 */

if(isset($_POST['firstname'], $_POST['lastname'], $_POST['usermail'], $_POST['phone'], $_POST['postcode'], $_POST['message'])){
    $insert = insertMessage($connectDB, $_POST['firstname'], $_POST['lastname'], $_POST['usermail'], $_POST['phone'], $_POST['postcode'], $_POST['message']);

// on appelle la fonction d'insertion dans la DB (addGuestbook())

// si l'insertion a réussi

// on redirige vers la page actuelle (ou on affiche un message de succès)

// sinon, on affiche un message d'erreur
}

/*
 * On récupère les messages du livre d'or
 */

// on appelle la fonction de récupération de la DB (getAllGuestbook())

/*********************
 * Ou Bonus Pagination
 *********************/

// on vérifie sur quelle page on est (et que c'est un string qui contient que des numériques sans "." ni "-" => ctype_digit) en utilisant la variable $_GET et les constantes de config.php
$pageActu = (isset($_GET[PAGINATION_GET]) && ctype_digit($_GET[PAGINATION_GET]) && (int)$_GET[PAGINATION_GET] >= 1) ? (int)$_GET[PAGINATION_GET] : 1;

# on compte le nombre total de messages (SQL)
$nbTotalMessages = getNbTotalGuestbook($connectDB);

# on récupère la pagination
$paginationHTML = pagination($nbTotalMessages, './?', PAGINATION_GET, $pageActu, PAGINATION_NB);

# pour obtenir le $offset pour les messages (calcul)

# on veut récupérer les messages de la page courante
$messages = getGuestbookPagination($connectDB, $pageActu, PAGINATION_NB);

/**************************
 * Fin du Bonus Pagination
 **************************/

// Appel de la vue

include URL_BASE . "/view/guestbookView.php";

// fermeture de la connexion (bonne pratique)
$connectDB = null;
?>