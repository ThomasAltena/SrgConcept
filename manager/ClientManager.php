<?php

class ClientManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddClient(Client $Client){
		$q = $this->_Db->prepare('INSERT INTO clients VALUES(:IdClient, :NomClient, :PrenomClient, :AdresseClient, :CodePostalClient, :VilleClient, :TelClient, :MailClient, :DateCreationClient, :ProspectClient, :IdUser)');
		$q->bindValue(':IdClient', $Client->GetIdClient());
		$q->bindValue(':NomClient', $Client->GetNomClient());
		$q->bindValue(':PrenomClient', $Client->GetPrenomClient());
		$q->bindValue(':AdresseClient', $Client->GetAdresseClient());
		$q->bindValue(':CodePostalClient', $Client->GetCodePostalClient());
		$q->bindValue(':VilleClient', $Client->GetVilleClient());
		$q->bindValue(':TelClient', $Client->GetTelClient());
		$q->bindValue(':MailClient', $Client->GetMailClient());
		$q->bindValue(':DateCreationClient', $Client->GetDateCreationClient());
		$q->bindValue(':ProspectClient', $Client->GetProspectClient());
		$q->bindValue(':IdUser', $Client->GetIdUser());
		$q->execute();
	}

	public function UpdateClient(Client $Client){
		$q = $this->_Db->prepare('UPDATE clients SET `NomClient` = :NomClient, `PrenomClient` = :PrenomClient, `AdresseClient` = :AdresseClient, `CodePostalClient` = :CodePostalClient, `VilleClient` = :VilleClient, `TelClient` = :TelClient, `MailClient` = :MailClient, `DateCreationClient` = :DateCreationClient, `ProspectClient` = :ProspectClient, `IdUser` = :IdUser WHERE IdClient = :IdClient ');
		$q->bindValue(':IdClient', $Client->GetIdClient());
		$q->bindValue(':NomClient', $Client->GetNomClient());
		$q->bindValue(':PrenomClient', $Client->GetPrenomClient());
		$q->bindValue(':AdresseClient', $Client->GetAdresseClient());
		$q->bindValue(':CodePostalClient', $Client->GetCodePostalClient());
		$q->bindValue(':VilleClient', $Client->GetVilleClient());
		$q->bindValue(':TelClient', $Client->GetTelClient());
		$q->bindValue(':MailClient', $Client->GetMailClient());
		$q->bindValue(':DateCreationClient', $Client->GetDateCreationClient());
		$q->bindValue(':ProspectClient', $Client->GetProspectClient());
		$q->bindValue(':IdUser', $Client->GetIdUser());
		$q->execute();
	}

	public function DeleteClient( $id){
		$this->_Db->exec('DELETE FROM clients WHERE IdClient ='.$id);
	}

	public function GetClient( $id){
		$q = $this->_Db->prepare('SELECT * FROM clients WHERE IdClient ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Client = new Client($donnees);}
		return $Client;
	}

	public function GetAllClient(){
		$Clients = [];
		$q = $this->_Db->query('SELECT * FROM clients');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Clients[] = new Client($donnees);}
		return $Clients;
	}

}