<link rel="stylesheet" href="../public/css/table.css" type="text/css">

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
      <th class=\"text-left\" scope='col'>Couleurs</th>
      <th class=\"text-left\" scope='col'>Hexadécimal</th>
      <th class=\"text-left\" scope='col'></th>
      <th class=\"text-left\" scope='col'></th>
    </tr>
  </thead>
  <tbody>");

$couleurs = $ManagerCouleur->GetCouleurs();
foreach ($couleurs as $couleur){
    echo("<tr>");
    echo("<td class=\"text-left\">" . $couleur->GetLibelle() . "</td>");
    echo("<td class=\"text-left\">" .$couleur->GetHexa(). "</td>");
    echo ("<td class=\"text-left\"><button  onclick='edit(".$couleur->GetId().")' class='btn btn-primary'><span class='fas fa-edit'></span></button> <button onclick='supp(".$couleur->GetId().")' class='btn btn-danger'><span class='fas fa-times'></span></button></td>");
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