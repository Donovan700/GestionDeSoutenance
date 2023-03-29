<?php require("../Connexion/Connexion.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Images/logoENI.png" />
    <title>Liste des Organismes</title>
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
        $sql = "SELECT niveau,COUNT(matricule) AS effectif FROM etudiants GROUP BY niveau";
        $statement = $connect->query($sql);
        if($statement === false) die("error");
    ?>
    <h1>NOMBRES D'ETUDIANT PAR NIVEAU</h1>
    <a href="ReadEtudiant.php"><button>Retour</button></a>
    <table>
        <thead>
            <tr>
                <td>NIVEAU</td>
                <td>EFFECTIFS TOTAL</td>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $statement->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row ['niveau']);?></td>
                <td><?php echo htmlspecialchars ($row['effectif']) ;?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>