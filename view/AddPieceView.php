<?php
include ("header.php");
?>
<body>
<div class="container">
  <h2>Création d'une matiére</h2>
  <form action="AddPieceView.php" method="post" enctype="multipart/form-data">

    <div class="form-group">
      <label for="Libelle_piece">Libellé:</label>
      <input type="text" class="form-control" id="Libelle_piece" placeholder="Libellé" name="Libelle_piece">
    </div>

    <div class="form-group">
      <label for="Code_piece">Code:</label>
      <input type="text" class="form-control" id="Code_piece" placeholder="Code" name="Code_piece">
    </div>

    <div class="form-group">
      <input type="file" id="fileToUpload" placeholder="Image" name="fileToUpload">
    </div>

    <button name="submit" type="submit" value="" class="btn btn-primary"">Envoyer</button>
  </form>
</div>

<?php
  
  if(isset($_POST['submit'])){

    if($_POST['Libelle_piece'] != "" && $_POST['Code_piece'] != ""){
      
    /* Assignation var */
    $id = "";
    $libelle = $_POST['Libelle_piece'];
    $code = $_POST['Code_piece'];
    //$image = $_POST['fileToUpload'];

    /* Construct */
    $piece = new Piece([
    "Id_piece" => $id,
    "Libelle_piece" => $libelle,
    "Code_piece" => $code,
    //"fileToUpload" => $image,
    ]);

    /* BDD*/
  $db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
  $ManagerPiece = new PieceManager($db); //Connexion a la BDD
  $UploadPiece = new Upload();


  /** Ajout **/
  $ManagerPiece->AddPiece($piece);
  $UploadPiece->ProtectionUpload($libelle);

  echo("<div class='alert alert-success'><strong>Félicitation !  </strong> Le nouvelle piéce a été ajoutée.</div>");
}else{
  echo("<div class='alert alert-danger'><strong>Inforamtion :  </strong>Remplissez les champs obligatoires.</div>");
}

}

?>
</div>
</body>