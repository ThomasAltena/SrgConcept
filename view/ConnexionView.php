<?php
session_start();

if(empty($_SESSION)){
    header('location:index.php');
} else {
    include('header.php');
}
?>
    <body>
		<div class="container">
  		<h2>Connexion</h2>

  	<form action="ConnexionView.php" method="post">

    <div class="form-group">
      <label for="Pseudo_user">Pseudo:</label>
      <input type="text" class="form-control" id="Pseudo_user" placeholder="Pseudo" name="Pseudo_user">
    </div>


    <div class="form-group">
      <label for="Pass_user">Mot de passe:</label>
      <input type="password" class="form-control" id="Pass_user" placeholder="Mot de passe" name="Pass_user">
    </div>

    <div class="form-group form-check">
        <label class="form-check-label"></label>
		<button name="go" type="submit" value="" class="btn btn-primary"">Valider</button>
  	</div>
  	</form>

<?php
  if(isset($_POST['go'])){

    if($_POST['Pseudo_user'] != "" && $_POST['Pass_user'] != ""){
      
    /* Assignation var */
    $psd= $_POST['Pseudo_user'];
    $pass= $_POST['Pass_user'];


    /* BDD*/
  $db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
  $ManagerUser = new UserManager($db); //Connexion a la BDD

  $ManagerUser->ConnexionUser($psd,$pass);
    
	}
	else{
	  echo("<div class='alert alert-danger'><strong>Inforamtion :  </strong>Remplissez les deux champs.</div>");
	}
	

}else{
}


?>