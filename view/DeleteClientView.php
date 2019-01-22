<?php
session_start();

if(empty($_SESSION)){
	//Session inexistant
    header('location:index.php');
}else{
    include('header.php');
    require('../model/ClientManager.php');
	require('../model/ClientClass.php');
	//session existe
	$id = $_GET['id'];
	$db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
  	$ManagerClient = new ClientManager($db); //Connexion a la BDD
  	$ManagerClient->DeleteClient($id);
  	header('Location:ClientView.php');


}
