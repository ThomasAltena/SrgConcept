<?php

include('header.php');



/* Mise en place de la base de donnée */
$db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
$ManagerClient = new ClientManager($db); //Connexion a la BDD

if(!empty($_SESSION)){
		  if($_SESSION['Role_user'] != 1){  
/** Get tout les utlisateurs **/

echo("

<body>
<div class='container'>
<table class='table table-striped'>
  <thead>
    <tr>
      <th scope='col'>Nom</th>
      <th scope='col'>Prenom</th>
      <th scope='col'>Adresse</th>
      <th scope='col'>Code postal</th>
      <th scope='col'>Ville</th>
      <th scope='col'>Téléphone</th>
      <th scope='col'>Mail</th>
      <th scope='col'>Date de création</th>
      <th scope='col'></th>
      <th scope='col'></th>
    </tr>
  </thead>
  <tbody>");
$iduser = $_SESSION['Id_user'];
$clients = $ManagerClient->GetClients($iduser);
foreach ($clients as $client){
    echo("<tr>");
    echo("<td>" .$client->GetNom(). "</td>");
    echo("<td>" .$client->GetPrenom(). "</td>");
    echo("<td>" .$client->GetAdresse(). "</td>");
    echo("<td>" .$client->GetCodePostal(). "</td>");
    echo("<td>" .$client->GetVille(). "</td>");
    echo("<td>" .$client->GetTel(). "</td>");
    echo("<td>" .$client->GetMail(). "</td>");
    echo("<td>" .$client->GetDateCreation(). "</td>");
    echo ("<td><button  onclick='edit(".$client->GetId().")' class='btn btn-primary'><span class='fas fa-edit'></span></button> <button onclick='supp(".$client->GetId().")' class='btn btn-danger'><span class='fas fa-times'></span></button></td>");
    echo ("</tr>");
}

echo ("</tbody>
    </table>
</div class='container'>
    </body>
");

}else {
echo("

<body>
<div class='container'>
<table class='table table-striped'>
  <thead>
    <tr>
      <th scope='col'>Nom</th>
      <th scope='col'>Prenom</th>
      <th scope='col'>Adresse</th>
      <th scope='col'>Code postal</th>
      <th scope='col'>Ville</th>
      <th scope='col'>Téléphone</th>
      <th scope='col'>Mail</th>
      <th scope='col'>Date de création</th>
      <th scope='col'></th>
      <th scope='col'></th>
    </tr>
  </thead>
  <tbody>");

$clientsAdmin = $ManagerClient->GetClientsAdmin();
foreach ($clientsAdmin as $clientAdmin){
	//var_dump($clientAdmin->GetDateCreation());
    echo("<tr>");
    echo("<td>" .$clientAdmin->GetNom() . "</td>");
    echo("<td>" .$clientAdmin->GetPrenom(). "</td>");
    echo("<td>" .$clientAdmin->GetAdresse(). "</td>");
    echo("<td>" .$clientAdmin->GetCodePostal(). "</td>");
    echo("<td>" .$clientAdmin->GetVille(). "</td>");
    echo("<td>" .$clientAdmin->GetTel(). "</td>");
    echo("<td>" .$clientAdmin->GetMail(). "</td>");
    echo("<td>" .$clientAdmin->GetDateCreation(). "</td>");
    echo ("<td><button  onclick='edit(".$clientAdmin->GetId().")' class='btn btn-primary'><span class='fas fa-edit'></span></button> <button onclick='supp(".$clientAdmin->GetId().")' class='btn btn-danger'><span class='fas fa-times'></span></button></td>");
    echo ("</tr>");
}
}

echo ("</tbody>
    </table>
</div class='container'>
    </body>
");


}
?>