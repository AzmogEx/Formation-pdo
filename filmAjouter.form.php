<form method="post" action="filmAjouter.php">
    <fieldset>
        <legend>Films</legend>

        <label for="titre">Titre :</label>
        <input type="text" name="titre" />

        <label for="affiche">Affiche :</label>
        <input type="text" name="affiche" />

        <label for="anneeSortie"> Année de sortie :</label>
        <input type="text" name="anneeSortie" />

        <label for="genre"> Genre :</label>
        <select name="genre">
            <?php
            require_once('fonction.php');
            // Connexion à la base de données
            $cnx = connect_bd('cinema');

            if ($cnx) {
                // Récupérer tous les genres
                $query = "SELECT idGenre, nomGenre FROM Genre";
                $genres = $cnx->query($query)->fetchAll(PDO::FETCH_ASSOC);
                // Afficher les options pour chaque genre
                foreach ($genres as $genre) {
                    echo "<option value='" . $genre['idGenre'] . "'>" . $genre['nomGenre'] . "</option>";
                }
            }
            ?>
        </select>

        <label for="acteurPrincipal"> Acteur principal :</label>
        <select name="acteurPrincipal">
            <?php
            if ($cnx) {
                // Récupérer tous les acteurs
                $query = "SELECT idActeur, Prenom FROM acteur";
                $acteurs = $cnx->query($query)->fetchAll(PDO::FETCH_ASSOC);
                // Afficher les options pour chaque acteur
                foreach ($acteurs as $acteur) {
                    echo "<option value='" . $acteur['idActeur'] . "'>" . $acteur['Prenom'] . "</option>";
                }
            }
            ?>
        </select>

        <label for="role"> Rôle de l'acteur principal :</label>
        <input type="text" name="role" />

        <label for="chiffreAffaire">Chiffre d'affaire généré par le film :</label>
        <input type="text" name="chiffreAffaire" />


        <fieldset>
            <legend><b>Salles de diffusion</b></legend>
            <input type="checkbox" name="salle[]" value="1" />Salle 1<br />
            <input type="checkbox" name="salle[]" value="2" />Salle 2<br />
            <input type="checkbox" name="salle[]" value="3" />Salle 3<br />
            <input type="checkbox" name="salle[]" value="4" />Salle 4<br />
            <input type="checkbox" name="salle[]" value="5" />Salle 5<br />
        </fieldset>

        <input type="submit" value="envoyer" />
    </fieldset>
</form>
<a href="index.html">Accueil</a>

<?php
// Fermeture de la connexion si elle a été établie
if (isset($cnx)) {
    deconnect_bd('cinema');
}
?>