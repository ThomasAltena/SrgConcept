<?php
session_start();

if(empty($_SESSION)){
    header('location:index.php');
} else {
    include('header.php');
}
?>

<link rel="stylesheet" href="../public/css/table.css" type="text/css">
<link rel="stylesheet" href="../public/css/form.css" type="text/css">

<?php
$idUser = $_SESSION['Id_user'];

/* Mise en place de la base de donnée */
$db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
$ManagerDevis = new DevisManager($db); //Connexion a la BDD
$ManagerClient = new ClientManager($db); //Connexion a la BDD

$clients = $ManagerClient->GetClientsAdmin();
/** Get tout les devis d'un utilisateur **/

?>
<body>
<div class='container'>
<table class='table table-striped' style='margin:10px 0;'>
  <thead>
    <tr>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>N° Devis</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Client</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Date</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Devis</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Fiche de Fabrication</th>
      <th style='border-top: 0px;' class=\"text-left\" scope='col'>Schema</th>
    </tr>
  </thead>
  <tbody>
<?php
//$devis = $ManagerDevis->GetDevis($idUser);
$query = 'SELECT * FROM devis WHERE IdUser_devis = '.$idUser.'';
$reponse = $db->query($query);

while ($devi = $reponse->fetch()){
    $clientId = $devi['IdClient_devis'];
    $currentClient;
    $clientlibelle = '';
   foreach ($clients as $client) {
      if($client->GetId() == $clientId){
        $currentClient = $client;
        $clientlibelle = ''.$currentClient->GetNom().' '.$currentClient->GetPrenom();
        break;
      }
   }

   ?>
    <tr>
    <td> <?php echo $devi['Id_devis']; ?> </td>
    <td> <?php echo $clientlibelle; ?></td>
    <td> <?php echo $devi['Date_devis']; ?></td>
    <td>
    <button onclick='getDevis(<?php echo $devi['Id_devis']; ?>)' class='btn btn-link'>Voir</button>
    <button onclick='' class='btn btn-link'>Modifier</span></button>
    <button onclick='' class='btn btn-link'>Télécharger</span></button>
    </td>
    <td>
    <?php
        if($devi['CheminFicheFab_devis'] != ''){
          ?>
          <button onclick='loadModalData(<?php echo json_encode($devi); ?> , "<?php echo $clientlibelle; ?>", "fiche" )' class='btn btn-link' data-toggle='modal' data-target='#optionSelectionModal'>Voir</button>
          <button onclick='' class='btn btn-link'>Modifier</span></button>
          <button onclick='' class='btn btn-link'>Télécharger</span></button>
          <?php
        } else {
          ?><button  onclick='directCreerFicheFab(<?php echo json_encode($devi); ?>)' class='btn btn-link'>Céer</button> <?php
        }
    ?>
    </td>
    <td>
    <button onclick='loadModalData(<?php echo json_encode($devi); ?> , "<?php echo $clientlibelle; ?>", "schema" )' class='btn btn-link' data-toggle='modal' data-target='#optionSelectionModal'>Voir</button>
    </td>
    </tr>
    <?php
}

?>
</tbody>
    </table>
</div>

<div class="modal fade bd-example-modal-lg" id="optionSelectionModal" tabindex="-1" role="dialog"
     aria-labelledby="optionSelectionModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="overflow:hidden;">
        <div class="modal-content" style="width: 800px;">
            <div class="modal-header">
                <h4 class="modal-title" id="previewSchemaTitle"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 0; overflow: hidden;">
                <img id="previewSchema" src="" alt"">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
</body>
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

function getDevis(devisId)
{
  window.open('../controller/DevisController.php?functionname=GenerateDevisPDF' + "&devisId=" + devisId, '_blank');
}

function loadModalData(devis, clientLibelle, type){
  let chemin = '';

  if(type == 'schema'){
    chemin = devis.CheminImage_devis;
  }
  if(type == 'fiche'){
    chemin = devis.CheminFicheFab_devis;
  }

  document.getElementById('previewSchemaTitle').innerHTML = clientLibelle;
  let previewSchema = document.getElementById('previewSchema');
  previewSchema.setAttribute('style', 'visibility: visible');
  previewSchema.setAttribute("src", chemin);
}

function directCreerFicheFab(d){

  window.location.replace("LigneFicheFab.php?q="+d.Id_devis);
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
