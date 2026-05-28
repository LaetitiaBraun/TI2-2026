<?php
# model/guestbookModel.php
/********************************
 * Model de la page livre d'or
 *******************************/

// INSERTION d'un message dans le livre d'or

/**
 * @param PDO $db
 * @param string $firstname
 * @param string $lastname
 * @param string $usermail
 * @param string $phone
 * @param string $postcode
 * @param string $message
 * @return bool
 * Fonction qui insère un message dans la base de données 'ti2web2026' et sa table 'guestbook'
 * Renvoie true si l'insertion a réussi, false sinon
 * Une requête préparée est utilisée pour éviter les injections SQL
 * Les données sont échappées pour éviter les injections XSS (protection backend)
 */
function insertMessage(PDO $db,
                    string $firstname,
                    string $lastname,
                    string $usermail,
                    string $phone,
                    string $postcode,
                    string $message
): bool
{
    $firstname = htmlspecialchars(trim(strip_tags($firstname)));
   if (empty($firstname) || strlen($firstname) > 100) return false;
 
   $lastname = htmlspecialchars(trim(strip_tags($lastname)));
   if (empty($lastname) || strlen($lastname) > 100) return false;
 
   $usermail = filter_var($usermail, FILTER_VALIDATE_EMAIL);
   if (empty($usermail) || strlen($usermail) > 200) return false;
 
   $phone = trim($phone);
    if (!preg_match('/^(\+32|0032|0)4\d{8}$/', $phone) || strlen($phone) > 20) return false;
 
    $postcode = trim($postcode);
    if (!preg_match('/^\d{4}$/', $postcode)) return false;
 
    $message = htmlspecialchars(trim(strip_tags($message)));
    if (empty($message) || strlen($message) > 500) return false;
    // traitement des données backend (SECURITE)
    // si pas de données complètes ou ne correspondant pas à nos attentes, on renvoie false
    // requête préparée obligatoire !
    $prepare = $db->prepare("INSERT INTO `guestbook` (`firstname`, `lastname`,`usermail`, `phone`, `postcode`,`message`)
        VALUES (:firstname, :lastname, :usermail, :phone, :postcode, :message);
    ");
    // si l'insertion a réussi
    $prepare->bindValue(':firstname', $firstname);
    $prepare->bindValue(':lastname', $lastname);
    $prepare->bindValue(':usermail', $usermail);
    $prepare->bindValue(':phone', $phone);
    $prepare->bindValue(':postcode', $postcode);
    $prepare->bindValue(':message', $message);
    // on renvoie true
    $insert = $prepare->execute();
    // sinon, on renvoie false
    return $insert;
}

/***************************
 * Sans le Bonus Pagination
 **************************/

// SELECTION de messages dans le livre d'or par ordre de date croissante
/**
 * @param PDO $db
 * @return array
 * Fonction qui récupère tous les messages du livre d'or par ordre de date croissante
 * venant de la base de données 'ti2web2026' et de la table 'guestbook'
 * Si pas de message, renvoie un tableau vide
 */
function selectAllMessage(PDO $db): array
{
    // try catch
    $stmt = $db->query("SELECT * FROM `guestbook` ORDER BY `datemessage` DESC");
    // si la requête a réussi,
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // bonne pratique, fermez le curseur
    $stmt->closeCursor();
    // renvoyer le tableau de(s) message(s)
    return $result;
}

/**************************
 * Pour le Bonus Pagination
 **************************/

// SELECTION du nombre total de messages
/**
 * @param PDO $db
 * @return int
 * Fonction qui compte le nombre total de messages dans la table 'guestbook'
 */
function getNbTotalGuestbook(PDO $db): int
{
    $stmt = $db->query("SELECT COUNT(*) FROM `guestbook`");
    $count = (int) $stmt->fetchColumn();
    // bonne pratique, fermez le curseur,
    $stmt->closeCursor();
    // renvoyez le nombre total de messages
    return $count;

}
// SELECTION de messages dans le livre d'or par ordre de date croissante
// en lien avec la pagination
/**
 * @param PDO $db
 * @param int $pageActu = 1
 * @param int $limit = 5
 * @return array
 * Fonction qui récupère les messages du livre d'or par ordre de date croissante
 * venant de la base de données 'ti2web2026' et de la table 'guestbook'
 * en utilisant une requête préparée (injection SQL), n'affiche que les messages
 * de la page courante
 */
function getGuestbookPagination(PDO $db, int $pageActu=1, int $limit=5): array
{
    $offset = ($pageActu - 1) * $limit;
    // Requête préparée obligatoire !
    // Le $offset et le $limit sont des entiers, il faut donc les passer
    // en paramètres de la requête préparée en tant qu'entiers !
    $prepare = $db->prepare("SELECT * FROM `guestbook` ORDER BY `datemessage` DESC LIMIT :limit OFFSET :offset");
    $prepare->bindValue(':limit', $limit, PDO::PARAM_INT);
    $prepare->bindValue(':offset', $offset, PDO::PARAM_INT);
    // si la requête a réussi,
    $prepare->execute();
    $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
    // bonne pratique, fermez le curseur
    $prepare->closeCursor();
    // renvoyer le tableau de(s) message(s) (vide si pas de résultats)
    return $result;
}

# Pour afficher la pagination dans la vue
// FONCTION de pagination
/**
 * @param int $nbtotalMessage
 * @param string $url
 * @param string $get
 * @param int $pageActu
 * @param int $perPage
 * @return string
 * Fonction qui génère le code HTML de la pagination
 * si le nombre de pages est supérieur à une.
 */
function pagination(int $nbtotalMessage, string $url="./?", string $get="page", int $pageActu=1, int $perPage=5 ): string
{
    $sortie = "";
    if ($nbtotalMessage === 0) return "";
    $nbPages = ceil($nbtotalMessage / $perPage);
    if ($nbPages == 1) return "";
    $sortie .= "<p class='pagination'>";
    for ($i = 1; $i <= $nbPages; $i++) {
        if ($i === 1) {
            if ($pageActu === 1) {
                $sortie .= "<span class='pagination-current'>&lt;&lt;</span>";
                $sortie .= "<span class='pagination-current'>&lt;</span>";
                $sortie .= "<span class='pagination-current'>1</span>";
            } elseif ($pageActu === 2) {
                $sortie .= "<a href='$url'>&lt;&lt;</a>";
                $sortie .= "<a href='$url'>&lt;</a>";
                $sortie .= "<a href='$url'>1</a>";
            } else {
                $sortie .= "<a href='$url'>&lt;&lt;</a>";
                $sortie .= "<a href='$url&$get=" . ($pageActu - 1) . "'>&lt;</a>";
                $sortie .= "<a href='$url'>1</a>";
            }
        } elseif ($i < $nbPages) {
            if ($i === $pageActu) {
                $sortie .= "<span class='pagination-current'>$i</span>";
            } else {
                $sortie .= "<a href='$url&$get=$i'>$i</a>";
            }
        } else {
            if ($pageActu >= $nbPages) {
                $sortie .= "<span class='pagination-current'>$nbPages</span>";
                $sortie .= "<span class='pagination-current'>&gt;</span>";
                $sortie .= "<span class='pagination-current'>&gt;&gt;</span>";
            } else {
                $sortie .= "<a href='$url&$get=$nbPages'>$nbPages</a>";
                $sortie .= "<a href='$url&$get=" . ($pageActu + 1) . "'>&gt;</a>";
                $sortie .= "<a href='$url&$get=$nbPages'>&gt;&gt;</a>";
            }
        }
    }
    $sortie .= "</p>";
    return $sortie;
}