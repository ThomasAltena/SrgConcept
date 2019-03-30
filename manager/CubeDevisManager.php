<?php

class CubeDevisManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddCubeDevis(CubeDevis $CubeDevis){
		$q = $this->_Db->prepare('INSERT INTO cubes_devis VALUES(:IdCubeDevis, :LibelleCubeDevis, :HauteurCubeDevis, :LargeurCubeDevis, :ProfondeurCubeDevis, :QuantiteCubeDevis, :IdDevis, :IdPiece, :IdPieceDevis, :IdCube, :IdMatiere, :AvantPolisCube, :AvantScieeCube, :ArrierePolisCube, :ArriereScieeCube, :DroitePolisCube, :DroiteScieeCube, :GauchePolisCube, :GaucheScieeCube, :DessusPolisCube, :DessusScieeCube, :DessousPolisCube, :DessousScieeCube)');
		$q->bindValue(':IdCubeDevis', $CubeDevis->GetIdCubeDevis());
		$q->bindValue(':LibelleCubeDevis', $CubeDevis->GetLibelleCubeDevis());
		$q->bindValue(':HauteurCubeDevis', $CubeDevis->GetHauteurCubeDevis());
		$q->bindValue(':LargeurCubeDevis', $CubeDevis->GetLargeurCubeDevis());
		$q->bindValue(':ProfondeurCubeDevis', $CubeDevis->GetProfondeurCubeDevis());
		$q->bindValue(':QuantiteCubeDevis', $CubeDevis->GetQuantiteCubeDevis());
		$q->bindValue(':IdDevis', $CubeDevis->GetIdDevis());
		$q->bindValue(':IdPiece', $CubeDevis->GetIdPiece());
		$q->bindValue(':IdPieceDevis', $CubeDevis->GetIdPieceDevis());
		$q->bindValue(':IdCube', $CubeDevis->GetIdCube());
		$q->bindValue(':IdMatiere', $CubeDevis->GetIdMatiere());
		$q->bindValue(':AvantPolisCube', $CubeDevis->GetAvantPolisCube());
		$q->bindValue(':AvantScieeCube', $CubeDevis->GetAvantScieeCube());
		$q->bindValue(':ArrierePolisCube', $CubeDevis->GetArrierePolisCube());
		$q->bindValue(':ArriereScieeCube', $CubeDevis->GetArriereScieeCube());
		$q->bindValue(':DroitePolisCube', $CubeDevis->GetDroitePolisCube());
		$q->bindValue(':DroiteScieeCube', $CubeDevis->GetDroiteScieeCube());
		$q->bindValue(':GauchePolisCube', $CubeDevis->GetGauchePolisCube());
		$q->bindValue(':GaucheScieeCube', $CubeDevis->GetGaucheScieeCube());
		$q->bindValue(':DessusPolisCube', $CubeDevis->GetDessusPolisCube());
		$q->bindValue(':DessusScieeCube', $CubeDevis->GetDessusScieeCube());
		$q->bindValue(':DessousPolisCube', $CubeDevis->GetDessousPolisCube());
		$q->bindValue(':DessousScieeCube', $CubeDevis->GetDessousScieeCube());
		if(!$q->execute()) {
				return [false,$q->errorInfo()];
		} else {
			return [true,$this->_Db->lastInsertId()];
		}
	}

	public function UpdateCubeDevis(CubeDevis $CubeDevis){
		$q = $this->_Db->prepare('UPDATE cubes_devis SET `LibelleCubeDevis` = :LibelleCubeDevis, `HauteurCubeDevis` = :HauteurCubeDevis, `LargeurCubeDevis` = :LargeurCubeDevis, `ProfondeurCubeDevis` = :ProfondeurCubeDevis, `QuantiteCubeDevis` = :QuantiteCubeDevis, `IdDevis` = :IdDevis, `IdPiece` = :IdPiece, `IdPieceDevis` = :IdPieceDevis, `IdCube` = :IdCube, `IdMatiere` = :IdMatiere, `AvantPolisCube` = :AvantPolisCube, `AvantScieeCube` = :AvantScieeCube, `ArrierePolisCube` = :ArrierePolisCube, `ArriereScieeCube` = :ArriereScieeCube, `DroitePolisCube` = :DroitePolisCube, `DroiteScieeCube` = :DroiteScieeCube, `GauchePolisCube` = :GauchePolisCube, `GaucheScieeCube` = :GaucheScieeCube, `DessusPolisCube` = :DessusPolisCube, `DessusScieeCube` = :DessusScieeCube, `DessousPolisCube` = :DessousPolisCube, `DessousScieeCube` = :DessousScieeCube WHERE IdCubeDevis = :IdCubeDevis ');
		$q->bindValue(':IdCubeDevis', $CubeDevis->GetIdCubeDevis());
		$q->bindValue(':LibelleCubeDevis', $CubeDevis->GetLibelleCubeDevis());
		$q->bindValue(':HauteurCubeDevis', $CubeDevis->GetHauteurCubeDevis());
		$q->bindValue(':LargeurCubeDevis', $CubeDevis->GetLargeurCubeDevis());
		$q->bindValue(':ProfondeurCubeDevis', $CubeDevis->GetProfondeurCubeDevis());
		$q->bindValue(':QuantiteCubeDevis', $CubeDevis->GetQuantiteCubeDevis());
		$q->bindValue(':IdDevis', $CubeDevis->GetIdDevis());
		$q->bindValue(':IdPiece', $CubeDevis->GetIdPiece());
		$q->bindValue(':IdPieceDevis', $CubeDevis->GetIdPieceDevis());
		$q->bindValue(':IdCube', $CubeDevis->GetIdCube());
		$q->bindValue(':IdMatiere', $CubeDevis->GetIdMatiere());
		$q->bindValue(':AvantPolisCube', $CubeDevis->GetAvantPolisCube());
		$q->bindValue(':AvantScieeCube', $CubeDevis->GetAvantScieeCube());
		$q->bindValue(':ArrierePolisCube', $CubeDevis->GetArrierePolisCube());
		$q->bindValue(':ArriereScieeCube', $CubeDevis->GetArriereScieeCube());
		$q->bindValue(':DroitePolisCube', $CubeDevis->GetDroitePolisCube());
		$q->bindValue(':DroiteScieeCube', $CubeDevis->GetDroiteScieeCube());
		$q->bindValue(':GauchePolisCube', $CubeDevis->GetGauchePolisCube());
		$q->bindValue(':GaucheScieeCube', $CubeDevis->GetGaucheScieeCube());
		$q->bindValue(':DessusPolisCube', $CubeDevis->GetDessusPolisCube());
		$q->bindValue(':DessusScieeCube', $CubeDevis->GetDessusScieeCube());
		$q->bindValue(':DessousPolisCube', $CubeDevis->GetDessousPolisCube());
		$q->bindValue(':DessousScieeCube', $CubeDevis->GetDessousScieeCube());
		$q->execute();
	}

	public function DeleteCubeDevis( $id){
		$this->_Db->exec('DELETE FROM cubes_devis WHERE IdCubeDevis ='.$id);
	}

	public function DeleteCubeDevisByPieceDevisId($id){
		$this->_Db->exec('DELETE FROM cubes_devis WHERE IdPieceDevis ='.$id);
	}

	public function GetCubeDevis( $id){
		$q = $this->_Db->prepare('SELECT * FROM cubes_devis WHERE IdCubeDevis ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$CubeDevis = new CubeDevis($donnees);}
		return $CubeDevis;
	}

	public function GetCubeDevisByDevis($id){
		$q = $this->_Db->prepare('SELECT * FROM cubes_devis WHERE IdDevis ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$CubeDevis[] = new CubeDevis($donnees);}
		return $CubeDevis;
	}

	public function GetAllCubeDevis(){
		$CubeDeviss = [];
		$q = $this->_Db->query('SELECT * FROM cubes_devis');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$CubeDeviss[] = new CubeDevis($donnees);}
		return $CubeDeviss;
	}

}
