<?php

class MatiereManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddMatiere(Matiere $Matiere){
		$q = $this->_Db->prepare('INSERT INTO matieres VALUES(:IdMatiere, :CodeMatiere, :LibelleMatiere, :PrixMatiere, :PrixScieage, :PrixPolissage, :CheminMatiere)');
		$q->bindValue(':IdMatiere', $Matiere->GetIdMatiere());
		$q->bindValue(':CodeMatiere', $Matiere->GetCodeMatiere());
		$q->bindValue(':LibelleMatiere', $Matiere->GetLibelleMatiere());
		$q->bindValue(':PrixMatiere', $Matiere->GetPrixMatiere());
		$q->bindValue(':PrixScieage', $Matiere->GetPrixScieage());
		$q->bindValue(':PrixPolissage', $Matiere->GetPrixPolissage());
		$q->bindValue(':CheminMatiere', $Matiere->GetCheminMatiere());
		if(!$q->execute()) {
			return [false,$q->errorInfo()];
		} else {
			return [true,$this->_Db->lastInsertId()];
		}
	}

	public function UpdateMatiere(Matiere $Matiere){
		$q = $this->_Db->prepare('UPDATE matieres SET `CodeMatiere` = :CodeMatiere, `LibelleMatiere` = :LibelleMatiere, `PrixMatiere` = :PrixMatiere, `PrixScieage` = :PrixScieage, `PrixPolissage` = :PrixPolissage, `CheminMatiere` = :CheminMatiere WHERE IdMatiere = :IdMatiere ');
		$q->bindValue(':IdMatiere', $Matiere->GetIdMatiere());
		$q->bindValue(':CodeMatiere', $Matiere->GetCodeMatiere());
		$q->bindValue(':LibelleMatiere', $Matiere->GetLibelleMatiere());
		$q->bindValue(':PrixMatiere', $Matiere->GetPrixMatiere());
		$q->bindValue(':PrixScieage', $Matiere->GetPrixScieage());
		$q->bindValue(':PrixPolissage', $Matiere->GetPrixPolissage());
		$q->bindValue(':CheminMatiere', $Matiere->GetCheminMatiere());
		$q->execute();
	}

	public function DeleteMatiere( $id){
		$this->_Db->exec('DELETE FROM matieres WHERE IdMatiere ='.$id);
	}

	public function GetMatiere( $id){
		$q = $this->_Db->prepare('SELECT * FROM matieres WHERE IdMatiere ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Matiere = new Matiere($donnees);}
		return $Matiere;
	}

	public function GetAllMatiere(){
		$Matieres = [];
		$q = $this->_Db->query('SELECT * FROM matieres');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Matieres[] = new Matiere($donnees);}
		return $Matieres;
	}

}