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
        $sql = "SELECT * FROM organismes";
        $statement = $connect->query($sql);
        if($statement === false) die("error");
    ?>
    <h1>LISTE DES ORGANISMES</h1>
    <a href="../"><button>Home</button></a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>DESIGNATION</th>
                <th>LIEU</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $statement->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row ['id_org']);?></td>
                <td><?php echo htmlspecialchars ($row['design']) ;?></td>
                <td><?php echo htmlspecialchars($row ['lieu']);?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>