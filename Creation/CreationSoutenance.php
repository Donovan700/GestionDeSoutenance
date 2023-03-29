<?php require("../Functions/Verification.php"); ?>
<?php require("../Models/Soutenir.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Images/logoENI.png" />
    <title>Formulaire - Soutenance</title>
</head>
<body>


    <?php require("../Connexion/Connexion.php"); ?>
    <?php
        $sqlO = "SELECT id_org FROM organismes";
        $sqlE = "SELECT matricule FROM etudiants WHERE niveau='L3' OR niveau='M2'";
        $sql = "SELECT id_prof,nom_prof,prenom_prof FROM professeurs";
        $statement = $connect->query($sql);
        $allmatricule = $connect->query($sqlE);
        $allIdOrg = $connect->query($sqlO);
    ?>
    <?php $IsDefine = verificate($_POST,['matricule','id_org','annee_univ','id_president','id_examinateur','id_rapporteur_int','id_rapporteur_ext','note']); ?>


    <a href="../"><button>Retour</button></a>
    <h1>AJOUTER UNE SOUTENANCE</h1>
    <form action="CreationSoutenance.php" method="post">
        <label for="matricule">Matricule: </label>
        <select name="matricule" id="matricule">
            <?php while($row = $allmatricule->fetch(PDO::FETCH_ASSOC)) : ?>
                <option value="<?php echo htmlspecialchars($row['matricule']); ?>"><?php echo htmlspecialchars($row ['matricule'])?></option>
            <?php endwhile; ?>
        </select><br/><br/>
        <label for="id_org">ID Organisme: </label>
        <select name="id_org" id="id_org">
            <?php while($row = $allIdOrg->fetch(PDO::FETCH_ASSOC)) : ?>
                <option value="<?php echo htmlspecialchars($row ['id_org']); ?>"><?php echo htmlspecialchars($row ['id_org']); ?></option>
            <?php endwhile; ?>
        </select><br/><br/>
        <label for="anne_univ">Année Universitaire: </label>
        <input type="text" name="annee_univ" id="annee_univ" required /><br/><br/>
        <label for="id_president">President: </label>
        <select name="id_president" id="id_president">
            <?php while($row = $statement->fetch(PDO::FETCH_ASSOC)) : ?>
                <option value="<?php echo htmlspecialchars($row['id_prof']);?>"><?php echo htmlspecialchars($row ['nom_prof']). ' '. htmlspecialchars($row['prenom_prof']);?></option>
            <?php endwhile; ?>
        </select><br/><br/>
        <label for="id_examinateur">Examinateur: </label>
        <select name="id_examinateur" id="id_examinateur">
            <?php while($row = $statement->fetch(PDO::FETCH_ASSOC)) : ?>
                <option value="<?php echo htmlspecialchars($row['id_prof']);?>"><?php echo htmlspecialchars($row ['nom_prof']). ' '. htmlspecialchars($row['prenom_prof']);?></option>
            <?php endwhile; ?>
        </select><br/><br/>
        <label for="id_rapporteur_int">Rapporteur interne: </label>
        <select name="id_rapporteur_int" id="id_rapporteur_int">
            <?php while($row = $statement->fetch(PDO::FETCH_ASSOC)) : ?>
                <option value="<?php echo htmlspecialchars($row['id_prof']);?>"><?php echo htmlspecialchars($row ['nom_prof']). ' '. htmlspecialchars($row['prenom_prof']);?></option>
            <?php endwhile; ?>
        </select><br/><br/>
        <label for="id_rapporteur_ext">Rapporteur externe: </label>
        <select name="id_rapporteur_ext" id="id_rapporteur_ext">
            <?php while($row = $statement->fetch(PDO::FETCH_ASSOC)) : ?>
                <option value="<?php echo htmlspecialchars($row['id_prof']);?>"><?php echo htmlspecialchars($row ['nom_prof']). ' '. htmlspecialchars($row['prenom_prof']);?></option>
            <?php endwhile; ?>
        </select><br/><br/>
        <label for="note">Note: </label>
        <input type="text" name="note" id="note" required /><br/><br/>
        <input type="submit" value="Enregistrer" />
    </form>
    <br/><br/><a href="../Read/ReadSoutenance.php" id="voir"><button>Voir les soutenances</button></a>

    <?php
        if($IsDefine)
        {
            $soutenance = new Soutenir($_POST['matricule'],$_POST['id_org'],$_POST['anne_univ'],$_POST['id_president'],$_POST['id_examinateur'],$_POST['id_rapporteur_int'],$_POST['id_rapporteur_ext'],$_POST['note']);

            $ajout = $connect->prepare("INSERT INTO soutenir VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            try
            {
                $ajout->execute(array($soutenance->getMatricule(),$soutenance->getOrg(),$soutenance->getAnnee(),$soutenance->getPresident(),$soutenance->getExaminateur(),$soutenance->getRapporteurInt(),$soutenance->getRapporteurExt()));
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