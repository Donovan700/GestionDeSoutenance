<?php require("../Connexion/Connexion.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Images/logoENI.png" />
    <title>Liste des Etudiants</title>
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
        $sql = "SELECT * FROM etudiants";
        $statement = $connect->query($sql);
        if($statement === false) die("error");
    ?>
    <h1>LISTE DES ETUDIANTS</h1>
    <a href="ReadNiveau.php"><button>Filtrer par niveau</button></a>
    <a href="../"><button>Home</button></a>
    <form action="ReadEtudiant.php" method="get" id="recherche">
        <input type="text" name="search" id="search" placeholder="Matricule ou Nom..." />
        <input type="submit" name='submit' value="Chercher" />
    </form>
    <?php 
        if(isset($_GET['submit']))
        {
            $searchString = '%' . $_GET['search'] . '%';
            $request = "SELECT * FROM etudiants WHERE matricule LIKE ? OR nom_etudiant LIKE ?";
            $prepared_stmnt = $connect->prepare($request);
            $prepared_stmnt->bindParam(1,$searchString);
            $prepared_stmnt->bindParam(2,$searchString);
            $prepared_stmnt->execute();
            $result = $prepared_stmnt->fetch(PDO::FETCH_ASSOC);
        }
    ?>
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
        <?php if(!isset($_GET['submit'])) : ?>
        <tbody>
            <?php while($row = $statement->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row ['matricule']);?></td>
                <td><?php echo htmlspecialchars ($row['nom_etudiant']) ;?></td>
                <td><?php echo htmlspecialchars($row ['prenom_etudiant']);?></td>
                <td><?php echo htmlspecialchars ($row['niveau']) ;?></td>
                <td><?php echo htmlspecialchars($row ['parcours']);?></td>
                <td><?php echo htmlspecialchars ($row['adr_email']) ;?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
        <?php else : ?>
            <?php if($result && $prepared_stmnt->rowCount() > 0) : ?>
            <tbody>
            <?php while($row = $prepared_stmnt->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td><?php echo htmlspecialchars($result['matricule']);?></td>
                <td><?php echo htmlspecialchars($result['nom_etudiant']);?></td>
                <td><?php echo htmlspecialchars($result['prenom_etudiant']);?></td>
                <td><?php echo htmlspecialchars($result['niveau']);?></td>
                <td><?php echo htmlspecialchars($result['parcours']);?></td>
                <td><?php echo htmlspecialchars($result['adr_email']);?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
        <a href="ReadEtudiant.php"><button>Retour</button></a>
        <?php else : ?>
        <tbody>
            <tr>
                <td colspan="6">Aucun résultat trouvé</td>
            </tr>
        </tbody>
        <a href="ReadEtudiant.php"><button>Retour</button></a>
         <?php endif; ?>
        <?php endif; ?>
    </table>
</body>
</html>