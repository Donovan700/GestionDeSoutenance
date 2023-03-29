<?php require("../Functions/Verification.php"); ?>
<?php require("../Models/Organisme.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Images/logoENI.png" />
    <title>Formulaire - Etudiants</title>
</head>
<body>


    <?php require("../Connexion/Connexion.php"); ?>
    <?php $IsDefine = verificate($_POST,['id_org','design','lieu']); ?>


    <a href="../"><button>Retour</button></a>
    <h1>AJOUTER UN ORGANISME</h1>
    <form action="CreationOrganisme.php" method="post">
        <label for="id_org">ID: </label>
        <input type="number" name="id_org" id="id_org" required /><br/><br/>
        <label for="design">Designation: </label>
        <input type="text" name="design" id="design" required /><br/><br/>
        <label for="lieu">Lieu: </label>
        <input type="text" name="lieu" id="lieu" required /><br/><br/>
        <input type="submit" value="Enregistrer" />
    </form>
    <br/><br/><a href="../Read/ReadOrganisme.php" id="voir"><button>Voir les organismes</button></a>

    <?php
        if($IsDefine)
        {
            $organisme = new Organisme($_POST['id_org'],$_POST['design'],$_POST['lieu']);

            $ajout = $connect->prepare("INSERT INTO organismes VALUES (?, ?, ?)");
            try
            {
                $ajout->execute(array($organisme->getId(),$organisme->getDesign(),$organisme->getLieu()));
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