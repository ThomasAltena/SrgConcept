<?php 
session_start();
header("Cache-Control:no-cache");

require('../model/ClientManager.php');
require('../model/ClientClass.php');
require('../model/UserManager.php');
require('../model/UserClass.php');
 ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../public/css/normalize.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	
	<!--  Glyphicon  -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../public/css/main.css">
</head>

  <header>
	  	<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
			<!-- Brand -->
			<a class="navbar-brand" href="#">Accueil</a>
	
		<!-- Links -->
		<ul class="navbar-nav">

	
	
		<?php		
		//var_dump($_SESSION);
		/* Verif si la session est vide */
		if(!empty($_SESSION)){
		  if($_SESSION['Role_user'] == 1){             //Si c'est un admin on ajoute les menus  
		
				echo("<li class='nav-item'><div class='dropdown '><a class='dropdown-toggle nav-link' href='UserView.php' role='button' id='dropdownMenuLink' data-toggle='dropdown'>Gestion des utilisateurs</a><div class='dropdown-menu' aria-labelledby='dropdownMenuLink'><a class='dropdown-item' href='UserView.php'>Liste</a><a class='dropdown-item' href='AddUserView.php'>Création</a></div></div></li>");
				echo("<li class='nav-item'><div class='dropdown '><a class='dropdown-toggle nav-link' href='ClientView.php' role='button' id='dropdownMenuLink' data-toggle='dropdown'>Gestion des clients</a><div class='dropdown-menu' aria-labelledby='dropdownMenuLink'><a class='dropdown-item' href='ClientView.php'>Liste</a><a class='dropdown-item' href='AddClientView.php'>Création</a></div></div></li>");
				echo("<li class='nav-item'><a class='nav-link' href='#'>Matières</a></li>");
				echo("<li class='nav-item'><a class='nav-link' href='#'>Pièces</a></li>");
			}else{ //C'est pas des admin afficher

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

