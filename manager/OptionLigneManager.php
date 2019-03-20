<?php

class OptionLigneManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddOptionLigne(OptionLigne $OptionLigne){
		$q = $this->_Db->prepare('INSERT INTO options_lignes VALUES(:IdOptionsLignes, :IdLigne, :IdOption)');
		$q->bindValue(':IdOptionsLignes', $OptionLigne->GetIdOptionsLignes());
		$q->bindValue(':IdLigne', $OptionLigne->GetIdLigne());
		$q->bindValue(':IdOption', $OptionLigne->GetIdOption());
		$q->execute();
	}

	public function UpdateOptionLigne(OptionLigne $OptionLigne){
		$q = $this->_Db->prepare('UPDATE options_lignes SET `IdLigne` = :IdLigne, `IdOption` = :IdOption WHERE IdOptionsLignes = :IdOptionsLignes ');
		$q->bindValue(':IdOptionsLignes', $OptionLigne->GetIdOptionsLignes());
		$q->bindValue(':IdLigne', $OptionLigne->GetIdLigne());
		$q->bindValue(':IdOption', $OptionLigne->GetIdOption());
		$q->execute();
	}

	public function DeleteOptionLigne( $id){
		$this->_Db->exec('DELETE FROM options_lignes WHERE IdOptionsLignes ='.$id);
	}

	public function GetOptionLigne( $id){
		$q = $this->_Db->prepare('SELECT * FROM options_lignes WHERE IdOptionsLignes ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$OptionLigne = new OptionLigne($donnees);}
		return $OptionLigne;
	}

	public function GetAllOptionLigne(){
		$OptionLignes = [];
		$q = $this->_Db->query('SELECT * FROM options_lignes');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$OptionLignes[] = new OptionLigne($donnees);}
		return $OptionLignes;
	}

}