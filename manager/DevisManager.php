<?php

class DevisManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddDevis(Devis $Devis){
		$q = $this->_Db->prepare('INSERT INTO devis VALUES(:IdDevis, :DateDevis, :IdClient, :IdUser, :CheminSchemaDevis, :ArchiveDevis, :CheminFicheFabDevis, :RemiseDevis, :FormatDevis)');
		$q->bindValue(':IdDevis', $Devis->GetIdDevis());
		$q->bindValue(':DateDevis', $Devis->GetDateDevis());
		$q->bindValue(':IdClient', $Devis->GetIdClient());
		$q->bindValue(':IdUser', $Devis->GetIdUser());
		$q->bindValue(':CheminSchemaDevis', $Devis->GetCheminSchemaDevis());
		$q->bindValue(':ArchiveDevis', $Devis->GetArchiveDevis());
		$q->bindValue(':CheminFicheFabDevis', $Devis->GetCheminFicheFabDevis());
		$q->bindValue(':RemiseDevis', $Devis->GetRemiseDevis());
		$q->bindValue(':FormatDevis', $Devis->GetFormatDevis());
		$q->execute();
	}

	public function UpdateDevis(Devis $Devis){
		$q = $this->_Db->prepare('UPDATE devis SET `DateDevis` = :DateDevis, `IdClient` = :IdClient, `IdUser` = :IdUser, `CheminSchemaDevis` = :CheminSchemaDevis, `ArchiveDevis` = :ArchiveDevis, `CheminFicheFabDevis` = :CheminFicheFabDevis, `RemiseDevis` = :RemiseDevis, `FormatDevis` = :FormatDevis WHERE IdDevis = :IdDevis ');
		$q->bindValue(':IdDevis', $Devis->GetIdDevis());
		$q->bindValue(':DateDevis', $Devis->GetDateDevis());
		$q->bindValue(':IdClient', $Devis->GetIdClient());
		$q->bindValue(':IdUser', $Devis->GetIdUser());
		$q->bindValue(':CheminSchemaDevis', $Devis->GetCheminSchemaDevis());
		$q->bindValue(':ArchiveDevis', $Devis->GetArchiveDevis());
		$q->bindValue(':CheminFicheFabDevis', $Devis->GetCheminFicheFabDevis());
		$q->bindValue(':RemiseDevis', $Devis->GetRemiseDevis());
		$q->bindValue(':FormatDevis', $Devis->GetFormatDevis());
		$q->execute();
	}

	public function DeleteDevis( $id){
		$this->_Db->exec('DELETE FROM devis WHERE IdDevis ='.$id);
	}

	public function GetDevis( $id){
		$q = $this->_Db->prepare('SELECT * FROM devis WHERE IdDevis ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Devis = new Devis($donnees);}
		return $Devis;
	}

	public function GetAllDevis(){
		$Deviss = [];
		$q = $this->_Db->query('SELECT * FROM devis');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Deviss[] = new Devis($donnees);}
		return $Deviss;
	}

}
