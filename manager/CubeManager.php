<?php

class CubeManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddCube(Cube $Cube){
		$q = $this->_Db->prepare('INSERT INTO cubes VALUES(:IdCube, :RangCube, :LibelleCube, :AvantPolisCube, :AvantScieeCube, :ArrierePolisCube, :ArriereScieeCube, :DroitePolisCube, :DroiteScieeCube, :GauchePolisCube, :GaucheScieeCube, :DessusPolisCube, :DessusScieeCube, :DessousPolisCube, :DessousScieeCube)');
		$q->bindValue(':IdCube', $Cube->GetIdCube());
		$q->bindValue(':RangCube', $Cube->GetRangCube());
		$q->bindValue(':LibelleCube', $Cube->GetLibelleCube());
		$q->bindValue(':AvantPolisCube', $Cube->GetAvantPolisCube());
		$q->bindValue(':AvantScieeCube', $Cube->GetAvantScieeCube());
		$q->bindValue(':ArrierePolisCube', $Cube->GetArrierePolisCube());
		$q->bindValue(':ArriereScieeCube', $Cube->GetArriereScieeCube());
		$q->bindValue(':DroitePolisCube', $Cube->GetDroitePolisCube());
		$q->bindValue(':DroiteScieeCube', $Cube->GetDroiteScieeCube());
		$q->bindValue(':GauchePolisCube', $Cube->GetGauchePolisCube());
		$q->bindValue(':GaucheScieeCube', $Cube->GetGaucheScieeCube());
		$q->bindValue(':DessusPolisCube', $Cube->GetDessusPolisCube());
		$q->bindValue(':DessusScieeCube', $Cube->GetDessusScieeCube());
		$q->bindValue(':DessousPolisCube', $Cube->GetDessousPolisCube());
		$q->bindValue(':DessousScieeCube', $Cube->GetDessousScieeCube());
		if(!$q->execute()) {
			return [false,$q->errorInfo()];
		} else {
			return [true,$this->_Db->lastInsertId()];
		}
	}

	public function UpdateCube(Cube $Cube){
		$q = $this->_Db->prepare('UPDATE cubes SET `RangCube` = :RangCube, `LibelleCube` = :LibelleCube, `AvantPolisCube` = :AvantPolisCube, `AvantScieeCube` = :AvantScieeCube, `ArrierePolisCube` = :ArrierePolisCube, `ArriereScieeCube` = :ArriereScieeCube, `DroitePolisCube` = :DroitePolisCube, `DroiteScieeCube` = :DroiteScieeCube, `GauchePolisCube` = :GauchePolisCube, `GaucheScieeCube` = :GaucheScieeCube, `DessusPolisCube` = :DessusPolisCube, `DessusScieeCube` = :DessusScieeCube, `DessousPolisCube` = :DessousPolisCube, `DessousScieeCube` = :DessousScieeCube WHERE IdCube = :IdCube ');
		$q->bindValue(':IdCube', $Cube->GetIdCube());
		$q->bindValue(':RangCube', $Cube->GetRangCube());
		$q->bindValue(':LibelleCube', $Cube->GetLibelleCube());
		$q->bindValue(':AvantPolisCube', $Cube->GetAvantPolisCube());
		$q->bindValue(':AvantScieeCube', $Cube->GetAvantScieeCube());
		$q->bindValue(':ArrierePolisCube', $Cube->GetArrierePolisCube());
		$q->bindValue(':ArriereScieeCube', $Cube->GetArriereScieeCube());
		$q->bindValue(':DroitePolisCube', $Cube->GetDroitePolisCube());
		$q->bindValue(':DroiteScieeCube', $Cube->GetDroiteScieeCube());
		$q->bindValue(':GauchePolisCube', $Cube->GetGauchePolisCube());
		$q->bindValue(':GaucheScieeCube', $Cube->GetGaucheScieeCube());
		$q->bindValue(':DessusPolisCube', $Cube->GetDessusPolisCube());
		$q->bindValue(':DessusScieeCube', $Cube->GetDessusScieeCube());
		$q->bindValue(':DessousPolisCube', $Cube->GetDessousPolisCube());
		$q->bindValue(':DessousScieeCube', $Cube->GetDessousScieeCube());
		$q->execute();
	}

	public function DeleteCube( $id){
		$this->_Db->exec('DELETE FROM cubes WHERE IdCube ='.$id);
	}

	public function GetCube( $id){
		$q = $this->_Db->prepare('SELECT * FROM cubes WHERE IdCube ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Cube = new Cube($donnees);}
		return $Cube;
	}

	public function GetAllCube(){
		$Cubes = [];
		$q = $this->_Db->query('SELECT * FROM cubes');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Cubes[] = new Cube($donnees);}
		return $Cubes;
	}

}