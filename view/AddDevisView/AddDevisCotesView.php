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

try {
  $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
} catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}

$cube = array(
    "Libelle"=>'coffrets av arr',
    "Matiere"=>'tclair',
    "Largeur"=>96,
    "Profodneur"=>93,
    "Hauteur"=>98,
    "Quantite"=>2,
    "Cout"=>98
  );


$testCubes = array($cube,$cube,$cube,$cube);


$date = date("d-m-Y");

?>
<link rel="stylesheet" href="../../public/css/form.css" type="text/css">
<link rel="stylesheet" href="AddDevisCotes.css" type="text/css">
<link rel="stylesheet" href="../../public/css/switch.css" type="text/css">
<!-------------------------- Il faut mettre le chemin dans les value -------------------------->
<body style="overflow: scroll;">
  <div id="content-wrapper">
    <div class='container' style="max-width: 1600px; min-width: 1600px">
      <div class="form">
        <div class="row">
          <div class="col-sm row" id="donneesDevisContainer">
            <div class="col-sm" id="donneesColonneGaucheContainer">
              <div class="formbox" style="margin-bottom: 1vw;">

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Devis N˚</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-describedby="basic-addon1" id="devisId" value="">
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Client :</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-describedby="basic-addon1" id="clientLibelle" value="" >
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Date :</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-describedby="basic-addon1" id="dateLibelle" value="">
                </div>

                <!--VUE PIECE-->
                <div class="formbox row" id="pieceVueEtControlContainer">
                  <span id="pieceVueContainerCount"></span>
                  <div class="col-sm"><img alt="" id="imagePieceSelectionnee" src="" style="max-width: inherit; max-height: inherit">
                  </div>
                </div>
              </div>


            </div>
            <div class="col-sm" id="listeCubesDevisContainer">
              <div class="formbox" style="margin-bottom: 1vw;">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script type="text/javascript">


</script>
