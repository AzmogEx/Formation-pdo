<form method="post" action="filmAjouter.php">
    <fieldset>
        <legend>Films</legend>

        <label for="titre">Titre :</label>
        <input type="text" name="titre"/>

        <label for="affiche">Affiche :</label>
        <input type="text" name="affiche"/>

        <label for="anneeSortie"> Année de sortie :</label>
        <input type="text" name="anneeSortie"/>

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
                        echo "<option value=".$donnees['idGenre'].">".$donnees['nomGenre']."</option>";
                    }
                }
            }
            ?>
        </select>

        <input type="submit" value="envoyer"/>
    </fieldset>
</form>
<a href="index.html">Accueil</a>

<?php
// Fermeture de la connexion si elle a été établie
if (isset($cnx)) {
    deconnect_bd('cinema');
}
?>
