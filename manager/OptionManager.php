<?php

class OptionManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddOption(Option $Option){
		$q = $this->_Db->prepare('INSERT INTO options VALUES(:IdOption, :LibelleOption, :CodeOption, :PrixOption)');
		$q->bindValue(':IdOption', $Option->GetIdOption());
		$q->bindValue(':LibelleOption', $Option->GetLibelleOption());
		$q->bindValue(':CodeOption', $Option->GetCodeOption());
		$q->bindValue(':PrixOption', $Option->GetPrixOption());
		$q->execute();
	}

	public function UpdateOption(Option $Option){
		$q = $this->_Db->prepare('UPDATE options SET `LibelleOption` = :LibelleOption, `CodeOption` = :CodeOption, `PrixOption` = :PrixOption WHERE IdOption = :IdOption ');
		$q->bindValue(':IdOption', $Option->GetIdOption());
		$q->bindValue(':LibelleOption', $Option->GetLibelleOption());
		$q->bindValue(':CodeOption', $Option->GetCodeOption());
		$q->bindValue(':PrixOption', $Option->GetPrixOption());
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