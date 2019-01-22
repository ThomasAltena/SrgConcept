
<?php
session_start();
if(empty($_SESSION)){
	//Session inexistant
    header('location:index.php');
}else{
    include('header.php');
	require('../model/MatiereManager.php');
	require('../model/MatiereClass.php');
	//session existe
	$id = $_GET['id'];
	var_dump($id);
	$db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
  	$ManagerUser = new MatiereManager($db); //Connexion a la BDD
  	$ManagerUser->DeleteMatiere($id);
  	header('Location:MatiereView.php');
}