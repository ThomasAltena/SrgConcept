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
<body style="overflow: auto; min-width:1920px;">
  <div  id='viewContainer' class="container" style="max-width:1400px; "></div>
</body>
<style>
.td {
  padding-top: 5px;
  padding-bottom: 5px;
}
</style>
<script type="text/javascript">

ViewRequest('PieceMainView.php').then(function (result){
    $('#viewContainer').html(result.responseText);
}).catch(function(error){

});


const unique = (value, index, self) => {
  return self.indexOf(value) === index;
};

const add = (a,b) => {
  return parseInt(a) + parseInt(b)
};

</script>
