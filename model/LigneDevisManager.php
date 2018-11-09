<?php

Class LigneDevisManager
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

    public function AddLigne(LigneDevis $ligne)
    {

    	//Préparation
    	$q = $this->_Db->prepare('INSERT INTO lignes_devis(Id_ligne, Code_ligne, Remise_ligne, Prix_ligne, Poids_ligne, Hauteur_ligne, Largeur_ligne, Profondeur_ligne, Id_piece, Id_matiere, Id_couleur, Id_tva, Option1, Option2, Option3, Option5, Option5) VALUES(:id, :code, :remise, :prix, :poids, :hauteur, :largeur, :profondeur, :idpiece, :idmatiere, :idcouleur, :idtva, :option1, :option2, :option3, :option4, :option5)');

    	//Assignation des valeurs
    	$q->bindValue(':id', $user->GetId());
        $q->bindValue(':code', $user->GetCode());
        $q->bindValue(':remise', $user->GetRemise());
        $q->bindValue(':prix', $user->GetPrix());
        $q->bindValue(':poids', $user->GetPoids());
        $q->bindValue(':jauteur', $user->GetHauteur());
        $q->bindValue(':largeur', $user->GetLargeur());
        $q->bindValue(':profondeur', $user->GetIdPiece());
        $q->bindValue(':idpiece', $user->GetIdMatiere());
        $q->bindValue(':idmatiere', $user->GetIdCouleur());
        $q->bindValue(':idcouleur', $user->GetIdTva());
        $q->bindValue(':idtva', $user->GetOption1());
        $q->bindValue(':option1', $user->GetOption2());
        $q->bindValue(':option2', $user->GetOption3());
        $q->bindValue(':option3', $user->GetOption4());
        $q->bindValue(':option4', $user->GetOption5());

    	//Execution de la requête
    	$q->execute();
    }
}