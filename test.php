<form>
<label for="genre"> Genre :</label>
    <FORM>
    <SELECT names="genre">
        <OPTION>Drame</OPTION>
        <OPTION>Comédie</OPTION>
        <OPTION>Thriller</OPTION>
        <OPTION>Action</OPTION>
        <OPTION>Fantastique</OPTION>
    </SELECT>
    </FORM>
    <input type="submit" value="envoyer"/>
</form>

<?php
    //Affichage de l'id de la personne sélectionnée
    if (isset($_POST['genre'])){
        $idG= $_POST['genre'];
        echo $idG;
    }
?>