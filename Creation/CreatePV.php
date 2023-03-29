<?php require("../Connexion/Connexion.php"); ?>
<?php require("../Features/FPDF/fpdf.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generer un PV</title>
    <style>
        form
        {
            text-align: center;
        }
    </style>
</head>
<body>
    <?php $sql = "SELECT matricule FROM soutenir"; ?>
    <?php $AllMatricule = $connect->query($sql); ?>
    <h1>GENERER UN PROCES VERBAL</h1>
    <a href="../Read/ReadSoutenance.php"><button>Retour</button></a>
    <form action="CreatePV.php" method="get">
        <label for="matricule">Matricule: </label>
        <select name="matricule" id="matricule">
            <?php while($row = $AllMatricule->fetch(PDO::FETCH_ASSOC)) : ?>
                <option value="<?php echo htmlspecialchars($row['matricule']); ?>"><?php echo htmlspecialchars($row['matricule']); ?></option>
            <?php endwhile; ?>
        </select>
        <input type="submit" name="submit" value="Valider" />
    </form>
    <?php
        if(isset($_GET['submit']))
        {
            $searchString = '%' . $_GET['matricule'] . '%';
            $request = "SELECT * FROM etudiants WHERE matricule LIKE ?";
            $prepared_stmnt = $connect->prepare($request);
            $prepared_stmnt->bindParam(1,$searchString);
            $prepared_stmnt->execute();
            $data = $prepared_stmnt->fetch(PDO::FETCH_ASSOC);
            $niveau = $data['niveau'];
            $parcours = $data['parcours'];
            if($niveau === 'L3')
            {
                ob_start();
                $pdf = new FPDF ();
                $pdf->AddPage ();
                $pdf->SetFont ('Arial', '', 11);
                $pdf->Cell(0, 10, 'PROCES VERBAL', 0, 1, 'C');
                $pdf->Cell(0, 10, "SOUTENANCE DE FIN D'ETUDES POUR L'OBTENTION DU DIPLOME DE LICENCE", 0, 1, 'C');
                $pdf->Cell(0, 10, "PROFESSIONNELLE", 0, 1, 'C');
                $pdf->Cell(0, 10, "Mention: Informatiques", 0, 1, 'C');
                switch($parcours)
                {
                    case 'GB' : $pdf->Cell(0, 10, "Parcours: Genie Logiciel et Base de Donnees", 0, 1, 'C'); break;
                    case 'SR' : $pdf->Cell(0, 10, "Parcours: Systeme et Reseau", 0, 1, 'C'); break;
                    case 'IG' : $pdf->Cell(0, 10, "Parcours: Informatique general", 0, 1, 'C'); break;
                    default : echo "Improbable";
                }
                $pdf->Output ();
                ob_end_flush();
            }
            else
            {
                echo "M2";
            }
        }
    ?>
    <table>
        <thead>
            <th>MATRICULE</th>
        </thead>
        <?php if(!isset($_GET['submit'])) : ?>
        <tbody>
            <tr>Blank</tr>
        </tbody>
        <?php else : ?>
        <tbody>
            <?php $result = $prepared_stmnt->fetch(PDO::FETCH_ASSOC); ?>
            <tr><?php echo htmlspecialchars($result['matricule']); ?></tr>
        </tbody>
        <?php endif; ?>
    </table>
</body>
</html>