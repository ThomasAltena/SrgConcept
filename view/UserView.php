<?php
session_start();

if(empty($_SESSION)){
    header('location:/SrgConcept/view/index.php');

} else {
    include('header.php');
}
?>

<link rel="stylesheet" href="../public/css/table.css" type="text/css">
<link rel="stylesheet" href="../public/css/form.css" type="text/css">

<?php
/* Mise en place de la base de donnée */
$db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
$ManagerUser = new UserManager($db); //Connexion a la BDD


/** Get tout les utlisateurs **/

echo("

<body>
<div class='container'>
<table class='table table-striped' style='margin:10px 0;'>
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

$users = $ManagerUser->GetAllUser();
foreach ($users as $unUser){
    echo("<tr>");
    echo("<td>" . $unUser->GetNomUser() . "</td>");
    echo("<td>" .$unUser->GetAdresseUser(). "</td>");
    echo("<td>" .$unUser->GetSiretUser(). "</td>");
    echo("<td>" .$unUser->GetIdUser(). "</td>");
    echo ("<td><button  onclick='edit(".$unUser->GetIdUser().")' class='btn btn-primary'><span class='fas fa-edit'></span></button> <button onclick='supp(".$unUser->GetIdUser().")' class='btn btn-danger'><span class='fas fa-times'></span></button></td>");
    echo ("</tr>");
}

echo ("</tbody>
    </table>
</div>
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
