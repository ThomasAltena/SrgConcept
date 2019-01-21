<?php

class MatiereManager
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

    public function AddMatiere(Matiere $matiere)
    {
    	//Preparation
    	$q = $this->_Db->prepare('INSERT INTO matieres(Id_matiere, Code_matiere, Libelle_matiere, Prix_matiere) VALUES(:id, :code, :libelle, :prix)');
    	//Assignation des valeurs
    	$q->bindValue(':id', "");
    	$q->bindValue(':code', $matiere->GetCode());
    	$q->bindValue(':libelle', $matiere->GetLibelle());
        $q->bindValue(':prix', $matiere->GetPrix());

    	//Exécution de la requete
    	$q->execute();
    }

    /** Suppression de matiére **/
    public function DeleteMatiere($id)
    {
    	$this->_Db->exec('DELETE FROM matieres WHERE Id_matiere ='.$id);
    }


    public function UpdateMatiere(Matiere $matiere)
    {
    	$q= $this->_Db->prepare('UPDATE `matieres` SET `Code_matiere` = :code, `Libelle_matiere` = :libelle,  `Prix_matiere` = :prix WHERE `matieres`.`Id_matiere` = :id');

    	//Assignation des valeurs
    	$q->bindValue(':id', $matiere->GetId());
    	$q->bindValue(':code', $matiere->GetCode());
    	$q->bindValue(':libelle', $matiere->GetLibell());
        $q->bindValue(':prix', $matiere->GetPrix());

    	//Exécution de la requete
    	$q->execute();
    }

    /** Retourne une matiére **/
    public function GetMatiere($id)
    {
    	//Preparation
        $q=$this->_Db->prepare('SELECT * FROM matieres WHERE Id_matiere = :id');
        $q->bindValue(':id', $id);
        $q->execute();

        //Assignation valeur
        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $matiere = new Matiere($donnees);
        }

        return $matiere;
    }

    /** Retourne toutes les matiéres **/
    public function GetMatieres()
    {
    	$matieres = [];
    	$q = $this->_Db->query('SELECT * FROM matieres');

    	while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    	{
    		$matieres[] = new Matiere($donnees);
    	}

    	return $matieres;
    }
}