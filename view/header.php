<?php 
session_start();
header("Cache-Control:no-cache");

require('../model/ClientManager.php');
require('../model/ClientClass.php');

require('../model/UserManager.php');
require('../model/UserClass.php');

require('../model/MatiereManager.php');
require('../model/MatiereClass.php');

require('../model/PieceManager.php');
require('../model/PieceClass.php');

require('../model/CouleurManager.php');
require('../model/CouleurClass.php');

require('../model/TvaManager.php');
require('../model/TvaClass.php');

require('../model/OptionManager.php');
require('../model/OptionClass.php');

require('../model/LigneDevisClass.php');
require('../model/LigneDevisManager.php');

require('../model/Upload.php');
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
		
				echo("<li class='nav-item'><div class='dropdown '><a class='dropdown-toggle nav-link' href='UserView.php' role='button' id='dropdownMenuLink' data-toggle='dropdown'>Utilisateurs</a><div class='dropdown-menu' aria-labelledby='dropdownMenuLink'><a class='dropdown-item' href='UserView.php'>Liste</a><a class='dropdown-item' href='AddUserView.php'>Création</a></div></div></li>");


				echo("<li class='nav-item'><div class='dropdown '><a class='dropdown-toggle nav-link' href='ClientView.php' role='button' id='dropdownMenuLink' data-toggle='dropdown'>Clients</a><div class='dropdown-menu' aria-labelledby='dropdownMenuLink'><a class='dropdown-item' href='ClientView.php'>Liste</a><a class='dropdown-item' href='AddClientView.php'>Création</a></div></div></li>");

				echo("<li class='nav-item'><div class='dropdown '><a class='dropdown-toggle nav-link' href='UserView.php' role='button' id='dropdownMenuLink' data-toggle='dropdown'>Matiéres</a><div class='dropdown-menu' aria-labelledby='dropdownMenuLink'><a class='dropdown-item' href='MatiereView.php'>Liste</a><a class='dropdown-item' href='AddMatiereView.php'>Création</a></div></div></li>");

				echo("<li class='nav-item'><div class='dropdown '><a class='dropdown-toggle nav-link' href='PieceView.php' role='button' id='dropdownMenuLink' data-toggle='dropdown'>Piéces</a><div class='dropdown-menu' aria-labelledby='dropdownMenuLink'><a class='dropdown-item' href='PieceView.php'>Liste</a><a class='dropdown-item' href='AddPieceView.php'>Création</a></div></div></li>");

				echo("<li class='nav-item'><div class='dropdown '><a class='dropdown-toggle nav-link' href='CouleurView.php' role='button' id='dropdownMenuLink' data-toggle='dropdown'>Couleurs</a><div class='dropdown-menu' aria-labelledby='dropdownMenuLink'><a class='dropdown-item' href='CouleurView.php'>Liste</a></div></div></li>");

				echo("<li class='nav-item'><div class='dropdown '><a class='dropdown-toggle nav-link' href='TvaView.php' role='button' id='dropdownMenuLink' data-toggle='dropdown'>TVA</a><div class='dropdown-menu' aria-labelledby='dropdownMenuLink'><a class='dropdown-item' href='TvaView.php'>Liste</a></div></div></li>");

				echo("<li class='nav-item'><div class='dropdown '><a class='dropdown-toggle nav-link' href='OptionView.php' role='button' id='dropdownMenuLink' data-toggle='dropdown'>Options</a><div class='dropdown-menu' aria-labelledby='dropdownMenuLink'><a class='dropdown-item' href='OptionView.php'>Liste</a></div></div></li>");

				echo("<li class='nav-item'><div class='dropdown '><a class='dropdown-toggle nav-link' href='UserView.php' role='button' id='dropdownMenuLink' data-toggle='dropdown'>Devis</a><div class='dropdown-menu' aria-labelledby='dropdownMenuLink'><a class='dropdown-item' href='UserView.php'>Liste</a><a class='dropdown-item' href='Devis.php'>Création</a></div></div></li>");



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

