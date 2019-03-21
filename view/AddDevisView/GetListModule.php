<?php
session_start();
if (empty($_SESSION)) {
  header('location:index.php');
}

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

spl_autoload_register(function ($class_name) {
  if(strpos($class_name, 'Manager')){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/SrgConcept/manager/'. $class_name . '.php');
  } else {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/SrgConcept/model/'. $class_name . 'Class.php');
  }
});

try {
  $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
} catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}

$result = array();
$input = file_get_contents('php://input');
$arguments = null;

if( !isset($_GET['functionname']) ) { $result['error'] = 'No function name!'; }

if( !isset($result['error']) ) {
  switch($_GET['functionname']) {
    case 'GetFilteredPieces':
      GetFilteredPieces();
      break;
    case 'GetFilteredSousFamille':
      GetFilteredSousFamille();
      break;
    case 'GetOptions':
      GetOptions();
      break;
    default:
      $result['error'] = 'Not found function '.$_GET['functionname'].'!';
      echo json_encode($result);
    break;
  }
}

function GetOptions(){
  global $_SESSION, $input, $result, $arguments, $bdd;

  $data = '';
  $i = 0;
  $reponse = $bdd->query('SELECT * FROM options');
  while ($donnees = $reponse->fetch()) {
      $i++;
      $data .= '<tr id="select_option_'.$donnees['Id_option'].'" ';
      $data .= "onclick='ToggleOption(".json_encode($donnees).")'>";
      $data .= '<th scope="col"><?php echo $i; ?></th>';
      $data .= '<td scope="col">'.$donnees['Code_option'].'</td>';
      $data .= '<td scope="col">'.$donnees['Libelle_option'].'</td>';
      $data .= '<td scope="col">'.$donnees['Prix_option'].'</td>';
      $data .= '<td scope="col"><?php ?></td>';
      $data .= '<td scope="col"><?php ?></td>';
      $data .= '<td scope="col"><?php ?></td>';
      $data .= '<td scope="col"><?php ?></td>';
      $data .= '<td scope="col"><?php ?></td>';
      $data .= '</tr>';
  }

  $data .= '</select>';
  echo $data;
}

function GetFilteredSousFamille(){
  global $_SESSION, $input, $result, $arguments, $bdd;

  $data = '';
  $code_famille = str_replace(' ', '', $_GET['codeFamille']);
  $sousFamilleManager = new SousfamilleManager($bdd);
  $sousFamilles = $sousFamilleManager->GetSousfamilleByFamilleOrderByRegroupement($code_famille);

  $selectFirst = false;

  $data .= '<div class="input-group-prepend">';
  $data .= '<span class="input-group-text" style="width:100px" id="Id_ss_famille_label">Sous-fam :</span>';
  $data .= '</div>';

  if(empty($sousFamilles)){
    $selectFirst = false;
  } else {
    $data .= '<select name="Id_ss_famille" id="select_ss_famille" aria-describedby=Id_ss_famille_label" ';
    $data .= 'onchange="FilterPieces(value)" class="form-control">';
    $data .= '<option value="" disabled selected>Aucun</option>';

    $regroupement = '';
    foreach ($sousFamilles as $sousFamille) {
      if($regroupement != $sousFamille->GetRegroupementSsFamille()){
        $regroupement = $sousFamille->GetRegroupementSsFamille();
        $data .= '<option disabled value="'.$regroupement.'"> --- '.$regroupement.' --- </option>';
      }

      if($selectFirst){
        $data .= "<option value='".json_encode($sousFamille->GetOriginalObject())."' selected>".$sousFamille->GetLibelleSsFamille()."</option>";

      } else {
        $data .= "<option value='".json_encode($sousFamille->GetOriginalObject())."'>".$sousFamille->GetLibelleSsFamille()."</option>";
      }
    }
  }
  $data .= '</select>';
  echo $data;
}

function GetFilteredPieces(){
  global $_SESSION, $input, $result, $arguments, $bdd;

  $data = '';
  $code_famille = str_replace(' ', '', $_GET['codeFamille']);
  $code_ss = str_replace(' ', '', $_GET['codeSs']);
  $format = str_replace(' ', '', $_GET['format']);
  $pieceManager = new PieceManager($bdd);
  $pieces = $pieceManager->GetPiecesByFamilleSsFamilleFormat($code_famille, $code_ss, $format);

  $selectFirst = true;

  $data .= '<div class="input-group-prepend">';
  $data .= '<span class="input-group-text" style="width:100px" id="Id_piece_label">Piece :</span>';
  $data .= '</div>';

  if(empty($pieces)){
    $data .= '<select name="Id_piece" id="select_piece" aria-describedby=Id_piece_label"';
    $data .= 'onchange="SelectPiece()" class="form-control" disabled>';
    $data .= '<option value="" disabled selected>Aucun sous famille</option>';
    $selectFirst = false;

  } else {
    $data .= '<select name="Id_piece" id="select_piece" aria-describedby=Id_piece_label" ';
    $data .= 'onchange="SelectPiece()" class="form-control">';

    foreach ($pieces as $piece) {
      if($selectFirst){
        $data .= '<option id="'.$piece->GetIdPiece().'"';
        $data .= "value='".json_encode($piece->GetOriginalObject())."' selected>".$piece->GetLibellePiece()."</option>";

      } else {
        $data .= '<option id="'.$donnees['Id_piece'].'"';
        $data .= "value='".json_encode($piece->GetOriginalObject())."'>".$piece->GetLibellePiece()."</option>";
      }
    }
  }
  $data .= '</select>';
  echo $data;
}
?>
