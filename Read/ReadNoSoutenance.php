<?php require("../Connexion/Connexion.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Images/logoENI.png" />
    <title>Liste des soutenances</title>
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
    </style>
</head>
<body>
    <?php
        $sql = "SELECT e.matricule,e.nom_etudiant,e.prenom_etudiant,e.niveau,e.parcours,e.adr_email 
                FROM etudiants e 
                LEFT OUTER JOIN soutenir ON e.matricule=soutenir.matricule
                WHERE soutenir.matricule IS NULL";
        $statement = $connect->query($sql);
        if($statement === false) die("error");
    ?>
    <h1>LISTE DES ETUDIANTS N'AYANT PAS FAIT DE SOUTENANCE</h1>
    <a href="../"><button>Home</button></a>
    <a href="ReadSoutenance.php"><button>Retour</button></a>
    <table>
        <thead>
            <tr>
                <th>MATRICULE</th>
                <th>NOM</th>
                <th>PRENOM</th>
                <th>NIVEAU</th>
                <th>PARCOURS</th>
                <th>ADRESSE EMAIL</th>
            </tr>
        </thead>
        <tbody>
        <tr>
        <?php while($row = $statement->fetch(PDO::FETCH_ASSOC)) : ?>
                <td><?php echo htmlspecialchars($row ['matricule']);?></td>
                <td><?php echo htmlspecialchars ($row['nom_etudiant']) ;?></td>
                <td><?php echo htmlspecialchars($row ['prenom_etudiant']);?></td>
                <td><?php echo htmlspecialchars ($row['niveau']) ;?></td>
                <td><?php echo htmlspecialchars($row ['parcours']);?></td>
                <td><?php echo htmlspecialchars ($row['adr_email']) ;?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>