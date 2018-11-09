<?php
include('header.php');

?>
<body>
<div class="container">
  <h2>Création d'un client</h2>
  <form action="AddClientView.php" method="post">

    <div class="form-group">
      <label for="Nom_client">Nom:</label>
      <input type="text" class="form-control" id="Nom_client" placeholder="Nom" name="Nom_client">
    </div>

    <div class="form-group">
      <label for="Prenom_client">Prenom:</label>
      <input type="text" class="form-control" id="Prenom_client" placeholder="Prenom" name="Prenom_client">
    </div>

    <div class="form-group">
      <label for="Prospect_client">Prospect:</label>
      <input type="text" class="form-control" id="Prospect_client" placeholder="Prospect" name="Prospect_client">
    </div>

    <div class="form-group">
      <label for="Adresse_client">Adresse:</label>
      <input type="text" class="form-control" id="Adresse_client" placeholder="Adresse" name="Adresse_client">
    </div>

    <div class="form-group">
      <label for="Ville_client">Ville:</label>
      <input type="text" class="form-control" id="Ville_client" placeholder="Ville" name="Ville_client">
    </div>

    <div class="form-group">
      <label for="CodePostal_client">Code postal:</label>
      <input type="text" class="form-control" id="CodePostal_client" placeholder="Code Postal" name="CodePostal_client">
    </div>

    <div class="form-group">
      <label for="Mail_client">Mail:</label>
      <input type="text" class="form-control" id="Mail_client" placeholder="Email" name="Mail_client">
    </div>

    <div class="form-group">
      <label for="Tel_client">Teléphone:</label>
      <input type="text" class="form-control" id="Tel_client" placeholder="Teléphone" name="Tel_client">
    </div>

    <div class="form-group form-check">
      <label class="form-check-label">

    <button name="go" type="submit" value="" class="btn btn-primary"">Envoyer</button>
  </form>
</div>

<?php
  
  if(isset($_POST['go'])){

    if($_POST['Nom_client'] != "" || $_POST['Prenom_client'] != "" || $_POST['Prospect_client'] != ""  || $_POST['Adresse_client'] != "" || $_POST['Ville_client'] != "" || $_POST['CodePostal_client'] != "" || $_POST['DateCrea_client'] != "" || $_POST['Mail_client'] != "" || $_POST['Tel_client'] != ""){
      
    /* Assignation var */
    $nom = $_POST['Nom_client'];
    $prenom = $_POST['Prenom_client'];
    $prospect = $_POST['Prospect_client'];
    $adresse=  $_POST['Adresse_client'];
    $ville = $_POST['Ville_client'];
    $codepostal = $_POST['CodePostal_client'];
    $mail = $_POST['Mail_client'];
    $tel = $_POST['Tel_client'];
    $idUser = $_SESSION['Id_user'];

    /* Construct */
    $client = new Client([
    "Id_client" => "" ,
    "Nom_client" => $nom ,
    "Prenom_client" => $prenom ,
    "Prospect_client" => $prospect ,
    "Adresse_client" => $adresse ,
    "Ville_client" => $ville ,
    "CodePostal_client" => $codepostal ,
    "Mail_client" => $mail , 
    "Tel_client" => $tel ,
    "IdUser_client" => $idUser,
    ]);

    /* BDD*/
  $db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
  $ManagerClient = new ClientManager($db); //Connexion a la BDD


  /** Ajout **/
  $ManagerClient->AddClient($client);

  echo("<div class='alert alert-success'><strong>Félicitation !  </strong> Le client a été crée.</div>");
}else{
  echo("<div class='alert alert-danger'><strong>Inforamtion :  </strong>Remplissez les champs obligatoires.</div>");
}

}
?>
</div>
</body>