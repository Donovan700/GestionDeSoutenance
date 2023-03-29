<?php require("../Functions/Verification.php"); ?>
<?php require("../Models/Etudiant.php"); ?>

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
    <?php $IsDefine = verificate($_POST,['matricule','nom_etudiant','prenom_etudiant','niveau','parcours','adr_email']); ?>


    <a href="../"><button>Retour</button></a>
    <h1>AJOUTER UN ETUDIANTS</h1>
    <form action="CreationEtudiant.php" method="post">
        <label for="matricule">Matricule: </label>
        <input type="text" name="matricule" id="matricule" required /><br/><br/>
        <label for="nom_etudiant">Nom: </label>
        <input type="text" name="nom_etudiant" id="nom_etudiant" required /><br/><br/>
        <label for="prenom_etudiant">Prénom: </label>
        <input type="text" name="prenom_etudiant" id="prenom_etudiant" required /><br/><br/>
        <label for="niveau">Niveau: </label>
        <select name="niveau" id="niveau">
            <option value="L1">L1</option>
            <option value="L2">L2</option>
            <option value="L3">L3</option>
            <option value="M1">M1</option>
            <option value="M2">M2</option>
        </select><br/><br/>
        <label for="parcours">Parcours: </label>
        <select name="parcours" id="parcours">
            <option value="GB">GB</option>
            <option value="SR">SR</option>
            <option value="IG">IG</option>
        </select><br/><br/>
        <label for="adr_email">Adresse email: </label>
        <input type="email" name="adr_email" id="adr_email" required /><br/><br/>
        <input type="submit" value="Enregistrer" />
    </form>
    <br/><br/><a href="../Read/ReadEtudiant.php" id="voir"><button>Voir les étudiants</button></a>

    <?php
        if($IsDefine)
        {
            $etudiant = new Etudiant($_POST['matricule'],$_POST['nom_etudiant'],$_POST['prenom_etudiant'],$_POST['niveau'],$_POST['parcours'],$_POST['adr_email']);

            $ajout = $connect->prepare("INSERT INTO etudiants (matricule,nom_etudiant,prenom_etudiant,niveau,parcours,adr_email) VALUES (?, ?, ?, ?, ?, ?)");
            try
            {
                $ajout->execute(array($etudiant->getMatricule(),$etudiant->getNom(),$etudiant->getPrenom(),$etudiant->getNiveau(),$etudiant->getParcours(),$etudiant->getMail()));
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