<?php require("../Connexion/Connexion.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Images/logoENI.png" />
    <title>Liste des Soutenances</title>
    <style>
        h1
        {
            text-align : center ;
        }
        table 
        {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            margin : 0 auto;
            width: 80%;
        }

        td, th 
        {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) 
        {
             background-color: #dddddd;
        }
        #recherche
        {
            text-align: center;
        }
    </style>
</head>
<body>
    <?php
        $sql = "SELECT * FROM soutenir";
        $statement = $connect->query($sql);
        if($statement === false) die("error");
    ?>
    <h1>LISTE DES SOUTENANCES</h1>
    <a href="../"><button>Home</button></a>
    <a href="ReadNoSoutenance.php"><button>Etudiants n'ayant pas de soutenance</button></a>
    <a href="../Creation/CreatePV.php"><button>Generer un PV</button></a>
    <form action="ReadSoutenance.php" method="get" id="recherche">
        <input type="text" name="search" id="search" placeholder="Annee universitaire..." />
        <input type="submit" name='submit' value="Chercher" />
    </form>
    <?php 
        if(isset($_GET['submit']))
        {
            $searchString = '%' . $_GET['search'] . '%';
            $request = "SELECT * FROM soutenir WHERE annee_univ LIKE ?";
            $prepared_stmnt = $connect->prepare($request);
            $prepared_stmnt->bindParam(1,$searchString);
            $prepared_stmnt->execute();
            $result = $prepared_stmnt->fetch(PDO::FETCH_ASSOC);
        }
    ?>
    <table>
        <thead>
            <tr>
                <th>MATRICULE</th>
                <th>ID ORGANISME</th>
                <th>ANNEE UNIVERSITAIRE</th>
                <th>NOTE</th>
                <th>PRESIDENT</th>
                <th>EXAMINATEUR</th>
                <th>RAPPORTEUR INTERNE</th>
                <th>RAPPORTEUR EXTERNE</th>
            </tr>
        </thead>
        <?php if(!isset($_GET['submit'])) : ?>
        <tbody>
            <?php while($row = $statement->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row ['matricule']);?></td>
                <td><?php echo htmlspecialchars ($row['id_org']) ;?></td>
                <td><?php echo htmlspecialchars($row ['annee_univ']);?></td>
                <td><?php echo htmlspecialchars($row ['note']);?></td>
                <td><?php echo htmlspecialchars ($row['id_president']) ;?></td>
                <td><?php echo htmlspecialchars($row ['id_examinateur']);?></td>
                <td><?php echo htmlspecialchars($row ['id_rapporteur_int']);?></td>
                <td><?php echo htmlspecialchars($row ['id_rapporteur_ext']);?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
        <?php else : ?>
            <?php if($result && $prepared_stmnt->rowCount() > 0) : ?>
            <tbody>
            <tr>
                <td><?php echo htmlspecialchars($result['matricule']);?></td>
                <td><?php echo htmlspecialchars($result['id_org']);?></td>
                <td><?php echo htmlspecialchars($result['annee_univ']);?></td>
                <td><?php echo htmlspecialchars($result['note']);?></td>
                <td><?php echo htmlspecialchars($result['id_president']);?></td>
                <td><?php echo htmlspecialchars($result['id_examinateur']);?></td>
                <td><?php echo htmlspecialchars($result ['id_rapporteur_int']);?></td>
                <td><?php echo htmlspecialchars($result ['id_rapporteur_ext']);?></td>
            </tr>
        </tbody>
        <a href="ReadSoutenance.php"><button>Retour</button></a>
        <?php else : ?>
        <tbody>
            <tr>
                <td colspan="8">Aucun résultat trouvé</td>
            </tr>
        </tbody>
        <a href="ReadSoutenance.php"><button>Retour</button></a>
         <?php endif; ?>
        <?php endif; ?>
    </table>
</body>
</html>