<?php
include ("header.php");
?>
<body>
<div class="container">
  <h2>Création d'une matiére</h2>
  <form action="AddMatiereView.php" method="post">

    <div class="form-group">
      <label for="Code_matiere">Code:</label>
      <input type="text" class="form-control" id="Code_matiere" placeholder="Code" name="Code_matiere">
    </div>

    <div class="form-group">
      <label for="Libelle_matiere">Libéllé:</label>
      <input type="text" class="form-control" id="Libelle_matiere" placeholder="Libellé" name="Libelle_matiere">
    </div>

    <div class="form-group">
      <label for="Prix_matiere">Prix:</label>
      <input type="text" class="form-control" id="Prix_matiere" placeholder="Prix" name="Prix_matiere">
    </div>

    <div class="form-group form-check">
      <label class="form-check-label">

    <button name="go" type="submit" value="" class="btn btn-primary"">Envoyer</button>
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