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
<link rel="stylesheet" href="../../public/css/AddDevis.css" type="text/css">
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
                  <select name="Id_client" id="id_client" aria-describedby="Id_client_label" class="form-control">
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
                  <select id="id_matiere"  onchange="SelectMatiere(value)" class="form-control" name="Id_matiere" aria-describedby="Id_matiere_label">
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
              <button class="btn btn-success col-lg-12 hover-effect-a" onclick="RedirectAddDevisCotesView()">
                Suite
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
let selectedPiece = [];
let pieces = [];
let piecesListCurrentPage = 0;
let format = 'simple';
let matiere = '';

let famille = [];
let sousFamille = [];

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

/*SHOW*/
function ShowSelectedPieceSchema() {
  if (selectedPiece.CheminPiece !== "") {
    let imagePieceSelectionnee = document.getElementById('imagePieceSelectionnee');
    imagePieceSelectionnee.setAttribute('style', 'visibility: visible');
    imagePieceSelectionnee.setAttribute("src", '../' + selectedPiece.CheminPiece);
    imagePieceSelectionnee.style.width = "inherit";
    imagePieceSelectionnee.style.position = "relative";
  }
}

function ShowSelectedPiecePreview() {
  if (selectedPiece.CheminPiece !== "") {
    let imagePieceSelectionneeSchema = document.getElementById('imagePieceSelectionneeSchema');
    imagePieceSelectionneeSchema.setAttribute('style', 'visibility: visible');
    imagePieceSelectionneeSchema.setAttribute("src", '../' + selectedPiece.CheminPiece);
    imagePieceSelectionneeSchema.style.position = "absolute";
    imagePieceSelectionneeSchema.style.maxWidth = "680px";
    imagePieceSelectionneeSchema.style.width = "680px";
    imagePieceSelectionneeSchema.style.height = "100%";
    imagePieceSelectionneeSchema.style.minWidth = "680px";
    $('#imagePieceSelectionneeSchema').css({top: "100px", position:'absolute'});
    //$('#imagePieceSelectionneeSchema').css({position:'absolute'});
  }
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

/*TOGGLE*/

function ToggleSubmitPieceButton(bool) {
  $("#ajouter_piece_button").attr("disabled", !bool);
}

function togglePieces(bool){
  if(format === 'simple'){
    format = 'double';
  } else {
    format = 'simple';
  }
  sousFamille = document.getElementById('select_ss_famille').value;
  if(sousFamille != null && sousFamille !== ''){
    FilterPieces(sousFamille);
  }
}

/*
/--------------------------------------- ACTIONS PIECE SELECTION PREVIEW -----------------------------------------------------------/
*/

function SelectMatiere(m) {
  matiere = JSON.parse(m);
  UpdateMatierePreview();
}

function UpdateMatierePreview() {
  let imageMatiereSelectionnee = document.getElementById('matiereImagePreview');
  if(matiere.CheminMatiere != ''){
    if(matiere.CheminMatiere.includes("../")){
      chemin = matiere.CheminMatiere.replace("../", "/SrgConcept/");
    } else {
      chemin = matiere.CheminMatiere;
    }
    imageMatiereSelectionnee.setAttribute('style', 'visibility: visible');
    imageMatiereSelectionnee.setAttribute("src", chemin);
    imageMatiereSelectionnee.style.position = "absolute";
    imageMatiereSelectionnee.style.maxWidth = "680px";
    imageMatiereSelectionnee.style.width = "680px";
    imageMatiereSelectionnee.style.height = "300";
  } else {
    imageMatiereSelectionnee.setAttribute('style', 'visibility: hidden');
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
    xhttp.open("GET", "/SrgConcept/view/AddDevisView/GetListModule.php?functionname=GetFilteredSousFamille&codeFamille=" + famille.CodeFamille, true);
    xhttp.send();
  }
}

function FilterPieces(sousFamilleJson, id_piece_to_select) {
  sousFamille = JSON.parse(sousFamilleJson);
  let xhttp;
  if (sousFamille.CodeSsFamille === "" || famille.CodeFamille === "") {
    ResetPieceSelector();
    UpdateImageCount();
    ToggleSubmitPieceButton(false);
    HideSelectedPieceSchema();
    HideSelectedPiecePreview();
  } else {
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
      if (this.readyState === 4 && this.status === 200) {
        document.getElementById("selectPieceContainer").innerHTML = this.responseText;
        SelectPiece();
      }
    };
    xhttp.open("GET", "/SrgConcept/view/AddDevisView/GetListModule.php?functionname=GetFilteredPieces&codeFamille=" + famille.CodeFamille + "&codeSs=" + sousFamille.CodeSsFamille + "&format=" + format, true);
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
  document.getElementById("schemaPiecesContainer").innerHTML = body;
}
/*
/--------------------------------------- ACTIONS PIECE -----------------------------------------------------------/
*/

function SelectPiece() {
  let select = document.getElementById('select_piece');
  selectedPiece = JSON.parse(select.value);
  // Si une  nouvelle piece est selectionnee par l'utilisateur et non rechargee depuis la selection dune piece existante
  if (select.value !== "") {
    let imagePieceSelectionneeSchema = $('#imagePieceSelectionneeSchema');
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
  pieces.push(selectedPiece);
  ReloadSchema();
  //ToggleSubmitPieceButton(false);
  HideSelectedPieceSchema();
  //HideSelectedPiecePreview();
  UpdatePiecesListView(-1);
}

function RedirectAddDevisCotesView(){
  let arguments = [pieces, matiere, client];

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
  xhttp.open("POST", "AddDevisCotesView.php", true);
  xhttp.send(JSON.stringify(arguments));
}

function SauvegarderDevis() {
  html2canvas($("#schemaPiecesContainer"), {
    onrendered: function(canvas) {
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
      xhttp.open("POST", "../controller/DevisController.php?functionname=" + 'SauvegarderDevis' , true);
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
