<?php
include('header.php');
?>

<link rel="stylesheet" href="../public/css/table.css" type="text/css">

<?php
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
      <th class=\"text-left\" scope='col'>Nom</th>
      <th class=\"text-left\" scope='col'>Prenom</th>
      <th class=\"text-left\" scope='col'>Adresse</th>
      <th class=\"text-left\" scope='col'>Code postal</th>
      <th class=\"text-left\" scope='col'>Ville</th>
      <th class=\"text-left\" scope='col'>Téléphone</th>
      <th class=\"text-left\" scope='col'>Mail</th>
      <th class=\"text-left\" scope='col'>Date de création</th>
      <th class=\"text-left\" scope='col'></th>
    </tr>
  </thead>
  <tbody>");


$clients = $ManagerClient->GetClients($_SESSION['Id_user']);
if($clients){
    var_dump($clients);

    foreach ($clients as $client){
        echo("<tr>");
        echo("<td class=\"text-left\">" .$client->GetNom(). "</td>");
        echo("<td class=\"text-left\">" .$client->GetPrenom(). "</td>");
        echo("<td class=\"text-left\">" .$client->GetAdresse(). "</td>");
        echo("<td class=\"text-left\">" .$client->GetCodePostal(). "</td>");
        echo("<td class=\"text-left\">" .$client->GetVille(). "</td>");
        echo("<td class=\"text-left\">" .$client->GetTel(). "</td>");
        echo("<td class=\"text-left\">" .$client->GetMail(). "</td>");
        echo("<td class=\"text-left\">" .$client->GetDateCreation(). "</td>");
        echo ("<td class=\"text-left\"><button  onclick='edit(".$client->GetId().")' class='btn btn-primary'><span class='fas fa-edit'></span></button> <button onclick='supp(".$client->GetId().")' class='btn btn-danger'><span class='fas fa-times'></span></button></td>");
        echo ("</tr>");
    }
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
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Nom</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Prenom</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Adresse</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Code postal</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Ville</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Téléphone</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Mail</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Date de création</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'></th>
    </tr>
  </thead>
  <tbody>");

      $clientsAdmin = $ManagerClient->GetClientsAdmin();
      if ($clientsAdmin) {
          foreach ($clientsAdmin as $clientAdmin) {
              //var_dump($clientAdmin->GetDateCreation());
              echo("<tr>");
              echo("<td class=\"text-left\">" . $clientAdmin->GetNom() . "</td>");
              echo("<td class=\"text-left\">" . $clientAdmin->GetPrenom() . "</td>");
              echo("<td class=\"text-left\">" . $clientAdmin->GetAdresse() . "</td>");
              echo("<td class=\"text-left\">" . $clientAdmin->GetCodePostal() . "</td>");
              echo("<td class=\"text-left\">" . $clientAdmin->GetVille() . "</td>");
              echo("<td class=\"text-left\">" . $clientAdmin->GetTel() . "</td>");
              echo("<td class=\"text-left\">" . $clientAdmin->GetMail() . "</td>");
              echo("<td class=\"text-left\">" . $clientAdmin->GetDateCreation() . "</td>");
              echo("<td class=\"text-left\"><button  onclick='edit(" . $clientAdmin->GetId() . ")' class='btn btn-primary'><span class='fas fa-edit'></span></button> <button onclick='supp(" . $clientAdmin->GetId() . ")' class='btn btn-danger'><span class='fas fa-times'></span></button></td>");
              echo("</tr>");
          }
    }
}

echo ("</tbody>
    </table>
</div class='container'>
    </body>
");


}
?>

<script>

function supp(id)
{
  if(window.confirm('Etes vous sur ?')){
  document.location.href="DeleteClientView.php?id="+id}else{return false;}
}

function edit(id)
{
  document.location.href="EditClientView.php?id="+id
}

$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>