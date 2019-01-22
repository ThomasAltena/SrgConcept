<?php
include ("header.php");
?>
<link rel="stylesheet" href="../public/css/form.css" type="text/css">
<body>
<div class="container">
    <form id="formbox" action="AddPieceView.php" method="post" enctype="multipart/form-data">
        <div class="table-title">
            <h3>Création d'une piéce</h3>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" style="width:100px" id="Libelle_piece_label">Libellé:</span>
            </div>
            <input required="true" type="text" class="form-control" placeholder="Libellé" name="Libelle_piece" id="Libelle_piece" aria-describedby="Libelle_piece_label">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" style="width:100px" id="Code_piece_label">Code:</span>
            </div>
            <input required="true" type="text" class="form-control" placeholder="Code" name="Code_piece" id="Code_piece" aria-describedby="Code_piece_label">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="fileToUpload_label">Upload</span>
            </div>
            <div class="custom-file">
                <input required="true" type="file" class="custom-file-input" placeholder="Image" id="fileToUpload" aria-describedby="fileToUpload_label">
                <label class="custom-file-label" for="inputGroupFile01">Choisir Image</label>
            </div>
        </div>

        <div class="form-group form-check">
            <button name="submit" type="submit" value="" class="btn btn-primary"">Envoyer</button>
        </div>

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