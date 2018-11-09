<?php

include('header.php');



/* Mise en place de la base de donnée */
$db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
$ManagerTva = new TvaManager($db); //Connexion a la BDD


/** Get tout les utlisateurs **/

echo("

<body>
<div class='container'>
<table class='table table-striped'>
  <thead>
    <tr>
      <th scope='col'>Id</th>
      <th scope='col'>Taux</th>
    </tr>
  </thead>
  <tbody>");

$tvas = $ManagerTva->GetTva();
foreach ($tvas as $tva){
    echo("<tr>");
    echo("<td>" . $tva->GetId() . "</td>");
    echo("<td>" .$tva->GetTaux(). "</td>");
    echo ("<td> <button onclick='supp(".$tva->GetId().")' class='btn btn-danger'><span class='fas fa-times'></span></button></td>");
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
  document.location.href="EditUserView.php?id="+id
}

</script>