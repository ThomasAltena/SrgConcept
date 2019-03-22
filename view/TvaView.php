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
$ManagerTva = new TvaManager($db); //Connexion a la BDD

if (isset($_GET['taux'])){
  $NewTva = new Tva([
    "Id_tva" => "" ,
    "Taux_tva" => $_GET['taux'],
  ]);
  $ManagerTva->AddTva($NewTva);

}else{

}



/** Get tout les utlisateurs **/

echo("

<body>
<br/>
  <form action='TVAView.php' class='form-mid form-inline' method='get'>
    <input style='margin-right:3%;' type='text' class='form-control' name='taux' required='required' placeholder='Taux'>
    <input class='btn btn-success' type='submit' >
  </form>


<br/>
<div class='container col-7'>
<table class='table table-striped' style='margin:10px 0;'>
  <thead>
    <tr>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Id</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Taux</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'></th>
    </tr>
  </thead>
  <tbody>");

$tvas = $ManagerTva->GetTva();
foreach ($tvas as $tva){
    echo("<tr>");
    echo("<td>" . $tva->GetId() . "</td>");
    echo("<td>" .$tva->GetTaux(). "</td>");
    echo ("<td> <button style='margin-left:30%;' onclick='supp(".$tva->GetId().")' class='btn btn-danger'><span class='fas fa-times'></span></button></td>");
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
  document.location.href="DeleteTauxView.php?id="+id}else{return false;}
}

</script>
