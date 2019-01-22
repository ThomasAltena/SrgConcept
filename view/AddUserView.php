<?php
session_start();

if(empty($_SESSION)){
    header('location:index.php');
} else {
    include('header.php');
}
?>
<link rel="stylesheet" href="../public/css/form.css" type="text/css">

  <body>
<div class="container">
    <form id="formbox" action="AddUserView.php" method="post">
        <div class="table-title">
            <h3>Création d'utilisateur</h3>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" style="width:100px" id="Nom_user_label">Nom:</span>
            </div>
            <input required="true" type="text" class="form-control" placeholder="Nom" name="Nom_user" id="Nom_user" aria-describedby="Nom_user_label">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" style="width:100px" id="Adresse_user_label">Adresse:</span>
            </div>
            <input required="true" type="text" class="form-control" placeholder="Adresse" name="Adresse_user" id="Adresse_user" aria-describedby="Adresse_user_label">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" style="width:100px" id="Siret_user_label">Siret:</span>
            </div>
            <input required="true" type="text" class="form-control" placeholder="SIRET" name="Siret_user" id="Siret_user" aria-describedby="Siret_user_label">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" style="width:100px" id="Pseudo_user_label">Pseudo:</span>
            </div>
            <input required="true" type="text" class="form-control" placeholder="Pseudo" name="Pseudo_user" id="Pseudo_user" aria-describedby="Pseudo_user_label">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="Pass_user_label">Mot de passe: *</span>
            </div>
            <input required="true" type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$"
                   class="form-control" placeholder="Mot de passe"
                   name="Pass_user" id="Pass_user" aria-describedby="Pass_user_label">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="Pass_user2_label">Mot de passe: *</span>
            </div>
            <input required="true" type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$"
                   class="form-control" placeholder="Répéter mot de passe"
                   name="Pass_user2" id="Pass_user2" aria-describedby="Pass_user2_label">
        </div>
        <div class="form-group form-check">
            <button name="go" type="submit" value="" class="btn btn-primary"">Créer</button>
        </div>
        <span style="margin:5px 5px 5px 10px; font-size: small">* Le mot de passe doit se composer d'une majuscule, une minuscule et un chiffre.</span>
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
