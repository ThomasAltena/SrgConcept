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
/*$r = $_GET['r'];*/

$code_famille = str_replace(' ', '', $q);
$code_ss = str_replace(' ', '', $p);
/*$code_piece_preselect = str_replace(' ', '', $r );*/

$query = 'SELECT * FROM pieces WHERE Code_famille = "'.$code_famille.'" && Code_ss = "'.$code_ss.'"';
$reponse = $bdd->query($query);
$selectFirst = true;

echo ('<div class="input-group-prepend">
    <span class="input-group-text" style="width:100px" id="Id_piece_label">Piece :</span>
</div>');

if(empty($reponse)){
    echo('<select name="Id_piece" id="select_piece" aria-describedby=Id_piece_label"
        onchange="SelectPiece()" class="form-control" disabled>');
    echo('<option value="" disabled selected>Aucun sous famille</option>');
    $selectFirst = false;

} else {
    echo('<select name="Id_piece" id="select_piece" aria-describedby=Id_piece_label"
        onchange="SelectPiece()" class="form-control">');

    while ($donnees = $reponse->fetch()) {
        if($selectFirst){
            ?>
            <option id="<?php echo $donnees['Id_piece']; ?>"
                    value="<?php echo $donnees['Chemin_piece']; ?>" selected> <?php echo $donnees['Libelle_piece']; ?></option>
            <?php
        } else {
            ?>
            <option id="<?php echo $donnees['Id_piece']; ?>"
                    value="<?php echo $donnees['Chemin_piece']; ?>"> <?php echo $donnees['Libelle_piece']; ?></option>
            <?php
        }
    }
}

?>
</select>
