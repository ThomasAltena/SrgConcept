<?php
session_start();

//include('../view/header.php');
?>


<?php
$tablesNonPluriel = ['tva', 'devis'];

/* Mise en place de la base de donnée */
$bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');

if(isset($_GET['tableNom']) ) {
  echo($_GET['tableNom']);
  genererClassTable($_GET['tableNom']);
} else {
  $querytables = 'SHOW TABLES';
  $reponsetables = $bdd->query($querytables);
  while ($tables = $reponsetables->fetch()) {
    genererClassTable($tables['Tables_in_srg']);
  }
}

function genererClassTable($tableNom) {
  global $tablesNonPluriel, $bdd;
  $tableNameParts = explode("_",$tableNom);
  $className = '';
  foreach ($tableNameParts as $tableNamePart) {
    if(!in_array($tableNamePart, $tablesNonPluriel)){
      $tableNamePart = substr($tableNamePart,0,-1);
    }
    $className .= ucfirst($tableNamePart);
  }

  $filename = $className."Class.php";

  $collumNames = [];
  $queryColumns = 'DESCRIBE `'.$tableNom.'`';
  $reponseColumns = $bdd->query($queryColumns);

  while ($Columns = $reponseColumns->fetch()) {
    $collumnName = $Columns['Field'];
    array_push($collumNames, $collumnName);
  }

  $content = "";
  $content .= "<?php";
  $content .= "\n\nclass ".$className;
  $content .= "\n{";
  $content .= "\n\tpublic $"."_".$collumNames[0].";";

  for ($x = 1; $x < count($collumNames); $x++) {
    $content .= "\n\tprivate $"."_".$collumNames[$x].";";
  }
  $content .= "\n\tprivate $"."_OriginalObject;";

  $content .= "\n\n\tpublic function __construct(array $"."donnees)";
  $content .= "\n\t{";
  $content .= "\n\t\t$"."this->hydrate($"."donnees);";
  $content .= "\n\t}";

  $content .= "\n\n\tpublic function hydrate(array $"."donnees)";
  $content .= "\n\t{";
  $content .= "\n\t\tif(isset($"."donnees)){";
  $content .= "\n\t\t\t$"."this->SetOriginalObject($"."donnees);";
  $content .= "\n\t\t\tforeach ($"."donnees as $"."key => $"."value)";
  $content .= "\n\t\t\t{";
  $content .= "\n\t\t\t\t$"."method = 'Set'.ucfirst($"."key);";
  $content .= "\n\t\t\t\tif (method_exists($"."this, $"."method))";
  $content .= "\n\t\t\t\t{";
  $content .= "\n\t\t\t\t\t$"."this->$"."method($"."value);";
  $content .= "\n\t\t\t\t}";
  $content .= "\n\t\t\t}";
  $content .= "\n\t\t}";
  $content .= "\n\t}";

  $content .= "\n\n\t/**GET**/";
  foreach ($collumNames as $collumName) {
    $content .= "\n\tpublic function Get".$collumName."(){return $"."this->_".$collumName.";}";
  }
  $content .= "\n\tpublic function GetOriginalObject(){return $"."this->_OriginalObject;}";

  $content .= "\n\n\t/**SET**/";
  foreach ($collumNames as $collumName) {
    $content .= "\n\tpublic function Set".$collumName."($".$collumName."){"."$"."this -> _".$collumName." = $".$collumName.";}";
  }
  $content .= "\n\tpublic function SetOriginalObject($"."OriginalObject){"."$"."this -> _OriginalObject = $"."OriginalObject;}";
  $content .= "\n\n}";

  file_put_contents('generated/class/'.$filename, $content);
}
?>
