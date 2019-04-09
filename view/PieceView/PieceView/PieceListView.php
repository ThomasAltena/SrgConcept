<div class="formbox" style="position: absolute; left: 1650px; top: 115px; width: 200px; height: 200px"></div>

<table class='table table-striped col-lg-12' style='margin:10px 0 0 0;'>
  <thead style="display: block;">
    <tr class="th-no-border search-input-title">
      <th class="text-left Width50" scope='col'>
        <input type="checkbox" value="0" class="form-control">
      </th>
      <th class="text-left Width100" scope='col'>
        <input type="number" min="0" placeholder="Id" value="" class="form-control">
      </th>
      <th class="text-left Width176" scope='col' >
        <input placeholder="Libelle" value="" class="form-control">
      </th>
      <th class="text-left Width176" scope='col'>
        <input value="" placeholder="Code" class="form-control">
      </th>
      <th class="text-left Width100" style="padding-bottom: 10px;" scope='col'>Image
      </th>
      <th class="text-left Width176" scope='col'>
        <input value="" placeholder="Famille" class="form-control">
      </th>
      <th class="text-left Width176" scope='col'>
        <input value="" placeholder="Sous-famille" class="form-control">
      </th>
      <th class="text-left Width176" scope='col'>
        <input value=""  placeholder="Lien (groupe)" class="form-control">
      </th>
      <th class="text-left Width119" scope='col'>
      </th>
    </tr>
  </thead>
  <tbody style="display: block;">
    <tr class="td-no-border" style="border-bottom: 2px solid grey;">
      <td class="text-left Width50" scope='col'>
        <input type="checkbox" disabled value="0" class="form-control">
      </td>
      <td class="text-left Width100" style="padding: 6px 0 6px 0;" scope='col'>
        <input disabled value="##" class="form-control">
      </td>
      <td class="text-left Width176" scope='col'>
        <input value="" placeholder="Libelle" onchange="CheckAddPiece()" id="LibelleAddPiece" class="form-control">
      </td>
      <td class="text-left Width176" scope='col'>
        <input value="" placeholder="Code" onchange="CheckAddPiece()" id="CodeAddPiece" class="form-control">
      </td>
      <td class="text-left Width100" scope='col'>
        <button class="btn btn-warning col-lg-12">Upload</button>
      </td>
      <td class="text-left Width176" scope='col'>
        <select class="select-2 form-control" onchange="LoadSousFamilleAddPieceSelect(value)" id="FamilleAddPiece">
        </select>
      </td>
      <td class="text-left Width176" scope='col'>
        <select class="select-2 form-control" onchange="CheckAddPiece()" id="SousFamilleAddPiece">
        </select>
      </td>
      <td class="text-left Width176" scope='col'>
        <select class="select-2 form-control" onchange="CheckAddPiece()" id="LienAddPiece">
        </select>
      </td>
      <td class="text-left Width119" scope='col' >
        <button class="btn btn-primary col-lg-12" disabled onclick="AddPiece()" id="ButtonAddPiece">Ajouter</button>
      </td>
    </tr>
  </tbody>
  <tbody id="table-body" class="scroller"  style="display: block; max-height: 640px; min-height: 640px; overflow-y:scroll; border-top:0;">

  </tbody>
</table>
<div class="row" style="border-top: 2px solid grey; padding:5px 0 0 0; margin:0">
  <div class="row col-lg-5" style="padding:0; margin:0">
    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text" id="Id_famille_label">Quantité visible :</span>
      </div>
      <select class="form-control col-lg-2" onchange="ChangeViewQuantite(value)">
        <option value='25'>25</option>
        <option value='50'>50</option>
        <option value='100'>100</option>
        <option value='500'>500</option>
        <option value='1000'>1000</option>
      </select>
    </div>
  </div>
  <div class="row col-lg-3" style="padding:0; margin:0">
    <button class="btn btn-primary" disabled onclick="GoTo('bottom')" id="pieceslistfullleft"><i class="fas fa-angle-double-left"></i></button>
    <button class="btn btn-primary" disabled onclick="GoTo('down')" id="pieceslistleft"><i class="fas fa-angle-left"></i></button>
    <select class="form-control col-lg-3" onchange="GoToPage(value)" id="pieceslistpageselector"></select>

    <button class="btn btn-primary" onclick="GoTo('up')" id="pieceslistright"><i class="fas fa-angle-right"></i></button>
    <button class="btn btn-primary" onclick="GoTo('top')" id="pieceslistfullright"><i class="fas fa-angle-double-right"></i></button>
  </div>
  <div class="row col-lg-4" style="padding:0; margin:0">
    <button class="btn btn-warning" onclick="ResetFilters()" id="pieceslistfullright">Retirer filtres</button>&nbsp
    <button class="btn btn-danger" disabled onclick="DeleteSelectedPieces()" id="pieceslistfullright">Supprimer séléction</button>
  </div>
</div>
<script>
PieceListView.viewQuantity = 25;
PieceListView.listPosition = 0;
PieceListView.totalPages = 0;
PieceListView.currentPage = 1;
PieceListView.tableBody = $('#table-body');
PieceListView.listLoading = true;

$( document ).ready(function() {
    PieceListView.pieceslistfullleft = $('#pieceslistfullleft');
    PieceListView.pieceslistleft = $('#pieceslistleft');
    PieceListView.pieceslistpageselector = $('#pieceslistpageselector');
    PieceListView.pieceslistright = $('#pieceslistright');
    PieceListView.pieceslistfullright = $('#pieceslistfullright');
});

CalculatetotalPages()
LoadtotalPagesOptions();
LoadTablePieceList();
LoadAddPieceSelects();

function CalculatetotalPages(){
  PieceListView.totalPages = Math.floor(pieces.length/PieceListView.viewQuantity);
  if(pieces.length%PieceListView.viewQuantity > 0){
    PieceListView.totalPages ++;
  }
}

function ChangeViewQuantite(value){
  PieceListView.viewQuantity = value;
  CalculatetotalPages()
  LoadtotalPagesOptions();
  GoToPage(1);
}

function LoadtotalPagesOptions(){
  let body = '';
  for(let i = 1; i <= PieceListView.totalPages; i++){
    body += "<option value='" + i + "' >" + i + "</option>";
  }
  $('#pieceslistpageselector').html(body);
}

function LoadAddPieceSelects(){
  PieceListView.FamilleAddPiece = $('#FamilleAddPiece');
  PieceListView.LienAddPiece = $('#LienAddPiece');
  PieceListView.SousFamilleAddPiece = $('#SousFamilleAddPiece');
  PieceListView.ButtonAddPiece = $('#ButtonAddPiece');
  PieceListView.CodeAddPiece = $('#CodeAddPiece');
  PieceListView.LibelleAddPiece = $('#LibelleAddPiece');
  PieceListView.FamilleAddPiece.html(MainFamilleSelectOptions);
  PieceListView.LienAddPiece.html(MainGroupeCubesSelectOptions);
  PieceListView.AddPiece = new Object();
}

function LoadSousFamilleAddPieceSelect(value){
  PieceListView.SousFamilleAddPiece.html(GenerateSousFamilleSelectOptions(value));
  CheckAddPiece();
}

function MaintainAddPiece(){
  PieceListView.AddPiece.CheminPiece = 'test';
  PieceListView.AddPiece.LibellePiece = PieceListView.LibelleAddPiece.val();
  PieceListView.AddPiece.CodePiece = PieceListView.CodeAddPiece.val();
  PieceListView.AddPiece.CodeFamille = PieceListView.FamilleAddPiece.val();
  PieceListView.AddPiece.CodeSsFamille = PieceListView.SousFamilleAddPiece.val();
  PieceListView.AddPiece.CodeGroupeCube = PieceListView.LienAddPiece.val();
}

function CheckAddPiece(){
  MaintainAddPiece(PieceListView.AddPiece);
  if(CheckPiece(PieceListView.AddPiece)){
    PieceListView.ButtonAddPiece.prop('disabled', false);
  }
}

function AddPiece(){
  DataRequest("PieceManager", "AddPieceArray", undefined, [PieceListView.AddPiece]).then(function(result){
    let piece = new Object();
    piece.CheminPiece = PieceListView.AddPiece.CheminPiece;
    piece.LibellePiece = PieceListView.AddPiece.LibellePiece;
    piece.CodePiece = PieceListView.AddPiece.CodePiece;
    piece.CodeFamille = PieceListView.AddPiece.CodeFamille;
    piece.CodeSsFamille = PieceListView.AddPiece.CodeSsFamille;
    piece.CodeGroupeCube = PieceListView.AddPiece.CodeGroupeCube;
    piece.IdPiece = result.responseText.replace(/["']/g, "");
    pieces.push(piece);
    CalculatetotalPages();
    if(PieceListView.currentPage == PieceListView.totalPages){
      GoToPage(PieceListView.currentPage);
    }
    ResetAddPiece();
  });

}

function ResetAddPiece(){
  PieceListView.AddPiece = new Object();
  PieceListView.LibelleAddPiece.val('');
  PieceListView.CodeAddPiece.val('');
  PieceListView.FamilleAddPiece.val('Aucun');
  PieceListView.SousFamilleAddPiece.val('');
  PieceListView.LienAddPiece.val('Aucun');
  PieceListView.ButtonAddPiece.prop('disabled', true);
}

function LoadTablePieceList(){
  PieceListView.listLoading = true;
  let piece;
  let rows = '';
  let updateParams;
  let templistPosition = PieceListView.listPosition;

  for(let i = 0; i < PieceListView.viewQuantity; i++){
    if(pieces[PieceListView.listPosition]){
      piece = pieces[PieceListView.listPosition];
      updateParams = '' + PieceListView.listPosition + ',' + piece.IdPiece + '';

      rows += "<tr>";

      rows += '<td class="text-left Width50" style="padding: 6px 0 6px 0;" scope="col" id="CheckboxContainer' + piece.IdPiece + '">'
      rows += '<input type="checkbox" class="form-control" onchange="SelectPiece(' + updateParams + ')" id="InputChecked' + piece.IdPiece + '">'
      rows += '</td>';

      rows += '<td class="text-left Width100" style="padding: 6px 0 6px 0;" scope="col" id="IdContainer' + piece.IdPiece + '">';
      rows += '<input value="' + piece.IdPiece + '" disabled class="form-control" style="padding:6px" > </td>';

      rows += '<td class="text-left Width176" scope="col" >';
      rows += '<input placeholder="Libelle" value="' + piece.LibellePiece + '" class="form-control" onchange="ToUpdate(' + updateParams + ')" id="InputLibelle' + piece.IdPiece + '">';
      rows += '</td>';

      rows += '<td class="text-left Width176" scope="col">';
      rows += '<input value="' + piece.CodePiece + '" placeholder="Code" class="form-control" onchange="ToUpdate(' + updateParams + ')" id="InputCode' + piece.IdPiece + '">';
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
    PieceListView.listPosition++;
  }

  PieceListView.tableBody.html(rows);

  for(let i = 0; i < PieceListView.viewQuantity; i++){
    if(pieces[templistPosition]){
      piece = pieces[templistPosition];
      $('#FamilleOptions'+piece.IdPiece).val(piece.CodeFamille);
      $('#SousFamilleOptions'+piece.IdPiece).val(piece.CodeSsFamille);
      $('#GroupeCubeOptions'+piece.IdPiece).val(piece.CodeGroupeCube);
    }
    templistPosition++;
  }

  PieceListView.listLoading = false;
}

function UpdateSousFamilleOptions(pos, id, value){
  if(!PieceListView.listLoading){
    $('#SousFamilleOptions'+id).html(GenerateSousFamilleSelectOptions(value));
    ToUpdate(pos, id);
  }
}

function SelectPiece(position, id){
  piece = pieces[position];
  if(piece.IdPiece != id){
    piece = pieces.filter(x => x.IdPiece == id)[0];
  }

  piece.Selected = $('#UpdatePieceButton' + id).is(':checked') ? true : false;
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
  if(!PieceListView.listLoading){
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
        GoToPage(PieceListView.totalPages);
      break;
    case "bottom":
        GoToPage(1);
      break;
    case "up":
        GoToPage(PieceListView.currentPage+1);
      break;
    case "down":
        GoToPage(PieceListView.currentPage-1);
      break;
    default:
  }
}

function GoToPage(pagenumber){
  if(pagenumber >= 1 && pagenumber <= PieceListView.totalPages){
    PieceListView.pieceslistpageselector.val(pagenumber);
    if(pagenumber == 1){
      PieceListView.pieceslistfullleft.prop('disabled', true);
      PieceListView.pieceslistleft.prop('disabled', true);
      PieceListView.pieceslistright.prop('disabled', false);
      PieceListView.pieceslistfullright.prop('disabled', false);
    }
    if(pagenumber == PieceListView.totalPages){
      PieceListView.pieceslistfullleft.prop('disabled', false);
      PieceListView.pieceslistleft.prop('disabled', false);
      PieceListView.pieceslistright.prop('disabled', true);
      PieceListView.pieceslistfullright.prop('disabled', true);
    }
    PieceListView.currentPage = pagenumber;
    PieceListView.listPosition = PieceListView.viewQuantity*pagenumber - PieceListView.viewQuantity;
    LoadTablePieceList();
  }
}


</script>
<style>
th {
    font-size:20px;
    padding:6px;
}
.table td, .table th {
    padding:6px;
}

tr.td-no-border th{
  border-top: 0;
  border-bottom: 0;
  padding: 2px;
}

tr.search-input-title input{
  margin: 0;
  border:0;
  background: rgb(27, 30, 36);
  font-size:20px;
  color:rgb(213, 221, 229);
  font-weight: 100;
  text-align:left;
  font-family: "Roboto", helvetica, arial, sans-serif;
  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
  padding: 0;
}

tr.search-input-title input::placeholder { /* Firefox, Chrome, Opera */
    color: rgb(213, 221, 229);
}
tr.search-input-title input:focus { /* Firefox, Chrome, Opera */
    background-color: rgb(64, 70, 81);
    border:0;
    color: rgb(213, 221, 229);
}

tr.search-input-title input, select, textarea{
    color: rgb(213, 221, 229);
}

tr.search-input-title input[type=number]::-webkit-outer-spin-button ,input[type=number]::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

.Width50 {
  min-width: 50px;
  max-width: 50px;
  width: 50px;
}

.Width100 {
  min-width: 100px;
  max-width: 100px;
  width: 100px;
}

.Width150 {
  min-width: 150px;
  max-width: 150px;
  width: 150px;
}

.Width119 {
  min-width: 119px;
  max-width: 119px;
  width: 119px;
}
.Width176 {
  min-width: 176px;
  max-width: 176px;
  width: 176px;
}

.scroller::-webkit-scrollbar {
  top:50px;
    width: 12px;
    height: 12px;
}
.scroller::-webkit-scrollbar-track {
    /* background: white; */
}
.scroller::-webkit-scrollbar-thumb {
    background: gray;
    visibility:hidden;
}
.scroller:hover::-webkit-scrollbar-thumb {
    visibility:visible;
}

.select2-selection--single {
  min-height: 38px;
  max-height: 38px;
  padding: 6px;
  border: 1px solid #ced4da;
}

.select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid #ced4da;
    border-radius: .25rem;
}

</style>
