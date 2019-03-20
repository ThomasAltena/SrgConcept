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
    include '../model/'. $class_name . '.php';
  } else {
    include '../model/'. $class_name . 'Class.php';
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
  $query = 'SELECT * FROM ss_familles WHERE CodeFamille_ss = "' . $code_famille . '" ORDER BY Regroupement_ss ASC, Libelle_ss ASC';
  $reponse = $bdd->query($query);
  $selectFirst = false;

  $data .= '<div class="input-group-prepend">';
  $data .= '<span class="input-group-text" style="width:100px" id="Id_ss_famille_label">Sous-fam :</span>';
  $data .= '</div>';

  if(empty($reponse)){
    $selectFirst = false;
  } else {
    $data .= '<select name="Id_ss_famille" id="select_ss_famille" aria-describedby=Id_ss_famille_label" ';
    $data .= 'onchange="FilterPieces(value)" class="form-control">';
    $data .= '<option value="" disabled selected>Aucun</option>';

    $regroupement = '';
    while ($donnees = $reponse->fetch()) {
      if($regroupement != $donnees['Regroupement_ss']){
        $regroupement = $donnees['Regroupement_ss'];
        $data .= '<option disabled value="'.$regroupement.'"> --- '.$regroupement.' --- </option>';
      }

      if($selectFirst){
        $data .= "<option value='".$donnees['Code_ss']."' selected>".$donnees['Libelle_ss']."</option>";

      } else {
        $data .= "<option value='".$donnees['Code_ss']."'>".$donnees['Libelle_ss']."</option>";
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
  //$query = 'SELECT * FROM pieces WHERE CodeFamille_piece = "'.$code_famille.'" && CodeSs_piece = "'.$code_ss.'" && Code_piece REGEXP "^['.$formatCode.'].*$" ORDER BY Libelle_piece ASC ';

  $query = 'SELECT * FROM pieces WHERE CodeFamille_piece = "'.$code_famille.'" && CodeSs_piece = "'.$code_ss.'"';
  if($format == 'simple'){
    $query .= ' && Code_piece REGEXP "^S"';
  } else {
    $query .= ' && (Code_piece REGEXP "^D" || Code_piece REGEXP "^SD" )';
  }
  $query .= ' ORDER BY Libelle_piece ASC ';

  $reponse = $bdd->query($query);
  $selectFirst = true;

  $data .= '<div class="input-group-prepend">';
  $data .= '<span class="input-group-text" style="width:100px" id="Id_piece_label">Piece :</span>';
  $data .= '</div>';

  if(empty($reponse)){
    $data .= '<select name="Id_piece" id="select_piece" aria-describedby=Id_piece_label"';
    $data .= 'onchange="SelectPiece()" class="form-control" disabled>';
    $data .= '<option value="" disabled selected>Aucun sous famille</option>';
    $selectFirst = false;

  } else {
    $data .= '<select name="Id_piece" id="select_piece" aria-describedby=Id_piece_label" ';
    $data .= 'onchange="SelectPiece()" class="form-control">';

    while ($donnees = $reponse->fetch()) {
      if($selectFirst){
        $data .= '<option id="'.$donnees['Id_piece'].'"';
        $data .= "value='".json_encode($donnees)."' selected>".$donnees['Libelle_piece']."</option>";

      } else {
        $data .= '<option id="'.$donnees['Id_piece'].'"';
        $data .= "value='".json_encode($donnees)."'>".$donnees['Libelle_piece']."</option>";
      }
    }
  }
  $data .= '</select>';
  echo $data;
}

?>
