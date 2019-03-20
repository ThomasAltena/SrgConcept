<?php

class TvaManager
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

    public function AddTva(Tva $tva)
    {
    	$q =$this->_Db->prepare('INSERT INTO tva (Id_tva,Taux_tva) VALUES (NULL, :taux)');

    	//Assignation des valeurs
    	//$q->bindValue(':id', '');
    	$q->bindValue(':taux', $tva->GetTaux());

    	//Execution de la requête
    	$q->execute();
    }

        /** Retourne toutes les Tva **/
    public function GetTva()
    {
    	$tva = [];
    	$q = $this->_Db->query('SELECT * FROM Tva');

    	while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    	{
    		$tva[] = new Tva($donnees);
    	}

    	return $tva;
    }
}