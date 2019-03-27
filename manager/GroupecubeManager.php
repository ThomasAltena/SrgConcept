<?php

class GroupecubeManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddGroupecube(Groupecube $Groupecube){
		$q = $this->_Db->prepare('INSERT INTO groupecubes VALUES(:CodeGroupeCube, :LibelleGroupeCube, :NombreGroupeCube, :Regroupement)');
		$q->bindValue(':CodeGroupeCube', $Groupecube->GetCodeGroupeCube());
		$q->bindValue(':LibelleGroupeCube', $Groupecube->GetLibelleGroupeCube());
		$q->bindValue(':NombreGroupeCube', $Groupecube->GetNombreGroupeCube());
		$q->bindValue(':Regroupement', $Groupecube->GetRegroupement());
		if(!$q->execute()) {
			return [false,$q->errorInfo()];
		} else {
			return [true,$this->_Db->lastInsertId()];
		}
	}

	public function UpdateGroupecube(Groupecube $Groupecube){
		$q = $this->_Db->prepare('UPDATE groupecubes SET `LibelleGroupeCube` = :LibelleGroupeCube, `NombreGroupeCube` = :NombreGroupeCube, `Regroupement` = :Regroupement WHERE CodeGroupeCube = :CodeGroupeCube ');
		$q->bindValue(':CodeGroupeCube', $Groupecube->GetCodeGroupeCube());
		$q->bindValue(':LibelleGroupeCube', $Groupecube->GetLibelleGroupeCube());
		$q->bindValue(':NombreGroupeCube', $Groupecube->GetNombreGroupeCube());
		$q->bindValue(':Regroupement', $Groupecube->GetRegroupement());
		$q->execute();
	}

	public function DeleteGroupecube( $id){
		$this->_Db->exec('DELETE FROM groupecubes WHERE CodeGroupeCube ='.$id);
	}

	public function GetGroupecube( $id){
		$q = $this->_Db->prepare('SELECT * FROM groupecubes WHERE CodeGroupeCube ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Groupecube = new Groupecube($donnees);}
		return $Groupecube;
	}

	public function GetAllGroupecube(){
		$Groupecubes = [];
		$q = $this->_Db->query('SELECT * FROM groupecubes');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Groupecubes[] = new Groupecube($donnees);}
		return $Groupecubes;
	}

}