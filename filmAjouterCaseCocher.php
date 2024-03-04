<form method="post" action="filmAjouterCaseCocher.php">
    <legend>Films</legend>
    <label for="titre">Titre :</label>
    <input type="text" name="titre" />
    <label for="anneeSortie"> Année de sortie :</label>
    <input type="text" name="anneeSortie" />
    <label for="affiche">Affiche :</label>
    <input type="text" name="affiche" />
    <label for="Genre"> Genre :</label>
    <input type="text" name="genre" />
    <fieldset>
        <legend><b>Salles de diffusion</b></legend>
        <input type="checkbox" name="salle[]" value="1" />Salle 1<br />
        <input type="checkbox" name="salle[]" value="2" />Salle 2<br />
        <input type="checkbox" name="salle[]" value="3" />Salle 3<br />
        <input type="checkbox" name="salle[]" value="4" />Salle 4<br />
    </fieldset>
    <input type="submit" value="envoyer" />
</form>


<?php
//inclure les fonctions pour la base
include("fonction.php");
//Conexion à la base de données
$cnx = connect_bd('cinema');
if ($cnx) // si connexion correcte
{
    // On prépare la requête (une seule fois)
    $result = $cnx->prepare('INSERT INTO film (titre, anneeSortie, affiche, idGenre)
VALUES (:titre, :anneeSortie, :affiche, :idGenre)');
    // On affecte aux variables les valeurs des données postées du formulaire
    $titre = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $anneeSortie = filter_input(INPUT_POST, "anneeSortie");
    $affiche = filter_input(INPUT_POST, "affiche", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $idGenre = filter_input(INPUT_POST, "genre");
    // On lie chaque marqueur à une variable en précisant le type de données
    $result->bindParam(':titre', $titre, PDO::PARAM_STR);
    $result->bindParam(':anneeSortie', $anneeSortie, PDO::PARAM_INT);
    $result->bindParam(':affiche', $affiche, PDO::PARAM_STR);
    $result->bindParam(':idGenre', $idGenre, PDO::PARAM_INT);
    $result->execute();
    // -------------------- Insertion des salles de diffusion
    $idFilm = $cnx->lastInsertId(); // Dernier film inséré
    $result2 = $cnx->prepare('INSERT INTO Diffuser(idFilm, idSalle) VALUES (:idFilm, :idSalle);');
    $result2->bindParam(':idFilm', $idFilm, PDO::PARAM_INT);
    echo "Dernier film : " . $idFilm;
    $nbSalle = 0;
    foreach ($_POST["salle"] as $uneSalle) {
        $result2->bindParam(':idSalle', $uneSalle, PDO::PARAM_INT);
        $result2->execute();
        $nbSalle++;
    }
    echo '<p>Nombre de lignes créées dans la table Film : ' . $result->rowCount() . '</p>';
    echo '<p>Nombre de lignes créées dans la table Diffuser : ' . $nbSalle . '</p>';
} else {
    echo "erreur";
}
deconnect_bd('cinema');
?>