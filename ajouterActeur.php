<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('fonction.php'); // Inclure le fichier de connexion à la base de données

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $prenom = $_POST['prenom']; // Correction ici
    $dateNaissance = $_POST['dateNaissance'];

    // Connexion à la base de données
    $cnx = connect_bd('cinema');

    // Préparation de la requête d'insertion
    $query = "INSERT INTO acteur (Prenom, dateNaissance) VALUES (:prenom, :dateNaissance)";

    // Préparation de la requête
    $stmt = $cnx->prepare($query);

    // Liaison des paramètres
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':dateNaissance', $dateNaissance);

    // Exécution de la requête
    if ($stmt->execute()) {
        echo "Acteur ajouté avec succès.";
    } else {
        echo "Une erreur est survenue lors de l'ajout de l'acteur.";
    }

    // Fermeture de la connexion
    deconnect_bd('cinema');
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <fieldset>
        <legend>Ajouter un Acteur</legend>

        <label for="prenom">Prénom :</label> <!-- Correction ici -->
        <input type="text" name="prenom" /> <!-- Correction ici -->

        <label for="dateNaissance">Date de Naissance :</label>
        <input type="date" name="dateNaissance" />

        <input type="submit" value="Ajouter" />
    </fieldset>
</form>
<a href="index.html">Accueil</a>