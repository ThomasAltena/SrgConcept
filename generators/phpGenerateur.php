<?php
session_start();

include('../view/header.php');
?>


<?php
$tablesNonPluriel = ['tva', 'devis'];

/* Mise en place de la base de donnée */
$bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');

$querytables = 'SHOW TABLES';
$reponsetables = $bdd->query($querytables);
?>
<!--CHOIX CLIENT-->
<div class="input-group mb-3 col-lg-4">
  <div class="input-group-prepend">
    <span class="input-group-text" style="width:100px"
    id="Id_client_label">Table :</span>
  </div>
  <select name="Id_client" id="tableNom" aria-describedby="Id_client_label" class="form-control">
    <?php
    foreach($reponsetables as $table){
      ?>
      <option value='<?php echo $table['Tables_in_srg']; ?>'> <?php echo $table['Tables_in_srg']; ?></option>
      <?php
    }
    ?>
  </select>
</div>
<button class='btn btn-default col-lg-2 mb-3' onclick='Allm()' > Generer tout managers</button>
<button class='btn btn-default col-lg-2 mb-3' onclick='Allc()'> Generer tout classes</button>
<button class='btn btn-default col-lg-2 mb-3' onclick='Selectedc()'> Generer class selectionnee</button>
<button class='btn btn-default col-lg-2 mb-3' onclick='SelectedM()'> Generer managers selectionnee</button>

<script>
function Allm(){
  let xhttp;
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () { console.log(this.responseText);  };
  xhttp.open("GET", "/SrgConcept/generators/phpManagerGenerateur.php", true);
  xhttp.send();
}

function SelectedM(){
  let xhttp;
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () { console.log(this.responseText);  };
  xhttp.open("GET", "/SrgConcept/generators/phpManagerGenerateur.php?tableNom=" + document.getElementById('tableNom').value, true);
  xhttp.send();
}
function Allc(){
  let xhttp;
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () { console.log(this.responseText);  };
  xhttp.open("GET", "/SrgConcept/generators/phpClassGenerateur.php", true);
  xhttp.send();
}
function Selectedc(){
  let xhttp;
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () { console.log(this.responseText);  };
  xhttp.open("GET", "/SrgConcept/generators/phpClassGenerateur.php?tableNom=" + document.getElementById('tableNom').value, true);
  xhttp.send();
}
</script>
