<?php
session_start();
if (empty($_SESSION)) {
  header('location:index.php');
}

require('../model/DevisClass.php');
require('../model/DevisManager.php');

require('../model/LigneDevisClass.php');
require('../model/LigneDevisManager.php');

require('../model/OptionLigneClass.php');
require('../model/OptionLigneManager.php');

try {
  $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
} catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}

$aResult = array();
$input = file_get_contents('php://input');
$arguments = null;

if( !isset($_GET['functionname']) ) { $aResult['error'] = 'No function name!'; }


if( !isset($aResult['error']) ) {
  switch($_GET['functionname']) {
    case 'AddLignesDevis':
    PostLignesDevis();
    break;
    case 'GetAllDevisInfo':
    GetAllDevisInfo();
    break;
    default:
    $aResult['error'] = 'Not found function '.$_GET['functionname'].'!';
    break;
  }
  echo json_encode($aResult);
}

function PostLignesDevis() {
  global $_SESSION, $input, $aResult, $arguments, $bdd;
  if( !isset($input) ) {
    $aResult['error'] = 'No function arguments!';
  } else {
    $arguments = json_decode($input);
    if( !is_array($arguments) || (count($arguments) < 5) ) {
      $aResult['error'] = 'Erreur - manque donnees devis!';
    }
  }

  if( !isset($aResult['error']) ) {
    $lignes = $arguments[4];

    if( !is_array($lignes) || (count($lignes) < 1) ) {
      $aResult['error'] = 'Erreur - manque données pieces!!';
    } else {
      $idUser = $_SESSION['Id_user'];
      $date = date("Y-m-d");
      $idclient = $arguments[0];
      $idMatiere = $arguments[1];
      $chemin = $arguments[2];

      $devis = ["Id_devis" => "",
        "Date_devis" => $date,
        "IdClient_devis" => $idclient,
        "IdUser_devis" => $idUser,
        "Chemin_devis" => "",
        "IdMatiere_devis" => $idMatiere
      ];
      $devisModel = new Devis($devis);

      $DevisManager = new DevisManager($bdd); //Connexion a la BDD
      $devisInsertResult = $DevisManager->AddDevis($devisModel);

      $aResult['devisResults'] = [
        "insertResult" => $devisInsertResult,
        "updateResult" => [],
        "devis" => $devis,
        "ligneResults" => []
      ];

      if(!$devisInsertResult[0]){
        $aResult['error'] = 'Erreur INSERT de DEVIS - '.$devisInsertResult[1][2];
      } else {
        $devisInsertId = $bdd->lastInsertId();
        $LigneDevisManager = new LigneDevisManager($bdd); //Connexion a la BDD
        $OptionLigneManager = new OptionLigneManager($bdd);

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

        $aResult['devisResults']['updateResult'] = $devisUpdateResult;

        foreach ($lignes as $ligne){
          $options = $ligne->options;

          $formattedLigne = [
            "Id_ligne" => '',
            "Remise_ligne" => $ligne->remise,
            "Poids_ligne" => '',
            "Hauteur_ligne" => $ligne->hauteur,
            "Largeur_ligne" => $ligne->largeur,
            "Profondeur_ligne" => $ligne->profondeur,
            "IdPiece_ligne" => $ligne->id_piece,
            "IdDevis_ligne" => $devisInsertId,
            "Pos_x_piece_ligne" => $ligne->pos_x,
            "Pos_y_piece_ligne" => $ligne->pos_y,
            "Ratio_piece_ligne" => $ligne->ratio,
            "Pos_z_piece_ligne" => $ligne->pos_z
          ];

          $formattedLigneModel = new LigneDevis($formattedLigne);

          $ligneInsertResult = $LigneDevisManager->AddLigne($formattedLigneModel);

          $ligneResultObject = [
            "insertResult" => $ligneInsertResult,
            "ligne" =>$ligne,
            "optionResults" => []
          ];

          if(!$ligneInsertResult[0]){
            $aResult['error'] = 'Erreur INSERT de LIGNE - '.$ligneInsertResult[1][2];
            break;
          } else {
            if( is_array($options) && (count($options) > 0) ) {
              $ligneInsertId = $bdd->lastInsertId();

              foreach ($options as $option) {
                $formattedOption = [
                  "Id_optionLigne" => '',
                  "IdLigne_optionLigne" => $ligneInsertId,
                  "IdOption_optionLigne" => $option->Id_option
                ];
                $formattedOptionModel = new OptionLigne($formattedOption);

                $optionLigneInsertResult = $OptionLigneManager->AddOptionLigne($formattedOptionModel);

                $optionResultObject = [
                  "insertResult" => $optionLigneInsertResult,
                  "option" =>$option
                ];
                array_push($ligneResultObject['optionResults'], $optionResultObject);

                if(!$optionLigneInsertResult[0]){
                  $aResult['error'] = 'Erreur INSERT de OPTION_LIGNE - '.$optionLigneInsertResult[1][2];
                  break 2;
                }
              }
            }
          }
          array_push($aResult['devisResults']['ligneResults'], $ligneResultObject);
        }
      }
    }
  }
}

function GetAllDevisInfo(){
  global $_SESSION, $input, $aResult, $arguments, $bdd;
  if( !isset($_GET['devisId']) ) {
    $aResult['error'] .= 'No devis Id! ';
  }
  if( !isset($aResult['error']) ) {
    $devisId = $_GET['devisId'];
    $optionsLignes = array();
    $devi = null;

    $syntax = 'SELECT * FROM devis WHERE Id_devis = :iddevis';
    $query = $bdd->prepare($syntax);
    $query->bindValue(':iddevis', $devisId);

    if(!$query->execute()) {
      $aResult['error'] .= $query->errorInfo();
    } else {
      while ($devi1 = $query->fetch(PDO::FETCH_ASSOC))
      {
        $deviModel = new Devis($devi1);
        $devi = $devi1;
      }
    }

    if( !isset($aResult['error']) ) {
      $devi['lignes'] = array();

      $syntax = 'SELECT * FROM lignes_devis WHERE IdDevis_ligne = :iddevis';
      $query = $bdd->prepare($syntax);
      $query->bindValue(':iddevis', $devisId);

      if(!$query->execute()) {
        $aResult['error'] .= $query->errorInfo();
      } else {
        while ($ligne = $query->fetch(PDO::FETCH_ASSOC))
        {
          array_push($devi['lignes'], $ligne);
        }
      }
    }

    if( !isset($aResult['error']) ) {
      foreach ($devi['lignes'] as &$ligne){
        $ligneModel = new LigneDevis($ligne);

        $syntax = 'SELECT * FROM pieces WHERE Id_piece = :idpiece';
        $query = $bdd->prepare($syntax);
        $query->bindValue(':idpiece', $ligneModel->GetIdPiece());

        if(!$query->execute()) {
          $aResult['error'] .= $query->errorInfo();
          break;
        } else {
          while ($piece = $query->fetch(PDO::FETCH_ASSOC))
          {
            $ligne['piece'] = $piece;
          }
        }


        $ligne['$options'] = array();
        $optionsLignes = [];

        $syntax = 'SELECT * FROM options_lignes WHERE IdLigne_OptionsLignes = :idligne';
        $query = $bdd->prepare($syntax);
        $query->bindValue(':idligne', $ligneModel->GetId());

        if(!$query->execute()) {
          $aResult['error'] .= $query->errorInfo();
          break;
        } else {
          while ($optionLigne = $query->fetch(PDO::FETCH_ASSOC))
          {
            array_push($optionsLignes, $optionLigne);
          }
        }

        foreach ($optionsLignes as $optionLigne) {
          $optionLigneModel = new OptionLigne($optionLigne);

          $syntax = 'SELECT * FROM options WHERE Id_option = :idoption';
          $query = $bdd->prepare($syntax);
          $query->bindValue(':idoption', $optionLigneModel->GetIdOption());

          if(!$query->execute()) {
            $aResult['error'] .= $query->errorInfo();
            break 2;
          } else {
            while ($option = $query->fetch(PDO::FETCH_ASSOC))
            {
              array_push($ligne['$options'], $option);
            }
          }
        }
      }
    }

    if( !isset($aResult['error']) ) {
      $syntax = 'SELECT * FROM clients WHERE Id_client = :idclient';
      $query = $bdd->prepare($syntax);
      $query->bindValue(':idclient', $deviModel->GetIdClient());

      if(!$query->execute()) {
        $aResult['error'] .= $query->errorInfo();
      } else {
        while ($client = $query->fetch(PDO::FETCH_ASSOC))
        {
          $devi['client'] = $client;
        }
      }
    }

    if( !isset($aResult['error']) ) {
      $syntax = 'SELECT * FROM matieres WHERE Id_matiere = :idmatiere';
      $query = $bdd->prepare($syntax);
      $query->bindValue(':idmatiere', $deviModel->GetIdMatiere());

      if(!$query->execute()) {
        $aResult['error'] .= $query->errorInfo();
      } else {
        while ($matiere = $query->fetch(PDO::FETCH_ASSOC))
        {
          $devi['matiere'] = $matiere;
        }
      }
    }

    if( !isset($aResult['error']) ) {
      $aResult['data'] = $devi;
    }
  }
}



?>
