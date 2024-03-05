<!--VERSION STATS GENRE SEPARER-->

<?php
// On établit la connexion
require_once('fonction.php');
$cnx = connect_bd('cinema');
if ($cnx) {
    //
// Exécution d'une requête statistique avec paramètres
//
// Préparation de la requête
    $req = $cnx->prepare("SELECT COUNT(*) as 'NbFilms' FROM Film, Genre
                    WHERE Film.idGenre = Genre.idGenre AND nomGenre = :unGenre");
    //Récupération des données par tableau associatif

    $unGenre = 'Comedie';
    $req->bindParam(':unGenre', $unGenre, PDO::PARAM_STR);
    // Exécution de la requête
    $req->execute();
    // Récupération des données sous la forme d'un tableau associatif
    $ligne = $req->fetch(PDO::FETCH_ASSOC);
    echo "Nombre de films du genre $unGenre: " . $ligne['NbFilms'] . "<br><br>";
    //récup des donnée par objet
// Définition des paramètres
    $unGenre = 'Drame';
    $req->bindParam(':unGenre', $unGenre, PDO::PARAM_STR);
    // Exécution de la requête
    $req->execute();
    // Récupération des données sous la forme d'un objet anonyme
    $ligne = $req->fetch(PDO::FETCH_OBJ);
    echo "Nombre de films du genre $unGenre: " . $ligne->NbFilms;
} else {
    echo "Echec de la connexion";
}
deconnect_bd('cinema');