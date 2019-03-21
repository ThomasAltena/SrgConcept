<?php
session_start();

?>


<?php
$tablesNonPluriel = ['tva', 'devis'];
/* Mise en place de la base de donnée */
$bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');

if(isset($_GET['tableNom']) ) {
  echo($_GET['tableNom']);
  genererManagerTable($_GET['tableNom']);
} else {
  $querytables = 'SHOW TABLES';
  $reponsetables = $bdd->query($querytables);
  while ($tables = $reponsetables->fetch()) {
    genererManagerTable($tables['Tables_in_srg']);
  }
}


function genererManagerTable($tableName) {
  global $tablesNonPluriel, $bdd;
  $tableNameParts = explode("_",$tableName);
  $className = '';
  foreach ($tableNameParts as $tableNamePart) {
    if(!in_array($tableNamePart, $tablesNonPluriel)){
      $tableNamePart = substr($tableNamePart,0,-1);
    }
    $className .= ucfirst($tableNamePart);
  }

  $filename = $className."Manager.php";

  $collumNames = [];
  $queryColumns = 'DESCRIBE `'.$tableName.'`';
  $reponseColumns = $bdd->query($queryColumns);

  while ($Columns = $reponseColumns->fetch()) {
    $collumnName = $Columns['Field'];
    array_push($collumNames, $collumnName);
  }

  $content = "";
  $content .= "<?php";
  $content .= "\n\nclass ".$className."Manager";
  $content .= "\n{";

  $content .= "\n\n\tprivate $"."_Db;";

  $content .= "\n\n\tpublic function __construct($"."db){"."$"."this->setDb($"."db);}";
  $content .= "\n\n\tpublic function SetDb(PDO $"."db){"."$"."this->_Db = $"."db;}";


  //ADD
  $content .= "\n\n\tpublic function Add".$className."(".$className." $".$className."){";
  $content .= "\n\t\t$"."q = $"."this->_Db->prepare('INSERT INTO ".$tableName." VALUES(";
  foreach ($collumNames as $collumName) {
    $content .= ":".$collumName.", ";
  }
  $content = substr($content,0,-2);
  $content .= ")');";
  foreach ($collumNames as $collumName) {
    $content .= "\n\t\t$"."q->bindValue(':".$collumName."', $".$className."->Get".$collumName."());";
  }
  $content .= "\n\t\t$"."q->execute();";
  $content .= "\n\t}";

  //UPDATE
  $content .= "\n\n\tpublic function Update".$className."(".$className." $".$className."){";
  $content .= "\n\t\t$"."q = $"."this->_Db->prepare('UPDATE ".$tableName." SET ";
  for($x = 1; $x < count($collumNames); $x++){
    $content .= "`".$collumNames[$x]."` = :".$collumNames[$x].", ";
  }
  $content = substr($content,0,-2);
  $content .= " WHERE ".$collumNames[0]." = :".$collumNames[0]." ');";
  foreach ($collumNames as $collumName) {
    $content .= "\n\t\t$"."q->bindValue(':".$collumName."', $".$className."->Get".$collumName."());";
  }
  $content .= "\n\t\t$"."q->execute();";
  $content .= "\n\t}";

  //DELETE
  $content .= "\n\n\tpublic function Delete".$className."( $"."id){";
  $content .= "\n\t\t$"."this->_Db->exec('DELETE FROM ".$tableName." WHERE ".$collumNames[0]." ='.$"."id);";
  $content .= "\n\t}";


  //GET BY ID
  $content .= "\n\n\tpublic function Get".$className."( $"."id){";
  $content .= "\n\t\t$"."q = $"."this->_Db->prepare('SELECT * FROM ".$tableName." WHERE ".$collumNames[0]." ='.$"."id);";
  $content .= "\n\t\t$"."q->execute();";
  $content .= "\n\t\twhile ($"."donnees = $"."q->fetch(PDO::FETCH_ASSOC)){"."$".$className." = new ".$className."($"."donnees);}";
  $content .= "\n\t\treturn $".$className.";";
  $content .= "\n\t}";

  //GET ALL
  $content .= "\n\n\tpublic function GetAll".$className."(){";
  $content .= "\n\t\t$".$className."s = [];";

  $content .= "\n\t\t$"."q = $"."this->_Db->query('SELECT * FROM ".$tableName."');";
  $content .= "\n\t\twhile ($"."donnees = $"."q->fetch(PDO::FETCH_ASSOC)){"."$".$className."s[] = new ".$className."($"."donnees);}";
  $content .= "\n\t\treturn $".$className."s;";
  $content .= "\n\t}";

  $content .= "\n\n}";

  file_put_contents('generated/manager/'.$filename, $content);
}
?>
