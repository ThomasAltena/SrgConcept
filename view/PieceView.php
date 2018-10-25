<?php
include('header.php');

/* Mise en place de la base de donnée */
$db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
$ManagerPiece = new PieceManager($db); //Connexion a la BDD


/** Get tout les utlisateurs **/

echo("
<body>
<div class='container'>
<table class='table table-striped'>
  <thead>
    <tr>
      <th scope='col'>Libelle</th>
      <th scope='col'>Chemin</th>
      <th scope='col'>Code</th>
      <th scope='col'>Image</th>
      <th></th>
    </tr>
  </thead>
  <tbody>");

$pieces = $ManagerPiece->GetPieces();
foreach ($pieces as $piece){
    echo("<tr>");
    echo("<td>" .$piece->GetLibelle(). "</td>");
    echo("<td>" .$piece->GetChemin(). "</td>");
    echo("<td>" .$piece->GetCode(). "</td>");
    echo("<td><img src=".$piece->GetChemin()."></td>");
    echo ("<td> <button onclick='supp(".$piece->GetId().")' class='btn btn-danger'><span class='fas fa-times'></span></button></td>");
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
  document.location.href="DeletePieceView.php?id="+id}else{return false;}
}

function edit(id)
{
  document.location.href="EditPieceView.php?id="+id
}

</script>