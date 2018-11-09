<?php

include('header.php');



/* Mise en place de la base de donnée */
$db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
$ManagerOption = new OptionManager($db); //Connexion a la BDD


/** Get tout les utlisateurs **/

echo("

<body>
<div class='container'>
<table class='table table-striped'>
  <thead>
    <tr>
      <th scope='col'>Libelle</th>
      <th scope='col'>Code</th>
      <th scope='col'>Prix</th>
      <th scope='col'></th>
    </tr>
  </thead>
  <tbody>");

$options = $ManagerOption->GetOptions();
foreach ($options as $option){
    echo("<tr>");
    echo("<td>" . $option->GetLibelle() . "</td>");
    echo("<td>" . $option->GetCode() . "</td>");
    echo("<td>" .$option->GetPrix(). "</td>");
    echo ("<td><button  onclick='edit(".$option->GetId().")' class='btn btn-primary'><span class='fas fa-edit'></span></button> <button onclick='supp(".$option->GetId().")' class='btn btn-danger'><span class='fas fa-times'></span></button></td>");
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