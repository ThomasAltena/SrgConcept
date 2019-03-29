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
<body style="overflow: scroll;">
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
let masseVolumique = 2700;
let matieres;
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
      GetDevisData();
    }
  };
  xhttp.open("POST", "AddDevisCotesView.php", true);
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
      devis = JSON.parse(this.responseText);
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
    body += '<tr><td class="text-left td"style="padding: 6px; font-size: 16px;">' + cube.LibelleCubeDevis + '</td>';
    body += '<td class="text-left td"style="padding: 6px; font-size: 16px; width:150px" id="MatiereSelectContainerCube' + cube.IdCubeDevis + '"></td>';
    body += '<td class="text-left td"style="padding: 6px; font-size: 16px;"><input onchange="UpdateCube(' + cube.IdCubeDevis + ')" type="number" class="form-control" style="padding:6px;" value="' + cube.LargeurCubeDevis + '" id="CoteLargeurCube' + cube.IdCubeDevis + '"></input></td>';
    body += '<td class="text-left td"style="padding: 6px; font-size: 16px;"><input onchange="UpdateCube(' + cube.IdCubeDevis + ')" type="number" class="form-control" style="padding:6px;" value="' + cube.LargeurCubeDevis + '" id="CoteLargeurICube' + cube.IdCubeDevis + '"></input></td>';
    body += '<td class="text-left td"style="padding: 6px; font-size: 16px;"><input onchange="UpdateCube(' + cube.IdCubeDevis + ')" type="number" class="form-control" style="padding:6px;" value="' + cube.ProfondeurCubeDevis + '" id="CoteProfondeurCube' + cube.IdCubeDevis + '"></input></td>';
    body += '<td class="text-left td"style="padding: 6px; font-size: 16px;"><input onchange="UpdateCube(' + cube.IdCubeDevis + ')" type="number" class="form-control" style="padding:6px;" value="' + cube.ProfondeurCubeDevis + '" id="CoteProfondeurICube' + cube.IdCubeDevis + '"></input></td>';
    body += '<td class="text-left td"style="padding: 6px; font-size: 16px;"><input onchange="UpdateCube(' + cube.IdCubeDevis + ')" type="number" class="form-control" style="padding:6px;" value="' + cube.HauteurCubeDevis + '" id="CoteHauteurCube' + cube.IdCubeDevis + '"></input></td>';
    body += '<td class="text-left td"style="padding: 6px; font-size: 16px;"><input onchange="UpdateCube(' + cube.IdCubeDevis + ')" type="number" class="form-control" style="padding:6px;" value="' + cube.HauteurCubeDevis + '" id="CoteHauteurICube' + cube.IdCubeDevis + '"></input></td>';
    body += '<td class="text-left td"style="padding: 6px; font-size: 16px;"><input onchange="UpdateCube(' + cube.IdCubeDevis + ')" type="number" class="form-control" style="padding:6px;" value="' + cube.QuantiteCubeDevis + '" id="QuantiteCube' + cube.IdCubeDevis + '"></input></td>';
    body += '<td class="text-left td"style="padding: 6px; font-size: 16px;"><input class="form-control" style="padding:6px;" disabled value="" id="CoutCube' + cube.IdCubeDevis + '"></input></td></tr>';
  });
  CubesDevisTable.html(body);
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

  MatiereDevis.html(matieresOptions);
}

function UpdatePrixCube(cube){
  let volumeM3 = cube.LargeurCubeDevis * cube.ProfondeurCubeDevis * cube.HauteurCubeDevis * cube.QuantiteCubeDevis / 1000000;
  let masseTonne = masseVolumique * volumeM3 /1000;
  cube.prixCube = cube.matiere.PrixMatiere * masseTonne;
  $('#CoutCube' + cube.IdCubeDevis).val((Math.round(cube.prixCube * 100) / 100).toLocaleString());

  // $masseVolumique = 2700;
  // $volumeCM3 = $ligneModel->GetLargeur() * $ligneModel->GetHauteur() * $ligneModel->GetProfondeur();
  // $volumeM3 = $volumeCM3 /1000000;
  // $masseKG = $volumeM3 * $masseVolumique;
  // $masseTonne = $masseKG/1000;
  // $prix = $masseTonne * $prixMatiereTonne;
}

function UpdateCube(IdCubeDevis){
  let cube = devis.cubes.find(x => x.IdCubeDevis == IdCubeDevis);
  cube.LargeurCubeDevis = $('#CoteLargeurCube' + cube.IdCubeDevis).val();
  cube.ProfondeurCubeDevis = $('#CoteProfondeurCube' + cube.IdCubeDevis).val();
  cube.HauteurCubeDevis = $('#CoteHauteurCube' + cube.IdCubeDevis).val();
  cube.QuantiteCubeDevis = $('#QuantiteCube' + cube.IdCubeDevis).val();
  cube.IdMatiere = $('#MatiereSelectCube' + cube.IdCubeDevis).val();

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

  let prixToutCube = devis.cubes.map(x => x.prixCube);
  let prixTotalCubes = prixToutCube.reduce(add, 0);
  PrixMatiere = Math.round(prixTotalCubes * 100) / 100;
  PrixMatiereDevis.val(PrixMatiere.toLocaleString());

  PrixFaconnage = 0;
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

function CheckVal(item){
  if(item.val() > 100){
    item.val(100);
  }
  if(item.val() < 0){
    item.val(0);
  }
}

function UpdateNets(){
  CheckVal(RemiseDevis);
  devis.RemiseDevis = RemiseDevis.val();
  NetsHT = MonumentHT * (100 - devis.RemiseDevis) / 100;
  NetsHTDevis.val(NetsHT.toLocaleString());
  NetsTTC = NetsHT * (100 + parseFloat(devis.TvaDevis)) / 100;
  NetsTTCDevis.val(NetsTTC.toLocaleString());
}

function UpdatePrixTTC(){
  CheckVal(TvaDevis);
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
  xhttp.open("POST", "/SrgConcept/ServiceHelper.php?manager=DevisManager&route=ReSaveDevis", true);
  xhttp.send(JSON.stringify([devis, devis.cubes]));
}

</script>
