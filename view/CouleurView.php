<?php

include('header.php');



/* Mise en place de la base de donnée */
$db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
$ManagerCouleur = new CouleurManager($db); //Connexion a la BDD


/** Get tout les utlisateurs **/

echo("

<body>
<div class='container'>
<table class='table table-striped'>
  <thead>
    <tr>
      <th scope='col'>Couleurs</th>
      <th scope='col'>Hexadécimal</th>
      <th scope='col'></th>
      <th scope='col'></th>
    </tr>
  </thead>
  <tbody>");

$couleurs = $ManagerCouleur->GetCouleurs();
foreach ($couleurs as $couleur){
    echo("<tr>");
    echo("<td>" . $couleur->GetLibelle() . "</td>");
    echo("<td>" .$couleur->GetHexa(). "</td>");
    echo ("<td><button  onclick='edit(".$couleur->GetId().")' class='btn btn-primary'><span class='fas fa-edit'></span></button> <button onclick='supp(".$couleur->GetId().")' class='btn btn-danger'><span class='fas fa-times'></span></button></td>");
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