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
                        echo "<option value=" . $donnees['idGenre'] . ">" . $donnees['nomGenre'] . "</option>";
                    }
                }
            }
            ?>
        </select>
        <label for="acteurPrincipal">Nom Acteur principal</label>
        <input type="text" name="acteurPrincipal" />

        <label for="dateNaissance">Date de naissance Acteur principal</label>
        <input type="date" name="dateNaissance" />

        <label for="chiffreAffaire">Chiffre d'affaire généré par le film</label>
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