<?php require("../Connexion/Connexion.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Images/logoENI.png" />
    <title>Liste des Professeurs</title>
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
        $sql = "SELECT * FROM professeurs";
        $statement = $connect->query($sql);
        if($statement === false) die("error");
    ?>
    <h1>LISTE DES PROFESSEURS</h1>
    <a href="../"><button>Home</button></a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>NOM</th>
                <th>PRENOM</th>
                <th>CIVILITE</th>
                <th>GRADE</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $statement->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row ['id_prof']);?></td>
                <td><?php echo htmlspecialchars ($row['nom_prof']) ;?></td>
                <td><?php echo htmlspecialchars($row ['prenom_prof']);?></td>
                <td><?php echo htmlspecialchars ($row['civilite']) ;?></td>
                <td><?php echo htmlspecialchars($row ['grade']);?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>