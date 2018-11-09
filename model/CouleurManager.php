<?php

class CouleurManager
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

    public function AddCouleur(Couleur $couleur)
    {

    	//Preparation
    	$q = $this->_Db->prepare('INSERT INTO couleurs(Id_couleur, Libelle_couleur, Hexa_couleur) VALUES (:id, :libelle, :hexa)');
    	//Assignation des valeurs
    	$q->bindValue(':id', "");
    	$q->bindValue(':libelle', $couleur.GetLibelle());
    	$q->bindValue(':hexa', $couleur.GetHexa());

    	//Exécution de la requete
    	$q->execute();
    }

      /** Suppression de matiére **/
    public function DeleteMatiere($id)
    {
    	$this->_Db->exec('DELETE FROM matieres WHERE Id_matiere ='.$id);
    }

    //Retourne toutes les couleurs dans un tableau.
    public function GetCouleurs()
    {
    	//Preparation
    	$couleurs = [];
    	$q =  $this->_Db->query('SELECT * FROM couleurs');

    	while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    	{
    		$couleurs[] = new Couleur($donnees);
    	}

    	return $couleurs;
    }

}