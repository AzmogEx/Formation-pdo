<?php
// On établit la connexion
require_once('fonction.php');

// Insertion de données
$cnx = connect_bd('cinema');
if ($cnx) {
    /*-----------------------------------------------*/
    /* Affichage de la liste déroulante (combo box) des genres */
    /*-----------------------------------------------*/
    // On prépare la requête
    $result = $cnx->prepare('SELECT idGenre, nomGenre FROM Genre;');
    // On execute la requête
    $result->execute();
    // Création du formulaire
    echo '<FORM id="MonForm" method="POST" action="#">';
    // Création de la combo box
    echo "<SELECT name='genre' value='Genre' type='text'>";
    // Si la requête renvoie une ligne
    if ($result->rowCount() > 0) {
        // Boucle d'alimentation des éléments de la combo box
        while ($donnees = $result->fetch()) {
            // La VALUE contient la valeur de l'item sélectionné
            echo "<OPTION value=".$donnees['idGenre'].">".$donnees['nomGenre']."</OPTION>";
        }
    }
    // Fermeture de la liste déroulante
    echo '</SELECT>';

    
    // Bouton de validation
    echo "<input type='submit' value='Choisir'/></p>";
    echo '</FORM>';
} else {
    echo "Aucun enregistrement, désolé";
}
deconnect_bd('cinema');
?>

<?php
    //Affichage de l'id de la personne sélectionnée
    if (isset($_POST['genre'])){
        $idG= $_POST['genre'];
        echo $idG;
    }
?>