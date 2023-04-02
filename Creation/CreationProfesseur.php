<?php require("../Functions/Verification.php"); ?>
<?php require("../Models/Professeur.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Images/logoENI.png" />
    <title>Formulaire - Professeur</title>
</head>
<body>


    <?php require("../Connexion/Connexion.php"); ?>
    <?php $IsDefine = verificate($_POST,['id_prof','nom_prof','prenom_prof','civilite','grade']); ?>


    <a href="../"><button>Retour</button></a>
    <h1>AJOUTER UN PROFESSEUR</h1>
    <form action="CreationProfesseur.php" method="post">
        <label for="id_prof">ID: </label>
        <input type="text" name="id_prof" id="id_prof" required /><br/><br/>
        <label for="nom_prof">Nom: </label>
        <input type="text" name="nom_prof" id="nom_prof" required /><br/><br/>
        <label for="prenom_prof">Prénom: </label>
        <input type="text" name="prenom_prof" id="prenom_prof" required /><br/><br/>
        <label for="civilite">Civilité: </label>
        <select name="civilite" id="civilite">
            <option value="Mr">Mr</option>
            <option value="Mlle">Mlle</option>
            <option value="Mme">Mme</option>
        </select><br/><br/>
        <label for="grade">Grade: </label>
        <select name="grade" id="grade">
            <option value="Professeur titulaire">Professeur titulaire</option>
            <option value="Maitre de conferences">Maître de conférences</option>
            <option value="Assistant d'Enseignement Superieur et de Recherche">Assistant d’Enseignement Supérieur et de Recherche</option>
            <option value="Docteur en HDR">Docteur HDR</option>
            <option value="docteur en informatiques">Docteur en informatiques</option>
            <option value="doctorant en informatiques">Doctorant en informatiques</option>
        </select><br/><br/>
        <input type="submit" value="Enregistrer" />
    </form>
    <br/><br/><a href="../Read/ReadProfesseur.php" id="voir"><button>Voir les professeurs</button></a>

    <?php
        if($IsDefine)
        {
            $professeur = new Professeur($_POST['id_prof'],$_POST['nom_prof'],$_POST['prenom_prof'],$_POST['civilite'],$_POST['grade']);

            $ajout = $connect->prepare("INSERT INTO professeurs VALUES (?, ?, ?, ?, ?)");
            try
            {
                $ajout->execute(array($professeur->getId(),$professeur->getNom(),$professeur->getPrenom(),$professeur->getCivilite(),$professeur->getGrade()));
                print "<em>Bien ajouter</em>";
                $_POST = null;
            }
            catch(PDOException $e)
            {
                echo "erreur ". $e ->getMessage();
                die();
            }
            $db = null; //Fermeture du Database
        }
    ?>
</body>
</html>