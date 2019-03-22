<?php

class CubeManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddCube(Cube $Cube){
		$q = $this->_Db->prepare('INSERT INTO cubes VALUES(:CodeCube, :NumeroCube, :LibelleCube, :CodeGroupeCube, :AvantPolisCube, :AvantScieeCube, :ArrierePolisCube, :ArriereScieeCube, :DroitePolisCube, :DroiteScieeCube, :GauchePolisCube, :GaucheScieeCube, :DessusPolisCube, :DessusScieeCube, :DessousPolisCube, :DessousScieeCube)');
		$q->bindValue(':CodeCube', $Cube->GetCodeCube());
		$q->bindValue(':NumeroCube', $Cube->GetNumeroCube());
		$q->bindValue(':LibelleCube', $Cube->GetLibelleCube());
		$q->bindValue(':CodeGroupeCube', $Cube->GetCodeGroupeCube());
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
		$q = $this->_Db->prepare('UPDATE cubes SET `NumeroCube` = :NumeroCube, `LibelleCube` = :LibelleCube, `CodeGroupeCube` = :CodeGroupeCube, `AvantPolisCube` = :AvantPolisCube, `AvantScieeCube` = :AvantScieeCube, `ArrierePolisCube` = :ArrierePolisCube, `ArriereScieeCube` = :ArriereScieeCube, `DroitePolisCube` = :DroitePolisCube, `DroiteScieeCube` = :DroiteScieeCube, `GauchePolisCube` = :GauchePolisCube, `GaucheScieeCube` = :GaucheScieeCube, `DessusPolisCube` = :DessusPolisCube, `DessusScieeCube` = :DessusScieeCube, `DessousPolisCube` = :DessousPolisCube, `DessousScieeCube` = :DessousScieeCube WHERE CodeCube = :CodeCube ');
		$q->bindValue(':CodeCube', $Cube->GetCodeCube());
		$q->bindValue(':NumeroCube', $Cube->GetNumeroCube());
		$q->bindValue(':LibelleCube', $Cube->GetLibelleCube());
		$q->bindValue(':CodeGroupeCube', $Cube->GetCodeGroupeCube());
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
		$this->_Db->exec('DELETE FROM cubes WHERE CodeCube ='.$id);
	}

	public function GetCube( $id){
		$q = $this->_Db->prepare('SELECT * FROM cubes WHERE CodeCube ='.$id);
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
