<?php
session_start();
if (empty($_SESSION)) {
  header('location:/SrgConcept/view/index.php');

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
    case 'SaveFicheFab':
      SaveFicheFab();
      echo json_encode($result);
      break;
    default:
      $result['error'] = 'Not found function '.$_GET['functionname'].'!';
      echo json_encode($result);
    break;
  }
}

function SaveFicheFab(){
  global $_SESSION, $input, $result, $arguments, $bdd;
  if( !isset($input) ) {
    $result['error'] = 'No function arguments!';
  } else {
    $arguments = json_decode($input);
    if( !is_array($arguments) || (count($arguments) < 2) ) {
      $result['error'] = 'Erreur - manque donnees devis!';
    }
  }

  if( !isset($result['error']) ) {
    $devisId = $arguments[0];

    //PREPARATION IMAGE
    $img = $arguments[1];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);

    //SAUVEGARDE IMAGE QUAND DEVIS INSERT REUSSI
    $upload_dir = "../public/images/ficheFabs/";
    $fichier_nom = "FICHEFAB_DEVIS" . $devisId . "_" . mktime() . ".png";
    $fichier = $upload_dir . $fichier_nom;
    $success = file_put_contents($fichier, $data);

    $fichier_full_path = $upload_dir . $fichier_nom;
    $devisManager = new DevisManager($bdd);
    $devisUpdateResult = $devisManager->UpdateCheminFicheFab($devisId, $fichier_full_path);
    $result['data'] = $fichier_full_path;
  }
}

?>
