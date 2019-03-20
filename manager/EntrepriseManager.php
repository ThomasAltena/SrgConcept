<?php

class EntrepriseManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddEntreprise(Entreprise $Entreprise){
		$q = $this->_Db->prepare('INSERT INTO entreprises VALUES(:IdEntreprise, :SiretEntreprise, :LibelleEntreprise, :AdresseEntreprise, :RoleEntreprise)');
		$q->bindValue(':IdEntreprise', $Entreprise->GetIdEntreprise());
		$q->bindValue(':SiretEntreprise', $Entreprise->GetSiretEntreprise());
		$q->bindValue(':LibelleEntreprise', $Entreprise->GetLibelleEntreprise());
		$q->bindValue(':AdresseEntreprise', $Entreprise->GetAdresseEntreprise());
		$q->bindValue(':RoleEntreprise', $Entreprise->GetRoleEntreprise());
		$q->execute();
	}

	public function UpdateEntreprise(Entreprise $Entreprise){
		$q = $this->_Db->prepare('UPDATE entreprises SET `SiretEntreprise` = :SiretEntreprise, `LibelleEntreprise` = :LibelleEntreprise, `AdresseEntreprise` = :AdresseEntreprise, `RoleEntreprise` = :RoleEntreprise WHERE IdEntreprise = :IdEntreprise ');
		$q->bindValue(':IdEntreprise', $Entreprise->GetIdEntreprise());
		$q->bindValue(':SiretEntreprise', $Entreprise->GetSiretEntreprise());
		$q->bindValue(':LibelleEntreprise', $Entreprise->GetLibelleEntreprise());
		$q->bindValue(':AdresseEntreprise', $Entreprise->GetAdresseEntreprise());
		$q->bindValue(':RoleEntreprise', $Entreprise->GetRoleEntreprise());
		$q->execute();
	}

	public function DeleteEntreprise( $id){
		$this->_Db->exec('DELETE FROM entreprises WHERE IdEntreprise ='.$id);
	}

	public function GetEntreprise( $id){
		$q = $this->_Db->prepare('SELECT * FROM entreprises WHERE IdEntreprise ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Entreprise = new Entreprise($donnees);}
		return $Entreprise;
	}

	public function GetAllEntreprise(){
		$Entreprises = [];
		$q = $this->_Db->query('SELECT * FROM entreprises');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Entreprises[] = new Entreprise($donnees);}
		return $Entreprises;
	}

}