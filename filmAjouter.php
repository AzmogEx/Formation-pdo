<?php
include("fonction.php");

$cnx = connect_bd('cinema');

if ($cnx) {


    $result = $cnx->prepare('INSERT INTO film (titre, anneeSortie, affiche, idGenre)
                            VALUES (:titre, :anneeSortie, :affiche, :idGenre)');
    $titre = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $anneeSortie = filter_input(INPUT_POST, "anneeSortie");
    $affiche = filter_input(INPUT_POST, "affiche", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $idGenre = filter_input(INPUT_POST, "genre");
    //echo $idGenre;
    $result->bindParam(':titre', $titre, PDO::PARAM_STR);
    $result->bindParam(':anneeSortie', $anneeSortie, PDO::PARAM_INT);
    $result->bindParam(':affiche', $affiche, PDO::PARAM_STR);
    $result->bindParam(':idGenre', $idGenre, PDO::PARAM_INT);

    $result->execute();

    $idFilm = $cnx->lastInsertId(); // Dernier film inséré 
    //echo "Dernier film : " . $idFilm . '<br/';


    echo '<p>' . $result->rowCount() . ' film a été ajouté dans la table Film</p>';
    echo "<p>Il s'agit du film $titre sorti en $anneeSortie</p>";
    echo '<p>Son identifiant est : ' . $cnx->LastInsertId() . '</p>';


    $result2 = $cnx->prepare('INSERT INTO Diffuser(idFilm, idSalle) VALUES (:idFilm, :idSalle);');
    $result2->bindParam(':idFilm', $idFilm, PDO::PARAM_INT);

    $nbSalle = 0;

    foreach ($_POST["salle"] as $uneSalle) {
        //echo $uneSalle;
        $result2->bindParam(':idSalle', $uneSalle, PDO::PARAM_INT);
        $result2->execute();
        $nbSalle++;
    }
    echo 'nb de salles : ' . $nbSalle;



} else {
    echo "erreur";
}
deconnect_bd('cinema');
?>
<a href="index.html">Accueil </a>