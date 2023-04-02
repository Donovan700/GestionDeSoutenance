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
    <?php $sql = "SELECT matricule FROM soutenir WHERE note BETWEEN 10 AND 20"; ?>
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

            
            //Les requêtes SQL
            $request = "SELECT * FROM etudiants WHERE matricule LIKE ?";
            $query = "SELECT * FROM soutenir WHERE matricule LIKE ?";
            $requete1 = "SELECT professeurs.nom_prof,professeurs.prenom_prof,grade FROM professeurs JOIN soutenir ON professeurs.id_prof=soutenir.id_president WHERE soutenir.matricule LIKE ?";
            $requete2 = "SELECT professeurs.nom_prof,professeurs.prenom_prof,grade FROM professeurs JOIN soutenir ON professeurs.id_prof=soutenir.id_examinateur WHERE soutenir.matricule LIKE ?";
            $requete3 = "SELECT professeurs.nom_prof,professeurs.prenom_prof,grade FROM professeurs JOIN soutenir ON professeurs.id_prof=soutenir.id_rapporteur_int WHERE soutenir.matricule LIKE ?";
            $requete4 = "SELECT professeurs.nom_prof,professeurs.prenom_prof,grade FROM professeurs JOIN soutenir ON professeurs.id_prof=soutenir.id_rapporteur_ext WHERE soutenir.matricule LIKE ?";



            //Preparation et execution


            //**___**//


            $preparation = $connect->prepare($query);
            $prepared_stmnt = $connect->prepare($request);
            $presider = $connect->prepare($requete1);
            $examiner = $connect->prepare($requete2);
            $rapporterInt = $connect->prepare($requete3);
            $rapporterExt = $connect->prepare($requete4);

            //bindParam
            $prepared_stmnt->bindParam(1,$searchString);
            $preparation->bindParam(1,$searchString);
            $presider->bindParam(1,$searchString);
            $examiner->bindParam(1,$searchString);
            $rapporterInt->bindParam(1,$searchString);
            $rapporterExt->bindParam(1,$searchString);

            //Execution
            $preparation->execute();
            $prepared_stmnt->execute();
            $presider->execute();
            $examiner->execute();
            $rapporterInt->execute();
            $rapporterExt->execute();

            //**_____**//

            //Liaisons
            $data = $prepared_stmnt->fetch(PDO::FETCH_ASSOC);
            $soutien = $preparation->fetch(PDO::FETCH_ASSOC);
            $president = $presider->fetch(PDO::FETCH_ASSOC);
            $examinateur = $examiner->fetch(PDO::FETCH_ASSOC);
            $rapporteurInt = $rapporterInt->fetch(PDO::FETCH_ASSOC);
            $rapporteurExt = $rapporterExt->fetch(PDO::FETCH_ASSOC);

            //Variable de stockage
            $note = $soutien['note'];
            $niveau = $data['niveau'];
            $parcours = $data['parcours'];
            $nom = $data['nom_etudiant'];
            $prenom = $data['prenom_etudiant'];
            $nom_profP = $president['nom_prof'];
            $prenom_profP = $president['prenom_prof'];
            $gradeP = $president['grade'];
            $nom_profE = $examinateur['nom_prof'];
            $prenom_profE = $examinateur['prenom_prof'];
            $gradeE = $examinateur['grade'];
            $nom_profRI = $rapporteurInt['nom_prof'];
            $prenom_profRI = $rapporteurInt['prenom_prof'];
            $gradeI = $rapporteurInt['grade'];
            $nom_profRE = $rapporteurExt['nom_prof'];
            $prenom_profRE = $rapporteurExt['prenom_prof'];
            $gradeE = $rapporteurExt['grade'];
            //Lancement du PDF
            if($niveau === 'L3')
            {
                ob_start();
                $pdf = new FPDF ();
                $pdf->AddPage ();
                $pdf->SetFont ('Arial', '', 12);
                $pdf->Cell(0, 10, 'PROCES VERBAL', 0, 1, 'C');
                $pdf->Cell(0, 10, "SOUTENANCE DE FIN D'ETUDES POUR L'OBTENTION DU DIPLOME DE LICENCE", 0, 1, 'C');
                $pdf->Cell(0, 1, "PROFESSIONNELLE", 0, 1, 'C');
                $pdf->Cell(0, 20, "Mention: Informatiques", 0, 1, 'C');
                switch($parcours)
                {
                    case 'GB' : $pdf->Cell(0, 2, "Parcours: Genie Logiciel et Base de Donnees", 0, 1, 'C'); break;
                    case 'SR' : $pdf->Cell(0, 2, "Parcours: Systeme et Reseau", 0, 1, 'C'); break;
                    case 'IG' : $pdf->Cell(0, 2, "Parcours: Informatique general", 0, 1, 'C'); break;
                    default : echo "Improbable";
                }
                $pdf->Cell(0, 40, "Mr/Mlle $nom $prenom" , 0, 1);
                $pdf->Cell(0, 10, "a soutenu publiquement son memoire de fin d'etudes pour l'obtention du diplome de Licence" , 0, 1);
                $pdf->Cell(0, 1, "professionnelle", 0, 1);
                $pdf->Cell(0, 10, "", 0,1);
                switch($note)
                {
                    case 1: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 1/20(un sur vingt)", 0, 1); break;
                    case 2: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 2/20(deux sur vingt)", 0, 1); break;
                    case 3: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 3/20(trois sur vingt)", 0, 1); break;
                    case 4: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 4/20(quatre sur vingt)", 0, 1); break;
                    case 5: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 5/20(cinq sur vingt)", 0, 1); break;
                    case 6: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 6/20(six sur vingt)", 0, 1); break;
                    case 7: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 7/20(sept sur vingt)", 0, 1); break;
                    case 8: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 8/20(huit sur vingt)", 0, 1); break;
                    case 9: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 9/20(neuf sur vingt)", 0, 1); break;
                    case 10: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 10/20(dix sur vingt)", 0, 1); break;
                    case 11: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 11/20(onze sur vingt)", 0, 1); break;
                    case 12: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 12/20(douze sur vingt)", 0, 1); break;
                    case 13: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 13/20(treize sur vingt)", 0, 1); break;
                    case 14: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 14/20(quatorze sur vingt)", 0, 1); break;
                    case 15: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 15/20(quinze sur vingt)", 0, 1); break;
                    case 16: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 16/20(seize sur vingt)", 0, 1); break;
                    case 17: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 17/20(dix-sept sur vingt)", 0, 1); break;
                    case 18: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 18/20(dix-huit sur vingt)", 0, 1); break;
                    case 19: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 19/20(dix-neuf sur vingt)", 0, 1); break;
                    case 20: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 20/20(vingt sur vingt)", 0, 1); break;
                    default : echo "Type Float";
                }
                $pdf->Cell(0, 10, "" ,0 ,2);
                $pdf->Cell(30, 4, "Membre du jury", 'B', 2);
                $pdf->Cell(0, 30, "President :          $nom_profP $prenom_profP, $gradeP", 0, 2);
                $pdf->Cell(0, 15, "Examinateur :        $nom_profE $prenom_profE, $gradeE ", 0, 2);
                $pdf->Cell(0, 15, "Rapporteurs :        $nom_profRI $prenom_profRI, $gradeI", 0, 2);
                $pdf->Cell(0, 5, "                              $nom_profRE $prenom_profRE, $gradeE" ,0, 2);
                $pdf->Output ();
                ob_end_flush();
            }
            else
            {
                ob_start();
                $pdf = new FPDF ();
                $pdf->AddPage ();
                $pdf->SetFont ('Arial', '', 12);
                $pdf->Cell(0, 10, 'PROCES VERBAL', 0, 1, 'C');
                $pdf->Cell(0, 10, "SOUTENANCE DE FIN D'ETUDES POUR L'OBTENTION DU DIPLOME DE MASTER", 0, 1, 'C');
                $pdf->Cell(0, 1, "PROFESSIONNELLE", 0, 1, 'C');
                $pdf->Cell(0, 20, "Mention: Informatiques", 0, 1, 'C');
                switch($parcours)
                {
                    case 'GB' : $pdf->Cell(0, 1, "Parcours: Genie Logiciel et Base de Donnees", 0, 1, 'C'); break;
                    case 'SR' : $pdf->Cell(0, 1, "Parcours: Systeme et Reseau", 0, 1, 'C'); break;
                    case 'IG' : $pdf->Cell(0, 1, "Parcours: Informatique general", 0, 1, 'C'); break;
                    default : echo "Improbable";
                }
                $pdf->Cell(0, 40, "Mr/Mlle $nom $prenom" ,0 ,1);
                $pdf->Cell(0, 10, "a soutenu publiquement son memoire de fin d'etudes pour l'obtention du diplome de Licence" , 0, 1);
                $pdf->Cell(0, 1, "professionnelle", 0, 1);
                $pdf->Cell(0, 10, "", 0,1);
                switch($note)
                {
                    case 1: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 1/20(un sur vingt)", 0, 1); break;
                    case 2: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 2/20(deux sur vingt)", 0, 1); break;
                    case 3: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 3/20(trois sur vingt)", 0, 1); break;
                    case 4: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 4/20(quatre sur vingt)", 0, 1); break;
                    case 5: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 5/20(cinq sur vingt)", 0, 1); break;
                    case 6: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 6/20(six sur vingt)", 0, 1); break;
                    case 7: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 7/20(sept sur vingt)", 0, 1); break;
                    case 8: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 8/20(huit sur vingt)", 0, 1); break;
                    case 9: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 9/20(neuf sur vingt)", 0, 1); break;
                    case 10: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 10/20(dix sur vingt)", 0, 1); break;
                    case 11: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 11/20(onze sur vingt)", 0, 1); break;
                    case 12: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 12/20(douze sur vingt)", 0, 1); break;
                    case 13: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 13/20(treize sur vingt)", 0, 1); break;
                    case 14: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 14/20(quatorze sur vingt)", 0, 1); break;
                    case 15: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 15/20(quinze sur vingt)", 0, 1); break;
                    case 16: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 16/20(seize sur vingt)", 0, 1); break;
                    case 17: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 17/20(dix-sept sur vingt)", 0, 1); break;
                    case 18: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 18/20(dix-huit sur vingt)", 0, 1); break;
                    case 19: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 19/20(dix-neuf sur vingt)", 0, 1); break;
                    case 20: $pdf->Cell(0, 10, "Apres la deliberation, la commission des membres du Jury a attribue la note de 20/20(vingt sur vingt)", 0, 1); break;
                    default : echo "Type Float";
                }
                $pdf->Cell(0, 10, "" ,0 ,2);
                $pdf->Cell(30, 4, "Membre du jury", 'B', 2);
                $pdf->Cell(0, 30, "President :          $nom_profP $prenom_profP, $gradeP", 0, 2);
                $pdf->Cell(0, 15, "Examinateur :        $nom_profE $prenom_profE, $gradeE ", 0, 2);
                $pdf->Cell(0, 15, "Rapporteurs :        $nom_profRI $prenom_profRI, $gradeI", 0, 2);
                $pdf->Cell(0, 5, "                              $nom_profRE $prenom_profRE, $gradeE" ,0, 2);
                $pdf->Output ();
                ob_end_flush();
            }
        }
    ?>
    </table>
</body>
</html>