<link rel="stylesheet" href="../public/css/table.css" type="text/css">

<?php

include('header.php');



/* Mise en place de la base de donnée */
$db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
$ManagerDevis = new DevisManager($db); //Connexion a la BDD

/** Get tout les devis d'un utilisateur **/

echo("
<body>
<div class='container'>
<table class='table table-striped'>
  <thead>
    <tr>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>N° Devis</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Libelle</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Code</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Date</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Image</th>
      <th style='border-top: 0px;' class=\"text-left\" ></th>
    </tr>
  </thead>
  <tbody>");
$iduser=1;
$devis = $ManagerDevis->GetDevis($iduser);
foreach ($devis as $devi){
    echo("<tr>");
    echo("<td>" .$devi->GetId()."</td>");
    echo("<td>" .$devi->GetLibelle()."</td>");
    echo("<td>" .$devi->GetCode()."</td>");
    echo("<td>" .$devi->GetDate()."</td>");
    echo("<td>" .$devi->GetCheminImage()."</td>");
    echo ("<td><button  onclick='edit(".$devi->GetId().")' class='btn btn-primary'><span class='fas fa-edit'></span></button> <button onclick='supp(".$devi->GetId().")' class='btn btn-danger'><span class='fas fa-times'></span></button></td>");
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
  document.location.href="DeleteCouleurView.php?id="+id}else{return false;}
}

function edit(id)
{
  document.location.href="devis.php?id="+id
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