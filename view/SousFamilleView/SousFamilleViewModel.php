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
  <div class="container" style="min-width:1300px; max-width:1300px;">

    <div id="dataContainer" class="formbox" style="padding:5px;max-height: 850px; min-height: 850px">
    </div>
  </div>
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


let viewQuantity = 25;
let listPosition = 0;
let totalPages = 0;
let currentPage = 1;
let tableBody;
let listLoading = true;
let onScreenFamilles = [];

let FamilleListView = [];

let MainGroupeCubesSelectOptions;

let promises = [];

promises.push(DataRequest("PieceManager", "GetAllPiece", "true", []));
promises.push(DataRequest("FamilleManager", "GetAllFamille", "true", []));
promises.push(DataRequest("SousFamilleManager", "GetAllSousfamille", "true", []));
promises.push(DataRequest("GroupecubeManager", "GetAllGroupecube", "true", []));
promises.push(ViewRequest('FamilleListView.php'));
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

  $('#dataContainer').html(results[4].responseText);

  familleslistfullleft = $('#familleslistfullleft');
  familleslistleft = $('#familleslistleft');
  familleslistpageselector = $('#familleslistpageselector');
  familleslistright = $('#familleslistright');
  familleslistfullright = $('#familleslistfullright');
  selectAllCheckbox = $('#selectAllCheckbox');
  deleteSelectedFamillesButton = $('#deleteSelectedFamillesButton');
  tableBody = $('#table-body');

  CalculatetotalPages()
  LoadtotalPagesOptions();
  GoToPage(1);
  LoadAddFamilleSelects();
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

function CalculatetotalPages(){
  totalPages = Math.floor(familles.length/viewQuantity);
  if(familles.length%viewQuantity > 0){
    totalPages ++;
  }
}

function ChangeViewQuantite(value){
  viewQuantity = value;
  CalculatetotalPages()
  LoadtotalPagesOptions();
  GoToPage(1);
}

function LoadtotalPagesOptions(){
  let body = '';
  for(let i = 1; i <= totalPages; i++){
    body += "<option value='" + i + "' >" + i + "</option>";
  }
  $('#familleslistpageselector').html(body);
}

function LoadAddFamilleSelects(){
  CodeAddFamille = $('#CodeAddFamille');
  LibelleAddFamille = $('#LibelleAddFamille');
  RegroupementAddFamille = $('#RegroupementAddFamille');
  RegroupementAddFamille.html(MainGroupeCubesSelectOptions);
  AddFamille = new Object();
}

function MaintainAddFamille(){
  AddFamille.CodeFamille = CodeAddFamille.val();
  AddFamille.LibelleFamille = LibelleAddFamille.val();
  AddFamille.RegroupementFamille = RegroupementAddFamille.val();
}

function CheckAddFamille(){
  MaintainAddFamille(AddFamille);
  if(CheckFamille(AddFamille)){
    ButtonAddFamille.prop('disabled', false);
  }
}

function AddFamille(){
  DataRequest("FamilleManager", "AddFamilleArray", undefined, [AddFamille]).then(function(result){
    let famille = new Object();
    famille.CodeFamille = AddFamille.CodeFamille;
    famille.LibelleFamille = AddFamille.LibelleFamille;
    famille.RegroupementFamille = AddFamille.RegroupementFamille;

    familles.push(famille);
    CalculatetotalPages();
    if(currentPage == totalPages){
      GoToPage(currentPage);
    }
    ResetAddFamille();
  });

}

function ResetAddFamille(){
  AddFamille = new Object();
  CodeAddFamille.val('');
  LibelleAddFamille.val('');
  RegroupementAddFamille.val('Aucun');
  ButtonAddFamille.prop('disabled', true);
}

function LoadTableFamilleList(){
  UnSelectAll();
  SetDeleteSelectionButton(true);
  onScreenFamilles = [];
  listLoading = true;
  let famille;
  let rows = '';
  let updateParams;
  let templistPosition = listPosition;

  for(let i = 0; i < viewQuantity; i++){
    if(familles[listPosition]){
      famille = familles[listPosition];
      onScreenFamilles.push(famille);
      updateParams = '' + listPosition + ',\'' + famille.CodeFamille + '\'';

      rows += "<tr>";

      rows += '<td class="text-left Width50" style="padding: 6px 0 6px 0;" scope="col" id="CheckboxContainer' + famille.CodeFamille + '">'
      rows += '<input type="checkbox" class="form-control" onchange="SelectFamille(' + updateParams + ')" id="InputChecked' + famille.CodeFamille + '">'
      rows += '</td>';

      rows += '<td class="text-left Width176" scope="col" >';
      rows += '<input placeholder="Code" disabled value="' + famille.CodeFamille + '" class="form-control" oninput="ToUpdate(' + updateParams + ')" id="InputCode' + famille.CodeFamille + '">';
      rows += '</td>';

      rows += '<td class="text-left Width176" scope="col">';
      rows += '<input value="' + famille.LibelleFamille + '" placeholder="Libelle" class="form-control" oninput="ToUpdate(' + updateParams + ')" id="InputLibelle' + famille.CodeFamille + '">';
      rows += '</td>';

      rows += '<td class="text-left Width176" scope="col">';
      rows += '<select class="select-2 form-control" onchange="ToUpdate(' + updateParams + ')" name="Regroupement" id="RegroupementOptions' + famille.CodeFamille + '">';
      rows += MainRegroupementSelectOptions;
      rows += '</select>';
      rows += '</td>';

      rows += '<td class="text-left Width119" style="padding-bottom: 6px;" scope="col">'
      rows += '<button class="btn btn-primary col-lg-12" disabled id="UpdateFamilleButton' + famille.CodeFamille + '" onclick="UpdateFamille(' + updateParams + ')">Update'
      rows += '</button>'
      rows += "</tr>";
    }
    listPosition++;
  }

  tableBody.html(rows);

  for(let i = 0; i < viewQuantity; i++){
    if(familles[templistPosition]){
      famille = familles[templistPosition];
      $('#RegroupementOptions'+famille.CodeFamille).val(famille.CodeGroupeCube);
    }
    templistPosition++;
  }

  listLoading = false;
}

function UpdateSousFamilleOptions(pos, id, value){
  if(!listLoading){
    $('#SousFamilleOptions'+id).html(GenerateSousFamilleSelectOptions(value));
    ToUpdate(pos, id);
  }
}

function UnSelectAll(){
  if(selectAllCheckbox){
    SetSelectAllCheckbox(false);
  }
  onScreenFamilles.forEach(function (famille) {
    famille.selected = false;
  });
}

function SetDeleteSelectionButton(value){
  if(deleteSelectedFamillesButton){
    deleteSelectedFamillesButton.prop('disabled', value);
  }
}

function SetSelectAllCheckbox(value){
  if(selectAllCheckbox){
    selectAllCheckbox.prop('checked', value);
  }
}

function SelectFamille(position, id){
  famille = familles[position];
  if(famille.CodeFamille != id){
    famille = familles.filter(x => x.CodeFamille == id)[0];
  }

  famille.selected = $('#InputChecked' + id).is(':checked') ? true : false;
  if(deleteSelectedFamillesButton.is(':disabled') && onScreenFamilles.some(x => x.selected)){
    SetDeleteSelectionButton(false);
  }
  if(!deleteSelectedFamillesButton.is(':disabled') && !onScreenFamilles.some(x => x.selected)) {
    SetDeleteSelectionButton(true);
    SetSelectAllCheckbox(false);
  }
  if(selectAllCheckbox.is(':checked') && onScreenFamilles.some(x => !x.selected)){
    SetSelectAllCheckbox(false);
  }
  if(!selectAllCheckbox.is(':checked') && !onScreenFamilles.some(x => !x.selected)){
    SetSelectAllCheckbox(true);
  }
}

function SelectAllFamilles(){
  let selected = selectAllCheckbox.is(':checked') ? true : false;
  onScreenFamilles.forEach(function (famille) {
    famille.selected = selected;
    $('#InputChecked' + famille.IdFamille).prop('checked', selected);
  });
  deleteSelectedFamillesButton.prop('disabled', !selected);
}

function DeleteSelectedFamilles(){
  onScreenFamilles.forEach(function (famille) {
    if(famille.selected){
      let index = familles.findIndex(x => x.IdFamille == famille.IdFamille);
      familles.splice(index, 1);
      DataRequest("FamilleManager", "DeleteFamille", undefined, [famille.IdFamille]);
      CalculatetotalPages();
      if(currentPage >= totalPages){
        GoToPage(totalPages);
      } else {
        GoToPage(currentPage);
      }
    }
  });
}

function UpdateFamille(position, code){
  $('#UpdateFamilleButton' + code).prop('disabled', true);
  $('#CheckboxContainer' + code).prop('disabled', false);
  famille = familles[position];
  if(famille.CodeFamille != code){
    famille = familles.filter(x => x.CodeFamille == code)[0];
  }


  DataRequest("FamilleManager", "UpdateFamilleArray", "true", [famille]);
}

function MaintainFamille(famille){
  famille.LibelleFamille = $('#InputLibelle' + famille.CodeFamille).val();
  famille.CodeFamille = $('#InputCode' + famille.CodeFamille).val();
  famille.RegroupementFamille = $('#FamilleOptions' + famille.CodeFamille).val();
}

function CheckFamille(famille){
  return famille.CheminFamille != "" && famille.LibelleFamille != "" && famille.CodeFamille != '' && famille.CodeFamille != '' && famille.CodeFamille != undefined && famille.CodeSsFamille != undefined && famille.CodeSsFamille != 'Aucun' && famille.CodeSsFamille != '' && famille.CodeGroupeCube != 'Aucun' && famille.CodeGroupeCube != undefined;
}

function ToUpdate(position, code){
  if(!listLoading){
    famille = familles[position];
    if(famille.CodeFamille != code){
      famille = familles.filter(x => x.CodeFamille == code)[0];
    }
    MaintainFamille(famille);
    if(CheckFamille(famille)){
      $('#UpdateFamilleButton' + code).prop('disabled', false);
      $('#CheckboxContainer' + code).prop('disabled', true);

      famille.ToUpdate = true;
    }
  }
}

function GoTo(place){
  switch (place) {
    case "top":
        GoToPage(totalPages);
      break;
    case "bottom":
        GoToPage(1);
      break;
    case "up":
        GoToPage(currentPage+1);
      break;
    case "down":
        GoToPage(currentPage-1);
      break;
    default:
  }
}

function GoToPage(pagenumber){
  if(pagenumber >= 1 && pagenumber <= totalPages){
    familleslistpageselector.val(pagenumber);
    if(pagenumber == 1){
      familleslistfullleft.prop('disabled', true);
      familleslistleft.prop('disabled', true);
      familleslistright.prop('disabled', false);
      familleslistfullright.prop('disabled', false);
    }
    if((currentPage == 1 || currentPage == totalPages) && (pagenumber > 1 || pagenumber < totalPages)){
      familleslistfullleft.prop('disabled', false);
      familleslistleft.prop('disabled', false);
      familleslistright.prop('disabled', false);
      familleslistfullright.prop('disabled', false);
    }
    if(pagenumber == totalPages){
      familleslistfullleft.prop('disabled', false);
      familleslistleft.prop('disabled', false);
      familleslistright.prop('disabled', true);
      familleslistfullright.prop('disabled', true);
    }
    if(pagenumber == totalPages && pagenumber == 1){
      familleslistfullleft.prop('disabled', true);
      familleslistleft.prop('disabled', true);
      familleslistright.prop('disabled', true);
      familleslistfullright.prop('disabled', true);
    }
    currentPage = pagenumber;
    listPosition = viewQuantity*pagenumber - viewQuantity;
    LoadTableFamilleList();
  }
}

const unique = (value, index, self) => {
  return self.indexOf(value) === index;
};

const add = (a,b) => {
  return parseInt(a) + parseInt(b)
};

</script>
