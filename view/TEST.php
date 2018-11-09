<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['submit'])){

    if($_POST['hauteur'] != "" && $_POST['largeur'] != "" && $_POST['profondeur'] != ""){
      
    /* Assignation var */
    $id = "";
    $code = $_POST['code'];
    $remise = $_POST['remise'];
    $prix = $_POST['prix'];
    $poids = $_POST['poids'];
    $hauteur = $_POST['hauteur'];
    $largeur = $_POST['largeur'];
    $profondeur = $_POST['profondeur'];
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $idpiece =
    $idmatiere =
    $idcouleur =
    $idtva =
    $option1 = 
    $option2 =
    $option3 = 
    $option4 =
    $option5 =
    //$image = $_POST['fileToUpload'];

    /* Construct */
    $ligneDevis = new LigneDevis([
    "Id_piece" => $id,
    "code" => $code,
    "remise" => $remise,
    "prix" => $prix,
    "poids" => $pods,
    "hauteur" => $hauteur,
    "Largeur" => $largeur,
    "profondeur" => $profondeur,
    //"fileToUpload" => $image,
    ]);
}
}

    /* BDD*/
  $db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
  $ManagerPiece = new PieceManager($db); //Connexion a la BDD
  $UploadPiece = new Upload();


  /** Ajout **/
  $ManagerPiece->AddPiece($piece);
  $UploadPiece->ProtectionUpload($libelle);

?>