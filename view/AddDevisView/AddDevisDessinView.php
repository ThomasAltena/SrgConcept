<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
  <title>Monumac</title>
</head>

<?php
session_start();

if (empty($_SESSION)) {
  header('location:/SrgConcept/view/index.php');

} else {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/SrgConcept/view/header.php');
}


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


$date = date("d-m-Y");

?>
<link rel="stylesheet" href="../../public/css/form.css" type="text/css">
<link rel="stylesheet" href="AddDevisDessin.css" type="text/css">
<link rel="stylesheet" href="../../public/css/switch.css" type="text/css">
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

                <!--CHOIX MATIERE-->
                <div class="input-group mb-3">
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
                </div>

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
                <button class="btn btn-danger hover-effect-a mb-3" style="margin: 0 25px 0 25px; width: 276px;" onclick="GetSome()">
                  Annuler
                </button>
                <button class="btn btn-success hover-effect-a" id='SaveContinueButton' disabled style="margin: 0 25px 0 25px; width: 276px;" onclick="RedirectAddDevisCotesView()">
                  Sauvegarder & Suite
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script type="text/javascript">
function GetSome() {
  let xhttp;
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      console.log(this.responseText);
    }
  };
  xhttp.open("POST", "/SrgConcept/ServiceHelper.php?manager=DevisManager&route=GetDevis", true);
  xhttp.send(JSON.stringify(['26']));
}

let selectedPiece = [];
let pieces = [];
let piecesListCurrentPage = 0;
let format = 'simple';
let matiere = '';
let client = '';

let famille = [];
let sousFamille = [];

let imagePieceSelectionneeSchema = $('#imagePieceSelectionneeSchema');
let imagePieceSelectionnee = $('#imagePieceSelectionnee');
let matiereImagePreview = $('#matiereImagePreview');
let pieceSelector = $('#select_piece');
let schemaPiecesContainer = $('#schemaPiecesContainer');
let piecesListContainer = $('#piecesListContainer');
let pieceSelectControlContainer = $('#pieceSelectControlContainer');

function formValidCheck(){
  if(matiere !== '' && client != '' && pieces.length > 0){
    document.getElementById("SaveContinueButton").disabled = false;
  } else {
    document.getElementById("SaveContinueButton").disabled = true;
  }
}
/*HIDE*/

/*
* Cache la <img> contenant la preview de l'image selectionnee dans schema quand celle ci est vide (au moment de sauvegarde ou selection de 'aucune' piece
*/
function HideSelectedPieceSchema() {
  imagePieceSelectionneeSchema.css({visibility: "hidden"});
}

/*
* Cache la <img> contenant la preview de l'image selectionnee dans selection quand celle ci est vide (au moment de sauvegarde ou selection de 'aucune' piece
*/
function HideSelectedPiecePreview() {
  imagePieceSelectionnee.css({visibility: "hidden"});
}

function ShowSelectedPieceSchema() {
  if (selectedPiece.CheminPiece !== "") {
    imagePieceSelectionnee.prop("src", "../" + selectedPiece.CheminPiece);
    imagePieceSelectionnee.css({position:'relative', width: "inherit", visibility: "visible"});
  }
}

function ShowSelectedPiecePreview() {
  if (selectedPiece.CheminPiece !== "") {
    imagePieceSelectionneeSchema.prop("src", "../" + selectedPiece.CheminPiece);
    imagePieceSelectionneeSchema.css({top: "100px", position:'absolute', width: "680px", minWidth: "680px", maxWidth: "680px", height: "100%", visibility: "visible"});
  }
}

/*RESET*/
function ResetFamilleSelector() {
  $("#select_famille").val("");
}

function ResetSousFamilleSelector() {
  $("#selectSousFamilleContainer").html("<div class=\"input-group-prepend\">\n" +
                                    "<span class=\"input-group-text\" style=\"width:100px\"\n" +
                                    "id=\"Id_ss_famille_label\">Sous-fam :</span>\n" +
                                    "</div>\n" +
                                    "<select name=\"Id_ss_famille\" aria-describedby=Id_ss_famille_label\" id=\"select_ss_famille\" disabled\n" +
                                    "class=\"form-control\" onchange=\"FilterPieces(value)\">\n" +
                                    "</select>");
}

function ResetPieceSelector() {
  $("#selectPieceContainer").html("<div class=\"input-group-prepend\">\n" +
                                    "<span class=\"input-group-text\" style=\"width:100px\" id=\"Id_piece_label\">Piece :</span>\n" +
                                    "</div>\n" +
                                    "<select name=\"Id_piece\" id=\"select_piece\" aria-describedby=Id_piece_label\"\n" +
                                    "onchange=\"SelectPiece()\" class=\"form-control\" disabled>\n" +
                                    "\n" +
                                    "</select>");

  pieceSelectControlContainer.css({visibility: "hidden"});
  document.getElementById('pieceVueContainerCount').innerHTML = '';
}

/*TOGGLE*/

function ToggleSubmitPieceButton(bool) {
  $("#ajouter_piece_button").prop("disabled", !bool);
}

function togglePieces(bool){
  if(format === 'simple'){
    format = 'double';
  } else {
    format = 'simple';
  }
  sousFamille = $("#select_ss_famille").val();
  if(sousFamille != null && sousFamille !== ''){
    FilterPieces(sousFamille);
  }
}

/*
/--------------------------------------- ACTIONS PIECE SELECTION PREVIEW -----------------------------------------------------------/
*/

function selectClient(c) {
  client = JSON.parse(c);
  formValidCheck();
}

function selectMatiere(m) {
  matiere = JSON.parse(m);
  UpdateMatierePreview();
  formValidCheck();
}

function UpdateMatierePreview() {
  if(matiere.CheminMatiere != ''){
    chemin = matiere.CheminMatiere;
    if(matiere.CheminMatiere.includes("../")){
      chemin = chemin.replace("../", "/SrgConcept/");
    }
    matiereImagePreview.prop("src", chemin);
    matiereImagePreview.css({position:'absolute', width: "680px", minWidth: "680px", maxWidth: "680px", visibility: "visible"});
  } else {
    matiereImagePreview.prop("alt", "Aucune image matiere disponible");
    matiereImagePreview.css({visibility: "visible"});
  }
}

function FilterSousFamille(familleJson) {
  famille = JSON.parse(familleJson);

  let xhttp;
  ResetPieceSelector();
  HideSelectedPieceSchema();
  HideSelectedPiecePreview();
  if (famille.CodeFamille === "") {
    ResetSousFamilleSelector();
    ToggleSubmitPieceButton(false);
  } else {
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
      if (this.readyState === 4 && this.status === 200) {
        document.getElementById("selectSousFamilleContainer").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "/SrgConcept/view/AddDevisView/AddDevisDessinGetListModule.php?functionname=GetFilteredSousFamille&codeFamille=" + famille.CodeFamille, true);
    xhttp.send();
  }
}

function FilterPieces(sousFamilleJson, id_piece_to_select) {
  sousFamille = JSON.parse(sousFamilleJson);
  let xhttp;
  if (sousFamille.CodeSsFamille === "" || famille.CodeFamille === "") {
    ResetPieceSelector();

    ToggleSubmitPieceButton(false);
    HideSelectedPieceSchema();
    HideSelectedPiecePreview();
  } else {
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
      if (this.readyState === 4 && this.status === 200) {
        document.getElementById("selectPieceContainer").innerHTML = this.responseText;
        UpdateImageCount();
        SelectPiece();
      }
    };
    xhttp.open("GET", "/SrgConcept/view/AddDevisView/AddDevisDessinGetListModule.php?functionname=GetFilteredPieces&codeFamille=" + famille.CodeFamille + "&codeSs=" + sousFamille.CodeSsFamille + "&format=" + format, true);
    xhttp.send();
  }
}

function UpdateImageCount() {
  let piecesCount = document.getElementById('select_piece').options.length;
  let body = '';
  if (piecesCount > 1) {
    pieceSelectControlContainer.css({visibility: "visible"});
    let selectedIndex = document.getElementById('select_piece').selectedIndex;
    body = 'Piece ' + (selectedIndex) + '/' + (piecesCount-1);
  } else {
    pieceSelectControlContainer.css({visibility: "hidden"});
  }
  document.getElementById('pieceVueContainerCount').innerHTML = body;
}

function PiecesSelectListGoTo(page) {
  let optionsLength = document.getElementById("select_piece").options.length;
  if (optionsLength > 1) {
    if (page === 1) {
      document.getElementById("select_piece").options.selectedIndex = 1;
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
  if (newSelect >= 1) {
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
    body += '<img alt="Une piece parmis pleins sur schema" id="schema_piece_' + piece.IdPiece + '" ' +
    'src="' + '../' + piece.CheminPiece + '" ' +
    'style="width:680px; max-width:680px; min-width:680px; height:100%;' +
    'position: absolute; left:0px ; top:100px ; ';
    if (piece.CheminPiece === "") {
      body += 'visibility: hidden;';
    }
    body += '" >\n'
  });
  body += '<img alt="La piece couramment selectionnee sur schema" id="imagePieceSelectionneeSchema" src="" style="visibility: hidden">\n';
  schemaPiecesContainer.html(body);
}
/*
/--------------------------------------- ACTIONS PIECE -----------------------------------------------------------/
*/

function SelectPiece() {
  let select = document.getElementById('select_piece');
  // Si une  nouvelle piece est selectionnee par l'utilisateur et non rechargee depuis la selection dune piece existante
  if (select.value !== "") {
    selectedPiece = JSON.parse(select.value);
    ShowSelectedPieceSchema();
    ShowSelectedPiecePreview();
    ToggleSubmitPieceButton(true);
  } else {
    ReloadSchema();
    ToggleSubmitPieceButton(false);
    HideSelectedPieceSchema();
    HideSelectedPiecePreview();

  }
  UpdateImageCount();
}

function DeletePiece(x) {
  pieces.splice(x, 1);
  UpdatePiecesListView(piecesListCurrentPage);
  ReloadSchema();
  if(pieces.length == 0){
    document.getElementById("simpleOuDouble").disabled = false;
  }
  formValidCheck();
}

function SelectExistingPiece(x){
  if(pieces[x].selected){
    pieces[x].selected = false;
  } else {
    pieces.forEach(piece => {
      piece.selected = false;
    });
    pieces[x].selected = true;
  }
  UpdatePiecesListView(piecesListCurrentPage);
}

function SauvegarderNouvellePiece() {
  document.getElementById("simpleOuDouble").disabled = true;

  pieces.push(selectedPiece);
  ReloadSchema();
  HideSelectedPieceSchema();
  UpdatePiecesListView(-1);
  formValidCheck();
}

function RedirectDevisListView(){
  window.location.replace("/SrgConcept/view/DevisView.php");
}

function RedirectAddDevisCotesView(){
  SauvegarderDevis();
}

function SauvegarderDevis() {
  html2canvas($("#schemaPiecesContainer"), {
    onrendered: function(canvas) {
      let client = JSON.parse(document.getElementById('id_client').value);
      let dataURL = canvas.toDataURL("image/png");
      let matiere = JSON.parse(document.getElementById('id_matiere').value);
      let arguments = [matiere, client, dataURL, pieces];

      let xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
          try {
            responseText = JSON.parse(this.responseText);
            if(responseText.error){
              console.log(responseText);
            } else {
              console.log(responseText);
              window.location.replace("AddDevisCotesView.php?devisId=" + responseText.devisResults.devis.IdDevis);
            }
          }
          catch (error){
            console.log(error);
          }
        }
      };
      xhttp.open("POST", "/SrgConcept/controller/DevisController.php?functionname=" + 'SauvegarderDevis' , true);
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
      '    <div class="btn hover-effect-a" id="deletePieceIcon" onclick="DeletePiece(' + x + ' )">\n' +
      '        <i class="fas fa-trash-alt"></i>\n' +
      '    </div>\n' +
      '</div>' +
      '<span id="singularSelectedPieceNumberContainer">' + x +
      '</span>' +
      '<div class="btn hover-effect-a';

      if (pieces[x].selected) {
        body += ' overlay'
      }


      body += '" id="singularSelectedPieceImageSubContainer"' +
      'onclick="SelectExistingPiece(' + x + ')">' +
      '<img alt="Une piece parmis pleins" id="selectable_piece_' + pieces[x].IdPiece + '" src="' + '../' + pieces[x].CheminPiece +
      '" style="max-width: 135px; height: 135px; ';
      if (pieces[x].CheminPiece === "") {
        body += 'visibility: hidden;';
      }
      body += '"' +
      ' >\n' +
      '</div></div>\n';
    }
  }
  body += '</div>';
  piecesListContainer.html(body);
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
