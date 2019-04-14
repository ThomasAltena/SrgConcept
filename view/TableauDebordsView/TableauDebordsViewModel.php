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

let IdEntreprise = findGetParameter('Id_Entreprise');
let TypeEntreprise = findGetParameter('Type_Entreprise');
let TypeUser = findGetParameter('Type_User');

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
</script>
