<?php
include ("header.php");

  ?>
  <body>
<div class="container">
  <h2>Création d'utilisateur</h2>
  <form action="AddUserView.php" method="post">

    <div class="form-group">
      <label for="Nom_user">Nom: *</label>
      <input type="text" class="form-control" id="Nom_user" placeholder="Nom" name="Nom_user">
    </div>

    <div class="form-group">
      <label for="Adresse_user">Adresse: *</label>
      <input type="text" class="form-control" id="Adresse_user" placeholder="Adresse" name="Adresse_user">
    </div>

    <div class="form-group">
      <label for="Siret_user">Siret:</label>
      <input type="text" class="form-control" id="Siret_user" placeholder="SIRET" name="Siret_user">
    </div>


    <div class="form-group">
      <label for="Pseudo_user">Pseudo: *</label>
      <input type="text" class="form-control" id="Pseudo_user" placeholder="Pseudo" name="Pseudo_user">
    </div>

    <div class="form-group">
      <label for="Pass_user">Mot de passe: * </label>
      <input type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" class="form-control" id="Pass_user" placeholder="Le mot de passe doit se composer d'une majuscule, une minuscule et un chiffre" name="Pass_user">
    </div>

    <div class="form-group">
      <label for="Pass_user2">Répéter mot de passe: * </label>
      <input type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" class="form-control" id="Pass_user2" placeholder="Le mot de passe doit se composer d'une majuscule, une minuscule et un chiffre" name="Pass_user2">
    </div>


    <div class="form-group form-check">
      <label class="form-check-label"></label>

    <button name="go" type="submit" value="" class="btn btn-primary"">Créer</button>
  </div>

  </form>


<?php
  
  if(isset($_POST['go'])){

    if($_POST['Nom_user'] != "" && $_POST['Adresse_user'] != "" && $_POST['Pseudo_user'] != "" && $_POST['Pass_user'] != "" && $_POST['Pass_user2'] != "" && $_POST['Pass_user'] ==  $_POST['Pass_user2']){
      
    /* Assignation var */
    $nom = $_POST['Nom_user'];
    $adresse=  $_POST['Adresse_user'];
    $psd= $_POST['Pseudo_user'];
    $pass= password_hash($_POST['Pass_user'], PASSWORD_DEFAULT);
    $siret= $_POST['Siret_user'];

    /* Construct */
    $user = new Utilisateur([
    "Id_user" => "" ,
    "Nom_user" => $nom ,
    "Adresse_user" => $adresse ,
    "DateCo_user" => "" ,
    "Siret_user" => $siret ,
    "Pseudo_user" => $psd ,
    "Pass_user" => $pass ,
    "Role_user" => "0" ,
    ]);

    /* BDD*/
  $db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
  $ManagerUser = new UserManager($db); //Connexion a la BDD


  /** Ajout **/
  $ManagerUser->AddUser($user);

  echo("<div class='alert alert-success'><strong>Félicitation !  </strong> L'utilisateur a été crée.</div>");
}else{
  echo("<div class='alert alert-danger'><strong>Inforamtion :  </strong>Remplissez les champs obligatoires.</div>");
}

}
?>
</div>
</body>
