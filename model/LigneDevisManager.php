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
    	$q->bindValue(':id', $LigneDevis->GetId());
        $q->bindValue(':code', $LigneDevis->GetCode());
        $q->bindValue(':remise', $LigneDevis->GetRemise());
        $q->bindValue(':prix', $LigneDevis->GetPrix());
        $q->bindValue(':poids', $LigneDevis->GetPoids());
        $q->bindValue(':hauteur', $LigneDevis->GetHauteur());
        $q->bindValue(':largeur', $LigneDevis->GetLargeur());
        $q->bindValue(':profondeur', $LigneDevis->GetIdPiece());
        $q->bindValue(':idpiece', $LigneDevis->GetIdPiece());
        $q->bindValue(':idmatiere', $LigneDevis->GetIdMatiere());
        $q->bindValue(':idcouleur', $LigneDevis->GetCouleur());
        $q->bindValue(':idtva', $LigneDevis->GetIdTva());
        $q->bindValue(':option1', $LigneDevis->GetOption1());
        $q->bindValue(':option2', $LigneDevis->GetOption2());
        $q->bindValue(':option3', $LigneDevis->GetOption3());
        $q->bindValue(':option4', $LigneDevis->GetOption4());

    	//Execution de la requête
    	$q->execute();
    }
}