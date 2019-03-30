<!DOCTYPE html>
<?php
spl_autoload_register(function ($class_name) {
  if(strpos($class_name, 'Manager')){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/SrgConcept/manager/'. $class_name . '.php');
  } else {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/SrgConcept/model/'. $class_name . 'Class.php');
  }
});

try {
  $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
} catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}

$ManagerMatiere = new MatiereManager($bdd); //Connexion a la BDD
$ClientManager = new ClientManager($bdd);
$FamilleManager = new FamilleManager($bdd);

$matieres = $ManagerMatiere->GetAllMatiere();
$clients = $ClientManager->GetAllClient();
$familles = $FamilleManager->GetAllFamilleOrderByRegroupement();


?>
<link rel="stylesheet" href="../../public/css/form.css" type="text/css">
<link rel="stylesheet" href="AddDevisDessin.css" type="text/css">
<link rel="stylesheet" href="../../public/css/switch.css" type="text/css">
<!-------------------------- Il faut mettre le chemin dans les value -------------------------->

  <div id="content-wrapper">
    <div class='container' style="max-width: 1600px; min-width: 1600px">
      <div class="form">
        <div class="row">
          <!--OPTIONS ET SCHEMA-->
          <div class="col-sm row" id="optionsPrincipaleEtSchemaContainer">
            <!--OPTIONS-->
            <div class="col-sm" id="optionsPrincipalContainer">
              <div class="formbox" style="margin-bottom: 1vw;">

                <!--CHOIX CLIENT-->
                <div class="input-group mb-3" id="vueChoixClient">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="width:100px"
                    id="Id_client_label">Client :</span>
                  </div>
                  <select name="Id_client" id="id_client" aria-describedby="Id_client_label" class="form-control" onchange="selectClient(value)">
                    <option value="aucun" selected disabled>Aucun</option>
                    <?php
                    foreach($clients as $client){
                      ?>
                      <option value='<?php echo json_encode($client->GetOriginalObject()); ?>'> <?php echo $client->GetNomClient(); ?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>

                <div class="row" id="vueClientDevisId" hidden>
                  <div class="input-group mb-2 col-sm-5" style="padding-right:5px">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="NumeroDevisTitre">N˚ Devis</span>
                    </div>
                    <input type="text" class="form-control" disabled aria-describedby="NumeroDevisTitre" id="NumeroDevis" value="">
                  </div>
                  <div class="input-group mb-2 col-sm-7" style="padding-left:5px">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="DateDevisTitre">Client :</span>
                    </div>
                    <input type="text" class="form-control" disabled aria-describedby="DateDevisTitre" id="LibelleClient" value="">
                  </div>
                </div>



                <!--CHOIX MATIERE-->
                <!-- <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="width:100px"
                    id="Id_matiere_label">Matière :</span>
                  </div>
                  <select id="id_matiere"  onchange="selectMatiere(value)" class="form-control" name="Id_matiere" aria-describedby="Id_matiere_label">
                    <option value="aucun" selected disabled>Aucun</option>

                    <?php
                    foreach($matieres as $matiere){
                      ?>
                      <option value='<?php echo json_encode($matiere->GetOriginalObject()); ?>'> <?php echo $matiere->GetLibelleMatiere(); ?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div> -->

                <!--SWITCH DOUBLE SIMPLE-->
                <div class="row mb-3">
                  <div class="col-sm">
                    <div class="onoffswitch">
                      <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="simpleOuDouble" onchange="togglePieces(event)" checked>
                      <label class="onoffswitch-label" for="simpleOuDouble">
                        <span class="onoffswitch-inner"></span>
                        <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>

                </div>

                <!--CHOIX FAMILLE    -->
                <div class="input-group mb-3" id="selectFamilleContainer">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="width:100px"
                    id="Id_famille_label">Famille :</span>
                  </div>
                  <select name="Id_famille" aria-describedby="Id_famille_label" id="select_famille" onchange="FilterSousFamille(value)" class="form-control">
                    <option value="" selected style="font-style: italic">Aucun</option>
                    <?php
                    $regroupement = '';
                    foreach ($familles as $famille) {
                      if($regroupement != $famille->GetRegroupementFamille()){
                        $regroupement = $famille->GetRegroupementFamille();
                        ?>
                        <option disabled value="<?php echo $regroupement; ?>"> --- <?php echo $regroupement; ?> ---</option>
                        <?php
                      }
                      ?>
                      <option type="submit" value='<?php echo json_encode($famille->GetOriginalObject()); ?>'> <?php echo $famille->GetLibelleFamille(); ?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>

                <!--CHOIX SOUS FAMILLE-->
                <div class="input-group mb-3" id="selectSousFamilleContainer">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="width:100px"
                    id="Id_ss_famille_label">Sous-fam :</span>
                  </div>
                  <select name="Id_ss_famille" aria-describedby="Id_ss_famille_label" id="select_ss_famille" disabled class="form-control" onchange="FilterPieces(value)">
                  </select>
                </div>

                <!--CHOIX PIECE-->
                <div class="input-group mb-3" id="selectPieceContainer">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="width:100px"
                    id="Id_piece_label">Piece :</span>
                  </div>
                  <select name="Id_piece" id="select_piece" aria-describedby="Id_piece_label" onchange="SelectPiece()" class="form-control" disabled>
                  </select>
                </div>

                <button class="btn btn-success col-lg-12 hover-effect-a" id="ajouter_piece_button" disabled onclick="SauvegarderNouvellePiece()">
                  Ajouter Piece
                </button>

                <!--VUE PIECE-->
                <div class="formbox row" id="pieceVueEtControlContainer">
                  <span id="pieceVueContainerCount"></span>
                  <div class="col-sm"><img alt="" id="imagePieceSelectionnee" src="" style="max-width: inherit; max-height: inherit">
                  </div>
                  <div class="col-sm" id="pieceSelectControlContainer">
                    <div class="col-sm btn hover-effect-a" id="piece-select-controls" onclick="PiecesSelectListGoTo(1)">
                      <i class="fas fa-step-backward fa-rotate-90"></i>
                    </div>
                    <div class="col-sm btn hover-effect-a" id="piece-select-controls" onclick="PiecesSelectListUp()">
                      <i class="fas fa-chevron-left fa-rotate-90"></i>
                    </div>
                    <div class="col-sm btn hover-effect-a" id="piece-select-controls" onclick="PiecesSelectListDown()">
                      <i class="fas fa-chevron-right fa-rotate-90"></i>
                    </div>
                    <div class="col-sm btn hover-effect-a" id="piece-select-controls" onclick="PiecesSelectListGoTo(-1)">
                      <i class="fas fa-step-forward fa-rotate-90"></i>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <!--SCHEMA-->
            <div class="col-sm" id="schemaOptionsContainer">
              <div class="col-lg-12 formbox row mb-3" id="schemaPiecesContainer">
                <img id="imagePieceSelectionneeSchema" src="" alt""  style="position:absolute;">

              </div>
              <div class="col-sm formbox" id="matiereImageContainer">
                <img id="matiereImagePreview" src="" alt="">
              </div>
            </div>

            <!--PIECES SELECTIONNEES-->
            <div class="col-sm" id="piecesSelectionneeEtOptionsDevisContainer">
              <div class="formbox col-lg-12" id="piecesSelectionneeEtOptionsPiecesContainer">
                <div class="row" id="piecesListContainer" style="height: 600px;margin: 0; padding: 0 0 0 20px;">
                </div>
                <div class="row" style="height: 25px;margin: 0; padding: 0;">
                  <div class="col-sm" style="text-align: center;" id="pageNumberContainer">

                  </div>
                </div>
                <div class="row col-lg-12 mb-3" style="height: 50px; margin: 0; padding: 0;" id="piecesListControls">
                  <div class="col-sm btn hover-effect-a" style="padding-top: 12px;" onclick="PiecesListGoTo(0)">
                    <i class="fas fa-step-backward"></i>
                  </div>
                  <div class="col-sm btn hover-effect-a" style="padding-top: 12px;" onclick="PiecesListPageLeft()">
                    <i class="fas fa-chevron-left"></i>
                  </div>
                  <div class="col-sm btn hover-effect-a" style="padding-top: 12px;" onclick="PiecesListPageRight()">
                    <i class="fas fa-chevron-right"></i>
                  </div>
                  <div class="col-sm btn hover-effect-a" style="padding-top: 12px;" onclick="PiecesListGoTo(-1)">
                    <i class="fas fa-step-forward"></i>
                  </div>
                </div>
                <button class="btn btn-danger hover-effect-a mb-3" style="margin: 0 25px 0 25px; width: 276px;" onclick="RedirectDevisListView()">
                  Annuler
                </button>
                <button class="btn btn-success hover-effect-a" id='SaveContinueButton' disabled style="margin: 0 25px 0 25px; width: 276px;" onclick="SauvegarderDevis()">
                  Sauvegarder & Suite
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
