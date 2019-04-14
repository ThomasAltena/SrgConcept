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
  require_once($_SERVER['DOCUMENT_ROOT'] . '/SrgConcept/ServiceHelperScript.php');
}

?>
<link rel="stylesheet" href="/SrgConcept/public/css/form.css" type="text/css">
<link rel="stylesheet" href="/SrgConcept/public/css/table.css" type="text/css">
<link rel="stylesheet" href="/SrgConcept/public/css/switch.css" type="text/css">
<!-------------------------- Il faut mettre le chemin dans les value -------------------------->
<body style="overflow: hidden; min-width:1920px;">
  <div  id='viewContainer' class="container col-lg-12 row" style="min-width:1920px; "></div>
</body>
<style>
.td {
  padding-top: 5px;
  padding-bottom: 5px;
}
</style>
<script type="text/javascript">
let MainAucunOption = '<option value="" disabled selected> Aucun</option>';
let pieces;
let familles;
let regroupementFamilles;
let sousFamilles;
let groupeCubes;
let MainFamilleSelectOptions;
let MainRegroupementSelectOptions;

let PieceListView = [];
let FamilleListView = [];

let MainGroupeCubesSelectOptions;

let promises = [];

promises.push(DataRequest("PieceManager", "GetAllPiece", "true", []));
promises.push(DataRequest("FamilleManager", "GetAllFamille", "true", []));
promises.push(DataRequest("SousFamilleManager", "GetAllSousfamille", "true", []));
promises.push(DataRequest("GroupecubeManager", "GetAllGroupecube", "true", []));
promises.push(ViewRequest('ParametrageMainView.php'));
promises.push(DataRequest("RegroupementfamilleManager", "GetAllRegroupementfamille", "true", []));


Promise.all(promises).then((results) => {
  pieces = JSON.parse(results[0].responseText);
  familles = JSON.parse(results[1].responseText);
  sousFamilles = JSON.parse(results[2].responseText);
  groupeCubes = JSON.parse(results[3].responseText);
  regroupementFamilles = JSON.parse(results[5].responseText);
  GenerateFamilleSelectOptions();
  GenerateGroupeCubeSelectOptions();
  GenerateRegroupementSelectOptions();

  $('#viewContainer').html(results[4].responseText);
}).catch((e) => {
             // Handle errors here
});


function GenerateFamilleSelectOptions(){
  MainFamilleSelectOptions = MainAucunOption;
  familles.forEach(function(famille){
    MainFamilleSelectOptions += '<option value="' + famille.CodeFamille + '">' + famille.CodeFamille + '&nbsp' + famille.LibelleFamille + '</option>';
  });
};

function GenerateRegroupementSelectOptions(){
  MainRegroupementSelectOptions = MainAucunOption;
  regroupementFamilles.forEach(function(regroupementFamille){
    MainRegroupementSelectOptions += '<option value="' + regroupementFamille.IdRegroupementFamille + '">' + regroupementFamille.LibelleRegroupementFamille + '&nbsp' + regroupementFamille.PositionRegroupementFamille + '</option>';
  });
};

function GenerateSousFamilleSelectOptions(CodeFamille){
  let MainSsFamilleSelectOptions = MainAucunOption;
  sousFamilles.forEach(function(sousFamille){
    if(sousFamille.CodeFamille == CodeFamille){
      MainSsFamilleSelectOptions += '<option value="' + sousFamille.CodeSsFamille + '">' + sousFamille.CodeSsFamille + '&nbsp' + sousFamille.LibelleSsFamille + '</option>';
    }
  });
  return MainSsFamilleSelectOptions;
};

function GenerateGroupeCubeSelectOptions(){
  MainGroupeCubesSelectOptions = MainAucunOption;
  groupeCubes.forEach(function(groupeCube){
    MainGroupeCubesSelectOptions += '<option value="' + groupeCube.CodeGroupeCube + '">' + groupeCube.CodeGroupeCube + '&nbsp' + groupeCube.LibelleGroupeCube + '</option>';
  });
};


const unique = (value, index, self) => {
  return self.indexOf(value) === index;
};

const add = (a,b) => {
  return parseInt(a) + parseInt(b)
};

</script>
