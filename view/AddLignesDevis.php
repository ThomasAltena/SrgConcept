
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

try {
    $db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$aResult = array();
$arguments = json_decode(file_get_contents('php://input'));

if( !isset($_GET['functionname']) ) { $aResult['error'] = 'No function name!'; }

//if( !isset($_GET['arguments']) ) {
//    $aResult['error'] = 'No function arguments!'; }
//else {
//    $arguments = json_decode(file_get_contents('php://input'));
//}

if( !isset($aResult['error']) ) {
    switch($_GET['functionname']) {
        case 'AddDevis':
            if( !is_array($arguments) || (count($arguments) < 5) ) {
                $aResult['error'] = 'Erreur - manque données devis!';
            }
            else {
                $lignes = $arguments[4];

                if( !is_array($lignes) || (count($lignes) < 1) ) {
                    $aResult['error'] = '\'Erreur - manque données pieces!!';
                } else {
                    $idUser = $_SESSION['Id_user'];
                    $date = date("Y-m-d");
                    $idclient = $arguments[0];
                    $idMatiere = $arguments[1];
                    $chemin = $arguments[2];

                    $devis = new Devis([
                        "Id" => "",
                        "Date" => $date,
                        "IdClient" => $idclient,
                        "IdUser" => $idUser,
                        "Chemin" => "",
                        "IdMatiere" => $idMatiere
                    ]);

                    $DevisManager = new DevisManager($db); //Connexion a la BDD
                    $devisInsertResult = $DevisManager->AddDevis($devis);

                    if(!$devisInsertResult[0]){
                        $aResult['error'] = "Erreur INSERT de DEVIS - ".$devisInsertResult[1][2];
                    } else {
                        $lastId = $db->lastInsertId();
                        $LigneDevisManager = new LigneDevisManager($db); //Connexion a la BDD

                        //PREPARATION IMAGE
                        $img = $arguments[3];
                        $img = str_replace('data:image/png;base64,', '', $img);
                        $img = str_replace(' ', '+', $img);
                        $data = base64_decode($img);

                        //SAUVEGARDE IMAGE QUAND DEVIS INSERT REUSSI
                        $upload_dir = "../public/images/schemas/";
                        $fichier_nom = "DEVIS_" . $lastId . "_" . mktime() . ".png";
                        $fichier = $upload_dir . $fichier_nom;
                        $success = file_put_contents($fichier, $data);

                        $fichier_full_path = $upload_dir . $fichier_nom;
                        $devisUpdateResult = $DevisManager->UpdateCheminSchema($lastId, $fichier_full_path);

                        foreach ($lignes as $ligne){
                            print_r($ligne->id_piece);

                            $formattedLigne = new LigneDevis([
                                "Id" => '',
                                "Remise" => $ligne->remise,
                                "Poids" => '',
                                "Hauteur" => $ligne->hauteur,
                                "Largeur" => $ligne->largeur,
                                "Profondeur" => $ligne->profondeur,
                                "IdPiece" => $ligne->id_piece,
                                "IdDevis" => $lastId,
                                "Pos_x_piece" => $ligne->pos_x,
                                "Pos_y_piece" => $ligne->pos_y,
                                "Ratio_piece" => $ligne->ratio,
                                "Pos_z_piece" => $ligne->pos_z
                            ]);

                            $ligneInsertResult = $LigneDevisManager->AddLigne($formattedLigne);

                            if(!$ligneInsertResult[0]){
                                $aResult['error'] = "Erreur INSERT de DEVIS - ".$ligneInsertResult[1][2];
                            } else {
                                // insert options lignes devis
                                //TODO

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
