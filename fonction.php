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

// Fonction pour lister tous les acteurs avec leur rôle dans les films
function listerActeursAvecRole()
{
    // Connexion à la base de données
    $cnx = connect_bd('cinema');

    // Vérifier la connexion
    if ($cnx) {
        // Préparation de la requête pour récupérer les acteurs avec leur rôle dans les films
        $req = $cnx->prepare("SELECT Film.titre, acteur.Prenom AS 'Acteur', acteurJoue.role 
                              FROM Film 
                              INNER JOIN acteurJoue ON Film.idFilm = acteurJoue.idFilm 
                              INNER JOIN acteur ON acteurJoue.idActeur = acteur.idActeur");
        // Exécution de la requête
        $req->execute();
        // Récupération des résultats
        $acteurs = $req->fetchAll(PDO::FETCH_ASSOC);

        // Retourner les acteurs avec leur rôle
        return $acteurs;
    } else {
        // Si erreur de connexion à la base de données
        return [];
    }
}



// Fonction pour récupérer le chiffre d'affaires total d'un genre donné
function chiffreAffaireTotalGenre($unGenre)
{
    // Connexion à la base de données
    $cnx = connect_bd('cinema');

    // Vérifier la connexion
    if ($cnx) {
        // Préparation de la requête pour récupérer le chiffre d'affaires total du genre sélectionné
        $req = $cnx->prepare("SELECT SUM(chiffreAffaire) as 'ChiffreAffaireTotal' FROM Film, Genre
                                WHERE Film.idGenre = Genre.idGenre AND nomGenre = :selectedGenre");
        // Définition des paramètres
        $req->bindParam(':selectedGenre', $unGenre, PDO::PARAM_STR);
        // Exécution de la requête
        $req->execute();
        // Récupération du chiffre d'affaires total
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        $chiffreAffaireTotal = $ligne['ChiffreAffaireTotal'];
        // Retourner le chiffre d'affaires total
        return $chiffreAffaireTotal;
    } else {
        // Si erreur de connexion à la base de données
        return -1;
    }
}

// Fonction pour récupérer le nombre total de films sortis à partir de l'an 2000
function nbFilmsAnnee2000()
{
    // Connexion à la base de données
    $cnx = connect_bd('cinema');

    // Vérifier la connexion
    if ($cnx) {
        // Préparation de la requête pour compter le nombre de films sortis à partir de l'an 2000
        $req = $cnx->prepare("SELECT COUNT(*) as 'NbFilms' FROM Film WHERE anneeSortie >= 2000");
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

// Fonction pour calculer la moyenne d'âge de tous les acteurs
function moyenneAgeActeurs()
{
    // Connexion à la base de données
    $cnx = connect_bd('cinema');

    // Vérifier la connexion
    if ($cnx) {
        // Préparation de la requête pour récupérer la date de naissance de tous les acteurs
        $req = $cnx->prepare("SELECT dateNaissance FROM Acteur");
        // Exécution de la requête
        $req->execute();
        // Récupération des dates de naissance
        $datesNaissance = $req->fetchAll(PDO::FETCH_COLUMN);

        // Calcul de l'âge pour chaque date de naissance
        $ages = [];
        foreach ($datesNaissance as $dateNaissance) {
            $age = date_diff(date_create($dateNaissance), date_create('today'))->y;
            $ages[] = $age;
        }

        // Calcul de la moyenne d'âge
        $moyenneAge = array_sum($ages) / count($ages);

        // Retourner la moyenne d'âge
        return $moyenneAge;
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