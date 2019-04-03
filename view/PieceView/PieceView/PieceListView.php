<div class="formbox" style="position: absolute; left: 1650px; top: 115px; width: 200px; height: 200px"></div>

<table class='table table-striped' style='margin:10px 0; min-width:1360px; max-width:1360px'>
  <thead>
    <tr class="th-no-border search-input-title">
      <th class="text-left" scope='col'>
        <input type="checkbox" value="0" style="width: 50px;" class="form-control">
      </th>
      <th class="text-left" scope='col'>
        <input type="number" min="0" placeholder="Id" value="" style="width:50px" class="form-control">
      </th>
      <th class="text-left" scope='col' >
        <input placeholder="Libelle" value="" class="form-control">
      </th>
      <th class="text-left" scope='col'>
        <input value="" style="width:150px" placeholder="Code" class="form-control">
      </th>
      <th class="text-left" style="padding-bottom: 6px;" scope='col'>Image
      </th>
      <th class="text-left" scope='col'>
        <input value="" placeholder="Famille" class="form-control">
      </th>
      <th class="text-left" scope='col'>
        <input value="" placeholder="Sous-famille" class="form-control">
      </th>
      <th class="text-left" scope='col'>
        <input value=""  placeholder="Lien (groupe)" style="width:150px" class="form-control">
      </th>
      <th class="text-left" style="padding-bottom: 6px;" scope='col'>Date de création
      </th>
    </tr>
    <!-- <tr>
      <th class="text-left" scope='col'><i class="far fa-check-square"></i></th>
      <th class="text-left" scope='col'>Id</th>
      <th class="text-left" scope='col'>Libelle</th>
      <th class="text-left" scope='col'>Code</th>
      <th class="text-left" scope='col'>Image</th>
      <th class="text-left" scope='col'>Famille</th>
      <th class="text-left" scope='col'>Sous-famille</th>
      <th class="text-left" scope='col'>Lien (groupe)</th>
      <th class="text-left" scope='col'>Date de création</th>
    </tr> -->

    <tr class="th-no-border">
      <th colspan="2"><button class="btn btn-primary" style="width:100%">Ajouter</button></th>
      <th class="text-left" scope='col'>
        <input value="" class="form-control">
      </th>
      <th class="text-left" scope='col'>
        <input value="" style="width:150px" class="form-control">
      </th>
      <th class="text-left" scope='col'>
        <button class="btn btn-warning">Upload</button>
      </th>
      <th class="text-left" scope='col'>
        <input value="" class="form-control">
      </th>
      <th class="text-left" scope='col'>
        <input value="" class="form-control">
      </th>
      <th class="text-left" scope='col'>
        <input value=""  style="width:150px" class="form-control">
      </th>
      <th class="text-left" scope='col'>
      </th>
    </tr>
  </thead>
  <tbody>

  </tbody>
</table>
<style>
th {
    font-size:20px;
    padding:6px;
}
.table td, .table th {
    padding:6px;
}

tr.th-no-border th{
  border-top: 0;
  border-bottom: 0;
  padding: 2px;
}

tr.search-input-title input{
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



</style>
