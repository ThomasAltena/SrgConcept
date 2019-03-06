<?php
session_start();
if (empty($_SESSION)) {
  header('location:index.php');
}

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

spl_autoload_register(function ($class_name) {
  if(strpos($class_name, 'Manager')){
    include '../model/'. $class_name . '.php';
  } else {
    include '../model/'. $class_name . 'Class.php';
  }
});


try {
  $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
} catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}

$result = array();
$input = file_get_contents('php://input');
$arguments = null;

if( !isset($_GET['functionname']) ) { $result['error'] = 'No function name!'; }


if( !isset($result['error']) ) {
  switch($_GET['functionname']) {
    case 'ArchiveDevis':
      if( !isset($_GET['devisId']) ) {
        $result['error'] .= 'No devis Id! ';
      } else {
        $result['data'] = ArchiveDevis(($_GET['devisId']));
      }

      echo json_encode($result);
      break;
    case 'AddLignesDevis':
      PostLignesDevis();
      echo json_encode($result);
      break;
    case 'GetAllDevisInfo':
      if( !isset($_GET['devisId']) ) {
        $result['error'] .= 'No devis Id! ';
      } else {
        $result['data'] = GetAllDevisInfo($_GET['devisId']);
      }
      echo json_encode($result);
      break;
    case 'GenerateDevisPDF':
      include '../vendor/autoload.php';
      if( !isset($_GET['devisId']) ) {
        $result['error'] .= 'No devis Id! ';
      } else {
        $result['data'] = GenerateDevisPDF(($_GET['devisId']));
      }
      if(!isset($result['error'])){
        echo json_encode($result['data']);
      } else {
        echo json_encode($result);
      }
      break;
    default:
      $result['error'] = 'Not found function '.$_GET['functionname'].'!';
      echo json_encode($result);
    break;
  }
}

function ArchiveDevis($deviId){
  global $_SESSION, $input, $result, $arguments, $bdd;
  $devisManager = new DevisManager($bdd);
  return $devisManager->ArchiveDevis($deviId);
}

function PostLignesDevis() {
  global $_SESSION, $input, $result, $arguments, $bdd;
  if( !isset($input) ) {
    $result['error'] = 'No function arguments!';
  } else {
    $arguments = json_decode($input);
    if( !is_array($arguments) || (count($arguments) < 5) ) {
      $result['error'] = 'Erreur - manque donnees devis!';
    }
  }

  if( !isset($result['error']) ) {
    $lignes = $arguments[4];

    if( !is_array($lignes) || (count($lignes) < 1) ) {
      $result['error'] = 'Erreur - manque données pieces!!';
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
        "CheminImage_devis" => "",
        "IdMatiere_devis" => $idMatiere,
        "Archive_devis" => false
      ];

      $devisModel = new Devis($devis);

      $DevisManager = new DevisManager($bdd); //Connexion a la BDD
      $devisInsertResult = $DevisManager->AddDevis($devisModel);

      $result['devisResults'] = [
        "insertResult" => $devisInsertResult,
        "updateResult" => [],
        "devis" => $devis,
        "ligneResults" => []
      ];

      if(!$devisInsertResult[0]){
        $result['error'] = 'Erreur INSERT de DEVIS - '.$devisInsertResult[1][2];
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

        $result['devisResults']['updateResult'] = $devisUpdateResult;

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
            $result['error'] = 'Erreur INSERT de LIGNE - '.$ligneInsertResult[1][2];
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
                  $result['error'] = 'Erreur INSERT de OPTION_LIGNE - '.$optionLigneInsertResult[1][2];
                  break 2;
                }
              }
            }
          }
          array_push($result['devisResults']['ligneResults'], $ligneResultObject);
        }
      }
    }
  }
}

function GetAllDevisInfo($deviId){
  global $_SESSION, $input, $result, $arguments, $bdd;
  $optionsLignes = array();
  $devi = null;

  $syntax = 'SELECT * FROM devis WHERE Id_devis = :iddevis';
  $query = $bdd->prepare($syntax);
  $query->bindValue(':iddevis', $deviId);

  if(!$query->execute()) {
    $result['error'] .= $query->errorInfo();
  } else {
    while ($deviResult = $query->fetch(PDO::FETCH_ASSOC))
    {
      $deviModel = new Devis($deviResult);
      $devi = $deviResult;
    }
  }

  if( !isset($result['error']) ) {
    $devi['lignes'] = array();

    $syntax = 'SELECT * FROM lignes_devis WHERE IdDevis_ligne = :iddevis';
    $query = $bdd->prepare($syntax);
    $query->bindValue(':iddevis', $deviId);

    if(!$query->execute()) {
      $result['error'] .= $query->errorInfo();
    } else {
      while ($ligne = $query->fetch(PDO::FETCH_ASSOC))
      {
        array_push($devi['lignes'], $ligne);
      }
    }
  }

  if( !isset($result['error']) ) {
    foreach ($devi['lignes'] as &$ligne){
      $ligneModel = new LigneDevis($ligne);

      $syntax = 'SELECT * FROM pieces WHERE Id_piece = :idpiece';
      $query = $bdd->prepare($syntax);
      $query->bindValue(':idpiece', $ligneModel->GetIdPiece());

      if(!$query->execute()) {
        $result['error'] .= $query->errorInfo();
        break;
      } else {
        while ($piece = $query->fetch(PDO::FETCH_ASSOC))
        {
          $ligne['piece'] = $piece;
        }
      }


      $ligne['options'] = array();
      $optionsLignes = [];

      $syntax = 'SELECT * FROM options_lignes WHERE IdLigne_OptionsLignes = :idligne';
      $query = $bdd->prepare($syntax);
      $query->bindValue(':idligne', $ligneModel->GetId());

      if(!$query->execute()) {
        $result['error'] .= $query->errorInfo();
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
          $result['error'] .= $query->errorInfo();
          break 2;
        } else {
          while ($option = $query->fetch(PDO::FETCH_ASSOC))
          {
            array_push($ligne['options'], $option);
          }
        }
      }
    }
  }

  if( !isset($result['error']) ) {
    $syntax = 'SELECT * FROM clients WHERE Id_client = :idclient';
    $query = $bdd->prepare($syntax);
    $query->bindValue(':idclient', $deviModel->GetIdClient());

    if(!$query->execute()) {
      $result['error'] .= $query->errorInfo();
    } else {
      while ($client = $query->fetch(PDO::FETCH_ASSOC))
      {
        $devi['client'] = $client;
      }
    }
  }

  if( !isset($result['error']) ) {
    $syntax = 'SELECT * FROM matieres WHERE Id_matiere = :idmatiere';
    $query = $bdd->prepare($syntax);
    $query->bindValue(':idmatiere', $deviModel->GetIdMatiere());

    if(!$query->execute()) {
      $result['error'] .= $query->errorInfo();
    } else {
      while ($matiere = $query->fetch(PDO::FETCH_ASSOC))
      {
        $devi['matiere'] = $matiere;
      }
    }
  }

  if( !isset($result['error']) ) {
    $syntax = 'SELECT * FROM user WHERE Id_user = :iduser';
    $query = $bdd->prepare($syntax);
    $query->bindValue(':iduser', $deviModel->GetIdUser());

    if(!$query->execute()) {
      $result['error'] .= $query->errorInfo();
    } else {
      while ($user = $query->fetch(PDO::FETCH_ASSOC))
      {
        $devi['user'] = $user;
      }
    }
  }

  if( !isset($result['error']) ) {
    return $devi;
  } else {
    return 'Données no recuperable. Voir message erreur';
  }
}

function GenerateDevisPDF($deviId){
  global $_SESSION, $input, $result, $arguments, $bdd;
  if( !isset($result['error']) ) {
    $dataPDF = '';
    $devi = GetAllDevisInfo($deviId);

    $deviModel = new Devis($devi);
    $clientModel = new Client($devi['client']);
    $matiereModel = new Matiere($devi['matiere']);
    $userModel = new User($devi['user']);

    $ligneModelItems = [];
    foreach ($devi['lignes'] as $ligne){
      $ligneModel = new LigneDevis($ligne);
      $pieceModel = new Piece($ligne['piece']);
      $optionModels = [];

      foreach ($ligne['options'] as $option){
        $optionModel = new Option($option);
        array_push($optionModels, $optionModel);
      }

      $ligneModelsItem = [
        'ligneModel' => $ligneModel,
        'pieceModel' => $pieceModel,
        'optionModels' => $optionModels
      ];
      array_push($ligneModelItems, $ligneModelsItem);
    }

    $dataPDF .= "<div style='width:100%'><table style='width:100%'>";
    //COLONE GAUCHE
    $dataPDF .= "<td style='width:60%'>";

    //CLIENT
    $dataPDF .= "<table>";
    $dataPDF .= "<tr>";
    $dataPDF .= "<td><h2>Devis N°".$deviId."</h2></td></tr>";
    $dataPDF .= "<tr><td><strong>Client:</strong><br></td></tr>";
    $dataPDF .= "<tr><td>".$clientModel->GetNom()." ".$clientModel->GetPrenom()."<br></td></tr>";
    $dataPDF .= "<tr><td>".$clientModel->GetAdresse()."<br></td></tr>";
    $dataPDF .= "<tr><td>".$clientModel->GetVille()."<br></td></tr>";
    $dataPDF .= "<tr><td>".$clientModel->GetCodePostal()."<br></td></tr>";
    $dataPDF .= "<tr><td>".$clientModel->GetTel()."</td></tr>";
    $dataPDF .= "<tr><td>".$clientModel->GetMail()."</td></tr>";
    $dataPDF .= "</table>";

    $dataPDF .= "</td>";
    //COLONE DROITE
    $dataPDF .= "<td style='width:40%'>";

    $dataPDF .= "<table style='width:100%; table-layout: fixed'>";
    $dataPDF .= "<tr><td><h2>SRG CONCEPT</h2></td></tr>";
    //UTILISATEUR
    $dataPDF .= "<tr><td>Emis le ".date('d/m/y')."<br></td></tr>";
    $dataPDF .= "<tr><td><strong>".$userModel->GetNom()."</strong><br></td></tr>";
    $dataPDF .= "<tr><td style='word-wrap:break-word'><strong>".$userModel->GetAdresse()."</strong><br></td></tr>";
    $dataPDF .= "<tr><td><strong>SIRET: ".$userModel->GetSiret()."</strong><br></td></tr>";
    $dataPDF .= "</table>";

    $dataPDF .= "</td>";
    $dataPDF .= "</table>";
    $dataPDF .= "</div>";

    $dataPDF .= "<div style='width:100%;'>";
    $dataPDF .= "<table style='border-collapse: collapse; border: 1px solid black; width: 100%;'>";
    $dataPDF .= "<tr style='border: 1px solid black;'>";
    $dataPDF .= "<td style='border: 1px solid black; width: 15%'>Poids:<br>Nb Pieces: ".sizeof($devi['lignes'])."</td>";
    $dataPDF .= "<td style='border: 1px solid black; width: 20%'>Délai:</td>";
    $dataPDF .= "<td style='border: 1px solid black; width: 45%'>Reglement</td>";
    $dataPDF .= "<td style='border: 1px solid black; width: 20%'></td>";
    $dataPDF .= "</tr>";
    $dataPDF .= "</table>";
    $dataPDF .= "</div>";

    $dataPDF .= "<div>";
    $dataPDF .= "<span>";
    $dataPDF .= "<br>Suite a votre demande, veuillez trouver ci-dessous notre DEVIS ( valable 2 mois ). <br>";
    $dataPDF .= "Pour acceptation, merci de retourner le devis signé, précédé du cachet de l'entreprise et de la mention 'BON POUR COMMANDE'. <br>";
    $dataPDF .= "Nous vous prions d'agréer nos meilleures salutations. ";

    $dataPDF .= "</span><br><br>";
    $dataPDF .= "</div>";
    //DEVIS
    $dataPDF .= "<div>";
    $dataPDF .= "<table style='border: 1px solid ; width: 100%; '>";
    $dataPDF .= "<thead>";
    $dataPDF .= "<tr>";
    $dataPDF .= "<th style='width: 20%';>Dimensions LxHxP.</th>";
    $dataPDF .= "<th style='width: 30%';>Ref.</th>";
    $dataPDF .= "<th style='width: 10%';>Prix HT</th>";
    $dataPDF .= "<th style='width: 10%';>Remise %</th>";
    $dataPDF .= "<th style='width: 10%';>Remise €</th>";
    $dataPDF .= "<th style='width: 10%';>Prix NET</th>";
    $dataPDF .= "<th style='width: 10%';>Prix TTC</th>";
    $dataPDF .= "</tr>";
    $dataPDF .= "</thead>";
    $dataPDF .= "<tbody style='height: 100%'>";

    $sommeTtc = 0;
    $sommeNetSansRemise = 0;
    $sommeNet = 0;
    foreach ($ligneModelItems as $ligneModelItem) {
      $ligneModel = $ligneModelItem['ligneModel'];
      $pieceModel = $ligneModelItem['pieceModel'];
      $optionModels = $ligneModelItem['optionModels'];

      $prixMatiereTonne = $matiereModel->GetPrix();

      $masseVolumique = 2700;
      $volumeCM3 = $ligneModel->GetLargeur() * $ligneModel->GetHauteur() * $ligneModel->GetProfondeur();
      $volumeM3 = $volumeCM3 /1000000;
      $masseKG = $volumeM3 * $masseVolumique;
      $masseTonne = $masseKG/1000;
      $prix = $masseTonne * $prixMatiereTonne;

      $pourcentageRemise = $ligneModel->GetRemise();
      $valeurRemise = $prix * ($pourcentageRemise / 100);
      $net = $prix - $valeurRemise;

      $pourcentageTva = 20;
      $valeurTva = $net * ($pourcentageTva / 100);

      $ttc = $net + $valeurTva;

      $sommeNetSansRemise += $prix;
      $sommeNet += $net;
      $sommeTtc += $ttc;

      $dataPDF .= "<tr style='height: 100%';>";
      $dataPDF .= "<td>".$ligneModel->GetLargeur()." x ".$ligneModel->GetProfondeur()." x ".$ligneModel->GetHauteur()."</td>";
      $dataPDF .= "<td>".$pieceModel->GetCode()." ".$pieceModel->GetCodeSs()." ".$pieceModel->GetCodeFamille()."</td>";
      $dataPDF .= "<td>".$prix." €</td>";
      $dataPDF .= "<td>".$pourcentageRemise."%</td>";
      $dataPDF .= "<td>-".$valeurRemise."€</td>";
      $dataPDF .= "<td>".$net." €</td>";
      $dataPDF .= "<td>".$ttc." €</td>";
      $dataPDF .= "</tr>";
    }

    $sommeTva = $sommeTtc - $sommeNet;
    $sommeRemise = $sommeNetSansRemise - $sommeNet;

    $dataPDF .= "</tbody>";
    $dataPDF .= "</table>";
    $dataPDF .= "<br>";

    $dataPDF .= "<table align=right style='border: 1px solid; border-radius: 12px;'>";
    $dataPDF .= "<tr>";
    $dataPDF .= "<th>Total</th>";
    $dataPDF .= "<td>".$sommeNetSansRemise." €</td>";
    $dataPDF .= "</tr>";
    $dataPDF .= "<tr>";
    $dataPDF .= "<th>Remise</th>";
    $dataPDF .= "<td> -".$sommeRemise." €</td>";
    $dataPDF .= "</tr>";
    $dataPDF .= "<tr>";
    $dataPDF .= "<th>Total Net</th>";
    $dataPDF .= "<td>".$sommeNet." €</td>";
    $dataPDF .= "</tr>";
    $dataPDF .= "<tr>";
    $dataPDF .= "<th>TVA</th>";
    $dataPDF .= "<td>".$sommeTva." €</td>";
    $dataPDF .= "</tr>";
    $dataPDF .= "<tr>";
    $dataPDF .= "<th>Total TTC</th>";
    $dataPDF .= "<td>".$sommeTtc." €</td>";
    $dataPDF .= "</tr>";
    $dataPDF .= "</table>";
    $dataPDF .= "<img style='width:100%' src='".$deviModel->GetCheminImage()."'>";

    $dataPDF .= "</div>";
    //$content = ob_get_clean();
    try {
      $pdf = new HTML2PDF("p","A4","fr");
      $pdf->pdf->SetAuthor($userModel->GetNom());
      $pdf->pdf->SetTitle('DEVIS_'.$deviId."_".$userModel->GetNom()."_".$clientModel->GetNom()."_".mktime());
      $pdf->pdf->SetSubject('Devis SRG');
      $pdf->pdf->SetKeywords('HTML2PDF, SRG, Devis');
      $pdf->writeHTML($dataPDF);
      ob_clean();
      $pdf->Output('DEVIS_'.$deviId."_".$userModel->GetNom()."_".$clientModel->GetNom()."_".mktime().'.pdf');
    } catch (HTML2PDF_exception $e) {
      $result['error'] = $e;

      //die($e);
    }
  } else {
    $result['error'] = "ERREUR A PARTIR DE CREATION DEVIS PDF - ".$result['error'];
  }
}

?>
