<?php

class FamilleManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddFamille(Famille $Famille){
		$q = $this->_Db->prepare('INSERT INTO familles VALUES(:CodeFamille, :LibelleFamille, :RegroupementFamille)');
		$q->bindValue(':CodeFamille', $Famille->GetCodeFamille());
		$q->bindValue(':LibelleFamille', $Famille->GetLibelleFamille());
		$q->bindValue(':RegroupementFamille', $Famille->GetRegroupementFamille());
		$q->execute();
	}

	public function UpdateFamille(Famille $Famille){
		$q = $this->_Db->prepare('UPDATE familles SET `LibelleFamille` = :LibelleFamille, `RegroupementFamille` = :RegroupementFamille WHERE CodeFamille = :CodeFamille ');
		$q->bindValue(':CodeFamille', $Famille->GetCodeFamille());
		$q->bindValue(':LibelleFamille', $Famille->GetLibelleFamille());
		$q->bindValue(':RegroupementFamille', $Famille->GetRegroupementFamille());
		$q->execute();
	}

	public function DeleteFamille( $id){
		$this->_Db->exec('DELETE FROM familles WHERE CodeFamille ='.$id);
	}

	public function GetFamille( $id){
		$q = $this->_Db->prepare('SELECT * FROM familles WHERE CodeFamille ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Famille = new Famille($donnees);}
		return $Famille;
	}

	public function GetAllFamille(){
		$Familles = [];
		$q = $this->_Db->query('SELECT * FROM familles');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Familles[] = new Famille($donnees);}
		return $Familles;
	}

}