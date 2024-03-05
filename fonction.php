<?php

// Fonction pour récupérer tous les genres disponibles dans la base de données
function getAllGenres()
{
    // Connexion à la base de données
    $cnx = connect_bd('cinema');

    // Vérifier la connexion
    if ($cnx) {
        // Préparation de la requête pour récupérer tous les genres
        $query = "SELECT nomGenre FROM Genre";
        $genres = $cnx->query($query)->fetchAll(PDO::FETCH_COLUMN);
        // Retourner tous les genres
        return $genres;
    } else {
        // Si erreur de connexion à la base de données
        return [];
    }
}

// Fonction pour récupérer le nombre de films d'un genre donné
function nbFilms($unGenre)
{
    // Connexion à la base de données
    $cnx = connect_bd('cinema');

    // Vérifier la connexion
    if ($cnx) {
        // Préparation de la requête pour compter le nombre de films pour le genre sélectionné
        $req = $cnx->prepare("SELECT COUNT(*) as 'NbFilms' FROM Film, Genre
                                WHERE Film.idGenre = Genre.idGenre AND nomGenre = :selectedGenre");
        // Définition des paramètres
        $req->bindParam(':selectedGenre', $unGenre, PDO::PARAM_STR);
        // Exécution de la requête
        $req->execute();
        // Récupération du nombre de films
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        $nbFilms = $ligne['NbFilms'];
        // Retourner le nombre de films
        return $nbFilms;
    } else {
        // Si erreur de connexion à la base de données
        return -1;
    }
}

// Fonction de connexion à la BD 
function connect_bd($nomBd)
{
    $nomServeur = 'localhost';
    //nom du seveur
    $login = 'root';
    //login de l'utilisateur
    $passWd = "root";
    // mot de passe
    try {
        // Connexion à la BD et définition du jeu de caractères UTF-8
        $cnx = new PDO("mysql:host=localhost; dbname=$nomBd", $login, $passWd);

        // PDO génére une erreur fatale si un problème survient. 
        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Jeu de caractères
        $cnx->exec("SET CHARACTER SET utf8");
        return $cnx;

    } catch (PDOException $e) {

        print "Erreur!" . $e->getMessage() . "<br/>";
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