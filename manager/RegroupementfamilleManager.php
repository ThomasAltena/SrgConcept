<?php

class RegroupementfamilleManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddRegroupementfamille(Regroupementfamille $Regroupementfamille){
		$q = $this->_Db->prepare('INSERT INTO regroupementfamilles VALUES(:IdRegroupementFamille, :LibelleRegroupementFamille, :PositionRegroupementFamille)');
		$q->bindValue(':IdRegroupementFamille', $Regroupementfamille->GetIdRegroupementFamille());
		$q->bindValue(':LibelleRegroupementFamille', $Regroupementfamille->GetLibelleRegroupementFamille());
		$q->bindValue(':PositionRegroupementFamille', $Regroupementfamille->GetPositionRegroupementFamille());
		if(!$q->execute()) {
			return [false,$q->errorInfo()];
		} else {
			return [true,$this->_Db->lastInsertId()];
		}
	}

	public function UpdateRegroupementfamille(Regroupementfamille $Regroupementfamille){
		$q = $this->_Db->prepare('UPDATE regroupementfamilles SET `LibelleRegroupementFamille` = :LibelleRegroupementFamille, `PositionRegroupementFamille` = :PositionRegroupementFamille WHERE IdRegroupementFamille = :IdRegroupementFamille ');
		$q->bindValue(':IdRegroupementFamille', $Regroupementfamille->GetIdRegroupementFamille());
		$q->bindValue(':LibelleRegroupementFamille', $Regroupementfamille->GetLibelleRegroupementFamille());
		$q->bindValue(':PositionRegroupementFamille', $Regroupementfamille->GetPositionRegroupementFamille());
		$q->execute();
	}

	public function DeleteRegroupementfamille( $id){
		$this->_Db->exec('DELETE FROM regroupementfamilles WHERE IdRegroupementFamille ='.$id);
	}

	public function GetRegroupementfamille( $id){
		$q = $this->_Db->prepare('SELECT * FROM regroupementfamilles WHERE IdRegroupementFamille ='.$id.' ORDER BY PositionRegroupementFamille');
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Regroupementfamille = new Regroupementfamille($donnees);}
		return $Regroupementfamille;
	}

	public function GetAllRegroupementfamille(){
		$Regroupementfamilles = [];
		$q = $this->_Db->query('SELECT * FROM regroupementfamilles');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Regroupementfamilles[] = new Regroupementfamille($donnees);}
		return $Regroupementfamilles;
	}

}
