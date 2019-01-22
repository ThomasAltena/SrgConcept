<link rel="stylesheet" href="../public/css/table.css" type="text/css">

<?php

include('header.php');



/* Mise en place de la base de donnée */
$db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
$ManagerUser = new UserManager($db); //Connexion a la BDD


/** Get tout les utlisateurs **/

echo("

<body>
<div class='container'>
<table class='table table-striped'>
  <thead>
    <tr>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Nom</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Adresse</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Siret</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Id</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'></th>
    </tr>
  </thead>
  <tbody>");

$users = $ManagerUser->GetUsers();
foreach ($users as $unUser){
    echo("<tr>");
    echo("<td>" . $unUser->GetNom() . "</td>");
    echo("<td>" .$unUser->GetAdresse(). "</td>");
    echo("<td>" .$unUser->GetSiret(). "</td>");
    echo("<td>" .$unUser->GetId(). "</td>");
    echo ("<td><button  onclick='edit(".$unUser->GetId().")' class='btn btn-primary'><span class='fas fa-edit'></span></button> <button onclick='supp(".$unUser->GetId().")' class='btn btn-danger'><span class='fas fa-times'></span></button></td>");
    echo ("</tr>");
}

echo ("</tbody>
    </table>
</div class='container'>
    </body>
");

?>

<script>
function supp(id)
{
  if(window.confirm('Etes vous sur ?')){
  document.location.href="DeleteUserView.php?id="+id}else{return false;}
}

function edit(id)
{
  document.location.href="EditUserView.php?id="+id
}

</script>