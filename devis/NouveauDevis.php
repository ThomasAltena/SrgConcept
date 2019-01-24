<?php
include ("../view/header.php");
    $db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
    $date = date("d-m-Y");
      
try
{
        $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
}
catch(Exception $e)
{
            die('Erreur : '.$e->getMessage());
}
$UserId = $_SESSION["Id_user"];
$Client = ($_POST["Id_client"]);
$ClientId = intval($Client);

//Libeller de l image +1
$reponse = $bdd->query('SELECT Id_devis FROM devis ORDER BY Id_devis DESC LIMIT 1',PDO::FETCH_ASSOC);
$IdDevis = $reponse->fetchAll();
$Tableau = $IdDevis['0'];

$ligne = $Tableau['Id_devis'];
$ligne = intval($ligne);
$NomImage = $ligne + 1;
$NomImage = strval($NomImage);


foreach ($IdDevis as $IdDevi);
{
    $DevisId = $IdDevi['Id_devis'];
}

$id = "";
$code = "";
$date = date("d-m-Y");
$chemin = "../public/image/".$NomImage.'.jpg';
$devis = new Devis([
    "id" => $id,
    "code" => $code,
    "datedevis" => $date,
    "idclient" => $ClientId,
    "iduser" => $UserId,
    "chemin" => $chemin,
]);
$ManagerDevis = new DevisManager($db);
$ManagerDevis->AddDevis($devis);
$idmatiere = $_POST['Id_matiere'];




if($_POST['Id_piece']  != "") {

    $codeLigne = "";
    $remise = $_POST['Remis1'];
    $poids = "";
    $hauteur = $_POST['Hauteur1'];
    $largeur = $_POST['Largeur1'];
    $profondeur = $_POST['Profondeur1'];
    $idpiece = $_POST['Id_piece'];
    $idmatiere = $_POST['Id_matiere'];
    $idcouleur = "";
    $idtva = "1";
    $option1 = $_POST['Id_option'];
    $option2 = $_POST['Id_option2'];
    $option3 = $_POST['Id_option3'];
    $option4 = $_POST['Id_option4'];
    $option5 = "";
    $PT= $ManagerDevis->PrixMatiére($idmatiere);
    $PT = $PT->GetPrix();
    $mv = 2700;
    $cm = $largeur *$hauteur * $profondeur;
    $m = $cm /1000000;
    $kg = $m * $mv;
    $tonne = $kg/1000;
    $PF = $tonne * $PT;
    $lignedevis = new LigneDevis([]);
    $lignedevis->SetId("");
    $lignedevis->SetCode("");
    $lignedevis->SetRemise($remise);
    $lignedevis->SetPrix($PF);
    $lignedevis->SetPoids("");
    $lignedevis->SetHauteur($profondeur);
    $lignedevis->SetLargeur($largeur);
    $lignedevis->SetProfondeur($profondeur);
    $lignedevis->SetIdpiece($idpiece);
    $lignedevis->SetIdmatiere($idmatiere);
    $lignedevis->SetIdcouleur("");
    $lignedevis->SetIdtva("1");
    $lignedevis->SetIddevis($NomImage);
    $lignedevis->SetOption1($option1);
    $lignedevis->SetOption2($option2);
    $lignedevis->SetOption3($option3);
    $lignedevis->SetOption4($option4);
    $lignedevis->SetOption5("");


    $ManagerLigne = new LigneDevisManager($bdd);
    $ManagerLigne->AddLigne($lignedevis);


//$Upload = new ProtectionUploadCroquis();
//$Upload->ProtectionUpload($libelle);
}

if($_POST['Id_piece2']  != "") {

    $codeLigne = "";
    $remise = $_POST['Remis2'];
    $prix = "";
    $poids = "";
    $hauteur = $_POST['Hauteur2'];
    $largeur = $_POST['Largeur2'];
    $profondeur = $_POST['Profondeur2'];
    $idpiece = $_POST['Id_piece2'];
    $idmatiere = $_POST['Id_matiere'];
    $idcouleur = "";
    $idtva = "1";
    $option1 = $_POST['Id_option5'];
    $option2 = $_POST['Id_option6'];
    $option3 = $_POST['Id_option7'];
    $option4 = $_POST['Id_option8'];
    $option5 = "";

    $PT= $ManagerDevis->PrixMatiére($idmatiere);
    $PT = $PT->GetPrix();
    $mv = 2700;
    $cm = $largeur *$hauteur * $profondeur;
    $m = $cm /1000000;
    $kg = $m * $mv;
    $tonne = $kg/1000;
    $PF = $tonne * $PT;
    $lignedevis2 = new LigneDevis([]);
    $lignedevis2->SetId("");
    $lignedevis2->SetCode("");
    $lignedevis2->SetRemise($remise);
    $lignedevis2->SetPrix($PF);
    $lignedevis2->SetPoids("");
    $lignedevis2->SetHauteur($profondeur);
    $lignedevis2->SetLargeur($largeur);
    $lignedevis2->SetProfondeur($profondeur);
    $lignedevis2->SetIdpiece($idpiece);
    $lignedevis2->SetIdmatiere($idmatiere);
    $lignedevis2->SetIdcouleur("");
    $lignedevis2->SetIdtva("1");
    $lignedevis2->SetIddevis($NomImage);
    $lignedevis2->SetOption1($option1);
    $lignedevis2->SetOption2($option2);
    $lignedevis2->SetOption3($option3);
    $lignedevis2->SetOption4($option4);
    $lignedevis2->SetOption5("");


    $ManagerLigne = new LigneDevisManager($bdd);
    $ManagerLigne->AddLigne($lignedevis2);
//$Upload = new ProtectionUploadCroquis();
//$Upload->ProtectionUpload($libelle);
}


if($_POST['Id_piece3'] != "") {

    $codeLigne = "";
    $remise = $_POST['Remis3'];
    $prix = "";
    $poids = "";
    $hauteur = $_POST['Hauteur3'];
    $largeur = $_POST['Largeur3'];
    $profondeur = $_POST['Profondeur3'];
    $idpiece = $_POST['Id_piece3'];
    $idmatiere = $_POST['Id_matiere'];
    $idcouleur = "";
    $idtva = "1";
    $option1 = $_POST['Id_option9'];
    $option2 = $_POST['Id_option10'];
    $option3 = $_POST['Id_option11'];
    $option4 = $_POST['Id_option12'];
    $option5 = "";

    $PT= $ManagerDevis->PrixMatiére($idmatiere);
    $PT = $PT->GetPrix();
    $mv = 2700;
    $cm = $largeur *$hauteur * $profondeur;
    $m = $cm /1000000;
    $kg = $m * $mv;
    $tonne = $kg/1000;
    $PF = $tonne * $PT;
    $lignedevis3 = new LigneDevis([]);
    $lignedevis3->SetId("");
    $lignedevis3->SetCode("");
    $lignedevis3->SetRemise($remise);
    $lignedevis3->SetPrix($PF);
    $lignedevis3->SetPoids("");
    $lignedevis3->SetHauteur($profondeur);
    $lignedevis3->SetLargeur($largeur);
    $lignedevis3->SetProfondeur($profondeur);
    $lignedevis3->SetIdpiece($idpiece);
    $lignedevis3->SetIdmatiere($idmatiere);
    $lignedevis3->SetIdcouleur("");
    $lignedevis3->SetIdtva("1");
    $lignedevis3->SetIddevis($NomImage);
    $lignedevis3->SetOption1($option1);
    $lignedevis3->SetOption2($option2);
    $lignedevis3->SetOption3($option3);
    $lignedevis3->SetOption4($option4);
    $lignedevis3->SetOption5("");


    $ManagerLigne = new LigneDevisManager($bdd);
    $ManagerLigne->AddLigne($lignedevis2);
//$Upload = new ProtectionUploadCroquis();
//$Upload->ProtectionUpload($libelle);
}


if($_POST['Id_piece4']  != "") {

    $codeLigne = "";
    $remise = $_POST['Remis4'];
    $prix = "";
    $poids = "";
    $hauteur = $_POST['Hauteur4'];
    $largeur = $_POST['Largeur4'];
    $profondeur = $_POST['Profondeur4'];
    $idpiece = $_POST['Id_piece4'];
    $idmatiere = $_POST['Id_matiere'];
    $idcouleur = "";
    $idtva = "1";
    $option1 = $_POST['Id_option13'];
    $option2 = $_POST['Id_option14'];
    $option3 = $_POST['Id_option15'];
    $option4 = $_POST['Id_option16'];
    $option5 = "";

    $PT= $ManagerDevis->PrixMatiére($idmatiere);
    $PT = $PT->GetPrix();
    $mv = 2700;
    $cm = $largeur *$hauteur * $profondeur;
    $m = $cm /1000000;
    $kg = $m * $mv;
    $tonne = $kg/1000;
    $PF = $tonne * $PT;
    $lignedevis4 = new LigneDevis([]);
    $lignedevis4->SetId("");
    $lignedevis4->SetCode("");
    $lignedevis4->SetRemise($remise);
    $lignedevis4->SetPrix($PF);
    $lignedevis4->SetPoids("");
    $lignedevis4->SetHauteur($profondeur);
    $lignedevis4->SetLargeur($largeur);
    $lignedevis4->SetProfondeur($profondeur);
    $lignedevis4->SetIdpiece($idpiece);
    $lignedevis4->SetIdmatiere($idmatiere);
    $lignedevis4->SetIdcouleur("");
    $lignedevis4->SetIdtva("1");
    $lignedevis4->SetIddevis($NomImage);
    $lignedevis4->SetOption1($option1);
    $lignedevis4->SetOption2($option2);
    $lignedevis4->SetOption3($option3);
    $lignedevis4->SetOption4($option4);
    $lignedevis4->SetOption5("");


    $ManagerLigne = new LigneDevisManager($bdd);
    $ManagerLigne->AddLigne($lignedevis2);
//$Upload = new ProtectionUploadCroquis();
//$Upload->ProtectionUpload($libelle);
}

if($_POST['Id_piece5'] != "") {

    $codeLigne = "";
    $remise = $_POST['Remis5'];
    $prix = "";
    $poids = "";
    $hauteur = $_POST['Hauteur5'];
    $largeur = $_POST['Largeur5'];
    $profondeur = $_POST['Profondeur5'];
    $idpiece = $_POST['Id_piece5'];
    $idmatiere = $_POST['Id_matiere'];
    $idcouleur = "";
    $idtva = "1";
    $option1 = $_POST['Id_option17'];
    $option2 = $_POST['Id_option18'];
    $option3 = $_POST['Id_option19'];
    $option4 = $_POST['Id_option20'];
    $option5 = "";

    $PT= $ManagerDevis->PrixMatiére($idmatiere);
    $PT = $PT->GetPrix();
    $mv = 2700;
    $cm = $largeur *$hauteur * $profondeur;
    $m = $cm /1000000;
    $kg = $m * $mv;
    $tonne = $kg/1000;
    $PF = $tonne * $PT;
    $lignedevis4 = new LigneDevis([]);
    $lignedevis4->SetId("");
    $lignedevis4->SetCode("");
    $lignedevis4->SetRemise($remise);
    $lignedevis4->SetPrix($PF);
    $lignedevis4->SetPoids("");
    $lignedevis4->SetHauteur($profondeur);
    $lignedevis4->SetLargeur($largeur);
    $lignedevis4->SetProfondeur($profondeur);
    $lignedevis4->SetIdpiece($idpiece);
    $lignedevis4->SetIdmatiere($idmatiere);
    $lignedevis4->SetIdcouleur("");
    $lignedevis4->SetIdtva("1");
    $lignedevis4->SetIddevis($NomImage);
    $lignedevis4->SetOption1($option1);
    $lignedevis4->SetOption2($option2);
    $lignedevis4->SetOption3($option3);
    $lignedevis4->SetOption4($option4);
    $lignedevis4->SetOption5("");


    $ManagerLigne = new LigneDevisManager($bdd);
    $ManagerLigne->AddLigne($lignedevis2);
//$Upload = new ProtectionUploadCroquis();
//$Upload->ProtectionUpload($libelle);
}


$location = 'Location: ../view/devis.php'.'?iduser='.$UserId.'&idclient='.$ClientId.'&iddevis='.$NomImage;
header($location);
?>
