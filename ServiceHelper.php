<?php
session_start();
if (empty($_SESSION)) {
  header('location:/SrgConcept/view/index.php');
}
spl_autoload_register(function ($class_name) {
  if(strpos($class_name, 'Manager')){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/SrgConcept/manager/'. $class_name . '.php');
  } else {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/SrgConcept/model/'. $class_name . 'Class.php');
  }
});

if( !isset($_GET['manager']) || !isset($_GET['route'])) {
  $result['error'] = 'No route or manager!';
} else {
  try {
    $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
  } catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
  }
  $manager = new $_GET['manager']($bdd);
  $args = json_decode(file_get_contents('php://input'));
  if(empty($args) || !isset($args)){
    $args = [];
  }
  $data = call_user_func_array(array($manager, $_GET['route']), $args);
  if(isset($_GET['originalObject'])){


    if(!is_array($data)){
      echo(json_encode(utf8ize($data->GetOriginalObject())));
    } else {
      $newData = [];
      foreach ($data as $dataPiece) {
        array_push($newData, $dataPiece->GetOriginalObject());
      }
      echo(json_encode(utf8ize($newData)));
    }
  } else {
    echo(json_encode(utf8ize($data)));
  }
}

function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
}
?>
