<?php

Class OptionLigneManager
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

    /** Ajout d'une ligne devis**/

    public function AddOptionLigne(OptionLigne $OptionLigne)
    {

    	//Préparation
    	$q = $this->_Db->prepare("INSERT INTO options_lignes VALUES (:id,:idLigne,:idOption)");

    	//Assignation des valeurs
    	$q->bindValue(':id', "");
      $q->bindValue(':idLigne', $OptionLigne->GetIdLigne());
      $q->bindValue(':idOption', $OptionLigne->GetIdOption());

    	//Execution de la requête
    	//$q->execute()or die(print_r($q->errorInfo()));

        //Execution de la requete
        if(!$q->execute()) {
            return [false,$q->errorInfo()];
        }
        return [true, 'OK'];
    }
}
