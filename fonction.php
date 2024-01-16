<?php

// Fonction de connexion à la BD 
function connect_bd($nomBd)
{
    $nomServeur = 'localhost';
                            //nom du seveur
    $login='root';
                    //login de l'utilisateur
    $passWd="root";
                // mot de passe
    try
    {
        // Connexion à la BD et définition du jeu de caractères UTF-8
        $cnx = new PDO("mysql:host=localhost; dbname=$nomBd", $login, $passWd);

        // PDO génére une erreur fatale si un problème survient. 
        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Jeu de caractères
        $cnx->exec("SET CHARACTER SET utf8");

        echo "connecté !";
        return $cnx;

    }

    catch (PDOException $e)
    {

        print "Erreur!" .$e->getMessage(). "<br/>";
        die();
        return 0;
    }
}

    // Fonction de deconnexion de la BD 
    function deconnect_bd($nomBd)
{
    $nomBd = null;
}

?>
<a href="index.html">Accueil </a>