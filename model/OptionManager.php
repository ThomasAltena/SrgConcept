<?php

Class OptionManager
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

    public function AddOption(Option $option)
    {
    	$q =$this->_Db->prepare('INSERT INTO options(Id_option, Libelle_option, Code_opton, Prix_option) VALUES(:id, :libelle, :code, :prix)');

    	//Assignation des valeurs
    	$q->bindValue(';id',$option.GetId());
    	$q->bindValue(':libelle', $option.GetLibelle());
    	$q->bindValue(':code', $option.GetCode());
    	$q->bindValue(':prix', $option.GetOption());

    	//Exécution de la requête
    	$q->execute();
    }

    	/** Retourne toutes les option **/
    public function GetOptions()
    {
    	$options = [];
    	$q = $this->_Db->query('SELECT * from options');

    	while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    	{
    		$options[] = new Option($donnees);
    	}

    	return $options;
    }
}