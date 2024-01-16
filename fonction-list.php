<?php
//on établis la connexion
require_once('fonction.php');


//insertion des données
$cnx = connect_bd('cinema');
if($cnx) {
    //on prépare la requête (une seule fois)
    $result = $cnx->prepare('SELECT * FROM film, genre;');

    //on exécute la requête
    $result->execute();

    //si la requête renvoie au moins 1 ligne 
    if($result->rowCount()>0)
    {
        echo "<table border='1'>";
        //enquête du tableau
        echo "<tr>";
            echo "<th>Visa</th>";
            echo "<th>Titre</th>";
            echo "<th>Année sortie</th>";
            echo "<th>Lien affiche</th>";
            echo "<th>Affiche</th>";
            echo "<th>Genre</th>";
        echo "</tr>";
        //On parcours les résultats
        while ($donnees = $result->fetch())
        {
            echo"<tr>";
                echo"<td>".$donnees['idFilm']."</td>";
                echo"<td>".$donnees['titre']."</td>";
                echo"<td>".$donnees['anneeSortie']."</td>";
                echo"<td>".$donnees['affiche']."</td>";
                echo"<td><img src='images/".$donnees['affiche']."'/></td>";
                echo"<td>".$donnees['nomGenre']."</td>";
        }
    echo "</table>";
    }
    else {
        echo "Aucun enregistrement, désolé";
    }
    deconnect_bd('cinema');
}
?>

<a href="index.html">Accueil</a>