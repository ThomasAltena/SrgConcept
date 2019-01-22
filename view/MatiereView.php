<link rel="stylesheet" href="../public/css/table.css" type="text/css">

<?php

include('header.php');



/* Mise en place de la base de donnée */
$db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
$ManagerMatiere = new MatiereManager($db); //Connexion a la BDD


/** Get toutes les matiéres **/

echo("

<body>
<div class='container'>
<br>
<input class='form-control' id='myInput' type='text' placeholder='Recherche..'>
<table class='table table-striped' style='margin:10px 0;'>
  <thead>
    <tr>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Id</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Code</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Libéllé</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Prix</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'></th>
    </tr>
  </thead>
  <tbody id='myTable'>");

$matieres = $ManagerMatiere->GetMatieres();
foreach ($matieres as $matiere){
    echo("<tr>");
    echo("<td>" .$matiere->GetId() . "</td>");
    echo("<td>" .$matiere->GetCode(). "</td>");
    echo("<td>" .$matiere->GetLibelle(). "</td>");
    echo("<td>" .$matiere->GetPrix(). "</td>");
    echo ("<td><button  onclick='edit(".$matiere->GetId().")' class='btn btn-primary'><span class='fas fa-edit'></span></button> <button onclick='supp(".$matiere->GetId().")' class='btn btn-danger'><span class='fas fa-times'></span></button></td>");
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
  document.location.href="DeleteMatiereView.php?id="+id}else{return false;}
}

function edit(id)
{
  document.location.href="EditMatiereView.php?id="+id
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