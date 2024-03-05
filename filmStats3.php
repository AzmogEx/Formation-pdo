<?php
// Inclusion du fichier de fonctions
require_once('fonction.php');

// Si un genre est sélectionné, afficher le nombre de films pour ce genre
if (isset($_GET['genre'])) {
    $selectedGenre = $_GET['genre'];
    // Appel de la fonction nbFilms pour récupérer le nombre de films du genre sélectionné
    $nbFilms = nbFilms($selectedGenre);
    // Vérification si le nombre de films est valide
    if ($nbFilms >= 0) {
        echo "Nombre de films du genre $selectedGenre : $nbFilms";
    } else {
        echo "Erreur de connexion à la base de données.";
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
?>
<a href="index.html">Accueil </a>