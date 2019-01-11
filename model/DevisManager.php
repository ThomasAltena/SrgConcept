 <?php

Class DevisManager
{

/** Base de données **/
	private $_Db; // Instance de PDO.


    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function SetDb(PDO $db)
    {
        $this->_Db = $db;
    }


    public function AddDevis($iddevis)
    {
        //Preparation
        $q = $this->_Db->prepare('INSERT INTO devis(Id_devis, Code_devis, Date_devis, Id_client, Id_user, Libelle_devis, CheminImage_devis) VALUES(:id, :code, :datedevis, :idclient, :iduser, :libelle, :chemin)');
        $q->bindValue(':id', $devis->GetId());
        $q->bindValue(':code',$devis->GetCode());
        $q->bindValue(':datedevis',$devis->GetDate());
        $q->bindValue(':idclient',$devis->GetIdClient());
        $q->bindValue(':iduser', $devis->GetLibelle());
        $q->bindValue(':libelle', $devis->GEtCheminImage());
        //Assignation des valeurs

        //Execution de la requete
        $q->execute();

    }

    public function GetDevis($iduser)
    {
        //Preparation
        
        $q = $this->_Db->prepare('SELECT * FROM devis WHERE devis.IdUser_devis = :iduser');
        $q->bindValue(':iduser', $iduser);
        $q->execute();

        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $devis[] = new Devis($donnees);

        }
        return $devis;
    }

    public function SelectDevisManager($iddevis)
    {
    	//Preparation
        $lignedevis = [];
    	$q = $this->_Db->prepare('SELECT * FROM lignes_devis WHERE lignes_devis.Id_devis = :iddevis');
    	$q->bindValue(':iddevis', $iddevis);
    	$q->execute();

    	while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    	{
    		$lignedevis[] = new LigneDevis($donnees);
    	}

    	return $lignedevis;

    }



    public function SelectUserDevis($iduser)
    {
    	//Preparation
        $user = "";
    	$q=$this->_Db->prepare('SELECT Nom_user, Siret_user FROM user WHERE user.Id_user = :iduser');
    	$q->bindValue(':iduser', $iduser);
    	$q->execute();

    	while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    	{
    		$user = new Utilisateur($donnees);
    	}

    	return $user;
    }

    public function SelectClientDevis($idclient)
    {

    	//Preparation
        $client = "";
    	$q=$this->_Db->prepare('SELECT Nom_client, Prenom_Client, Tel_Client, Adresse_client, Ville_client, Cp_client, Mail_client FROM clients C WHERE C.Id_client = :idclient');
    	$q->bindValue(':idclient', $idclient);
    	$q->execute();

    	while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    	{
    		$client = new Client($donnees);
    	}

    	return $client;
    	
    }

    public function SommePrix($iddevis)
    {
        $somme = "";
        $q=$this->_Db->prepare('SELECT sum(Prix_ligne) FROM lignes_devis WHERE lignes_devis.Id_devis = :iddevis');
        $q->bindValue(':iddevis', $iddevis);
        $q->execute();

        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $somme = $donnees;
        }
        return $somme;
    }
}