<?php
session_start();

if(empty($_SESSION)){
    header('location:/SrgConcept/view/index.php');

} else {
    include('header.php');
}
?>

<link rel="stylesheet" href="../public/css/form.css" type="text/css">

<body>
<div class="container">
    <form id="formbox" action="AddMatiereView.php" method="post">
        <div class="table-title">
            <h3>Création d'une matiére</h3>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" style="width:100px" id="Code_matiere_label">Code:</span>
            </div>
            <input required="true" type="text" class="form-control" placeholder="Code" name="Code_matiere" id="Code_matiere" aria-describedby="Code_matiere_label">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" style="width:100px" id="Libelle_matiere_label">Libéllé:</span>
            </div>
            <input required="true" type="text" class="form-control" placeholder="Libéllé" name="Libelle_matiere" id="Libelle_matiere" aria-describedby="Libelle_matiere_label">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" style="width:100px" id="Prix_matiere_label">Prix:</span>
            </div>
            <input required="true" type="number" class="form-control" placeholder="Prix" name="Prix_matiere" id="Prix_matiere" aria-describedby="Prix_matiere_label">
        </div>

        <div class="form-group form-check">
            <button name="go" type="submit" value="" class="btn btn-primary"">Envoyer</button>
        </div>
    </form>
</div>

<?php
  
  if(isset($_POST['go'])){

    if($_POST['Code_matiere'] != "" && $_POST['Libelle_matiere'] != "" &&  $_POST['Prix_matiere'] != ""){
      
    /* Assignation var */
    $id = "";
    $code = $_POST['Code_matiere'];
    $libelle = $_POST['Libelle_matiere'];
    $prix = $_POST['Prix_matiere'];

    /* Construct */
    $matiere = new Matiere([
    "Id_matiere" => $id,
    "Code_matiere" => $code ,
    "Libelle_matiere" => $libelle ,
    "Prix_matiere" => $prix ,
    ]);

    /* BDD*/
  $db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
  $ManagerMatiere = new MatiereManager($db); //Connexion a la BDD


  /** Ajout **/
  $ManagerMatiere->AddMatiere($matiere);

  echo("<div class='alert alert-success'><strong>Félicitation !  </strong> Le nouvelle matiére a été ajoutée.</div>");
}else{
  echo("<div class='alert alert-danger'><strong>Inforamtion :  </strong>Remplissez les champs obligatoires.</div>");
}

}
?>
</div>
</body>