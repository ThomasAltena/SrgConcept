<?php

class DevisManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddDevis(Devis $Devis){
		$q = $this->_Db->prepare('INSERT INTO devis VALUES(:IdDevis, :DateDevis, :IdClient, :IdUser, :CheminSchemaDevis, :ArchiveDevis, :CheminFicheFabDevis, :RemiseDevis, :FormatDevis, :TypeDevis, :AquisDevis, :DosPolisDevis, :ArrondiDevis, :PrixDevis, :CommentairesDevis, :LibelleDevis, :TvaDevis, :PUTransportDevis)');
		$q->bindValue(':IdDevis', $Devis->GetIdDevis());
		$q->bindValue(':DateDevis', $Devis->GetDateDevis());
		$q->bindValue(':IdClient', $Devis->GetIdClient());
		$q->bindValue(':IdUser', $Devis->GetIdUser());
		$q->bindValue(':CheminSchemaDevis', $Devis->GetCheminSchemaDevis());
		$q->bindValue(':ArchiveDevis', $Devis->GetArchiveDevis());
		$q->bindValue(':CheminFicheFabDevis', $Devis->GetCheminFicheFabDevis());
		$q->bindValue(':RemiseDevis', $Devis->GetRemiseDevis());
		$q->bindValue(':FormatDevis', $Devis->GetFormatDevis());
		$q->bindValue(':TypeDevis', $Devis->GetTypeDevis());
		$q->bindValue(':AquisDevis', $Devis->GetAquisDevis());
		$q->bindValue(':DosPolisDevis', $Devis->GetDosPolisDevis());
		$q->bindValue(':ArrondiDevis', $Devis->GetArrondiDevis());
		$q->bindValue(':PrixDevis', $Devis->GetPrixDevis());
		$q->bindValue(':CommentairesDevis', $Devis->GetCommentairesDevis());
		$q->bindValue(':LibelleDevis', $Devis->GetLibelleDevis());
		$q->bindValue(':TvaDevis', $Devis->GetTvaDevis());
		$q->bindValue(':PUTransportDevis', $Devis->GetPUTransportDevis());

		if(!$q->execute()) {
				return [false,$q->errorInfo()];
		} else {
			return [true,$this->_Db->lastInsertId()];
		}
	}

	public function UpdateDevis(Devis $Devis){
		$q = $this->_Db->prepare('UPDATE devis SET `DateDevis` = :DateDevis, `IdClient` = :IdClient, `IdUser` = :IdUser, `CheminSchemaDevis` = :CheminSchemaDevis, `ArchiveDevis` = :ArchiveDevis, `CheminFicheFabDevis` = :CheminFicheFabDevis, `RemiseDevis` = :RemiseDevis, `FormatDevis` = :FormatDevis, `TypeDevis` = :TypeDevis, `AquisDevis` = :AquisDevis, `DosPolisDevis` = :DosPolisDevis, `ArrondiDevis` = :ArrondiDevis, `PrixDevis` = :PrixDevis, `CommentairesDevis` = :CommentairesDevis, `LibelleDevis` = :LibelleDevis, `TvaDevis` = :TvaDevis, `PUTransportDevis` = :PUTransportDevis WHERE IdDevis = :IdDevis ');
		$q->bindValue(':IdDevis', $Devis->GetIdDevis());
		$q->bindValue(':DateDevis', $Devis->GetDateDevis());
		$q->bindValue(':IdClient', $Devis->GetIdClient());
		$q->bindValue(':IdUser', $Devis->GetIdUser());
		$q->bindValue(':CheminSchemaDevis', $Devis->GetCheminSchemaDevis());
		$q->bindValue(':ArchiveDevis', $Devis->GetArchiveDevis());
		$q->bindValue(':CheminFicheFabDevis', $Devis->GetCheminFicheFabDevis());
		$q->bindValue(':RemiseDevis', $Devis->GetRemiseDevis());
		$q->bindValue(':FormatDevis', $Devis->GetFormatDevis());
		$q->bindValue(':TypeDevis', $Devis->GetTypeDevis());
		$q->bindValue(':AquisDevis', $Devis->GetAquisDevis());
		$q->bindValue(':DosPolisDevis', $Devis->GetDosPolisDevis());
		$q->bindValue(':ArrondiDevis', $Devis->GetArrondiDevis());
		$q->bindValue(':PrixDevis', $Devis->GetPrixDevis());
		$q->bindValue(':CommentairesDevis', $Devis->GetCommentairesDevis());
		$q->bindValue(':LibelleDevis', $Devis->GetLibelleDevis());
		$q->bindValue(':TvaDevis', $Devis->GetTvaDevis());
		$q->bindValue(':PUTransportDevis', $Devis->GetPUTransportDevis());
		$q->execute();
	}

	public function DeleteDevis($id){
		$this->_Db->exec('DELETE FROM devis WHERE IdDevis ='.$id);
	}

	public function GetDevis( $id){
		$q = $this->_Db->prepare('SELECT * FROM devis WHERE IdDevis ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Devis = new Devis($donnees);}
		return $Devis;
	}

	public function GetAllDevis(){
		$Deviss = [];
		$q = $this->_Db->query('SELECT * FROM devis');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Deviss[] = new Devis($donnees);}
		return $Deviss;
	}

	public function UpdateCheminSchema($devisInsertId, $fichier_full_path){
		$q = $this->_Db->query('UPDATE devis SET CheminSchemaDevis = "'.$fichier_full_path.'" WHERE IdDevis = '.$devisInsertId);
		return $q->execute();
	}

	public function GetDevisData($id){
		$q = $this->_Db->prepare('SELECT * FROM devis WHERE IdDevis ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Devis = new Devis($donnees);}

		$CubeDevisManager = new CubeDevisManager($this->_Db);
		$Cubes = $CubeDevisManager->GetCubeDevisByDevis($id);

		$originalObject = $Devis->GetOriginalObject();
		$originalObject['cubes'] = [];
		foreach ($Cubes as $cube) {
			array_push($originalObject['cubes'], $cube->GetOriginalObject());
		}

		$ClientManager = new ClientManager($this->_Db);
		$Client = $ClientManager->GetClient($Devis->GetIdClient());
		$originalObject['client'] = $Client->GetOriginalObject();

		return $originalObject;
	}

	public function SaveDevis($Matiere, $Client, $DataUrl, $Pieces) {
	  //arguments = [matiere, client, dataURL, pieces];
	  $result = [];
		$IdUser = $_SESSION['Id_user'];

    if( !$IdUser || !$Matiere || !$Client || !$DataUrl || !$Pieces ) {
      $result['error'] = 'Erreur - manque donnees devis!';
    }

	  if( !isset($result['error']) ) {
	    $matiere = new Matiere(get_object_vars($Matiere));
	    $client = new Client(get_object_vars($Client));
	    $img = $DataUrl;
	    $date = date("Y-m-d");

	    if( !is_array($Pieces) || (count($Pieces) < 1) ) {
	      $result['error'] = 'Erreur - manque données pieces!!';
	    } else {

	      $devisModel = new Devis([
					"DateDevis" => $date,
	        "IdClient" => $client->GetIdClient(),
	        "IdUser" => $IdUser
				]);

	      $DevisManager = new DevisManager($this->_Db); //Connexion a la BDD
	      $devisInsertResult = $DevisManager->AddDevis($devisModel);

	      $result['devisResults'] = [
	        "insertResult" => $devisInsertResult,
	        "updateResult" => [],
	        "devis" => $devisModel->GetOriginalObject(),
	        "cubeResults" => []
	      ];

	      if(!$devisInsertResult[0]){
	        $result['error'] = 'Erreur INSERT de DEVIS - '.$devisInsertResult[1][2];
	      } else {
	        $devisInsertId = $this->_Db->lastInsertId();
	        $result['devisResults']['devis']['IdDevis'] = $devisInsertId;

	        //PREPARATION IMAGE
	        $img = str_replace('data:image/png;base64,', '', $img);
	        $img = str_replace(' ', '+', $img);
	        $data = base64_decode($img);

	        //SAUVEGARDE IMAGE QUAND DEVIS INSERT REUSSI
	        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/SrgConcept/public/images/schemas/';
	        $fichier_nom = "DEVIS_" . $devisInsertId . "_" . mktime() . ".png";
	        $fichier = $upload_dir . $fichier_nom;
	        $success = file_put_contents($fichier, $data);

	        $fichier_full_path = $upload_dir . $fichier_nom;
	        $devisUpdateResult = $DevisManager->UpdateCheminSchema($devisInsertId, $fichier_full_path);

	        $result['devisResults']['updateResult'] = $devisUpdateResult;

	        $CubeDevisManager = new CubeDevisManager($this->_Db); //Connexion a la BDD
	        $GroupecubeCubeManager = new GroupecubeCubeManager($this->_Db); //Connexion a la BDD
	        $PieceDevisManager = new PieceDevisManager($this->_Db); //Connexion a la BDD

	        foreach ($Pieces as $argument){
	          $piece = new Piece(get_object_vars($argument));
	          $PieceDevisManager->AddPieceDevis(new PieceDevis([
	            "IdPieceDevis" => '',
	            "IdPiece" => $piece->GetIdPiece(),
	            "IdDevis" => $devisInsertId
	          ]));
	          $cubes = $GroupecubeCubeManager->GetCubesByGroupe($piece->GetCodeGroupeCube());

	          foreach ($cubes as $cube) {
	            $cubeDevis = new CubeDevis($cube->GetOriginalObject());
	            $cubeDevis->SetLibelleCubeDevis($cube->GetLibelleCube());
	            $cubeDevis->SetIdDevis($devisInsertId);
	            $cubeDevis->SetIdMatiere($matiere->GetIdMatiere());
							$cubeDevis->SetIdPiece($piece->GetIdPiece());
							$cubeDevis->SetQuantiteCubeDevis(1);
	            $cubeInsertResult = $CubeDevisManager->AddCubeDevis($cubeDevis);
	            $cubeResultObject = [
	              "insertResult" => $cubeInsertResult,
	              "cubeDevis" =>$cubeDevis,
	            ];
	            array_push($result['devisResults']['cubeResults'], $cubeResultObject);
	          }
	        }
	      }
	    }
	  }
		return $result;
	}


}
