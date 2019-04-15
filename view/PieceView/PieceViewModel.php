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
let onScreenPieces = [];

let PieceListView = [];
let FamilleListView = [];

let MainGroupeCubesSelectOptions;

let promises = [];

promises.push(DataRequest("PieceManager", "GetAllPiece", "true", []));
promises.push(DataRequest("FamilleManager", "GetAllFamille", "true", []));
promises.push(DataRequest("SousFamilleManager", "GetAllSousfamille", "true", []));
promises.push(DataRequest("GroupecubeManager", "GetAllGroupecube", "true", []));
promises.push(ViewRequest('PieceView.php'));
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

  pieceslistfullleft = $('#pieceslistfullleft');
  pieceslistleft = $('#pieceslistleft');
  pieceslistpageselector = $('#pieceslistpageselector');
  pieceslistright = $('#pieceslistright');
  pieceslistfullright = $('#pieceslistfullright');
  selectAllCheckbox = $('#selectAllCheckbox');
  deleteSelectedPiecesButton = $('#deleteSelectedPiecesButton');
  tableBody = $('#table-body');
  CalculatetotalPages()
  LoadtotalPagesOptions();
  LoadTablePieceList();
  LoadAddPieceSelects();

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
  totalPages = Math.floor(pieces.length/viewQuantity);
  if(pieces.length%viewQuantity > 0){
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
  $('#pieceslistpageselector').html(body);
}

function LoadAddPieceSelects(){
  FamilleAddPiece = $('#FamilleAddPiece');
  LienAddPiece = $('#LienAddPiece');
  SousFamilleAddPiece = $('#SousFamilleAddPiece');
  ButtonAddPiece = $('#ButtonAddPiece');
  CodeAddPiece = $('#CodeAddPiece');
  LibelleAddPiece = $('#LibelleAddPiece');
  FamilleAddPiece.html(MainFamilleSelectOptions);
  LienAddPiece.html(MainGroupeCubesSelectOptions);
  AddPiece = new Object();
}

function LoadSousFamilleAddPieceSelect(value){
  SousFamilleAddPiece.html(GenerateSousFamilleSelectOptions(value));
  CheckAddPiece();
}

function MaintainAddPiece(){
  AddPiece.CheminPiece = 'test';
  AddPiece.LibellePiece = LibelleAddPiece.val();
  AddPiece.CodePiece = CodeAddPiece.val();
  AddPiece.CodeFamille = FamilleAddPiece.val();
  AddPiece.CodeSsFamille = SousFamilleAddPiece.val();
  AddPiece.CodeGroupeCube = LienAddPiece.val();
}

function CheckAddPiece(){
  MaintainAddPiece();
  if(CheckPiece(AddPiece)){
    ButtonAddPiece.prop('disabled', false);
  }
}

function AddPiece(){
  DataRequest("PieceManager", "AddPieceArray", undefined, [AddPiece]).then(function(result){
    let piece = new Object();
    piece.CheminPiece = AddPiece.CheminPiece;
    piece.LibellePiece = AddPiece.LibellePiece;
    piece.CodePiece = AddPiece.CodePiece;
    piece.CodeFamille = AddPiece.CodeFamille;
    piece.CodeSsFamille = AddPiece.CodeSsFamille;
    piece.CodeGroupeCube = AddPiece.CodeGroupeCube;
    piece.IdPiece = result.responseText.replace(/["']/g, "");
    pieces.push(piece);
    CalculatetotalPages();
    if(currentPage == totalPages){
      GoToPage(currentPage);
    }
    ResetAddPiece();
  });

}

function ResetAddPiece(){
  AddPiece = new Object();
  LibelleAddPiece.val('');
  CodeAddPiece.val('');
  FamilleAddPiece.val('Aucun');
  SousFamilleAddPiece.val('');
  LienAddPiece.val('Aucun');
  ButtonAddPiece.prop('disabled', true);
}

function LoadTablePieceList(){
  UnSelectAll();
  SetDeleteSelectionButton(true);
  onScreenPieces = [];
  listLoading = true;
  let piece;
  let rows = '';
  let updateParams;
  let templistPosition = listPosition;

  for(let i = 0; i < viewQuantity; i++){
    if(pieces[listPosition]){
      piece = pieces[listPosition];
      onScreenPieces.push(piece);
      updateParams = '' + listPosition + ',' + piece.IdPiece + '';

      rows += "<tr>";

      rows += '<td class="text-left Width50" style="padding: 6px 0 6px 0;" scope="col" id="CheckboxContainer' + piece.IdPiece + '">'
      rows += '<input type="checkbox" class="form-control" onchange="SelectPiece(' + updateParams + ')" id="InputChecked' + piece.IdPiece + '">'
      rows += '</td>';

      rows += '<td class="text-left Width100" style="padding: 6px 0 6px 0;" scope="col" id="IdContainer' + piece.IdPiece + '">';
      rows += '<input value="' + piece.IdPiece + '" disabled class="form-control" style="padding:6px" > </td>';

      rows += '<td class="text-left Width176" scope="col" >';
      rows += '<input placeholder="Libelle" value="' + piece.LibellePiece + '" class="form-control" oninput="ToUpdate(' + updateParams + ')" id="InputLibelle' + piece.IdPiece + '">';
      rows += '</td>';

      rows += '<td class="text-left Width176" scope="col">';
      rows += '<input value="' + piece.CodePiece + '" placeholder="Code" class="form-control" oninput="ToUpdate(' + updateParams + ')" id="InputCode' + piece.IdPiece + '">';
      rows += '</td>';

      rows += '<td class="text-left Width100" style="padding-bottom: 6px;" scope="col">';
      rows += '<button class="btn btn-success col-lg-12">Voir</button>';
      rows += '</td>';

      rows += '<td class="text-left Width176" scope="col">';
      rows += '<select class="select-2 form-control" onchange="UpdateSousFamilleOptions(' + updateParams + ', value)" id="FamilleOptions' + piece.IdPiece + '" name="famille" >';
      rows += MainFamilleSelectOptions;
      rows += '</select>';
      rows += '</td>';

      rows += '<td class="text-left Width176" scope="col">';
      rows += '<select class="select-2 form-control" onchange="ToUpdate(' + updateParams + ')" name="sousFamille" id="SousFamilleOptions' + piece.IdPiece + '">';
      rows += GenerateSousFamilleSelectOptions(piece.CodeFamille);
      rows += '</select>';
      rows += '</td>';

      rows += '<td class="text-left Width176" scope="col">';
      rows += '<select class="select-2 form-control" onchange="ToUpdate(' + updateParams + ')" name="Lien" id="GroupeCubeOptions' + piece.IdPiece + '">';
      rows += MainGroupeCubesSelectOptions;
      rows += '</select>';
      rows += '</td>';


      rows += '<td class="text-left Width119" style="padding-bottom: 6px;" scope="col">'
      rows += '<button class="btn btn-primary col-lg-12" disabled id="UpdatePieceButton' + piece.IdPiece + '" onclick="UpdatePiece(' + updateParams + ')">Update'
      rows += '</button>'
      rows += "</tr>";
    }
    listPosition++;
  }
  tableBody.html(rows);

  for(let i = 0; i < viewQuantity; i++){
    if(pieces[templistPosition]){
      piece = pieces[templistPosition];
      $('#FamilleOptions'+piece.IdPiece).val(piece.CodeFamille);
      $('#SousFamilleOptions'+piece.IdPiece).val(piece.CodeSsFamille);
      $('#GroupeCubeOptions'+piece.IdPiece).val(piece.CodeGroupeCube);
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
  onScreenPieces.forEach(function (piece) {
    piece.selected = false;
  });
}

function SetDeleteSelectionButton(value){
  if(deleteSelectedPiecesButton){
    deleteSelectedPiecesButton.prop('disabled', value);
  }
}

function SetSelectAllCheckbox(value){
  if(selectAllCheckbox){
    selectAllCheckbox.prop('checked', value);
  }
}

function SelectPiece(position, id){
  piece = pieces[position];
  if(piece.IdPiece != id){
    piece = pieces.filter(x => x.IdPiece == id)[0];
  }

  piece.selected = $('#InputChecked' + id).is(':checked') ? true : false;
  if(deleteSelectedPiecesButton.is(':disabled') && onScreenPieces.some(x => x.selected)){
    SetDeleteSelectionButton(false);
  }
  if(!deleteSelectedPiecesButton.is(':disabled') && !onScreenPieces.some(x => x.selected)) {
    SetDeleteSelectionButton(true);
    SetSelectAllCheckbox(false);
  }
  if(selectAllCheckbox.is(':checked') && onScreenPieces.some(x => !x.selected)){
    SetSelectAllCheckbox(false);
  }
  if(!selectAllCheckbox.is(':checked') && !onScreenPieces.some(x => !x.selected)){
    SetSelectAllCheckbox(true);
  }
}

function SelectAllPieces(){
  let selected = selectAllCheckbox.is(':checked') ? true : false;
  onScreenPieces.forEach(function (piece) {
    piece.selected = selected;
    $('#InputChecked' + piece.IdPiece).prop('checked', selected);
  });
  deleteSelectedPiecesButton.prop('disabled', !selected);
}

function DeleteSelectedPieces(){
  onScreenPieces.forEach(function (piece) {
    if(piece.selected){
      let index = pieces.findIndex(x => x.IdPiece == piece.IdPiece);
      pieces.splice(index, 1);
      DataRequest("PieceManager", "DeletePiece", undefined, [piece.IdPiece]);
      CalculatetotalPages();
      if(currentPage >= totalPages){
        GoToPage(totalPages);
      } else {
        GoToPage(currentPage);
      }
    }
  });
}

function UpdatePiece(position, id){
  $('#UpdatePieceButton' + id).prop('disabled', true);
  $('#CheckboxContainer' + id).prop('disabled', false);
  piece = pieces[position];
  if(piece.IdPiece != id){
    piece = pieces.filter(x => x.IdPiece == id)[0];
  }

  DataRequest("PieceManager", "UpdatePieceArray", "true", [piece]);
}

function MaintainPiece(piece){
  piece.LibellePiece = $('#InputLibelle' + piece.IdPiece).val();
  piece.CodePiece = $('#InputCode' + piece.IdPiece).val();
  piece.CodeFamille = $('#FamilleOptions' + piece.IdPiece).val();
  piece.CodeSsFamille = $('#SousFamilleOptions' + piece.IdPiece).val();
  piece.CodeGroupeCube =  $('#GroupeCubeOptions' + piece.IdPiece).val();
}

function CheckPiece(piece){
  return piece.CheminPiece != "" && piece.LibellePiece != "" && piece.CodePiece != '' && piece.CodeFamille != '' && piece.CodeFamille != undefined && piece.CodeSsFamille != undefined && piece.CodeSsFamille != 'Aucun' && piece.CodeSsFamille != '' && piece.CodeGroupeCube != 'Aucun' && piece.CodeGroupeCube != undefined;
}

function ToUpdate(position, id){
  if(!listLoading){
    piece = pieces[position];
    if(piece.IdPiece != id){
      piece = pieces.filter(x => x.IdPiece == id)[0];
    }
    MaintainPiece(piece);
    if(CheckPiece(piece)){
      $('#UpdatePieceButton' + id).prop('disabled', false);
      $('#CheckboxContainer' + id).prop('disabled', true);

      piece.ToUpdate = true;
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
    pieceslistpageselector.val(pagenumber);
    if(pagenumber == 1){
      pieceslistfullleft.prop('disabled', true);
      pieceslistleft.prop('disabled', true);
      pieceslistright.prop('disabled', false);
      pieceslistfullright.prop('disabled', false);
    }
    if((currentPage == 1 || currentPage == totalPages) && (pagenumber > 1 || pagenumber < totalPages)){
      pieceslistfullleft.prop('disabled', false);
      pieceslistleft.prop('disabled', false);
      pieceslistright.prop('disabled', false);
      pieceslistfullright.prop('disabled', false);
    }
    if(pagenumber == totalPages){
      pieceslistfullleft.prop('disabled', false);
      pieceslistleft.prop('disabled', false);
      pieceslistright.prop('disabled', true);
      pieceslistfullright.prop('disabled', true);
    }
    currentPage = pagenumber;
    listPosition = viewQuantity*pagenumber - viewQuantity;
    LoadTablePieceList();
  }
}

const unique = (value, index, self) => {
  return self.indexOf(value) === index;
};

const add = (a,b) => {
  return parseInt(a) + parseInt(b)
};

</script>
