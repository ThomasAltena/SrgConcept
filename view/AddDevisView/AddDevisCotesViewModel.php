<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
  <title>Monumac</title>
</head>

<?php
session_start();
if (empty($_SESSION)) {
  header('location:/SrgConcept/view/index.php');
} else if(!isset($_GET['idDevis'])){
  header('location:/SrgConcept/view/DevisView.php');
} else {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/SrgConcept/view/header.php');
}

?>
<link rel="stylesheet" href="/SrgConcept/public/css/form.css" type="text/css">
<link rel="stylesheet" href="/SrgConcept/public/css/table.css" type="text/css">
<link rel="stylesheet" href="AddDevisCotes.css" type="text/css">
<link rel="stylesheet" href="/SrgConcept/public/css/switch.css" type="text/css">
<!-------------------------- Il faut mettre le chemin dans les value -------------------------->
<body style="overflow: auto;">
  <div  id='viewContainer'></div>
</body>
<style>
.td {
  padding-top: 5px;
  padding-bottom: 5px;
}
</style>
<script type="text/javascript">
let FraisDePortDevis, RemiseDevis, CubesDevisTable, NumeroDevis, DateDevis, LibelleDevis, ClientDevis, AquisDevis, DosPolisDevis, TypeDevis, MatiereDevis, ArrondiDevis, PrixDevis, TvaDevis, PUTransportDevis, SurfaceDevis, VolumeDevis, PoidsDevis, NombrePiecesDevis, NombreCubesDevis,PrixMatiereDevis, PrixFaconnageDevis, PrixOptionsDevis, MonumentHTDevis, MonumentTTCDevis, ArticlesHTDevis, ArticlesTTCDevis, NetsHTDevis, NetsTTCDevis;
let devis;
let PrixMatiere, PrixFaconnage, PrixOptions, MonumentHT, MonumentTTC, ArticlesHT, ArticlesTTC, NetsHT, NetsTTC, PoidsTotal, VolumeTotal, SurfaceTotal;

let CubeModalContainer, CodeCubeModal, LibelleCubeModal, LargeurCubeModal, HauteurCubeModal, ProfondeurCubeModal, QuantiteCubeModal;
let MatiereCubeModal, SurfaceCubeModal, VolumeCubeModal, PoidsCubeModal, PrixMatiereCubeModal, PrixFaconnadeCubeModal;
let SurfaceAvantCubeModal, SurfaceAvantPolieCubeModal, SurfaceAvantScieeCubeModal;
let SurfaceArriereCubeModal, SurfaceArrierePolieCubeModal, SurfaceArriereScieeCubeModal;
let SurfaceDroiteCubeModal, SurfaceDroitePolieCubeModal, SurfaceDroiteScieeCubeModal;
let SurfaceGaucheCubeModal, SurfaceGauchePolieCubeModal, SurfaceGaucheScieeCubeModal;
let SurfaceDessusCubeModal, SurfaceDessusPolieCubeModal, SurfaceDessusScieeCubeModal;
let SurfaceDessousCubeModal, SurfaceDessousPolieCubeModal, SurfaceDessousScieeCubeModal;

let masseVolumique = 2700;
let matieres;
let selectedCube;
let matieresOptions;
let idDevis = findGetParameter('idDevis');
LoadView();

const unique = (value, index, self) => {
  return self.indexOf(value) === index;
};

const add = (a,b) => {
  return parseInt(a) + parseInt(b)
};

function LoadView(){
  let xhttp;
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      $('#viewContainer').html(this.responseText);
      NumeroDevis = $('#NumeroDevis');
      DateDevis = $('#DateDevis');
      LibelleDevis = $('#LibelleDevis');
      ClientDevis = $('#ClientDevis');
      AquisDevis = $('#AquisDevis');
      DosPolisDevis = $('#DosPolisDevis');
      TypeDevis = $('#TypeDevis');
      MatiereDevis = $('#MatiereDevis');
      ArrondiDevis = $('#ArrondiDevis');
      PrixDevis = $('#PrixDevis');
      TvaDevis = $('#TvaDevis');
      RemiseDevis = $('#RemiseDevis');
      PUTransportDevis = $('#PUTransportDevis');
      SurfaceDevis = $('#SurfaceDevis');
      VolumeDevis = $('#VolumeDevis');
      PoidsDevis = $('#PoidsDevis');
      NombrePiecesDevis = $('#NombrePiecesDevis');
      NombreCubesDevis = $('#NombreCubesDevis');
      PrixMatiereDevis = $('#PrixMatiereDevis');
      PrixFaconnageDevis = $('#PrixFaconnageDevis');
      PrixOptionsDevis = $('#PrixOptionsDevis');
      MonumentHTDevis = $('#MonumentHTDevis');
      MonumentTTCDevis = $('#MonumentTTCDevis');
      ArticlesHTDevis = $('#ArticlesHTDevis');
      ArticlesTTCDevis = $('#ArticlesTTCDevis');
      NetsHTDevis = $('#NetsHTDevis');
      NetsTTCDevis = $('#NetsTTCDevis');
      CubesDevisTable = $('#CubesDevisTable');
      FraisDePortDevis = $('#FraisDePortDevis');
      CubeModalContainer = $('#CubeModalContainer');
      LoadCubeModal();
    }
  };
  xhttp.open("POST", "AddDevisCotesView.php", true);
  xhttp.send();
}

function LoadCubeModal(){
  let xhttp;
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      CubeModalContainer.html(this.responseText);
      CubeModalContainer = $('#CubeModalContainer');
      CodeCubeModal = $('#CodeCubeModal');
      LibelleCubeModal = $('#LibelleCubeModal');
      LargeurCubeModal = $('#LargeurCubeModal');
      HauteurCubeModal = $('#HauteurCubeModal');
      ProfondeurCubeModal = $('#ProfondeurCubeModal');
      QuantiteCubeModal = $('#QuantiteCubeModal');

      MatiereCubeModal = $('#MatiereCubeModal');
      SurfaceCubeModal = $('#SurfaceCubeModal');
      VolumeCubeModal = $('#VolumeCubeModal');
      PoidsCubeModal = $('#PoidsCubeModal');
      PrixMatiereCubeModal = $('#PrixMatiereCubeModal');
      PrixFaconnadeCubeModal = $('#PrixFaconnadeCubeModal');

      SurfaceAvantCubeModal = $('#SurfaceAvantCubeModal');
      SurfaceAvantPolieCubeModal = $('#SurfaceAvantPolieCubeModal');
      SurfaceAvantScieeCubeModal = $('#SurfaceAvantScieeCubeModal');

      SurfaceArriereCubeModal = $('#SurfaceArriereCubeModal');
      SurfaceArrierePolieCubeModal = $('#SurfaceArrierePolieCubeModal');
      SurfaceArriereScieeCubeModal = $('#SurfaceArriereScieeCubeModal');

      SurfaceDroiteCubeModal = $('#SurfaceDroiteCubeModal');
      SurfaceDroitePolieCubeModal = $('#SurfaceDroitePolieCubeModal');
      SurfaceDroiteScieeCubeModal = $('#SurfaceDroiteScieeCubeModal');

      SurfaceGaucheCubeModal = $('#SurfaceGaucheCubeModal');
      SurfaceGauchePolieCubeModal = $('#SurfaceGauchePolieCubeModal');
      SurfaceGaucheScieeCubeModal = $('#SurfaceGaucheScieeCubeModal');

      SurfaceDessusCubeModal = $('#SurfaceDessusCubeModal');
      SurfaceDessusPolieCubeModal = $('#SurfaceDessusPolieCubeModal');
      SurfaceDessusScieeCubeModal = $('#SurfaceDessusScieeCubeModal');

      SurfaceDessousCubeModal = $('#SurfaceDessousCubeModal');
      SurfaceDessousPolieCubeModal = $('#SurfaceDessousPolieCubeModal');
      SurfaceDessousScieeCubeModal = $('#SurfaceDessousScieeCubeModal');

      GetDevisData();
    }
  };
  xhttp.open("POST", "CubeCotesModalView.php", true);
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

function GetDevisData() {
  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      console.log(this.responseText);
      devis = JSON.parse(this.responseText);
      console.log(devis);
      FillDevisInfo();
      FillTableDevis();
      GetMatieres();
      UpdateDimensions();
    }
  };
  xhttp.open("POST", "/SrgConcept/ServiceHelper.php?manager=DevisManager&route=GetDevisData", true);
  xhttp.send(JSON.stringify([idDevis]));
}

function FillDevisInfo(){
  NumeroDevis.val(devis.IdDevis);
  DateDevis.val(devis.DateDevis);
  LibelleDevis.val(devis.LibelleDevis);
  ClientDevis.val(devis.client.NomClient.toUpperCase() + ' ' + devis.client.PrenomClient);
  AquisDevis.prop('checked', devis.AquisDevis == '1' ? true : false);
  DosPolisDevis.prop('checked', devis.DosPolisDevis == '1' ? true : false);
  TypeDevis.val(devis.TypeDevis);
  ArrondiDevis.val(devis.ArrondiDevis);
  RemiseDevis.val(devis.RemiseDevis);
  PrixDevis.val(devis.PrixDevis);
  TvaDevis.val(devis.TvaDevis);
  PUTransportDevis.val(devis.PUTransportDevis);

  NombrePiecesDevis.val(devis.cubes.map(x => x.IdPieceDevis).filter(unique).length);
  NombreCubesDevis.val(devis.cubes.map(x => x.QuantiteCubeDevis).reduce(add, 0));
}

function FillTableDevis(){
  let body = '';
  devis.cubes.forEach(function(cube){
    body += '<tr>';
    body += '<td class="text-left td"style="padding: 6px; font-size: 16px;"><button class="btn btn-primary form-control" style="padding:6px" data-toggle="modal" data-target="#CubeDevisModal" onclick="OpenModal(' + cube.IdCubeDevis + ')"><i class="far fa-edit"></i></button></td>';
    body += '<td class="text-left td"style="padding: 6px; font-size: 16px; width:180px"><input onchange="UpdateCube(' + cube.IdCubeDevis + ')" class="form-control" style="padding:6px;" value="' + cube.LibelleCubeDevis + '" id="LibelleCube' + cube.IdCubeDevis + '"></input></td>';
    body += '<td class="text-left td"style="padding: 6px; font-size: 16px; width:120px" id="MatiereSelectContainerCube' + cube.IdCubeDevis + '"></td>';
    body += '<td class="text-left td"style="padding: 6px; font-size: 16px;"><input onchange="UpdateCube(' + cube.IdCubeDevis + ')" type="number" class="form-control" style="padding:6px;" value="' + cube.LargeurCubeDevis + '" id="CoteLargeurCube' + cube.IdCubeDevis + '"></input></td>';
    body += '<td class="text-left td"style="padding: 6px; font-size: 16px;"><input onchange="UpdateCube(' + cube.IdCubeDevis + ')" type="number" class="form-control" style="padding:6px;" value="' + cube.LargeurExacteCubeDevis + '" id="CoteLargeurExacteCube' + cube.IdCubeDevis + '"></input></td>';
    body += '<td class="text-left td"style="padding: 6px; font-size: 16px;"><input onchange="UpdateCube(' + cube.IdCubeDevis + ')" type="number" class="form-control" style="padding:6px;" value="' + cube.ProfondeurCubeDevis + '" id="CoteProfondeurCube' + cube.IdCubeDevis + '"></input></td>';
    body += '<td class="text-left td"style="padding: 6px; font-size: 16px;"><input onchange="UpdateCube(' + cube.IdCubeDevis + ')" type="number" class="form-control" style="padding:6px;" value="' + cube.ProfondeurExacteCubeDevis + '" id="CoteProfondeurExacteCube' + cube.IdCubeDevis + '"></input></td>';
    body += '<td class="text-left td"style="padding: 6px; font-size: 16px;"><input onchange="UpdateCube(' + cube.IdCubeDevis + ')" type="number" class="form-control" style="padding:6px;" value="' + cube.HauteurCubeDevis + '" id="CoteHauteurCube' + cube.IdCubeDevis + '"></input></td>';
    body += '<td class="text-left td"style="padding: 6px; font-size: 16px;"><input onchange="UpdateCube(' + cube.IdCubeDevis + ')" type="number" class="form-control" style="padding:6px;" value="' + cube.HauteurExacteCubeDevis + '" id="CoteHauteurExacteCube' + cube.IdCubeDevis + '"></input></td>';
    body += '<td class="text-left td"style="padding: 6px; font-size: 16px;"><input onchange="UpdateCube(' + cube.IdCubeDevis + ')" type="number" class="form-control" style="padding:6px;" value="' + cube.QuantiteCubeDevis + '" id="QuantiteCube' + cube.IdCubeDevis + '"></input></td>';
    body += '<td class="text-left td"style="padding: 6px; font-size: 16px;"><input class="form-control" style="padding:6px;" disabled value="" id="CoutCube' + cube.IdCubeDevis + '"></input></td></tr>';
  });
  CubesDevisTable.html(body);
}

function OpenModal(id){
  let cube = devis.cubes.find(x => x.IdCubeDevis == id);
  selectedCube = cube;

  CodeCubeModal.val(cube.CodeGroupCube);
  LibelleCubeModal.val(cube.LibelleCubeDevis);
  LargeurCubeModal.val(cube.LargeurCubeDevis);
  HauteurCubeModal.val(cube.HauteurCubeDevis);
  ProfondeurCubeModal.val(cube.ProfondeurCubeDevis);
  QuantiteCubeModal.val(cube.QuantiteCubeDevis);
  MatiereCubeModal.val(cube.IdMatiere);

  UpdateCubeModalDimensionsPrix(cube);

  SurfaceAvantPolieCubeModal.prop('checked', cube.AvantPolisCube == '1' ? true : false);
  SurfaceAvantScieeCubeModal.prop('checked', cube.AvantScieeCube == '1' ? true : false);

  SurfaceArrierePolieCubeModal.prop('checked', cube.ArrierePolisCube == '1' ? true : false);
  SurfaceArriereScieeCubeModal.prop('checked', cube.ArriereScieeCube == '1' ? true : false);

  SurfaceDroitePolieCubeModal.prop('checked', cube.DroitePolisCube == '1' ? true : false);
  SurfaceDroiteScieeCubeModal.prop('checked', cube.DroiteScieeCube == '1' ? true : false);

  SurfaceGauchePolieCubeModal.prop('checked', cube.GauchePolisCube == '1' ? true : false);
  SurfaceGaucheScieeCubeModal.prop('checked', cube.GaucheScieeCube == '1' ? true : false);

  SurfaceDessusPolieCubeModal.prop('checked', cube.DessusPolisCube == '1' ? true : false);
  SurfaceDessusScieeCubeModal.prop('checked', cube.DessusScieeCube == '1' ? true : false);

  SurfaceDessousPolieCubeModal.prop('checked', cube.DessousPolisCube == '1' ? true : false);
  SurfaceDessousScieeCubeModal.prop('checked', cube.DessousScieeCube == '1' ? true : false);
}

function UpdateCubeModalDimensionsPrix(cube){
  let devantArriere = (cube.HauteurCubeDevis * cube.LargeurCubeDevis)*2;
  let dessusDessous = (cube.LargeurCubeDevis * cube.ProfondeurCubeDevis)*2;
  let droiteGauche = (cube.HauteurCubeDevis * cube.ProfondeurCubeDevis)*2;
  let surfaceTotalM3 = (devantArriere + dessusDessous + droiteGauche) * cube.QuantiteCubeDevis * 0.01;
  let volumeTotalM3 = (cube.HauteurCubeDevis * cube.LargeurCubeDevis * cube.ProfondeurCubeDevis * cube.QuantiteCubeDevis) * 0.000001;
  let masseTonne = volumeTotalM3 * masseVolumique * 0.001;

  SurfaceCubeModal.val(surfaceTotalM3);
  VolumeCubeModal.val(volumeTotalM3);
  PoidsCubeModal.val(masseTonne);


  SurfaceAvantCubeModal.val(devantArriere * 0.01);
  SurfaceArriereCubeModal.val(devantArriere * 0.01);
  SurfaceDroiteCubeModal.val(droiteGauche * 0.01);
  SurfaceGaucheCubeModal.val(droiteGauche * 0.01);
  SurfaceDessusCubeModal.val(dessusDessous * 0.01);
  SurfaceDessousCubeModal.val(dessusDessous * 0.01);

  PrixMatiereCubeModal.val(cube.prixMatiere);
  PrixFaconnadeCubeModal.val(cube.prixFaconnage);
}


function GetMatieres(){
  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      matieres = JSON.parse(this.responseText);
      FillMatiereTableDevis();
      UpdatePrix();
    }
  };
  xhttp.open("POST", "/SrgConcept/ServiceHelper.php?manager=MatiereManager&route=GetAllMatiere&originalObject=true", true);
  xhttp.send();
}

function UpdateMatiereAll(value){
  devis.cubes.forEach(function(cube){
    cube.IdMatiere = value;
    $('#MatiereSelectCube' + cube.IdCubeDevis).val(value);
    if(!cube.ToInsert){
      cube.ToUpdate = true;
    };
  });
}

function FillMatiereTableDevis(){
  matieresOptions = '';
  matieres.forEach(function(matiere){
    matieresOptions += '<option value="' + matiere.IdMatiere + '">' + matiere.CodeMatiere + ' - ' + matiere.LibelleMatiere + '</option>'
  });

  devis.cubes.forEach(function(cube){
    cube.matiere = matieres.find(x => x.IdMatiere == cube.IdMatiere);
    UpdatePrixCube(cube);

    let container = $('#MatiereSelectContainerCube' + cube.IdCubeDevis);
    let body = '<select style="padding:6px;" onchange="UpdateCube(' + cube.IdCubeDevis + ')" class="form-control" id="MatiereSelectCube' + cube.IdCubeDevis + '" >';
    body += matieresOptions;
    body += '</select>'
    container.html(body);

    $('#MatiereSelectCube' + cube.IdCubeDevis).val(cube.IdMatiere);
  });

  MatiereCubeModal.html(matieresOptions);
  MatiereDevis.html(matieresOptions);
}

function UpdatePrixCube(cube){
  let volumeM3 = cube.LargeurCubeDevis * cube.ProfondeurCubeDevis * cube.HauteurCubeDevis * cube.QuantiteCubeDevis / 1000000;
  let masseTonne = masseVolumique * volumeM3 /1000;
  let prixMatiere = 0;
  let prixPolissage = 0;
  let prixScieage = 0;
  if(cube.matiere){
    prixMatiere = cube.matiere.PrixMatiere;
    prixPolissage = cube.matiere.PrixPolissage;
    prixScieage = cube.matiere.PrixScieage;
  }
  cube.prixMatiere = prixMatiere * masseTonne;

  let surfaceAvantArriereM3 = cube.HauteurCubeDevis * cube.LargeurCubeDevis * 0.01;
  let surfaceDroiteGaucheM3 = cube.ProfondeurCubeDevis * cube.HauteurCubeDevis * 0.01;
  let surfaceDessusDessousM3 = cube.ProfondeurCubeDevis * cube.LargeurCubeDevis * 0.01;

  let surfacePolissage = 0;
  surfacePolissage += cube.AvantPolisCube == 1 ? surfaceAvantArriereM3 : 0;
  surfacePolissage += cube.ArrierePolisCube == 1 ? surfaceAvantArriereM3 : 0;
  surfacePolissage += cube.DroitePolisCube == 1 ? surfaceDroiteGaucheM3 : 0;
  surfacePolissage += cube.GauchePolisCube == 1 ? surfaceDroiteGaucheM3 : 0;
  surfacePolissage += cube.DessusPolisCube == 1 ? surfaceDessusDessousM3 : 0;
  surfacePolissage += cube.DessousPolisCube == 1 ? surfaceDessusDessousM3 : 0;
  cube.prixPolissage = prixPolissage * surfacePolissage;

  let surfaceSciage = 0;
  surfaceSciage += cube.AvantScieeCube == 1 ? surfaceAvantArriereM3 : 0;
  surfaceSciage += cube.ArriereScieeCube == 1 ? surfaceAvantArriereM3 : 0;
  surfaceSciage += cube.DroiteScieeCube == 1 ? surfaceDroiteGaucheM3 : 0;
  surfaceSciage += cube.GaucheScieeCube == 1 ? surfaceDroiteGaucheM3 : 0;
  surfaceSciage += cube.DessusScieeCube == 1 ? surfaceDessusDessousM3 : 0;
  surfaceSciage += cube.DessousScieeCube == 1 ? surfaceDessusDessousM3 : 0;
  cube.prixScieage = prixScieage * surfaceSciage;

  cube.prixFaconnage = cube.prixPolissage + cube.prixScieage;
  cube.prixCube = cube.prixMatiere + cube.prixFaconnage + cube.prixScieage;
  $('#CoutCube' + cube.IdCubeDevis).val((Math.round(cube.prixCube * 100) / 100).toLocaleString());
}

function UpdateCubeModal(){
  selectedCube.LibelleCubeDevis = LibelleCubeModal.val();
  selectedCube.LargeurCubeDevis = CheckVal(LargeurCubeModal, 0, null);
  selectedCube.HauteurCubeDevis = CheckVal(HauteurCubeModal, 0, null);
  selectedCube.ProfondeurCubeDevis = CheckVal(ProfondeurCubeModal, 0, null);
  selectedCube.QuantiteCubeDevis = CheckVal(QuantiteCubeModal, 0, null);
  selectedCube.IdMatiere = MatiereCubeModal.val();

  if(!selectedCube.matiere || selectedCube.matiere.IdMatiere != selectedCube.IdMatiere){
    selectedCube.matiere = matieres.find(x => x.IdMatiere == selectedCube.IdMatiere);
  }

  selectedCube.AvantPolisCube = SurfaceAvantPolieCubeModal.is(':checked') ? '1' : '0';
  selectedCube.AvantScieeCube = SurfaceAvantScieeCubeModal.is(':checked') ? '1' : '0';
  selectedCube.ArrierePolisCube = SurfaceArrierePolieCubeModal.is(':checked') ? '1' : '0';
  selectedCube.ArriereScieeCube = SurfaceArriereScieeCubeModal.is(':checked') ? '1' : '0';
  selectedCube.DroitePolisCube = SurfaceDroitePolieCubeModal.is(':checked') ? '1' : '0';
  selectedCube.DroiteScieeCube = SurfaceDroiteScieeCubeModal.is(':checked') ? '1' : '0';
  selectedCube.GauchePolisCube = SurfaceGauchePolieCubeModal.is(':checked') ? '1' : '0';
  selectedCube.GaucheScieeCube = SurfaceGaucheScieeCubeModal.is(':checked') ? '1' : '0';
  selectedCube.DessusPolisCube = SurfaceDessusPolieCubeModal.is(':checked') ? '1' : '0';
  selectedCube.DessusScieeCube = SurfaceDessusScieeCubeModal.is(':checked') ? '1' : '0';
  selectedCube.DessousPolisCube = SurfaceDessousPolieCubeModal.is(':checked') ? '1' : '0';
  selectedCube.DessousScieeCube = SurfaceDessousScieeCubeModal.is(':checked') ? '1' : '0';

  ReverseUpdateCube(selectedCube);
  UpdateCubeModalDimensionsPrix(selectedCube);
}

function ReverseUpdateCube(cube){
  if(!cube.ToInsert){
    cube.ToUpdate = true;
  };
  $('#LibelleCube' + cube.IdCubeDevis).val(cube.LibelleCube);
  $('#CoteLargeurCube' + cube.IdCubeDevis).val(cube.LargeurCubeDevis);
  $('#CoteProfondeurCube' + cube.IdCubeDevis).val(cube.ProfondeurCubeDevis);
  $('#CoteHauteurCube' + cube.IdCubeDevis).val(cube.HauteurCubeDevis);
  $('#QuantiteCube' + cube.IdCubeDevis).val(cube.QuantiteCubeDevis);
  $('#MatiereSelectCube' + cube.IdCubeDevis).val(cube.IdMatiere);

  NombreCubesDevis.val(devis.cubes.map(x => x.QuantiteCubeDevis).reduce(add, 0));

  UpdatePrixCube(cube);
  UpdateDimensions();
  UpdatePrix();
}

function UpdateCube(IdCubeDevis){
  let cube = devis.cubes.find(x => x.IdCubeDevis == IdCubeDevis);
  if(!cube.ToInsert){
    cube.ToUpdate = true;
  };
  cube.LibelleCube = $('#LibelleCube' + cube.IdCubeDevis).val();

  cube.LargeurCubeDevis = CheckVal($('#CoteLargeurCube' + cube.IdCubeDevis), 0, null);
  cube.ProfondeurCubeDevis = CheckVal($('#CoteProfondeurCube' + cube.IdCubeDevis), 0, null);
  cube.HauteurCubeDevis = CheckVal($('#CoteHauteurCube' + cube.IdCubeDevis), 0, null);
  cube.LargeurExacteCubeDevis = CheckVal($('#CoteLargeurExacteCube' + cube.IdCubeDevis), 0, null);
  cube.ProfondeurExacteCubeDevis = CheckVal($('#CoteProfondeurExacteCube' + cube.IdCubeDevis), 0, null);
  cube.HauteurExacteCubeDevis = CheckVal($('#CoteHauteurExacteCube' + cube.IdCubeDevis), 0, null);

  cube.QuantiteCubeDevis = CheckVal($('#QuantiteCube' + cube.IdCubeDevis), 0, null);
  cube.IdMatiere = $('#MatiereSelectCube' + cube.IdCubeDevis).val();
  if(!cube.matiere || cube.matiere.IdMatiere != cube.IdMatiere){
    cube.matiere = matieres.find(x => x.IdMatiere == cube.IdMatiere);
  }

  NombreCubesDevis.val(devis.cubes.map(x => x.QuantiteCubeDevis).reduce(add, 0));

  UpdatePrixCube(cube);

  UpdateDimensions();
  UpdatePrix();
}

function UpdateDevis(){
  devis.LibelleDevis = LibelleDevis.val();
  devis.AquisDevis = AquisDevis.is(':checked') ? '1' : '0';
  devis.DosPolisDevis = DosPolisDevis.is(':checked') ? '1' : '0';
  devis.TypeDevis = TypeDevis.val();
  devis.ArrondiDevis = ArrondiDevis.val();
  devis.PrixDevis = PrixDevis.val();
}

function UpdatePrix(){
  devis.PUTransportDevis = PUTransportDevis.val();
  UpdateFraisDePort();

  let prixMatiereToutCube = devis.cubes.map(x => x.prixMatiere);
  let prixMatiereTotalCubes = prixMatiereToutCube.reduce(add, 0);
  PrixMatiere = Math.round(prixMatiereTotalCubes * 100) / 100;
  PrixMatiereDevis.val(PrixMatiere.toLocaleString());

  let prixFaconnageToutCube = devis.cubes.map(x => x.prixFaconnage);
  let prixFaconnageTotalCubes = prixFaconnageToutCube.reduce(add, 0);
  PrixFaconnage = Math.round(prixFaconnageTotalCubes * 100) / 100;
  PrixFaconnageDevis.val(PrixFaconnage.toLocaleString());

  PrixOptions = 0;
  PrixOptionsDevis.val(PrixOptions.toLocaleString());

  MonumentHT = PrixFaconnage + PrixOptions + PrixMatiere;
  MonumentHTDevis.val(MonumentHT.toLocaleString());

  ArticlesHT = 0;
  ArticlesHTDevis.val(ArticlesHT.toLocaleString());

  UpdateNets();
  UpdatePrixTTC();
}

function CheckVal(item, min, max){
  if(max != null && item.val() > max){
    item.val(max);
  }
  if(min != null && item.val() < min){
    item.val(min);
  }
  return item.val();
}

function UpdateNets(){
  CheckVal(RemiseDevis, 0, 100);
  devis.RemiseDevis = RemiseDevis.val();
  NetsHT = MonumentHT * (100 - devis.RemiseDevis) / 100;
  NetsHTDevis.val(NetsHT.toLocaleString());
  NetsTTC = NetsHT * (100 + parseFloat(devis.TvaDevis)) / 100;
  NetsTTCDevis.val(NetsTTC.toLocaleString());
}

function UpdatePrixTTC(){
  CheckVal(TvaDevis, 0, 100);
  devis.TvaDevis = TvaDevis.val();
  MonumentTTC = MonumentHT * (100 + parseFloat(devis.TvaDevis)) / 100;
  MonumentTTCDevis.val(MonumentTTC.toLocaleString());
  ArticlesTTC = ArticlesHT * (100 + parseFloat(devis.TvaDevis)) / 100;
  ArticlesTTCDevis.val(ArticlesTTC.toLocaleString());
  NetsTTC = NetsHT * (100 + parseFloat(devis.TvaDevis)) / 100;
  NetsTTCDevis.val(NetsTTC.toLocaleString());
}

function UpdateDimensions(){
  let surfaceTotalCM2 = 0;
  let volumeTotalCM3 = 0;
  devis.cubes.forEach(function(cube){
    let devantArriere = (cube.HauteurCubeDevis * cube.LargeurCubeDevis)*2;
    let dessusDessous = (cube.LargeurCubeDevis * cube.ProfondeurCubeDevis)*2;
    let droiteGauche = (cube.HauteurCubeDevis * cube.ProfondeurCubeDevis)*2;
    surfaceTotalCM2 += (devantArriere + dessusDessous + droiteGauche) * cube.QuantiteCubeDevis;
    volumeTotalCM3 += (cube.HauteurCubeDevis * cube.LargeurCubeDevis * cube.ProfondeurCubeDevis * cube.QuantiteCubeDevis);
  });
  let surfaceTotalM3 = surfaceTotalCM2 * 0.01;
  let volumeTotalM3 = volumeTotalCM3 * 0.000001;
  let masseKG = volumeTotalM3 * masseVolumique;
  let masseTonne = masseKG * 0.001;

  SurfaceTotal = Math.round(surfaceTotalM3 * 100) / 100;
  SurfaceDevis.val(SurfaceTotal.toLocaleString());
  VolumeTotal = Math.round(volumeTotalM3 * 100) / 100;
  VolumeDevis.val(VolumeTotal.toLocaleString());
  PoidsTotal = Math.round(masseTonne * 100) / 100;
  PoidsDevis.val(PoidsTotal.toLocaleString());

  UpdateFraisDePort();
}

function UpdateFraisDePort(){
  FraisDePortDevis.html((Math.round(devis.PUTransportDevis * PoidsTotal * 100) / 100).toLocaleString());
}

function SaveChanges(){
  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      console.log(this.responseText);
    }
  };
  xhttp.open("POST", "/SrgConcept/ServiceHelper.php?manager=DevisManager&route=SaveDevisCotes", true);
  xhttp.send(JSON.stringify([devis, devis.cubes]));
}

function RedirectDevisDessinView(){
  window.location.replace("AddDevisDessinViewModel.php?idDevis=" + idDevis);
}

function RedirectDevisListView(){
  window.location.replace("/SrgConcept/view/DevisView.php");
}

</script>
