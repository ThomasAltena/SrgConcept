<?php
session_start();
if (empty($_SESSION)) {
  header('location:/SrgConcept/view/index.php');
}
require_once($_SERVER['DOCUMENT_ROOT'] .'/SrgConcept/vendor/autoload.php');

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

spl_autoload_register(function ($class_name) {
    if(strpos($class_name, 'Manager')){
      require_once($_SERVER['DOCUMENT_ROOT'] . '/SrgConcept/manager/'. $class_name . '.php');
    } else {
      require_once($_SERVER['DOCUMENT_ROOT'] . '/SrgConcept/model/'. $class_name . 'Class.php');
    }
});

try {
  $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
} catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}

if(isset($_GET['idDevis'])){
  $id = $_GET['idDevis'];


		$DevisManager = new DevisManager($bdd);
	  if( !isset($result['error']) ) {
	    $dataPDF = '';

	    $devis = $DevisManager->GetDevisData($id);

	    $userModel = new User($devis['user']);

	    $dataPDF .= "<div style='width:100%'><table style='width:100%'>";
	    //COLONE GAUCHE
	    $dataPDF .= "<td style='width:60%'>";

	    //CLIENT
	    $dataPDF .= "<table>";
	    $dataPDF .= "<tr>";
	    $dataPDF .= "<td><h2>Devis N°".$id."</h2></td></tr>";
	    $dataPDF .= "<tr><td><strong>Client:</strong><br></td></tr>";
	    $dataPDF .= "<tr><td>".$devis['client']['NomClient']." ".$devis['client']['PrenomClient']."<br></td></tr>";
	    $dataPDF .= "<tr><td>".$devis['client']['AdresseClient']."<br></td></tr>";
	    $dataPDF .= "<tr><td>".$devis['client']['VilleClient']."<br></td></tr>";
	    $dataPDF .= "<tr><td>".$devis['client']['CodePostalClient']."<br></td></tr>";
	    $dataPDF .= "<tr><td>".$devis['client']['TelClient']."</td></tr>";
	    $dataPDF .= "<tr><td>".$devis['client']['MailClient']."</td></tr>";
	    $dataPDF .= "</table>";

	    $dataPDF .= "</td>";
	    //COLONE DROITE
	    $dataPDF .= "<td style='width:40%'>";

	    $dataPDF .= "<table style='width:100%; table-layout: fixed'>";
	    $dataPDF .= "<tr><td><h2>SRG CONCEPT</h2></td></tr>";
	    //UTILISATEUR
	    $dataPDF .= "<tr><td>Emis le ".date('d/m/y')."<br></td></tr>";
	    $dataPDF .= "<tr><td><strong>".$userModel->GetNomUser()."</strong><br></td></tr>";
	    $dataPDF .= "<tr><td style='word-wrap:break-word'><strong>".$userModel->GetAdresseUser()."</strong><br></td></tr>";
	    $dataPDF .= "<tr><td><strong>SIRET: ".$userModel->GetSiretUser()."</strong><br></td></tr>";
	    $dataPDF .= "</table>";

	    $dataPDF .= "</td>";
	    $dataPDF .= "</table>";
	    $dataPDF .= "</div>";

	    $dataPDF .= "<div style='width:100%;'>";
	    $dataPDF .= "<table style='border-collapse: collapse; border: 1px solid black; width: 100%;'>";
	    $dataPDF .= "<tr style='border: 1px solid black;'>";
	    $dataPDF .= "<td style='border: 1px solid black; width: 15%'>Poids:<br>Nb Cubes: ".sizeof($devis['cubes'])."</td>";
	    $dataPDF .= "<td style='border: 1px solid black; width: 15%'>Poids:<br>Nb Pieces: ".sizeof($devis['pieces'])."</td>";
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
	    $dataPDF .= "<th style='width: 20%';>Dimensions LHP.</th>";
	    $dataPDF .= "<th style='width: 10%';>Piece</th>";
	    $dataPDF .= "<th style='width: 10%';>Cube</th>";
	    $dataPDF .= "<th style='width: 10%';>Matiere</th>";
	    $dataPDF .= "<th style='width: 10%';>Prix Mat</th>";
	    $dataPDF .= "<th style='width: 10%';>Prix Fac</th>";
	    $dataPDF .= "<th style='width: 10%';>Prix Opt</th>";
	    $dataPDF .= "<th style='width: 10%';>Prix Total</th>";
	    $dataPDF .= "</tr>";
	    $dataPDF .= "</thead>";
	    $dataPDF .= "<tbody style='height: 100%'>";

			$masseVolumique = 2700;
	    $sommeMatiere = 0;
	    $sommeFaconnage = 0;
	    $sommeOptions = 0;
			$somme = 0;
			$sommeRemise = 0;
	    $sommeNet = 0;
	    $sommeTva = 0;
	    foreach ($devis['cubes'] as $cube) {
				$nomMatiere = 'AUCUN';

				$volumeM3 = $cube['LargeurCubeDevis'] * $cube['ProfondeurCubeDevis'] * $cube['HauteurCubeDevis'] * $cube['QuantiteCubeDevis'] / 1000000;
			  $masseTonne = $masseVolumique * $volumeM3 /1000;
			  $prixMatiere = 0;
			  $prixPolissage = 0;
			  $prixScieage = 0;
			  if(isset($cube['matiere'])){
			    $prixMatiere = $cube['matiere']['PrixMatiere'];
			    $prixPolissage = $cube['matiere']['PrixPolissage'];
			    $prixScieage = $cube['matiere']['PrixScieage'];
					$nomMatiere = $cube['matiere']['CodeMatiere'];
			  }
			  $cube['prixMatiere'] = $prixMatiere * $masseTonne;

			  $surfaceAvantArriereM3 = $cube['HauteurCubeDevis'] * $cube['LargeurCubeDevis'] * 0.01;
			  $surfaceDroiteGaucheM3 = $cube['ProfondeurCubeDevis'] * $cube['HauteurCubeDevis'] * 0.01;
			  $surfaceDessusDessousM3 = $cube['ProfondeurCubeDevis'] * $cube['LargeurCubeDevis'] * 0.01;

			  $surfacePolissage = 0;
			  $surfacePolissage += $cube['AvantPolisCube'] == 1 ? $surfaceAvantArriereM3 : 0;
			  $surfacePolissage += $cube['ArrierePolisCube'] == 1 ? $surfaceAvantArriereM3 : 0;
			  $surfacePolissage += $cube['DroitePolisCube'] == 1 ? $surfaceDroiteGaucheM3 : 0;
			  $surfacePolissage += $cube['GauchePolisCube'] == 1 ? $surfaceDroiteGaucheM3 : 0;
			  $surfacePolissage += $cube['DessusPolisCube'] == 1 ? $surfaceDessusDessousM3 : 0;
			  $surfacePolissage += $cube['DessousPolisCube'] == 1 ? $surfaceDessusDessousM3 : 0;
			  $cube['prixPolissage'] = $prixPolissage * $surfacePolissage;

			  $surfaceSciage = 0;
			  $surfaceSciage += $cube['AvantScieeCube'] == 1 ? $surfaceAvantArriereM3 : 0;
			  $surfaceSciage += $cube['ArriereScieeCube'] == 1 ? $surfaceAvantArriereM3 : 0;
			  $surfaceSciage += $cube['DroiteScieeCube'] == 1 ? $surfaceDroiteGaucheM3 : 0;
			  $surfaceSciage += $cube['GaucheScieeCube'] == 1 ? $surfaceDroiteGaucheM3 : 0;
			  $surfaceSciage += $cube['DessusScieeCube'] == 1 ? $surfaceDessusDessousM3 : 0;
			  $surfaceSciage += $cube['DessousScieeCube'] == 1 ? $surfaceDessusDessousM3 : 0;
			  $cube['prixScieage'] = $prixScieage * $surfaceSciage;

				$cube['prixOptions'] = 0;
			  $cube['prixFaconnage'] = $cube['prixPolissage'] + $cube['prixScieage'];
			  $cube['prixCube'] = $cube['prixMatiere'] + $cube['prixFaconnage'] + $cube['prixScieage'] + $cube['prixOptions'];

	      $dataPDF .= "<tr style='height: 100%';>";
	      $dataPDF .= "<td>".$cube['LargeurCubeDevis']." x ".$cube['ProfondeurCubeDevis']." x ".$cube['HauteurCubeDevis']."</td>";
	      $dataPDF .= "<td>".$cube['piece']['CodePiece']."</td>";
				$dataPDF .= "<td>".$cube['LibelleCubeDevis']."</td>";
	      $dataPDF .= "<td>".$nomMatiere."</td>";
	      $dataPDF .= "<td>".$cube['prixMatiere']." €</td>";
	      $dataPDF .= "<td>".$cube['prixFaconnage']."€</td>";
	      $dataPDF .= "<td>".$cube['prixOptions']." €</td>";
	      $dataPDF .= "<td>".$cube['prixCube']." €</td>";
	      $dataPDF .= "</tr>";

				$sommeMatiere += $cube['prixMatiere'];
			  $sommeFaconnage += $cube['prixFaconnage'];
			  $sommeOptions += $cube['prixOptions'];
			  $somme += $cube['prixCube'];
	    }
			$sommeRemise = $somme * $devis['RemiseDevis'] * 0.01;
			$sommeNet = $somme * (100 - $devis['RemiseDevis']) * 0.01;
			$sommeTva = $sommeNet * $devis['TvaDevis'] * 0.01;

	    $sommeTtc = $sommeNet + $sommeTva;

	    $dataPDF .= "</tbody>";
	    $dataPDF .= "</table>";
	    $dataPDF .= "<br>";

	    $dataPDF .= "<table align=right style='border: 1px solid; border-radius: 12px;'>";
	    $dataPDF .= "<tr>";
	    $dataPDF .= "<th>Prix Matiere</th>";
	    $dataPDF .= "<td>".$sommeMatiere." €</td>";
	    $dataPDF .= "</tr>";
	    $dataPDF .= "<tr>";
	    $dataPDF .= "<th>Prix Faconnage</th>";
	    $dataPDF .= "<td> ".$sommeFaconnage." €</td>";
	    $dataPDF .= "</tr>";
	    $dataPDF .= "<tr>";
	    $dataPDF .= "<th>Prix Options</th>";
	    $dataPDF .= "<td> ".$sommeOptions." €</td>";
	    $dataPDF .= "</tr>";
	    $dataPDF .= "<tr>";
	    $dataPDF .= "<th>Total</th>";
	    $dataPDF .= "<td> ".$somme." €</td>";
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
	    $dataPDF .= "<td>+".$sommeTva." €</td>";
	    $dataPDF .= "</tr>";
	    $dataPDF .= "<tr>";
	    $dataPDF .= "<th>Total TTC</th>";
	    $dataPDF .= "<td>".$sommeTtc." €</td>";
	    $dataPDF .= "</tr>";
	    $dataPDF .= "</table>";
	    $dataPDF .= "</div>";

	    $dataPDF .= "<div style='overflow:hidden; height:50%; width:100%'>";
	    // $dataPDF .= "<img style='height:100%' src='".$deviModel->GetCheminImage()."'>";
	    $dataPDF .= "</div>";
	    //$content = ob_get_clean();
	    try {
	      $pdf = new HTML2PDF("p","A4","fr");
	      $pdf->pdf->SetAuthor($userModel->GetNomUser());
	      $pdf->pdf->SetTitle('DEVIS_'.$id."_".$userModel->GetNomUser()."_".$devis['client']['NomClient']."_".mktime());
	      $pdf->pdf->SetSubject('Devis SRG');
	      $pdf->pdf->SetKeywords('HTML2PDF, SRG, Devis');
	      $pdf->writeHTML($dataPDF);
	      ob_clean();
	      $pdf->Output('DEVIS_'.$id."_".$userModel->GetNomUser()."_".$devis['client']['NomClient']."_".mktime().'.pdf');
	    } catch (HTML2PDF_exception $e) {


	      //die($e);
	    }
	  } else {

	  }
	}


?>
