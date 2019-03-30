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


?>
<link rel="stylesheet" href="../../public/css/form.css" type="text/css">
<link rel="stylesheet" href="AddDevisDessin.css" type="text/css">
<link rel="stylesheet" href="../../public/css/switch.css" type="text/css">
<!-------------------------- Il faut mettre le chemin dans les value -------------------------->
<body style="overflow: scroll;">
  <div id='viewContainer'></div>
</body>
<script type="text/javascript">

let selectedPiece = [];
let pieces = [];
let piecesListCurrentPage = 0;
let format = 'simple';
let matiere = '';
let client = '';
let devis;

let famille = [];
let sousFamille = [];
let vueChoixClient, vueClientDevisId, NumeroDevis, LibelleClient;
let imagePieceSelectionneeSchema, imagePieceSelectionnee, matiereImagePreview, schemaPiecesContainer, piecesListContainer, pieceSelectControlContainer;
let sousFamilleSelectContainer, pieceSelector, clientSelector;
let allSousFamilles, allPieces;

LoadView();
let idDevis = findGetParameter('idDevis');
idDevis = 47;
if(idDevis){
  LoadDevis(idDevis);
}

function LoadDevis(id){
  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      devis = JSON.parse(this.responseText);
      pieces = devis.pieces;
      vueChoixClient.prop("hidden", true);
      vueClientDevisId.prop("hidden", false);
      NumeroDevis.val(id);
      LibelleClient.val(devis.client.NomClient.toUpperCase() + ' ' + devis.client.PrenomClient);
      client = devis.client;
      matiere = '';
      ReloadSchema();
      UpdatePiecesListView(-1);
      console.log(devis);
    }
  };
  xhttp.open("POST", "/SrgConcept/ServiceHelper.php?manager=DevisManager&route=GetDevisData", true);
  xhttp.send(JSON.stringify([id]));
}

function LoadView(){
  let xhttp;
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      $('#viewContainer').html(this.responseText);
      imagePieceSelectionneeSchema = $('#imagePieceSelectionneeSchema');
      imagePieceSelectionnee = $('#imagePieceSelectionnee');
      matiereImagePreview = $('#matiereImagePreview');
      pieceSelector = $('#select_piece');
      schemaPiecesContainer = $('#schemaPiecesContainer');
      piecesListContainer = $('#piecesListContainer');
      pieceSelectControlContainer = $('#pieceSelectControlContainer');
      sousFamilleSelectContainer = $('#selectSousFamilleContainer');
      clientSelector = $('#id_client');
      vueChoixClient = $('#vueChoixClient');
      vueClientDevisId = $('#vueClientDevisId');
      NumeroDevis = $('#NumeroDevis');
      LibelleClient = $('#LibelleClient');
    }
  };
  xhttp.open("POST", "AddDevisDessinView.php", true);
  xhttp.send();
}

function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
          tmp = item.split("=");
          if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });

    return result;
}

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
        GenerateSousFamillesOptions(this.responseText)
      }
    };
    xhttp.open("POST", "/SrgConcept/ServiceHelper.php?manager=SousfamilleManager&route=GetSousfamilleByFamilleOrderByRegroupement&originalObject=true", true);
    xhttp.send(JSON.stringify([famille.CodeFamille]));
  }
}

function GenerateSousFamillesOptions(responseText){
  let body = '<div class="input-group-prepend"><span class="input-group-text" style="width:100px" id="Id_ss_famille_label">Sous-fam :</span></div>';
  if(responseText == undefined){
    body += '<select name="Id_ss_famille" id="select_ss_famille" disabled aria-describedby=Id_ss_famille_label" onchange="FilterPieces(value)" class="form-control">'
    body += '<option value="" disabled selected>Aucune piece dans categorie</option></select>';
    sousFamilleSelectContainer.html(body);
  } else {
    body += '<select name="Id_ss_famille" id="select_ss_famille" aria-describedby=Id_ss_famille_label" onchange="FilterPieces(value)" class="form-control">'
    body += '<option value="" disabled>Aucune</option>';
    let regroupement = '';

    allSousFamilles = JSON.parse(responseText);
    allSousFamilles.forEach(function (sf){
      if(regroupement != sf.RegroupementSsFamille){
        regroupement = sf.RegroupementSsFamille;
        body += '<option disabled value="' + regroupement + '"> --- ' + regroupement + ' --- </option>';
      }
      body += "<option value='" + JSON.stringify(sf) + "'>" + sf.LibelleSsFamille + "</option>";
    });
    body += '</select>'
    $('#Id_ss_famille :nth-child(2)').prop('selected', true);
    sousFamilleSelectContainer.html(body);
    FilterPieces(JSON.stringify(allSousFamilles[0]));
  }
}

function FilterPieces(sousFamilleJson) {
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

function SauvegarderDevis() {
  html2canvas($("#schemaPiecesContainer"), {
    onrendered: function(canvas) {
      let xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
          try {
            responseText = JSON.parse(this.responseText);
            if(responseText.error){
              console.log(responseText);
            } else {
              console.log(responseText);
              //window.location.replace("AddDevisCotesViewModel.php?idDevis=" + responseText.devisResults.devis.IdDevis);
            }
          }
          catch (error){
            console.log(error, this.responseText);
          }
        }
      };
      let route = '';
      let arguments = [];
      let dataURL = canvas.toDataURL("image/png");
      if(idDevis){
        arguments = [devis, pieces, dataURL];
        console.log(arguments);
        route = "/SrgConcept/ServiceHelper.php?manager=DevisManager&route=UpdateDevisDessin";
      } else {
        let client = JSON.parse(clientSelector.val());
        let matiere = JSON.parse(document.getElementById('id_matiere').value);
        arguments = [matiere, client, dataURL, pieces];
        route = "/SrgConcept/ServiceHelper.php?manager=DevisManager&route=SaveDevisDessin";
      }
      xhttp.open("POST", route, true);
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
