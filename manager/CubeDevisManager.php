<?php

class CubeDevisManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddCubeDevis(CubeDevis $CubeDevis){
		$q = $this->_Db->prepare('INSERT INTO cubes_devis VALUES(:IdCubeDevis, :HauteurCubeDevis, :LargeurCubeDevis, :ProfondeurCubeDevis, :IdDevis, :IdPiece, :IdCube, :AvantPolisCube, :AvantScieeCube, :ArrierePolisCube, :ArriereScieeCube, :DroitePolisCube, :DroiteScieeCube, :GauchePolisCube, :GaucheScieeCube, :DessusPolisCube, :DessusScieeCube, :DessousPolisCube, :DessousScieeCube)');
		$q->bindValue(':IdCubeDevis', $CubeDevis->GetIdCubeDevis());
		$q->bindValue(':HauteurCubeDevis', $CubeDevis->GetHauteurCubeDevis());
		$q->bindValue(':LargeurCubeDevis', $CubeDevis->GetLargeurCubeDevis());
		$q->bindValue(':ProfondeurCubeDevis', $CubeDevis->GetProfondeurCubeDevis());
		$q->bindValue(':IdDevis', $CubeDevis->GetIdDevis());
		$q->bindValue(':IdPiece', $CubeDevis->GetIdPiece());
		$q->bindValue(':IdCube', $CubeDevis->GetIdCube());
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

	public function UpdateCubeDevis(CubeDevis $CubeDevis){
		$q = $this->_Db->prepare('UPDATE cubes_devis SET `HauteurCubeDevis` = :HauteurCubeDevis, `LargeurCubeDevis` = :LargeurCubeDevis, `ProfondeurCubeDevis` = :ProfondeurCubeDevis, `IdDevis` = :IdDevis, `IdPiece` = :IdPiece, `IdCube` = :IdCube, `AvantPolisCube` = :AvantPolisCube, `AvantScieeCube` = :AvantScieeCube, `ArrierePolisCube` = :ArrierePolisCube, `ArriereScieeCube` = :ArriereScieeCube, `DroitePolisCube` = :DroitePolisCube, `DroiteScieeCube` = :DroiteScieeCube, `GauchePolisCube` = :GauchePolisCube, `GaucheScieeCube` = :GaucheScieeCube, `DessusPolisCube` = :DessusPolisCube, `DessusScieeCube` = :DessusScieeCube, `DessousPolisCube` = :DessousPolisCube, `DessousScieeCube` = :DessousScieeCube WHERE IdCubeDevis = :IdCubeDevis ');
		$q->bindValue(':IdCubeDevis', $CubeDevis->GetIdCubeDevis());
		$q->bindValue(':HauteurCubeDevis', $CubeDevis->GetHauteurCubeDevis());
		$q->bindValue(':LargeurCubeDevis', $CubeDevis->GetLargeurCubeDevis());
		$q->bindValue(':ProfondeurCubeDevis', $CubeDevis->GetProfondeurCubeDevis());
		$q->bindValue(':IdDevis', $CubeDevis->GetIdDevis());
		$q->bindValue(':IdPiece', $CubeDevis->GetIdPiece());
		$q->bindValue(':IdCube', $CubeDevis->GetIdCube());
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

	public function GetCubeDevis( $id){
		$q = $this->_Db->prepare('SELECT * FROM cubes_devis WHERE IdCubeDevis ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$CubeDevis = new CubeDevis($donnees);}
		return $CubeDevis;
	}

	public function GetAllCubeDevis(){
		$CubeDeviss = [];
		$q = $this->_Db->query('SELECT * FROM cubes_devis');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$CubeDeviss[] = new CubeDevis($donnees);}
		return $CubeDeviss;
	}

}