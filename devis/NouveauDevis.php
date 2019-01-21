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
$reponse = $bdd->query('SELECT Id_devis FROM devis ORDER BY Id_devis DESC LIMIT 1');
$IdDevis = $reponse->fetchAll();
foreach ($IdDevis as $IdDevi);
{
    $DevisId = $IdDevi['Id_devis'];
}

$id = "";
$code = "";
$libelle = "";
$chemin = "";
$devis = new Devis([
    "id" => $id,
    "code" => $code,
    "datedevis" => $date,
    "idclient" => $Client,
    "iduser" => $User,
    "libelle" => $libelle,
    "chemin" => $chemin,
]);
$ManagerDevis = new DevisManager($db);
$ManagerDevis->AddDevis($devis);

$codeLigne = "";
$remise = "";
$prix = "";
$poids = "";
$hauteur = "";
$largeur = "";
$profondeur = "";
$idpiece = "";
$idmatiere = "";
$idcouleur = "";
$idtva = "";
$option1 = "";
$option2 = "";
$option3 = "";
$option4 = "";
$lignedevis = new LigneDevis([
   "id" => $id,
   "code" => $codeLigne,
   "remise" => $remise,
   "prix" => $prix,
   "poids" => $poids,
   "hauteur" => $hauteur,
   "largeur" => $largeur,
   "profondeur" => $profondeur,
   "idpiece" => $idpiece,
   "idmatiere" => $idmatiere,
   "idcouleur" => $idcouleur,
   "idtva" => $idtva,
   "option1" => $option1,
   "option2" => $option2,
   "option3" => $option3,
   "option4" => $option4,

]);
$Upload = new ProtectionUploadCroquis();
$Upload->ProtectionUpload($libelle);




$location = 'Location: ../view/devis.php'.'?iduser='.$UserId.'&idclient='.$ClientId.'&iddevis='.$DevisId;
//header($location);
?>