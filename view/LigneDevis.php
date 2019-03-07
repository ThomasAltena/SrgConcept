<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
  <title>Monumac</title>
</head>

<?php
session_start();

if (empty($_SESSION)) {
  header('location:index.php');
} else {
  include('header.php');
}


$db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
$ManagerMatiere = new MatiereManager($db); //Connexion a la BDD
$matieres = $ManagerMatiere->GetMatieres();
try {
  $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
} catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}


$reponse = $bdd->query('SELECT Id_devis, IdClient_devis, IdUser_devis FROM devis ORDER BY Id_devis DESC LIMIT 1');
$IdDevis = $reponse->fetchAll();

if ($IdDevis) {
  foreach ($IdDevis as $IdDevi) ;
  $Devis = $IdDevi['Id_devis'];
  $User = $IdDevi['IdUser_devis'];
  $Client = $IdDevi['IdClient_devis'];
}


$date = date("d-m-Y");

?>
<script src="../jquery-3.3.1.min.js"></script>
<link rel="stylesheet" href="../public/css/form.css" type="text/css">
<link rel="stylesheet" href="../public/css/ligneDevis.css" type="text/css">
<link rel="stylesheet" href="../public/css/switch.css" type="text/css">
<!-------------------------- Il faut mettre le chemin dans les value -------------------------->
<body style="overflow: scroll;">
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
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="width:100px"
                    id="Id_client_label">Client :</span>
                  </div>
                  <select name="Id_client" id="id_client" aria-describedby="Id_client_label" class="form-control">
                    <?php
                    $reponse = $bdd->query('SELECT * FROM clients');
                    while ($donnees = $reponse->fetch()) {
                      ?>
                      <option value='<?php echo $donnees['Id_client']; ?>'> <?php echo $donnees['Nom_client']; ?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>

                <!--CHOIX MATIERE-->
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="width:100px"
                    id="Id_matiere_label">Matière :</span>
                  </div>
                  <select id="id_matiere"  onchange="SelectMatiere(value)" class="form-control" name="Id_matiere" aria-describedby="Id_matiere_label">
                    <?php
                    $reponse = $bdd->query('SELECT * FROM matieres');
                    while ($donnees = $reponse->fetch()) {
                      ?>
                      <option value='<?php echo json_encode($donnees); ?>'><?php echo $donnees['Libelle_matiere']; ?> </option>
                      <?php
                    }
                    ?>
                  </select>
                </div>

                <!--SWITCH DOUBLE SIMPLE-->
                <div class="row">
                  <div class="col-sm">
                    <div class="onoffswitch">
                      <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"
                      id="myonoffswitch"
                      checked>
                      <label class="onoffswitch-label" for="myonoffswitch">
                        <span class="onoffswitch-inner"></span>
                        <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                  <div class="col-sm formbox" id="matiereImageContainer">
                    <img id="matiereImagePreview" src="" alt="">
                  </div>
                </div>
              </div>
              <div class="formbox" style="padding-right: 0;padding-left: 0">
                <!--CHOIX FAMILLE    -->
                <div class="input-group mb-3" id="selectFamilleContainer">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="width:100px"
                    id="Id_famille_label">Famille :</span>
                  </div>
                  <select name="Id_famille" aria-describedby="Id_famille_label" id="select_famille" onchange="FilterSousFamille(value)" class="form-control">
                    <option value="" selected style="font-style: italic">Aucun</option>
                    <?php
                    $_POST = [];
                    $reponse = $bdd->query('SELECT * FROM familles ORDER BY Regroupement_fam ASC, Libelle_famille ASC');
                    $regroupement = '';
                    while ($donnees = $reponse->fetch()) {
                      if($regroupement != $donnees['Regroupement_fam']){
                        $regroupement = $donnees['Regroupement_fam'];
                        ?>
                        <option disabled value="<?php echo $regroupement; ?>"> --- <?php echo $regroupement; ?> ---</option>
                        <?php
                      }
                      ?>
                      <option type="submit"
                      value="<?php echo $donnees['Code_famille']; ?>"> <?php echo $donnees['Libelle_famille']; ?></option>
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

                <!--VUE PIECE-->
                <div class="formbox row" id="pieceVueEtControlContainer">
                  <span id="pieceVueContainerCount"></span>
                  <div class="col-sm"><img alt="" id="imagePieceSelectionnee" src="" style="max-width: inherit; max-height: inherit">
                  </div>
                  <div class="col-sm"
                  id="pieceSelectControlContainer">
                  <div class="col-sm btn hover-effect-a" id="piece-select-controls" onclick="PiecesSelectListGoTo(0)">
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

              <!--CHOIX PIECE-->
              <div class="input-group" id="selectPieceContainer">
                <div class="input-group-prepend">
                  <span class="input-group-text" style="width:100px"
                  id="Id_piece_label">Piece :</span>
                </div>
                <select name="Id_piece" id="select_piece" aria-describedby="Id_piece_label" onchange="SelectPiece()" class="form-control" disabled>
                </select>
              </div>
            </div>

          </div>
          <!--SCHEMA-->
          <div class="col-sm" id="schemaOptionsContainer">
            <div class="col-lg-12 formbox row" id="schemaPiecesEtSlidersContainer">
              <div class="col-sm-11 formbox" id="schemaPiecesContainer">
                <img id="imagePieceSelectionneeSchema" src="" alt""  style="top:100px; position:absolute;">

              </div>
              <div class="formbox" id="selectedPieceOptionsList">

              </div>
              <div id="deplacementPieceSchemaControlsContainer" class="row">
                <div id="slider-container" class="col-sm row formbox">
                  <div class="col-sm-3 row" style="margin:0; padding:0">
                    <h5 class="col-sm" style="margin:0; padding:0">&nbsp;X </h5>
                    <input type="number" class="col-sm-9" style="margin-bottom: 5px; padding: 0;"
                    id="pos_x_number" oninput="MoveByNumber()">
                  </div>

                  <input type="range" min="-9999" max="9999" value="0" style="margin:0; padding:0"
                  oninput="MoveBySlider()" class="slider col-sm-9" name="posX"
                  id="pos_x_slider">
                </div>
                <div id="slider-container" class="col-sm row formbox">
                  <div class="col-sm-3 row" style="margin:0; padding:0">
                    <h5 class="col-sm" style="margin:0; padding:0">&nbsp;Y </h5>
                    <input type="number" class="col-sm-9" style="margin-bottom: 5px; padding: 0;"
                    id="pos_y_number" oninput="MoveByNumber()">
                  </div>
                  <input type="range"
                  min="-9999"
                  max="9999"
                  value="0"
                  style="margin:0; padding:0"
                  oninput="MoveBySlider()"
                  class="slider col-sm-9"
                  name="posY"
                  id="pos_y_slider">
                </div>
                <div id="slider-container" class="col-sm row formbox">
                  <div class="col-sm-3 row" style="margin:0; padding:0">
                    <h5 class="col-sm" style="margin:0; padding:0">&nbsp;Z </h5>
                    <input type="number" class="col-sm-9" style="margin-bottom: 5px; padding: 0;"
                    id="pos_z_number" oninput="MoveByNumber()">
                  </div>
                  <input type="range"
                  min="-999"
                  max="999"
                  value="0"
                  style="margin:0; padding:0"
                  oninput="MoveBySlider()"
                  class="slider col-sm-9"
                  name="posZ"
                  id="pos_z_slider">
                </div>
              </div>
            </div>
            <div class="col-lg-12 row formbox" id="optionsButtonsContainer" style="margin-top: 0;">
              <div class="col-sm" id="inputOptionsContainer">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="width:100px" id="Hauteur_piece_label">Hauteur :</span>
                  </div>
                  <input id="hauteur_piece" type="number" class="form-control"
                  onchange="UpdatePieceInputOptions()"
                  placeholder="0" name="Hauteur_piece" aria-describedby="Hauteur_piece_label">
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="width:100px" id="Largeur_piece_label">Largeur :</span>
                  </div>
                  <input id="largeur_piece" type="number" class="form-control"
                  onchange="UpdatePieceInputOptions()"
                  placeholder="0" name="Largeur_piece" aria-describedby="Largeur_piece_label">
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="width:100px" id="Profondeur_piece_label">Profondeur :</span>
                  </div>
                  <input id="profondeur_piece" type="number" class="form-control"
                  onchange="UpdatePieceInputOptions()"
                  placeholder="0" name="Profondeur_piece"
                  aria-describedby="Profondeur_piece_label">
                </div>

                <div class="input-group" id="selectRemiseContainer">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="width:100px"
                    id="Remise_piece_label">Remise :</span>
                  </div>
                  <input id="remise_piece" type="number" class="form-control"
                  onchange="UpdatePieceInputOptions()"
                  placeholder="0" name="Remise_piece" aria-describedby="Remise_piece_label"
                  min="0" max="500000">
                </div>
              </div>
              <div class="col-sm" id="pieceButtonsContainer">
                <button class="mb-3 btn btn-primary col-lg-12 hover-effect-a" onclick="LoadOptions()" onclick="" data-toggle="modal" data-target="#optionSelectionModal">Ajouter
                  Options
                </button>
                <button class="mb-3 btn btn-success col-lg-12 hover-effect-a" id="ajouter_piece_button" disabled onclick="SauvegarderNouvellePiece()">
                  Ajouter Piece
                </button>
              </div>
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
              <div class="row col-lg-12" style="height: 50px; margin: 0; padding: 0;" id="piecesListControls">
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
            </div>

            <div class="col-sm formbox col-lg-12" style="margin-top: 0;">
              <button class="btn btn-success col-lg-12 hover-effect-a" onclick="SauvegarderDevis()">
                Sauvegarder Devis
              </button>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-lg" id="optionSelectionModal" tabindex="-1" role="dialog" aria-labelledby="optionSelectionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ajouterOptionsModal">Options</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding: 0">
        <table class="table table-hover table-sm" style="margin: 0">
          <thead class="thead-light">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Code</th>
              <th scope="col">Libelle</th>
              <th scope="col">Prix</th>
              <th scope="col">Durée</th>
              <th scope="col">Quantité</th>
              <th scope="col">Unité</th>
              <th scope="col">Cote 1</th>
              <th scope="col">Cote 2</th>
            </tr>
          </thead>
          <tbody id="optionsTableInnerContents">

          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

</body>
<script type="text/javascript">
let saved = false;
let selectedPiece = new Piece();
let originalPiece;
let pieces = [];
let piecesListCurrentPage = 0;

let matiere = '';

function Piece() {
  this.pos_z = '';
  this.code_famille = "";
  this.code_ss_famille = "";
  this.id_piece = "";
  this.chemin_piece = "";
  this.pos_x = "";
  this.pos_y = "";
  this.ratio = "";
  this.originalHeight = "";
  this.originalWidth = "";
  this.hauteur = "";
  this.largeur = "";
  this.remise = "";
  this.profondeur = "";
  this.selected = false;
  this.loading = false;
  this.options = [];
}

function Option() {
  this.Code_option = "";
  this.Id_option = "";
  this.Libelle_option = "";
  this.Prix_option = "";
}

/*HIDE*/

/*
* Cache la <img> contenant la preview de l'image selectionnee dans schema quand celle ci est vide (au moment de sauvegarde ou selection de 'aucune' piece
*/
function HideSelectedPieceSchema() {
  document.getElementById('imagePieceSelectionneeSchema').setAttribute("src", "");
  document.getElementById('imagePieceSelectionneeSchema').setAttribute('style', 'visibility: hidden');
}

/*
* Cache la <img> contenant la preview de l'image selectionnee dans selection quand celle ci est vide (au moment de sauvegarde ou selection de 'aucune' piece
*/
function HideSelectedPiecePreview() {
  document.getElementById('imagePieceSelectionnee').setAttribute("src", "");
  document.getElementById('imagePieceSelectionnee').setAttribute('style', 'visibility: hidden');
}

function HideSliders() {
  document.getElementById('pieceSelectControlContainer').setAttribute('style', 'visibility: hidden');
}

function HideCurrentPieceOptionsPreview() {
  document.getElementById('selectedPieceOptionsList').setAttribute('style', 'visibility: hidden');
}

function HidePieceSelectors() {
  document.getElementById('deplacementPieceSchemaControlsContainer').setAttribute('style', 'visibility: hidden');
}

function HideOptions() {
  document.getElementById('inputOptionsContainer').setAttribute('style', 'visibility: hidden');
  document.getElementById('pieceButtonsContainer').setAttribute('style', 'visibility: hidden');
}

/*SHOW*/

function ShowSelectedPieceSchema() {
  if (selectedPiece.chemin_piece !== "") {
    let imagePieceSelectionnee = document.getElementById('imagePieceSelectionnee');
    imagePieceSelectionnee.setAttribute('style', 'visibility: visible');
    imagePieceSelectionnee.setAttribute("src", selectedPiece.chemin_piece);
    imagePieceSelectionnee.style.width = "inherit";
    imagePieceSelectionnee.style.position = "relative";
  }
}

function ShowSelectedPiecePreview() {
  if (selectedPiece.chemin_piece !== "") {
    let imagePieceSelectionneeSchema = document.getElementById('imagePieceSelectionneeSchema');
    imagePieceSelectionneeSchema.setAttribute('style', 'visibility: visible');
    imagePieceSelectionneeSchema.setAttribute("src", selectedPiece.chemin_piece);
    imagePieceSelectionneeSchema.style.position = "absolute";
    imagePieceSelectionneeSchema.style.maxWidth = "600px";
    imagePieceSelectionneeSchema.style.width = "600px";
    imagePieceSelectionneeSchema.style.height = "600px";
    $('#imagePieceSelectionneeSchema').css({top: "100px", position:'absolute'});
  }
}

function ShowSliders() {
  document.getElementById('pieceSelectControlContainer').setAttribute('style', 'visibility: visible');
}

function ShowCurrentPieceOptionsPreview() {
  document.getElementById('selectedPieceOptionsList').setAttribute('style', 'visibility: visible');
}

function ShowPieceSelectors() {
  document.getElementById('deplacementPieceSchemaControlsContainer').setAttribute('style', 'visibility: visible');
}

function ShowOptions() {
  document.getElementById('inputOptionsContainer').setAttribute('style', 'visibility: visible');
  document.getElementById('pieceButtonsContainer').setAttribute('style', 'visibility: visible');
}

/*RESET*/

function ResetFamilleSelector() {
  document.getElementById("select_famille").value = "";
}

function ResetSousFamilleSelector() {
  document.getElementById("selectSousFamilleContainer").innerHTML =
  "<div class=\"input-group-prepend\">\n" +
  "<span class=\"input-group-text\" style=\"width:100px\"\n" +
  "id=\"Id_ss_famille_label\">Sous-fam :</span>\n" +
  "</div>\n" +
  "<select name=\"Id_ss_famille\" aria-describedby=Id_ss_famille_label\" id=\"select_ss_famille\" disabled\n" +
  "class=\"form-control\" onchange=\"FilterPieces(value)\">\n" +
  "</select>";
}

function ResetPieceSelector() {
  document.getElementById("selectPieceContainer").innerHTML =
  "<div class=\"input-group-prepend\">\n" +
  "<span class=\"input-group-text\" style=\"width:100px\" id=\"Id_piece_label\">Piece :</span>\n" +
  "</div>\n" +
  "<select name=\"Id_piece\" id=\"select_piece\" aria-describedby=Id_piece_label\"\n" +
  "onchange=\"SelectPiece()\" class=\"form-control\" disabled>\n" +
  "\n" +
  "</select>";
}

function ResetPiecePosition() {
  selectedPiece.ratio = 0;
  selectedPiece.pos_y = 0;
  selectedPiece.pos_x = 0;
}

function ResetOptionsBoutonSchema() {
  document.getElementById('pieceButtonsContainer').innerHTML = '<button class="mb-3 btn btn-primary col-lg-12 hover-effect-a" onclick="LoadOptions()"\n' +
  '                                        onclick="" data-toggle="modal" data-target="#optionSelectionModal">Ajouter Options\n' +
  '                                </button>\n' +
  '                                <button class="mb-3 btn btn-success col-lg-12 hover-effect-a" id="ajouter_piece_button"\n' +
  '                                        disabled\n' +
  '                                        onclick="SauvegarderNouvellePiece()">Ajouter Piece\n' +
  '                                </button>';
}

function ResetSliders() {
  document.getElementById('pos_x_slider').value = '0';
  document.getElementById('pos_y_slider').value = '0';
  document.getElementById('pos_z_slider').value = '0';
  document.getElementById('pos_x_number').value = '0';
  document.getElementById('pos_y_number').value = '0';
  document.getElementById('pos_z_number').value = '0';
}

function ResetInputOptions() {
  document.getElementById('hauteur_piece').value = '0';
  document.getElementById('largeur_piece').value = '0';
  document.getElementById('profondeur_piece').value = '0';
  document.getElementById('remise_piece').value = '0';
}

/*TOGGLE*/

function ToggleSubmitPieceButton(bool) {
  $("#ajouter_piece_button").attr("disabled", !bool);
}


/*
/--------------------------------------- ACTIONS PIECE SELECTION PREVIEW -----------------------------------------------------------/
*/

function SelectMatiere(m) {
  matiere = JSON.parse(m);

  UpdateMatierePreview(matiere.Chemin_matiere);
}

function UpdateMatierePreview(cheminMatiereImage) {
  let imageMatiereSelectionnee = document.getElementById('matiereImagePreview');
  if(cheminMatiereImage != ''){
    imageMatiereSelectionnee.setAttribute('style', 'visibility: visible');
    imageMatiereSelectionnee.setAttribute("src", cheminMatiereImage);
    imageMatiereSelectionnee.style.position = "absolute";
    imageMatiereSelectionnee.style.maxWidth = "200";
    imageMatiereSelectionnee.style.width = "200";
    imageMatiereSelectionnee.style.height = "200";
  } else {
    imageMatiereSelectionnee.setAttribute('style', 'visibility: hidden');
  }

}

function FilterSousFamille(code_famille, code_ss_famille_to_select) {
  selectedPiece.code_famille = code_famille;
  let xhttp;
  ResetPieceSelector();
  HideSelectedPieceSchema();
  HideSelectedPiecePreview();
  if (code_famille === "") {
    ResetSousFamilleSelector();
    ResetPieceSelector();
    HideSliders();
    HideCurrentPieceOptionsPreview();
    ResetSliders();
    ResetInputOptions();
    HidePieceSelectors();
    HideOptions();
    UpdateImageCount();
    ToggleSubmitPieceButton(false);

    ResetPiecePosition();
  } else {
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
      if (this.readyState === 4 && this.status === 200) {
        document.getElementById("selectSousFamilleContainer").innerHTML = this.responseText;
        if (code_ss_famille_to_select) {
          var selectSousFamille = document.getElementById("select_ss_famille");
          for (var x = 0; x < selectSousFamille.options.length; x++) {
            if (selectSousFamille.options[x].value === code_ss_famille_to_select) {
              selectSousFamille.selectedIndex = x;
              break;
            }
          }
        }
      }
    };
    xhttp.open("GET", "../module/LigneDeviModule.php?functionname=GetFilteredSousFamille&codeFamille=" + code_famille, true);
    xhttp.send();
  }
}

function FilterPieces(code_sous_famille, id_piece_to_select) {
  let ss_famille_selected_index = document.getElementById("select_ss_famille").selectedIndex;
  if (ss_famille_selected_index >= 0) {
    selectedPiece.code_ss_famille = document.getElementById("select_ss_famille").options[ss_famille_selected_index].value;
  }

  let xhttp;
  if (selectedPiece.code_famille === "" || selectedPiece.code_ss_famille === "") {
    ResetPieceSelector();
    HideSliders();
    HideCurrentPieceOptionsPreview();
    ResetSliders();
    ResetInputOptions();
    HidePieceSelectors();
    HideOptions();
    UpdateImageCount();
    ToggleSubmitPieceButton(false);
    HideSelectedPieceSchema();
    HideSelectedPiecePreview();
    ResetPiecePosition();
  } else {
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
      if (this.readyState === 4 && this.status === 200) {
        document.getElementById("selectPieceContainer").innerHTML = this.responseText;
        let selectPiece = document.getElementById("select_piece");

        if (selectPiece.options.length >= 0) {
          if (id_piece_to_select) {
            for (let x = 0; x < selectPiece.options.length; x++) {
              if (JSON.parse(selectPiece.options[x].value)['Id_piece'] === id_piece_to_select) {
                selectPiece.selectedIndex = x;
                break;
              }
            }
          } else {
            selectPiece.selectedIndex = 0;
            SelectPiece();
          }
        }
      }
    };
    xhttp.open("GET", "../module/LigneDeviModule.php?functionname=GetFilteredPieces&codeFamille=" + selectedPiece.code_famille + "&codeSs=" + code_sous_famille, true);
    xhttp.send();
  }
}

function UpdateImageCount() {
  let piecesCount = document.getElementById('select_piece').options.length;
  let body = '';
  if (piecesCount > 0) {
    let selectedIndex = document.getElementById('select_piece').selectedIndex;
    body = 'Piece ' + (selectedIndex + 1) + '/' + (piecesCount);

  }
  document.getElementById('pieceVueContainerCount').innerHTML = body;
}

function PiecesSelectListGoTo(page) {
  let optionsLength = document.getElementById("select_piece").options.length;
  if (optionsLength > 0) {
    if (page === 0) {
      document.getElementById("select_piece").options.selectedIndex = 0;
      SelectPiece();
    }
    if (page === -1) {
      document.getElementById("select_piece").options.selectedIndex = optionsLength - 1;
      SelectPiece();
    }
  }
}

function PiecesSelectListUp() {
  let currentSelected = document.getElementById("select_piece").options.selectedIndex;
  let newSelect = currentSelected - 1;
  if (newSelect >= 0) {
    document.getElementById("select_piece").options.selectedIndex = newSelect;
    SelectPiece();
  }
}

function PiecesSelectListDown() {
  let currentSelected = document.getElementById("select_piece").options.selectedIndex;
  let newSelect = currentSelected + 1;
  if (newSelect < document.getElementById("select_piece").options.length) {
    document.getElementById("select_piece").options.selectedIndex = newSelect;
    SelectPiece();
  }
}

/*
/--------------------------------------- ACTIONS SCHEMA -----------------------------------------------------------/
*/

function ReloadSchema() {
  let body = '';
  pieces.forEach(function (piece) {
    if (!piece.selected) {
      let text = '<img alt="Une piece parmis pleins sur schema" id="schema_piece_' + selectedPiece.pos_z + '" ' +
      'src="' + piece.chemin_piece + '" ' +
      'style="height:' + (piece.originalHeight * piece.ratio) + 'px; width:' + (piece.originalWidth * piece.ratio) + 'px;' +
      'position: absolute; left:' + (piece.pos_x / 10) + 'px ; top:' + (100 + piece.pos_y / 10) + 'px ; ';
      if (piece.chemin_piece === "") {
        text += 'visibility: hidden;';
      }
      text += '" >\n'
      body = body + text;
    }
  });

  body = body + '<img alt="La piece couramment selectionnee sur schema" id="imagePieceSelectionneeSchema" src="" style="visibility: hidden">\n';
  document.getElementById("schemaPiecesContainer").innerHTML = body;
}

function ReloadCurrentPieceOptionsPreview() {
  let body = '';
  selectedPiece.options.forEach(option => {
    body += '<label class="formbox" id="singleOptionPreviewContainer">' + option.Code_option +
    '</label>'
  });
  document.getElementById('selectedPieceOptionsList').innerHTML = body;
}

function MoveBySlider() {
  document.getElementById('pos_x_number').value = document.getElementById('pos_x_slider').value;
  document.getElementById('pos_y_number').value = document.getElementById('pos_y_slider').value;
  document.getElementById('pos_z_number').value = document.getElementById('pos_z_slider').value;
  MovePieceImage();
}

function MoveByNumber() {
  document.getElementById('pos_x_slider').value = document.getElementById('pos_x_number').value;
  document.getElementById('pos_y_slider').value = document.getElementById('pos_y_number').value;
  document.getElementById('pos_z_slider').value = document.getElementById('pos_z_number').value;
  MovePieceImage();
}

function MovePieceImage() {
  let imagePieceSelectionneeSchema = $('#imagePieceSelectionneeSchema');
  let posX = $('#pos_x_slider').val();
  let posY = $('#pos_y_slider').val();
  let posZ = $('#pos_z_slider').val();

  let ratio = 1 + posZ / 1000;

  selectedPiece.pos_x = posX;
  selectedPiece.pos_y = posY;
  selectedPiece.ratio = ratio;

  imagePieceSelectionneeSchema.css({"left": ((posX / 10)).toString().concat('px')});
  imagePieceSelectionneeSchema.css({"top": (100+(posY / 10)).toString().concat('px')});

  imagePieceSelectionneeSchema.css({"max-width": ''});

  let height = selectedPiece.originalHeight * ratio;
  let width = selectedPiece.originalWidth * ratio;

  imagePieceSelectionneeSchema.css({"height": height.toString().concat('px')});
  imagePieceSelectionneeSchema.css({"width": width.toString().concat('px')});
}

function UpdatePieceInputOptions() {
  selectedPiece.hauteur = document.getElementById('hauteur_piece').value;
  selectedPiece.largeur = document.getElementById('largeur_piece').value;
  selectedPiece.profondeur = document.getElementById('profondeur_piece').value;
  selectedPiece.remise = document.getElementById('remise_piece').value;
}

/*
/--------------------------------------- ACTIONS PIECE -----------------------------------------------------------/
*/

function LoadOptions() {
  let xhttp;

  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      document.getElementById("optionsTableInnerContents").innerHTML = this.responseText;
      HighlightSelectedOptions();
    }
  };
  xhttp.open("GET", "../module/LigneDeviModule.php?functionname=GetOptions", true);
  xhttp.send();
}

function HighlightSelectedOptions() {
  selectedPiece.options.forEach(option => {
    $('#select_option_' + option.Id_option).addClass('table-primary');
  });
}

/*$('#optionSelectionModal').on('shown.bs.modal', function () {
console.log("SHOW");
});

$(function(){ // let all dom elements are loaded
$(document).on('hide.bs.modal', function (e) {
alert('event fired')
});
$(document).on('shown.bs.modal', function () {
alert('event fired')
});
});*/

function ToggleOption(option) {
  if (selectedPiece.options.some(x => x.Id_option == option.Id_option)) {
    selectedPiece.options = selectedPiece.options.filter(x => x.Id_option != option.Id_option);
    $('#select_option_' + option.Id_option).removeClass('table-primary');
  } else {
    selectedPiece.options.push(option);
    $('#select_option_' + option.Id_option).addClass('table-primary');
  }
  ReloadCurrentPieceOptionsPreview();
}

function SelectPiece() {
  let select = document.getElementById('select_piece');
  // Si une  nouvelle piece est selectionnee par l'utilisateur et non rechargee depuis la selection dune piece existante
  if (!selectedPiece.loading) {
    if (select.value !== "") {
      let piece = JSON.parse(select.value);
      let imagePieceSelectionneeSchema = $('#imagePieceSelectionneeSchema');
      let choice = select.selectedIndex;

      selectedPiece.chemin_piece = piece['Chemin_piece'];
      selectedPiece.id_piece = piece['Id_piece'];

      ShowSelectedPieceSchema();
      ShowSelectedPiecePreview();


      selectedPiece.originalHeight = imagePieceSelectionneeSchema.height();
      selectedPiece.originalWidth = imagePieceSelectionneeSchema.width();

      ShowSliders();
      ShowCurrentPieceOptionsPreview();
      ReloadCurrentPieceOptionsPreview();
      ShowPieceSelectors();
      ShowOptions();
      UpdateImageCount();
      ToggleSubmitPieceButton(true);
      ResetPiecePosition();
      MovePieceImage();
    } else {
      ReloadSchema();
      HideSliders();
      HideCurrentPieceOptionsPreview();
      ResetSliders();
      ResetInputOptions();
      HidePieceSelectors();
      HideOptions();
      UpdateImageCount();
      ToggleSubmitPieceButton(false);
      HideSelectedPieceSchema();
      HideSelectedPiecePreview();
      ResetPiecePosition();
    }
  } else {
    ShowSelectedPieceSchema();
    ShowSelectedPiecePreview();
    MoveBySlider();
    UpdateImageCount();
    ShowSliders();
    ShowCurrentPieceOptionsPreview();
    ReloadCurrentPieceOptionsPreview();
    ShowPieceSelectors();
    ShowOptions();
    selectedPiece.loading = false;
  }
}

function SelectExistingPiece(piecePosition) {
  selectedPiece = pieces.find(x => x.pos_z === piecePosition);

  if (selectedPiece.selected) {
    AnnulerModificationsPiece();
  } else {
    SaveOriginal();

    pieces.forEach(x => x.selected = false);

    selectedPiece.selected = true;
    selectedPiece.loading = true;

    UpdatePiecesListView(piecesListCurrentPage);
    ReloadSchema();
    ReloadPieceState();

    document.getElementById('pieceButtonsContainer').innerHTML = '<button class="mb-3 btn btn-primary col-lg-12 hover-effect-a" onclick="LoadOptions()"\n' +
    '                                        onclick="" data-toggle="modal" data-target="#optionSelectionModal">Ajouter Options\n' +
    '</button>\n' +
    '<button class="mb-3 btn btn-success col-lg-12 hover-effect-a" id="ajouter_piece_button"\n' +
    '                                        onclick="SauvegarderModificationsPiece()">Sauvegarder Modifications\n' +
    '</button>\n' +
    '<button class="mb-3 btn btn-warning col-lg-12 hover-effect-a" id="ajouter_piece_button"\n' +
    '                                        onclick="AnnulerModificationsPiece()">Annuler Modifications\n' +
    '</button>\n' +
    '<button class="btn btn-danger col-lg-12 hover-effect-a" id="effacer_piece_button"\n' +
    '                                        onclick="DeletePiece()">Effacer Piece\n' +
    '</button>';
    document.getElementById("select_famille").value = selectedPiece.code_famille;

    FilterSousFamille(selectedPiece.code_famille, selectedPiece.code_ss_famille);
    FilterPieces(selectedPiece.code_ss_famille, selectedPiece.id_piece);
    SelectPiece();
    MovePieceImage();
  }
}

function SaveOriginal() {
  originalPiece = Object.assign({}, selectedPiece);
}

function ReplaceOriginal() {
  let index = pieces.findIndex(x => x == selectedPiece);
  pieces.splice(index, 1, originalPiece);
  originalPiece = undefined;
}

function DeselectPiece() {
  selectedPiece.selected = false;
  selectedPiece = new Piece();

  document.getElementById('imagePieceSelectionnee').setAttribute("src", "");
  document.getElementById('imagePieceSelectionnee').setAttribute('style', 'visibility: hidden');

  ReloadSchema();
  ResetFamilleSelector();
  ResetSousFamilleSelector();
  ResetPieceSelector();

  HideSliders();
  HideCurrentPieceOptionsPreview();
  ResetSliders();
  ResetInputOptions();
  HidePieceSelectors();
  HideOptions();
  UpdateImageCount();
  ToggleSubmitPieceButton(false);
  HideSelectedPieceSchema();
  HideSelectedPiecePreview();
  ResetPiecePosition();

  UpdatePiecesListView();
  ResetOptionsBoutonSchema();
}

function ReloadPieceState() {
  document.getElementById('pos_x_slider').value = selectedPiece.pos_x;
  document.getElementById('pos_y_slider').value = selectedPiece.pos_y;
  document.getElementById('pos_z_slider').value = (selectedPiece.ratio - 1) * 1000;

  document.getElementById('largeur_piece').value = selectedPiece.largeur;
  document.getElementById('profondeur_piece').value = selectedPiece.profondeur;
  document.getElementById('hauteur_piece').value = selectedPiece.hauteur;
  document.getElementById('remise_piece').value = selectedPiece.remise;
}

function DeletePiece(piecePosition) {
  if (!piecePosition || pieces.find(x => x.pos_z == piecePosition).selected) {
    piecePosition = selectedPiece.pos_z;
    selectedPiece = new Piece();

    ResetOptionsBoutonSchema();
    ResetFamilleSelector();
    ResetSousFamilleSelector();
    ResetPieceSelector();

    document.getElementById('imagePieceSelectionnee').setAttribute("src", "");
    document.getElementById('imagePieceSelectionnee').setAttribute('style', 'visibility: hidden');

    HideSliders();
    HideCurrentPieceOptionsPreview();
    ResetSliders();
    ResetInputOptions();
    HidePieceSelectors();
    HideOptions();
    UpdateImageCount();
    ToggleSubmitPieceButton(false);
    HideSelectedPieceSchema();
    HideSelectedPiecePreview();
  }

  pieces = pieces.filter(x => x.pos_z !== piecePosition);
  let pos = 1;
  pieces.forEach(piece => {
    piece.pos_z = pos;
    pos++;
  });

  UpdatePiecesListView(piecesListCurrentPage);
  ReloadSchema();
}

function SauvegarderNouvellePiece() {
  if (pieces.length) {
    selectedPiece.pos_z = pieces.length + 1;
  } else {
    selectedPiece.pos_z = 1;
  }
  pieces.push(selectedPiece);

  selectedPiece = new Piece();

  document.getElementById('imagePieceSelectionnee').setAttribute("src", "");
  document.getElementById('imagePieceSelectionnee').setAttribute('style', 'visibility: hidden');

  ReloadSchema();
  ResetFamilleSelector();
  ResetSousFamilleSelector();
  ResetPieceSelector();

  HideSliders();
  HideCurrentPieceOptionsPreview();
  ResetSliders();
  ResetInputOptions();
  HidePieceSelectors();
  HideOptions();
  UpdateImageCount();
  ToggleSubmitPieceButton(false);
  HideSelectedPieceSchema();
  HideSelectedPiecePreview();
  ResetPiecePosition();

  UpdatePiecesListView(-1);
}

function SauvegarderModificationsPiece() {
  DeselectPiece();
}

function AnnulerModificationsPiece() {
  ReplaceOriginal();
  DeselectPiece();
}

function DuplicatePiece() {
  let piece = new Piece();
  pieces.push(piece);
  piece.pos_z = pieces.length;
  UpdatePiecesListView(-1);
}

function SauvegarderDevis() {
  html2canvas($("#schemaPiecesContainer"), {
    onrendered: function(canvas) {
      //document.body.appendChild(canvas);
      //var image = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");  // here is the most important part because if you dont replace you will get a DOM 18 exception.
      let dataURL = canvas.toDataURL("image/png");
      let idClient = document.getElementById('id_client').value;
      let idMatiere = JSON.parse(document.getElementById('id_matiere').value)['Id_matiere'];
      let cheminImageDevis = 'unknown';
      let arguments = [idClient, idMatiere, cheminImageDevis, dataURL, pieces];

      let xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
          responseText = JSON.parse(this.responseText);
          if(responseText.error){
            console.log(responseText);
          } else {
            saved = true;
          }
        }
      };
      xhttp.open("POST", "../controller/DevisController.php?functionname=" + 'AddLignesDevis' , true);
      xhttp.send(JSON.stringify(arguments));
    }
  });
}
/*
/--------------------------------------- FONCTIONS PIECE LIST -----------------------------------------------------------/
*/
function PiecesListPageRight() {
  if ((piecesListCurrentPage * 8) + 8 < pieces.length) {
    piecesListCurrentPage++;
    UpdatePiecesListView(piecesListCurrentPage);
  }
}

function PiecesListPageLeft() {
  if (piecesListCurrentPage >= 1) {
    piecesListCurrentPage--;
    UpdatePiecesListView(piecesListCurrentPage);
  }
}

function PiecesListGoTo(page) {
  if (page === 0) {
    piecesListCurrentPage = page;
    UpdatePiecesListView(page);
  }
  if (page === -1) {
    UpdatePiecesListView(page);
  }
}

function UpdatePiecesListView(pageSetNumber) {
  let start = 0;
  let end = 8;

  if (!pageSetNumber) {
    pageSetNumber = piecesListCurrentPage;
  }

  /* -1 va a la derniere page */
  if (pageSetNumber === -1) {
    end = pieces.length;
    start = Math.floor((pieces.length - 1) / 8) * 8;
    piecesListCurrentPage = Math.floor((pieces.length - 1) / 8);

  } else if (pageSetNumber >= 0) {
    start = pageSetNumber * 8;
    end = start + 8;
  }

  if (!pieces[end - 1]) {
    end = pieces.length;
    start = Math.floor((pieces.length - 1) / 8) * 8;
    piecesListCurrentPage = Math.floor((pieces.length - 1) / 8);
  }

  let body = '<div class="col-sm" id="selectedPiecesListContainerLeft">\n' +
  '\n';

  for (let x = start; x < end; x++) {
    if (x === (start + 4)) {
      body += '</div>\n' +
      '<div class="col-sm" id="selectedPiecesListContainerRight">\n';
    }

    if (pieces[x]) {
      body += '<div class="col-sm" id="singularSelectedPieceBoxContainer"> \n' +
      '<div id="deletePieceIconContainer">\n' +
      '    <div class="btn hover-effect-a" id="deletePieceIcon" onclick="DeletePiece(' + pieces[x].pos_z + ' )">\n' +
      '        <i class="fas fa-trash-alt"></i>\n' +
      '    </div>\n' +
      '</div>' +
      '<span id="singularSelectedPieceNumberContainer">' + pieces[x].pos_z +
      '</span>' +
      '<div class="btn hover-effect-a';

      if (pieces[x].selected) {
        body += ' overlay'
      }


      body += '" id="singularSelectedPieceImageSubContainer" ' +
      'onclick="SelectExistingPiece(' + pieces[x].pos_z + ')">' +
      '<img alt="Une piece parmis pleins" id="selectable_piece_' + pieces[x].pos_z + '" src="' + pieces[x].chemin_piece +
      '" style="max-width: 135px; height: 135px; ';
      if (pieces[x].chemin_piece === "") {
        body += 'visibility: hidden;';
      }
      body += '"' +
      ' >\n' +
      '</div></div>\n';
    }
  }
  body += '</div>';

  document.getElementById("piecesListContainer").innerHTML = body;
  SetPageNumberContainer();
}

function SetPageNumberContainer() {
  let pageCount;
  pageCount = Math.floor(pieces.length / 8);
  if (Math.floor(pieces.length % 8) > 0) {
    pageCount++;
  }
  document.getElementById('pageNumberContainer').innerHTML = '<i> Page ' +
  (piecesListCurrentPage + 1) +
  '/' +
  pageCount +
  '</i>';
}

function getDevis(devisId)
{
  window.open('../controller/DevisController.php?functionname=GenerateDevisPDF' + "&devisId=" + devisId, '_blank');
}

</script>
