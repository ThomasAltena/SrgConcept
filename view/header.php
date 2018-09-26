<?php 
session_start();
header("Cache-Control:no-cache");

require('../model/UserManager.php');
require('../model/UserClass.php');
 ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../public/css/normalize.css">
	
	<!--  Glyphicon  -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">


	
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js" integrity="sha384-pjaaA8dDz/5BgdFUPX6M/9SUZv4d12SUPF0axWc+VRZkx5xU3daN+lYb49+Ax+Tl" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="../public/css/main.css">
</head>

  <header>
	  	<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
			<!-- Brand -->
			<a class="navbar-brand" href="#">Accueil</a>
	
		<!-- Links -->
		<ul class="navbar-nav">
		<li class="nav-item"><a class="nav-link" href="#">Matières</a></li>
		<li class="nav-item"><a class="nav-link" href="#">Pièces</a></li>
	
	
		<?php		
		//var_dump($_SESSION);
		/* Verif si la session est vide */
		if(!empty($_SESSION)){
		  if($_SESSION['Role_user'] == 1){             //Si c'est un admin on ajoute les menus  
		
				echo("<li class='nav-item'><a class='nav-link' href='UserView.php'>Gestion utilisateur</a></li>");
				echo("<li class='nav-item'><a class='nav-link' href='AddUserView.php'>Ajouter un utilisateur</a></li>");
			}
		}
		         //Si la connexion est bonne ou pas         
		    if(isset($_SESSION['Id_user'])){
		        	echo("<li class='nav-item'><a class='btn btn-outline-danger my-2 my-sm-0' href='Logout.php'>Deconnexion</a></li>");
		     }
		     else {
		    	 echo("<li class='nav-item'><a class='btn btn-outline-success my-2 my-sm-0' href='ConnexionView.php'>Connexion</a> </li>");
		     }
	?> 
	</ul>
    </nav>
  </header>

