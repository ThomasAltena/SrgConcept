<?php 
session_start();
if(empty($_SESSION)){
	//Session inexistant
	header('Location:ConnexionView.php');
}else{
	require('../model/UserManager.php');
	require('../model/UserClass.php');
	//session existe
	$id = $_GET['id'];
	$db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
  	$ManagerUser = new UserManager($db); //Connexion a la BDD
  	$ManagerUser->DeleteUser($id);
  	header('Location:UserView.php');


}