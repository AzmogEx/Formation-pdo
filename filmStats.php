<!--VERSION STATS TOUT-->
<?php
//on établis la connexion
require_once('fonction.php');

$cnx = connect_bd('cinema');
if ($cnx) {
    //EXECUTION D'UNE requête de statistique sans paramêtre
    $requete_count = $cnx->query("SELECT COUNT(*) as 'NbFilms' FROM film");
    //retour des données sous la forme d'un objet
    $dataCount = $requete_count->fetch(PDO::FETCH_ASSOC);
    //Recupération de la donnée
    $nbFilms = $dataCount["NbFilms"];
    //Affichage
    echo "Nombre de films : " . $nbFilms;
    echo '<br/';
} else {
    echo "Echec de la connexion";
}
deconnect_bd('cinema');
