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

$i = 0;
$reponse = $bdd->query('SELECT * FROM options');
while ($donnees = $reponse->fetch()) {
    $i++;
    ?>

    <tr id="select_option_<?php echo $donnees['Id_option']; ?>"
        onclick='ToggleOption(<?php echo json_encode($donnees); ?>)'>
        <th scope="col"><?php echo $i; ?></th>
        <td scope="col"><?php echo $donnees['Code_option']; ?></td>
        <td scope="col"><?php echo $donnees['Libelle_option']; ?></td>
        <td scope="col"><?php echo $donnees['Prix_option']; ?></td>
        <td scope="col"><?php ?></td>
        <td scope="col"><?php ?></td>
        <td scope="col"><?php ?></td>
        <td scope="col"><?php ?></td>
        <td scope="col"><?php ?></td>
    </tr>
    <?php
}

?>
</select>
