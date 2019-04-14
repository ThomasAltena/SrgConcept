<div>
  <table class='table table-striped' style='margin:0;'>
    <thead class="scroller" style="display: block; overflow-y:scroll;">
      <tr class="th-no-border search-input-title">
        <th class="text-left Width50" scope='col'>
          <input type="checkbox" value="0" id="selectAllCheckbox" class="form-control" onchange="SelectAllFamilles()">
        </th>
        <th class="text-left Width176" scope='col' >
          <input placeholder="Code" value="" class="form-control">
        </th>
        <th class="text-left Width176" scope='col'>
          <input value="" placeholder="Libelle" class="form-control">
        </th>
        <th class="text-left Width176" scope='col'>
          <input value="" placeholder="Regroupement" class="form-control">
        </th>
        <th class="text-left Width119" scope='col'>
        </th>
      </tr>
    </thead>
    <tbody class="scroller" style="display: block; overflow-y:scroll;">
      <tr class="td-no-border" style="border-bottom: 2px solid grey;">
        <td class="text-left Width50" scope='col'>
          <input type="checkbox" disabled value="0" class="form-control">
        </td>
        <td class="text-left Width176" scope='col'>
          <input value="" placeholder="Code" onchange="CheckAddFamille()" id="CodeAddFamille" class="form-control">
        </td>
        <td class="text-left Width176" scope='col'>
          <input value="" placeholder="Libelle" onchange="CheckAddFamille()" id="LibelleAddFamille" class="form-control">
        </td>
        <td class="text-left Width176" scope='col'>
          <select class="select-2 form-control" onchange="CheckAddFamille()" id="RegroupementAddFamille">
          </select>
        </td>
        <td class="text-left Width119" scope='col' >
          <button class="btn btn-primary col-lg-12" disabled onclick="AddFamille()" id="ButtonAddFamille">Ajouter</button>
        </td>
      </tr>
    </tbody>
    <tbody id="table-body" class="scroller" style="display: block; max-height: 640px; min-height: 640px; overflow-y:scroll; border-top:0;">

    </tbody>
  </table>
</div>
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
    <button class="btn btn-primary" disabled onclick="GoTo('bottom')" id="familleslistfullleft"><i class="fas fa-angle-double-left"></i></button>
    <button class="btn btn-primary" disabled onclick="GoTo('down')" id="familleslistleft"><i class="fas fa-angle-left"></i></button>
    <select class="form-control col-lg-3" onchange="GoToPage(value)" id="familleslistpageselector"></select>

    <button class="btn btn-primary" onclick="GoTo('up')" id="familleslistright"><i class="fas fa-angle-right"></i></button>
    <button class="btn btn-primary" onclick="GoTo('top')" id="familleslistfullright"><i class="fas fa-angle-double-right"></i></button>
  </div>
  <div class="row col-lg-4" style="padding:0; margin:0">
    <button class="btn btn-warning" onclick="ResetFilters()" id="familleslistfullright">Retirer filtres</button>&nbsp
    <button class="btn btn-danger" disabled onclick="DeleteSelectedFamilles()" id="deleteSelectedFamillesButton">Supprimer séléction</button>
  </div>
</div>
<script>


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

<!-- TODO filtrage et suppression par selection et retraction de filtres -->
