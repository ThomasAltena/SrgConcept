<?php

class ClientManager
{
	private $_Db;

	public function __construct($db)
	{
		$this->setDb($db);
	}

	public function SetDb(PDO $db)
	{
		$this->_Db = $db;
	}

	/** Ajout d'un client **/
	public function AddClient(Client $client)
	{

		$q = $this->_Db->prepare('INSERT INTO clients(Id_client, Adresse_client, Cp_client, DateCrea_client, Mail_client, Nom_client, Prenom_client, Prospect_client, Tel_client, Ville_client, Id_user) VALUES(:id, :adresse, :codepostal, :datecreation, :mail, :nom, :prenom, :prospect, :tel, :ville, :iduser)');

		//Récupération de la date du jour
		$todaysDate = date("Y-m-d");
		//Assignation des valeur
		$q->bindValue(':id', $client->GetId());
		$q->bindValue(':adresse', $client->GetAdresse());
		$q->bindValue(':codepostal', $client->GetCodePostal());
		$q->bindValue(':datecreation', $todaysDate);
		$q->bindValue(':mail', $client->GetMail());
		$q->bindValue(':nom', $client->GetNom());
		$q->bindValue(':prenom', $client->GetPrenom());
		$q->bindValue(':prospect', $client->GetProspect());
		$q->bindValue(':tel', $client->GetTel());
		$q->bindValue(':ville', $client->GetVille());
		$q->bindValue(':iduser', $client->GetIdUser());

		//Execution de la requete
		$q->execute();
	}
	/** Suppression d'un utilisateur **/
	public function DeleteClient($id)
	{
		$this->_Db->exec('DELETE FROM clients WHERE Id_client = '.id);
	}

	/** Mise a jour d'un client **/
	public function UpdateClient(Client $client)
	{
		//Preparation
		$q = $this->_Db->prepare('UPDATE `clients` SET `Adresse_client` = :adresse , `Cp_client` = :codepostal , `DateCrea_client` = :datecreation , `Mail_client` = :mail , `Nom_client` = :nom , `Prenom_client` = :prenom , `Prospect_client` = :prospect , `Tel_client` = :tel , `Ville_client` = :ville , `Id_user` = :iduser WHERE `client`.`Id_client` = :id');

		//Assignation de valeur
		$q->bindValue(':id', $client->GetId());
		$q->bindValue(':adresse', $client->GetAdresse());
		$q->bindValue(':co:depostal', $client->GetCodePostal());
		$q->bindValue(':datecreation', $client->GetDateCreation());
		$q->bindValue(':mail', $client->GetMail());
		$q->bindValue(':nom', $client->GetNom());
		$q->bindValue(':prenom', $client->GetPrenom());
		$q->bindValue(':prospect', $client->GetProspect());
		$q->bindValue(':tel', $client->GetTel());
		$q->bindValue(':ville', $client->GetVille());
		$q->bindValue(':iduser', $client->GetUserId());
		
		//Execution de la requete
		$q->execute();

	}

	/** Retourne UN client **/
/*	public function GetClient($nom)
	{

		//Preparation
		$q=$this->_Db->prepare('SELECT * FROM clients WHERE Nom_client = :nom');
		$q->bindValue(':nom', $nom);
		$q->execute();

		//Assignation de valeur
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $client = new Client($donnees);
        }

        return $client;
    }*/

    /** Retourne tous les clients **/
    public function GetClientsAdmin()
    {
    	$clientsAmin = [];
    	$q = $this->_Db->query('SELECT * FROM clients ORDER BY DateCrea_client ');

    	while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $clientsAdmin[] = new Client($donnees);
        }

        return $clientsAdmin;
    }

   public function GetClients($iduser)
    {
    	$clients = [];
    	$q = $this->_Db->prepare('SELECT * FROM clients WHERE Id_user = :iduser');
    	$q->bindValue(':iduser', $iduser);
    	$q->execute();

    	while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $clients[] = new Client($donnees);
        }

        return $clients;
    }

}