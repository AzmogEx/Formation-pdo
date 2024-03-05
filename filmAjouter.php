<?php
include("fonction.php");

$cnx = connect_bd('cinema');

if ($cnx) {
    $result = $cnx->prepare('INSERT INTO film (titre, anneeSortie, affiche, idGenre, chiffreAffaire)
                            VALUES (:titre, :anneeSortie, :affiche, :idGenre, :chiffreAffaire)');
    $titre = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $anneeSortie = filter_input(INPUT_POST, "anneeSortie");
    $affiche = filter_input(INPUT_POST, "affiche", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $idGenre = filter_input(INPUT_POST, "genre");
    $chiffreAffaire = filter_input(INPUT_POST, "chiffreAffaire"); // Ajout du chiffre d'affaires

    $result->bindParam(':titre', $titre, PDO::PARAM_STR);
    $result->bindParam(':anneeSortie', $anneeSortie, PDO::PARAM_INT);
    $result->bindParam(':affiche', $affiche, PDO::PARAM_STR);
    $result->bindParam(':idGenre', $idGenre, PDO::PARAM_INT);
    $result->bindParam(':chiffreAffaire', $chiffreAffaire, PDO::PARAM_STR); // Binder le chiffre d'affaires

    $result->execute();

    $idFilm = $cnx->lastInsertId(); // Dernier film inséré 

    echo '<p>' . $result->rowCount() . ' film a été ajouté dans la table Film</p>';
    echo "<p>Il s'agit du film $titre sorti en $anneeSortie</p>";
    echo '<p>Son identifiant est : ' . $cnx->LastInsertId() . '</p>';

    $result2 = $cnx->prepare('INSERT INTO Diffuser(idFilm, idSalle) VALUES (:idFilm, :idSalle);');
    $result2->bindParam(':idFilm', $idFilm, PDO::PARAM_INT);

    $nbSalle = 0;

    foreach ($_POST["salle"] as $uneSalle) {
        $result2->bindParam(':idSalle', $uneSalle, PDO::PARAM_INT);
        $result2->execute();
        $nbSalle++;
    }

    // Insertion de l'acteur principal dans la table acteurJoue
    $idActeurPrincipal = filter_input(INPUT_POST, "acteurPrincipal");
    $roleActeurPrincipal = filter_input(INPUT_POST, "role", FILTER_SANITIZE_FULL_SPECIAL_CHARS); // Récupérer le rôle de l'acteur principal

    $result3 = $cnx->prepare('INSERT INTO acteurJoue(idFilm, idActeur, role) VALUES (:idFilm, :idActeur, :role)');
    $result3->bindParam(':idFilm', $idFilm, PDO::PARAM_INT);
    $result3->bindParam(':idActeur', $idActeurPrincipal, PDO::PARAM_INT);
    $result3->bindParam(':role', $roleActeurPrincipal, PDO::PARAM_STR); // Binder le rôle de l'acteur principal
    $result3->execute();

    echo 'Nombre de salles : ' . $nbSalle;
} else {
    echo "erreur";
}

deconnect_bd('cinema');
?>
<a href="index.html">Accueil </a>