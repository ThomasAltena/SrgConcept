<?php

class OptionManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddOption(Option $Option){
		$q = $this->_Db->prepare('INSERT INTO options VALUES(:IdOption, :CodeOption, :LibelleOption, :DureeOption, :UniteOption, :Cote1Option, :Cote2Option)');
		$q->bindValue(':IdOption', $Option->GetIdOption());
		$q->bindValue(':CodeOption', $Option->GetCodeOption());
		$q->bindValue(':LibelleOption', $Option->GetLibelleOption());
		$q->bindValue(':DureeOption', $Option->GetDureeOption());
		$q->bindValue(':UniteOption', $Option->GetUniteOption());
		$q->bindValue(':Cote1Option', $Option->GetCote1Option());
		$q->bindValue(':Cote2Option', $Option->GetCote2Option());
		if(!$q->execute()) {
			return [false,$q->errorInfo()];
		} else {
			return [true,$this->_Db->lastInsertId()];
		}
	}

	public function UpdateOption(Option $Option){
		$q = $this->_Db->prepare('UPDATE options SET `CodeOption` = :CodeOption, `LibelleOption` = :LibelleOption, `DureeOption` = :DureeOption, `UniteOption` = :UniteOption, `Cote1Option` = :Cote1Option, `Cote2Option` = :Cote2Option WHERE IdOption = :IdOption ');
		$q->bindValue(':IdOption', $Option->GetIdOption());
		$q->bindValue(':CodeOption', $Option->GetCodeOption());
		$q->bindValue(':LibelleOption', $Option->GetLibelleOption());
		$q->bindValue(':DureeOption', $Option->GetDureeOption());
		$q->bindValue(':UniteOption', $Option->GetUniteOption());
		$q->bindValue(':Cote1Option', $Option->GetCote1Option());
		$q->bindValue(':Cote2Option', $Option->GetCote2Option());
		$q->execute();
	}

	public function DeleteOption( $id){
		$this->_Db->exec('DELETE FROM options WHERE IdOption ='.$id);
	}

	public function GetOption( $id){
		$q = $this->_Db->prepare('SELECT * FROM options WHERE IdOption ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Option = new Option($donnees);}
		return $Option;
	}

	public function GetAllOption(){
		$Options = [];
		$q = $this->_Db->query('SELECT * FROM options');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Options[] = new Option($donnees);}
		return $Options;
	}

}