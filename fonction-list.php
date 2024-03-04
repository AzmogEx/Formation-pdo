<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <fieldset>
        <label for="genre"> Genre :</label>
        <select name="genre">
            <?php
            require_once('fonction.php');
            // On établit la connexion seulement si elle n'a pas déjà été établie
            $cnx = connect_bd('cinema');

            if ($cnx) {
                // On prépare la requête
                $result = $cnx->prepare('SELECT idGenre, nomGenre FROM Genre;');
                // On execute la requête
                $result->execute();

                // Si la requête renvoie une ligne
                if ($result->rowCount() > 0) {
                    // Boucle d'alimentation des options de la liste déroulante
                    while ($donnees = $result->fetch()) {
                        $selected = ($donnees['idGenre'] == $genreId) ? 'selected' : '';
                        echo "<option value=" . $donnees['idGenre'] . " $selected>" . $donnees['nomGenre'] . "</option>";
                    }
                }
            }
            ?>
        </select>

        <input type="submit" value="Filtrer" />
    </fieldset>
</form>

<?php
// Récupération de la valeur du genre sélectionné
$genreId = isset($_POST['genre']) ? $_POST['genre'] : null;

// Établissement de la connexion
require_once('fonction.php');
$cnx = connect_bd('cinema');

if ($cnx) {

    if (isset($_REQUEST['delete'])) {
        $result = $cnx->prepare("DELETE FROM Film WHERE idFilm = :cle"); // Préparation de la requête
        $idFilm = $_REQUEST['cle']; // On récupère la clé postée dans une variable
        $result->bindParam(':cle', $idFilm, PDO::PARAM_INT); // On lie chaque marqueur à sa variable
    }
    // L'utilisateur a cliqué sur "Modifier"
    elseif (isset($_REQUEST['update'])) {
        // Préparation de la requête
        echo "id : " . $_REQUEST['id'];
        $result = $cnx->prepare("UPDATE Film SET titre=:titre, anneeSortie=:anneeSortie, idGenre=:genre, affiche=:affiche WHERE idFilm=:cle");
        // On récupère les valeurs postées dans une variable
        $idFilm = $_REQUEST['id'];
        $titre = $_REQUEST['titre'];
        $anneeSortie = $_REQUEST['anneeSortie'];
        $affiche = $_REQUEST['affiche'];
        $genre = $_REQUEST['genre2']; // Assurez-vous que le champ du genre est correctement récupéré
        echo "Genre : " . $genre;
        // On lie chaque marqueur à sa variable
        $result->bindParam(':cle', $idFilm, PDO::PARAM_INT);
        $result->bindParam(':titre', $titre, PDO::PARAM_STR);
        $result->bindParam(':anneeSortie', $anneeSortie, PDO::PARAM_STR);
        $result->bindParam(':affiche', $affiche, PDO::PARAM_STR);
        $result->bindParam(':genre', $genre, PDO::PARAM_INT); // Assurez-vous que le genre est lié correctement
    }


    if (isset($result)) { // Si une requête a été créée ci-dessus, on l'exécute
        $result->execute();
        if ($result->rowCount() > 0) { // Si la requête renvoie au moins 1 ligne
            $num = ($result->rowCount());
            $message = "$num enregistrement(s) traités";
            echo $message; // Affichage du nb de lignes traitées
        }
    }

    // Modification de la requête pour inclure la clause WHERE
    $query = 'SELECT * FROM film F, genre G WHERE G.idGenre = F.idGenre';

    if (!empty($genreId)) {
        $query .= ' AND G.idGenre = :genreId';
    }

    $result = $cnx->prepare($query);

    // Liaison des paramètres si le genre est sélectionné
    if (!empty($genreId)) {
        $result->bindParam(':genreId', $genreId, PDO::PARAM_INT);
    }

    // Exécution de la requête
    $result->execute();

    // Affichage des résultats
    if ($result->rowCount() > 0) {
        echo "<table border='1'>";
        echo "<tr>";
        echo "<th>Visa</th>";
        echo "<th>Titre</th>";
        echo "<th>Année sortie</th>";
        echo "<th>Lien affiche</th>";
        echo "<th>Affiche</th>";
        echo "<th>Genre</th>";
        echo "<th>Modifier</th>";
        echo "<th>Supprimer</th>";
        echo "</tr>";

        while ($donnees = $result->fetch()) {
            echo "<form action=" . $_SERVER['SCRIPT_NAME'] . " method='post'>";
            echo "<input type='hidden' name='cle' value='" . $donnees['idFilm'] . "'>";
            echo "<tr>";
            echo "<td><input type='text' name='id'size='20' value=" . $donnees['idFilm'] . "></td>";
            echo "<td><input type='text' name='titre'size='20' value='" . $donnees['titre'] . "'></td>";
            echo "<td><input type='text' name='anneeSortie'size='20' value='" . $donnees['anneeSortie'] . "'></td>";
            echo "<td><input type='text' name='affiche'size='20' value='" . $donnees['affiche'] . "'></td>";
            echo "<td><img src='images/" . $donnees['affiche'] . "'/></td>";
            echo "<td><select name='genre2'>"; // Ouverture de la balise de sélection
            // Récupération des genres depuis la base de données
            $resultGenre = $cnx->prepare('SELECT idGenre, nomGenre FROM genre;');
            $resultGenre->execute();
            while ($genre = $resultGenre->fetch()) {
                // Vérifie si le genre actuel correspond au genre du film
                $selected = ($genre['idGenre'] == $donnees['idGenre']) ? 'selected' : '';
                echo "<option value=" . $genre['idGenre'] . " $selected>" . $genre['nomGenre'] . "</option>";
            }
            echo "</select></td>"; // Fermeture de la balise de sélection
            echo "<td><input type='submit' name='update' value='Modifier'></td>";
            echo "<td><input type='submit' name='delete' value='Supprimer'></td>";
            echo "</tr>";
            echo "</form>";
        }
        echo "</table>";
    } else {
        echo "Aucun enregistrement, désolé";
    }
    deconnect_bd('cinema');
}
?>

<a href="index.html">Accueil</a>