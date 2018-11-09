 <?php 
session_start();
if(empty($_SESSION)){
	//Session inexistant
	header('Location:ConnexionView.php');
}else{
	require('../model/PieceManager.php');
	require('../model/PieceClass.php');
	//session existe
	$id = $_GET['id'];
	
	$db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
  	$ManagerPiece = new PieceManager($db); //Connexion a la BDD
  	$ManagerPiece->DeletePiece($id);
  	header('Location:PieceView.php');


}