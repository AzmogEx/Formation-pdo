<?php
// Inclusion du fichier de fonctions
require_once('fonction.php');

// Si un genre est sélectionné, afficher le nombre de films et le chiffre d'affaires total pour ce genre
if (isset($_GET['genre'])) {
    $selectedGenre = $_GET['genre'];
    // Appel de la fonction nbFilms pour récupérer le nombre de films du genre sélectionné
    $nbFilms = nbFilms($selectedGenre);
    // Vérification si le nombre de films est valide
    if ($nbFilms >= 0) {
        echo "Nombre de films du genre $selectedGenre : $nbFilms<br>";

        // Appel de la fonction chiffreAffaireTotalGenre pour récupérer le chiffre d'affaires total du genre sélectionné
        $chiffreAffaireTotal = chiffreAffaireTotalGenre($selectedGenre);
        // Vérification si le chiffre d'affaires total est valide
        if ($chiffreAffaireTotal >= 0) {
            echo "Chiffre d'affaires total du genre $selectedGenre : $chiffreAffaireTotal<br>";
        } else {
            echo "Erreur de connexion à la base de données pour récupérer le chiffre d'affaires total.<br>";
        }

    } else {
        echo "Erreur de connexion à la base de données pour récupérer le nombre de films.<br>";
    }
}

// Affichage de la liste déroulante des genres
echo '<form method="get">';
echo '<label for="genre">Choisir un genre :</label>';
echo '<select name="genre" id="genre">';

// Récupération de tous les genres disponibles dans la base de données
$genres = getAllGenres();

// Parcours de chaque genre et ajout à la liste déroulante
foreach ($genres as $genre) {
    echo '<option value="' . $genre . '">' . $genre . '</option>';
}

echo '</select>';
echo '<input type="submit" value="Voir les stats">';
echo '</form>';

// Affichage du nombre total de films sortis à partir de l'an 2000
$nbFilms2000 = nbFilmsAnnee2000();
echo "Nombre total de films sortis à partir de l'an 2000 : $nbFilms2000<br><br>";

// Affichage de la moyenne d'âge de tous les acteurs
$moyenneAge = moyenneAgeActeurs();
echo "Moyenne d'âge de tous les acteurs : $moyenneAge<br>";


// Affichage de tous les acteurs avec leur rôle
$acteursAvecRole = listerActeursAvecRole();
echo "<h2>Liste des film avec leur acteur principal et role:</h2>";
echo "<ul>";
foreach ($acteursAvecRole as $acteur) {
    echo "<li>Film: {$acteur['titre']} - Acteur principal: {$acteur['Acteur']} - Rôle : {$acteur['role']}</li> <br>";
}
echo "</ul>";


?>

<a href="index.html">Accueil</a><br>