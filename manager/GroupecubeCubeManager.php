<?php

class GroupecubeCubeManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddGroupecubeCube(GroupecubeCube $GroupecubeCube){
		$q = $this->_Db->prepare('INSERT INTO groupecubes_cubes VALUES(:IdGroupCubeCubes, :IdCube, :CodeGroupeCube)');
		$q->bindValue(':IdGroupCubeCubes', $GroupecubeCube->GetIdGroupCubeCubes());
		$q->bindValue(':IdCube', $GroupecubeCube->GetIdCube());
		$q->bindValue(':CodeGroupeCube', $GroupecubeCube->GetCodeGroupeCube());
		if(!$q->execute()) {
			return [false,$q->errorInfo()];
		} else {
			return [true,$this->_Db->lastInsertId()];
		}
	}

	public function UpdateGroupecubeCube(GroupecubeCube $GroupecubeCube){
		$q = $this->_Db->prepare('UPDATE groupecubes_cubes SET `IdCube` = :IdCube, `CodeGroupeCube` = :CodeGroupeCube WHERE IdGroupCubeCubes = :IdGroupCubeCubes ');
		$q->bindValue(':IdGroupCubeCubes', $GroupecubeCube->GetIdGroupCubeCubes());
		$q->bindValue(':IdCube', $GroupecubeCube->GetIdCube());
		$q->bindValue(':CodeGroupeCube', $GroupecubeCube->GetCodeGroupeCube());
		$q->execute();
	}

	public function DeleteGroupecubeCube( $id){
		$this->_Db->exec('DELETE FROM groupecubes_cubes WHERE IdGroupCubeCubes ='.$id);
	}

	public function GetGroupecubeCube( $id){
		$q = $this->_Db->prepare('SELECT * FROM groupecubes_cubes WHERE IdGroupCubeCubes ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$GroupecubeCube = new GroupecubeCube($donnees);}
		return $GroupecubeCube;
	}

	public function GetAllGroupecubeCube(){
		$GroupecubeCubes = [];
		$q = $this->_Db->query('SELECT * FROM groupecubes_cubes');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$GroupecubeCubes[] = new GroupecubeCube($donnees);}
		return $GroupecubeCubes;
	}

	public function GetCubesByGroupe($groupe){
		$GroupecubeCubes = [];
		$q = $this->_Db->query('SELECT * FROM groupecubes_cubes WHERE CodeGroupeCube = "'.$groupe.'"');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$GroupecubeCubes[] = new GroupecubeCube($donnees);}
		$CubeManager = new CubeManager($this->_Db);

		$Cubes = [];
		foreach($GroupecubeCubes as $GroupecubeCube) {
		  array_push($Cubes, $CubeManager->GetCube($GroupecubeCube->GetIdCube()));
		}

		return $Cubes;
	}
}
