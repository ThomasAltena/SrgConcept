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


    public function AddDevis(Devis $devis)
    {
        //Preparation
        $q = $this->_Db->prepare('INSERT INTO devis(Id_devis, Code_devis, Date_devis, IdClient_devis, IdUser_devis, CheminImage_devis) VALUES(:id, :code, :datedevis, :idclient, :iduser, :chemin)');
        $q->bindValue(':id', "");
        $q->bindValue(':code',$devis->GetCode());
        $q->bindValue(':datedevis',$devis->GetDate());
        $q->bindValue(':idclient',$devis->GetIdClient());
        $q->bindValue(':iduser', $devis->GetIdUser());
        $q->bindValue(':chemin', $devis->GetCheminImage());
        //Assignation des valeurs

        //Execution de la requete
        $q->execute();

    }

    public function GetDevis($iduser)
    {
        //Preparation
        $devis = [];
        $q = $this->_Db->prepare('SELECT * FROM devis WHERE devis.IdUser_devis = :iduser');
        $q->bindValue(':iduser', $iduser);
        $q->execute();

        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $devis[] = new Devis($donnees);

        }
        return $devis;
    }

    public function GetImageDevis($iddevis)
    {
        //Preparation
        $imageDevis = "";
        $q = $this->_Db->prepare('SELECT CheminImage_devis FROM devis WHERE devis.Id_devis = :iddevis');
        $q->bindValue(':iddevis', $iddevis);
        $q->execute();

        //Assignation valeur
        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $imageDevis = new Devis($donnees);
        }

        return $imageDevis;

    }

    public function SelectLigneDevisManager($iddevis)
    {
    	//Preparation
        $lignedevis = [];
    	$q = $this->_Db->prepare('SELECT * FROM lignes_devis WHERE lignes_devis.Id_devis = :iddevis');
    	$q->bindValue(':iddevis', $iddevis);
    	$q->execute()or die(print_r($q->errorInfo()));


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
    	$q=$this->_Db->prepare('SELECT Nom_client, DateCrea_Client, Prenom_Client, Tel_Client, Adresse_client, Ville_client, CodePostal_client, Mail_client FROM clients C WHERE C.Id_client = :idclient');
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

    public function PrixMatiére($idmatiere){
        $matiere = "";
        $q=$this->_Db->prepare('SELECT Prix_matiere FROM matieres where Id_matiere = :idmatiere');
        $q->bindValue(':idmatiere', $idmatiere);
        $q->execute();

        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    	{
    		$matiere = new Matiere($donnees);
    	}

    	return $matiere;

    }
}