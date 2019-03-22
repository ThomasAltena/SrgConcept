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


$cube = new CubeDevis(array(
  'IdCubeDevis' => 1,
  'HauteurCubeDevis' => 25,
  'LargeurCubeDevis' => 25,
  'ProfondeurCubeDevis' => 25,
  'IdDevis' => 2,
  'IdPiece' => 5,
  'IdCube' => 5,
  'IdMatiere' => 'A',
  'AvantPolisCube' => 'A',
  'AvantScieeCube' => 'A',
  'ArrierePolisCube' => 'A',
  'ArriereScieeCube' => 'A',
  'DroitePolisCube' => 'A',
  'DroiteScieeCube' => 'A',
  'GauchePolisCube' => 'A',
  'GaucheScieeCube' => 'A',
  'DessusPolisCube' => 'A',
  'DessusScieeCube' => 'A',
  'DessousPolisCube' => 'A',
  'DessousScieeCube' => 'A',
  'OriginalObject' => 'A'
));


$testCubes = array($cube,$cube,$cube,$cube);


$date = date("d-m-Y");

?>
<link rel="stylesheet" href="/SrgConcept/public/css/form.css" type="text/css">
<link rel="stylesheet" href="/SrgConcept/public/css/table.css" type="text/css">
<link rel="stylesheet" href="AddDevisCotes.css" type="text/css">
<link rel="stylesheet" href="/SrgConcept/public/css/switch.css" type="text/css">
<!-------------------------- Il faut mettre le chemin dans les value -------------------------->
<body style="overflow: scroll;">
  <div id="content-wrapper">
    <div class='container' style="max-width: 1600px; min-width: 1600px">
      <div class="form">
        <div class="row">
          <div class="col-sm row" id="donneesDevisContainer">
            <div class="col-sm" id="donneesColonneGaucheContainer">
              <div class="formbox" style="margin-bottom: 1vw; height:100%">
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
              <div style="margin-bottom: 1vw; height:100%">
                <table class='table table-striped' style='margin:10px 0;'>
                  <thead>
                    <tr>
                      <th style='border-top: 0px;' class="text-left" scope='col'>Cubes Monument</th>
                      <th style='border-top: 0px;' class="text-left" scope='col'>Matiere</th>
                      <th style='border-top: 0px;' class="text-left" scope='col'>Larg.</th>
                      <th style='border-top: 0px;font-style: italic;' class="text-left" scope='col'>Larg.</th>
                      <th style='border-top: 0px;' class="text-left" scope='col'>Prof.</th>
                      <th style='border-top: 0px;font-style: italic;' class="text-left" scope='col'>Prof.</th>
                      <th style='border-top: 0px;' class="text-left" scope='col'>Haut.</th>
                      <th style='border-top: 0px;font-style: italic;' class="text-left" scope='col'>Haut.</th>
                      <th style='border-top: 0px;' class="text-left" scope='col'>Qté</th>
                      <th style='border-top: 0px;' class="text-left" scope='col'>Coût Cube</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($testCubes as $testCube) { ?>
                    <tr>
                      <td class="text-left">test</td>
                      <td class="text-left">test</td>
                      <td class="text-left">test</td>
                      <td class="text-left">test</td>
                      <td class="text-left">test</td>
                      <td class="text-left">test</td>
                      <td class="text-left">test</td>
                      <td class="text-left">test</td>
                      <td class="text-left">test</td>
                      <td class="text-left">test</td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
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
