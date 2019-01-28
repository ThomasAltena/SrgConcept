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
$p = $_GET['p'];

$code_famille = str_replace(' ', '', $q);
$code_ss = str_replace(' ', '', $p);

$query = 'SELECT * FROM pieces WHERE Code_famille = "'.$code_famille.'" && Code_ss = "'.$code_ss.'"';
$reponse = $bdd->query('SELECT * FROM pieces');

echo ('<div class="input-group-prepend">
    <span class="input-group-text" style="width:100px" id="Id_piece_label">Piece :</span>
</div>');

if(empty($reponse)){
    echo('<select name="Id_piece" id="select_piece" aria-describedby=Id_piece_label"
        onchange="AfficheImg(1)" class="form-control" disabled>');
    echo('<option value="" disabled selected>Aucun sous famille</option>');

} else {
    echo('<select name="Id_piece" id="select_piece" aria-describedby=Id_piece_label"
        onchange="AfficheImg(1)" class="form-control">');
    echo('<option value="" selected style="font-style: italic">Aucun</option>');
    while ($donnees = $reponse->fetch()) {
        ?>
        <option id="<?php echo $donnees['Id_piece']; ?>"
                value=" <?php echo $donnees['Chemin_piece']; ?>"> <?php echo $donnees['Libelle_piece']; ?></option>
        <?php
    }
}

?>
</select>