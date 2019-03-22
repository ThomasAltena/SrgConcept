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

$ManagerMatiere = new MatiereManager($bdd); //Connexion a la BDD

$matieres = $ManagerMatiere->GetAllMatiere();

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


$testCubes = array($cube,$cube,$cube,$cube,$cube,$cube,$cube,$cube,$cube,$cube,$cube,$cube);


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
              <div class="formbox" style="margin-bottom: 1vw; height:100%; padding: 5px">
                <div class="row">
                  <div class="input-group mb-2 col-sm-6" style="padding-right:5px">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">N˚ Devis</span>
                    </div>
                    <input type="text" class="form-control" disabled aria-describedby="basic-addon1" id="devisId" value="">
                  </div>
                  <div class="input-group mb-2 col-sm-6" style="padding-left:5px">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">Date :</span>
                    </div>
                    <input type="text" class="form-control" disabled aria-describedby="basic-addon1" id="dateLibelle" value="">
                  </div>
                </div>

                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Libellé :</span>
                  </div>
                  <input type="text" class="form-control" aria-describedby="basic-addon1" id="clientLibelle" value="" >
                </div>

                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Client :</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-describedby="basic-addon1" id="clientLibelle" value="" >
                </div>

                <hr>

                <div class="row">
                  <div class="input-group mb-2 col-sm-6" style="padding-right:5px">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">Aquis :</span>
                    </div>
                    <div class="input-group-append">
                      <span class="input-group-text" id="basic-addon1">
                        <input type="checkbox" aria-label="Checkbox for following text input">
                      </span>
                    </div>
                  </div>
                  <div class="input-group mb-2 col-sm-6" style="padding-left:5px">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">Dos Poli :</span>
                    </div>
                    <div class="input-group-append">
                      <span class="input-group-text" id="basic-addon1">
                        <input type="checkbox" aria-label="Checkbox for following text input">
                      </span>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="input-group mb-2 col-sm-6" style="padding-right:5px">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">Type :</span>
                    </div>
                    <select id="id_matiere"  onchange="SelectMatiere(value)" class="form-control" name="Id_matiere" aria-describedby="Id_matiere_label">
                      <?php
                      foreach($matieres as $matiere){
                        ?>
                        <option value='<?php echo json_encode($matiere->GetOriginalObject()); ?>'> <?php echo $matiere->GetLibelleMatiere(); ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="input-group mb-2 col-sm-6" style="padding-left:5px">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">Matiere :</span>
                    </div>
                    <select class="form-control">
                      <option selected disabled></option>
                      <option value='Marbrier'>Marbrier</option>
                      <option value='Granitier'>Granitier</option>
                    </select>
                  </div>
                </div>

                <div class="row">
                  <div class="input-group mb-2 col-sm-6" style="padding-right:5px">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">Arrondi :</span>
                    </div>
                    <select class="form-control">
                      <option selected disabled></option>
                      <option value='HT Net'>HT Net</option>
                      <option value='HT Net'>HT Arrondi</option>
                      <option value='HT Net'>TTC Net</option>
                      <option value='HT Net'>TTC Net</option>
                    </select>
                  </div>
                  <div class="input-group mb-2 col-sm-6" style="padding-left:5px">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">Prix :</span>
                    </div>
                    <select class="form-control">
                      <option selected disabled></option>
                      <option value='Prix Depart'>Prix Départ</option>
                      <option value='Prix Franco'>Prix Franco</option>
                      <option value='Prix Pose'>Prix Posé</option>
                    </select>
                  </div>
                </div>

                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">TVA (Monu.) :</span>
                  </div>
                  <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon1">%</span>
                  </div>
                </div>

                <hr>

                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">PU Transport :</span>
                  </div>
                  <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon1">€</span>
                  </div>
                </div>
                <span class="input-group-text mb-2" id="basic-addon1">(la tonne) - Soit 0.00 € frais de port.</span>

                <hr>

                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Surface Totale :</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-label="Amount (to the nearest dollar)">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon1">m2</span>
                  </div>
                </div>

                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Volume Total :</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-label="Amount (to the nearest dollar)">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon1">m3</span>
                  </div>
                </div>

                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Poids Total :</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-label="Amount (to the nearest dollar)">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon1">m3</span>
                  </div>
                </div>

                <hr>

                <div class="row">
                  <div class="input-group mb-2 col-sm-6" style="padding-right:5px">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">Nb pieces :</span>
                    </div>
                    <input type="text" class="form-control" disabled aria-label="Amount (to the nearest dollar)">
                  </div>
                  <div class="input-group mb-2 col-sm-6" style="padding-left:5px">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">Nb cubes :</span>
                    </div>
                    <input type="text" class="form-control" disabled aria-label="Amount (to the nearest dollar)">
                  </div>
                </div>

                <hr>

                <button class='btn btn-primary form-control mb-2'>Affinage calculs
                </button>

              </div>


            </div>
            <div class="col-sm" id="listeCubesDevisContainer" style="margin-top:10px">
              <div style="margin-bottom: 1vw; overflow-y: scroll; max-height: 500px; min-height:500px">
                <table class='table table-striped'>
                  <thead>
                    <tr>
                      <th style='padding: 2px; border-top: 0px; font-size: 18px;' class="text-left" scope='col'>Cubes Monument</th>
                      <th style='padding: 2px; border-top: 0px; font-size: 18px;' class="text-left" scope='col'>Matiere</th>
                      <th style='padding: 2px; border-top: 0px; font-size: 18px;' class="text-left" scope='col'>Larg.</th>
                      <th style='padding: 2px; border-top: 0px; font-size: 18px; font-style: italic;' class="text-left" scope='col'>Larg.</th>
                      <th style='padding: 2px; border-top: 0px; font-size: 18px;' class="text-left" scope='col'>Prof.</th>
                      <th style='padding: 2px; border-top: 0px; font-size: 18px;font-style: italic;' class="text-left" scope='col'>Prof.</th>
                      <th style='padding: 2px; border-top: 0px; font-size: 18px;' class="text-left" scope='col'>Haut.</th>
                      <th style='padding: 2px; border-top: 0px; font-size: 18px;font-style: italic;' class="text-left" scope='col'>Haut.</th>
                      <th style='padding: 2px; border-top: 0px; font-size: 18px;' class="text-left" scope='col'>Qté</th>
                      <th style='padding: 2px; border-top: 0px; font-size: 18px;' class="text-left" scope='col'>Coût Cube</th>
                    </tr>
                  </thead>
                  <tbody style="">
                    <?php foreach($testCubes as $testCube) { ?>
                    <tr>
                      <td class="text-left td"style="padding: 6px; font-size: 16px;">test</td>
                      <td class="text-left td"style="padding: 2px; font-size: 16px; width:150px">
                        <select id="id_matiere" style="" onchange="SelectMatiere(value)" class="form-control" name="Id_matiere" aria-describedby="Id_matiere_label">
                          <?php
                          foreach($matieres as $matiere){
                            ?>
                            <option value='<?php echo json_encode($matiere->GetOriginalObject()); ?>'> <?php echo $matiere->GetLibelleMatiere(); ?></option>
                            <?php
                          }
                          ?>
                        </select>
                      </td>
                      <td class="text-left td"style="padding: 6px; font-size: 16px;">test</td>
                      <td class="text-left td"style="padding: 6px; font-size: 16px;">test</td>
                      <td class="text-left td"style="padding: 6px; font-size: 16px;">test</td>
                      <td class="text-left td"style="padding: 6px; font-size: 16px;">test</td>
                      <td class="text-left td"style="padding: 6px; font-size: 16px;">test</td>
                      <td class="text-left td"style="padding: 6px; font-size: 16px;">test</td>
                      <td class="text-left td"style="padding: 6px; font-size: 16px;">test</td>
                      <td class="text-left td"style="padding: 6px; font-size: 16px;">test</td>

                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="col-sm" id="donneesColonneDroiteContainer">
              <div class="formbox" style="margin-bottom: 1vw; height:100%; padding: 5px">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Prix Matiere :</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-label="Amount (to the nearest dollar)">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon1">€</span>
                  </div>
                </div>

                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Prix Faconnage :</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-label="Amount (to the nearest dollar)">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon1">€</span>
                  </div>
                </div>

                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Prix Options :</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-label="Amount (to the nearest dollar)">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon1">€</span>
                  </div>
                </div>

                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Monument HT :</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-label="Amount (to the nearest dollar)">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon1">€</span>
                  </div>
                </div>

                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Monument TTC :</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-label="Amount (to the nearest dollar)">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon1">€</span>
                  </div>
                </div>

                <hr>

                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Articles HT :</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-label="Amount (to the nearest dollar)">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon1">€</span>
                  </div>
                </div>

                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Articles TTC :</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-label="Amount (to the nearest dollar)">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon1">€</span>
                  </div>
                </div>

                <hr>

                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Nets HT :</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-label="Amount (to the nearest dollar)">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon1">€</span>
                  </div>
                </div>

                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Nets TTC :</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-label="Amount (to the nearest dollar)">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon1">€</span>
                  </div>
                </div>
                <hr>

                <button class='btn btn-primary form-control mb-2'>Ajout cubes
                </button>
                <button class='btn btn-primary form-control mb-2'>Modifier Dessin
                </button>
                <button class='btn btn-primary form-control mb-2'>Commentaires
                </button>

                <button class='btn btn-success form-control mb-2'>Suite
                </button>
                <button class='btn btn-success form-control mb-2'>Sauvegarder
                </button>
                <button class='btn btn-danger form-control mb-2'>Annuler
                </button>

                <!--VUE PIECE-->
                <!-- <div class="formbox row" id="pieceVueEtControlContainer">
                  <span id="pieceVueContainerCount"></span>
                  <div class="col-sm"><img alt="" id="imagePieceSelectionnee" src="" style="max-width: inherit; max-height: inherit">
                  </div>
                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>
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


</script>
