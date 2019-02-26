
<?php

session_start();

if (empty($_SESSION)) {
    header('location:index.php');
}

//header('Content-Type: application/json');

require('../model/DevisClass.php');
require('../model/DevisManager.php');

require('../model/LigneDevisClass.php');
require('../model/LigneDevisManager.php');

require('../model/OptionLigneClass.php');
require('../model/OptionLigneManager.php');

try {
    $db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$aResult = array();
$input = file_get_contents('php://input');
$arguments = null;

if( !isset($_GET['functionname']) ) { $aResult['error'] .= 'No function name!'; }

if( !isset($input) ) {
    $aResult['error'] .= '\n No function arguments!'; }
else {
    $arguments = json_decode($input);
}

if( !isset($aResult['error']) ) {
    switch($_GET['functionname']) {
        case 'AddDevis':
            if( !is_array($arguments) || (count($arguments) < 5) ) {
                $aResult['error'] .= '\n Erreur - manque données devis!';
            }
            else {
                $lignes = $arguments[4];

                if( !is_array($lignes) || (count($lignes) < 1) ) {
                    $aResult['error'] .= '\n Erreur - manque données pieces!!';
                } else {
                    $idUser = $_SESSION['Id_user'];
                    $date = date("Y-m-d");
                    $idclient = $arguments[0];
                    $idMatiere = $arguments[1];
                    $chemin = $arguments[2];

                    $devis = new Devis([
                        "Id_devis" => "",
                        "Date_devis" => $date,
                        "IdClient_devis" => $idclient,
                        "IdUser_devis" => $idUser,
                        "Chemin_devis" => "",
                        "IdMatiere_devis" => $idMatiere
                    ]);

                    $DevisManager = new DevisManager($db); //Connexion a la BDD
                    $devisInsertResult = $DevisManager->AddDevis($devis);

                    if(!$devisInsertResult[0]){
                        $aResult['error'] .= '\n Erreur INSERT de DEVIS - '.$devisInsertResult[1][2];
                    } else {
                        $devisInsertId = $db->lastInsertId();
                        $LigneDevisManager = new LigneDevisManager($db); //Connexion a la BDD
                        $OptionLigneManager = new OptionLigneManager($db);

                        //PREPARATION IMAGE
                        $img = $arguments[3];
                        $img = str_replace('data:image/png;base64,', '', $img);
                        $img = str_replace(' ', '+', $img);
                        $data = base64_decode($img);

                        //SAUVEGARDE IMAGE QUAND DEVIS INSERT REUSSI
                        $upload_dir = "../public/images/schemas/";
                        $fichier_nom = "DEVIS_" . $devisInsertId . "_" . mktime() . ".png";
                        $fichier = $upload_dir . $fichier_nom;
                        $success = file_put_contents($fichier, $data);

                        $fichier_full_path = $upload_dir . $fichier_nom;
                        $devisUpdateResult = $DevisManager->UpdateCheminSchema($devisInsertId, $fichier_full_path);

                        foreach ($lignes as $ligne){
                            $options = $ligne->options;

                            $formattedLigne = new LigneDevis([
                                "Id" => '',
                                "Remise" => $ligne->remise,
                                "Poids" => '',
                                "Hauteur" => $ligne->hauteur,
                                "Largeur" => $ligne->largeur,
                                "Profondeur" => $ligne->profondeur,
                                "IdPiece" => $ligne->id_piece,
                                "IdDevis" => $devisInsertId,
                                "Pos_x_piece" => $ligne->pos_x,
                                "Pos_y_piece" => $ligne->pos_y,
                                "Ratio_piece" => $ligne->ratio,
                                "Pos_z_piece" => $ligne->pos_z
                            ]);

                            $ligneInsertResult = $LigneDevisManager->AddLigne($formattedLigne);

                            if(!$ligneInsertResult[0]){
                                $aResult['error'] .= '\n Erreur INSERT de LIGNE - '.$ligneInsertResult[1][2];
                            } else {

                                if( is_array($options) && (count($options) > 0) ) {
                                    $ligneInsertId = $db->lastInsertId();

                                    foreach ($options as $option) {
                                        $formattedOption = new OptionLigne([
                                            "Id" => '',
                                            "IdLigne" => $ligneInsertId,
                                            "IdOption" => $option->Id_option
                                        ]);

                                        $optionLigneInsertResult = $OptionLigneManager->AddOptionLigne($formattedOption);

                                        if(!$optionLigneInsertResult[0]){
                                            $aResult['error'] .= '\n Erreur INSERT de OPTION_LIGNE - '.$optionLigneInsertResult[1][2];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            break;
        default:
            $aResult['error'] = 'Not found function '.$_GET['functionname'].'!';
            break;
    }
}

echo json_encode($aResult);
?>
