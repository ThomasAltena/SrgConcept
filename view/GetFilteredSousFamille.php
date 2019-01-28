<?php
session_start();
if (empty($_SESSION)) {
    header('location:index.php');
}

$db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');

try {
    $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$q = $_GET['q'];
$code_famille = str_replace(' ', '', $q);
$query = 'SELECT * FROM ss_familles WHERE Code_famille = "'.$code_famille.'"';
$reponse = $bdd->query($query);


echo ('<div class="input-group-prepend">
    <span class="input-group-text" style="width:100px"
      id="Id_ss_famille_label">Sous-fam :</span>
</div>');

if(empty($reponse)){
    echo('<select name="Id_ss_famille" aria-describedby=Id_ss_famille_label" id="select_ss_famille"
    class="form-control" onchange="FilterPieces(value)" disabled>');
    echo('<option value="" disabled selected>Aucun sous famille</option>');

} else {
    echo('<select name="Id_ss_famille" aria-describedby=Id_ss_famille_label" id="select_ss_famille"
    class="form-control" onchange="FilterPieces(value)">');
    echo('<option value="" selected style="font-style: italic">Aucun</option>');
    while ($donnees = $reponse->fetch()) {
        ?>
        <option value=" <?php echo $donnees['Code_ss']; ?>"
        > <?php echo $donnees['Libelle_ss']; ?></option>
        <?php
    }
}

?>
</select>