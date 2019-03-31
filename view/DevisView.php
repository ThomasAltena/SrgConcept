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
$idUser = $_SESSION['Id_user'];

/* Mise en place de la base de donnée */

try {
  $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
} catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}


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
        $ManagerDevis = new DevisManager($bdd); //Connexion a la BDD
        $ManagerClient = new ClientManager($bdd); //Connexion a la BDD

        $clients = $ManagerClient->GetAllClientUser($idUser);
        $devis = $ManagerDevis->GetAllByUserId($idUser);

        foreach (array_reverse($devis,true) as $devi) {

          $idClient = $devi->GetIdClient();
          $client = array_filter($clients, function ($c)use($idClient){return $c->GetIdClient() == $idClient;});
          $currentClient;
          $clientlibelle = ''.array_values($client)[0]->GetNomClient().' '.array_values($client)[0]->GetPrenomClient();


          ?>
          <tr>
            <td> <?php echo $devi->GetIdDevis(); ?> </td>
            <td> <?php echo $clientlibelle; ?></td>
            <td> <?php echo $devi->GetDateDevis(); ?></td>
            <td>
              <button onclick='getDevis(<?php echo $devi->GetIdDevis(); ?>)' class='btn btn-link'>PDF</button>
              <button class='btn btn-link' onclick="RedirectDevisDessinView(<?php echo $devi->GetIdDevis(); ?>)">Modifier Dessin</span></button>
              <button class='btn btn-link' onclick="RedirectDevisCotesView(<?php echo $devi->GetIdDevis(); ?>)">Modifier Cotes</span></button>
            </td>
            <td>
              <?php
              if($devi->GetCheminFicheFabDevis() != ''){
                ?>
                <button onclick='loadModalData(<?php echo json_encode($devi->GetOriginalObject()); ?> , "<?php echo $clientlibelle; ?>", "fiche" )' class='btn btn-link' data-toggle='modal' data-target='#optionSelectionModal'>Voir</button>


                <!-- <button onclick='' class='btn btn-link'>Télécharger</span></button> -->
                <?php
              } else {
                ?><button  onclick='directCreerFicheFab(<?php echo json_encode($devi->GetOriginalObject()); ?>)' class='btn btn-link'>Créer</button> <?php
              }
              ?>
            </td>
            <td>
              <button onclick='loadModalData(<?php echo json_encode($devi->GetOriginalObject()); ?> , "<?php echo $clientlibelle; ?>", "schema" )' class='btn btn-link' data-toggle='modal' data-target='#optionSelectionModal'>Voir</button>
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

  function RedirectDevisDessinView(idDevis){
    window.location.replace("/SrgConcept/view/AddDevisView/AddDevisDessinViewModel.php?idDevis=" + idDevis);
  }

  function RedirectDevisCotesView(idDevis){
    window.location.replace("/SrgConcept/view/AddDevisView/AddDevisCotesViewModel.php?idDevis=" + idDevis);
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
