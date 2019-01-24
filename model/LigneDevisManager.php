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

    public function AddLigne(LigneDevis $Ligne)
    {

    	//Préparation
    	$q = $this->_Db->prepare("INSERT INTO lignes_devis (Id_ligne,Code_ligne,Remise_ligne,Prix_ligne,Poids_ligne,Hauteur_ligne,Largeur_ligne,Profondeur_ligne,Id_devis,Id_piece,Id_matiere,Id_couleur,Id_tva,Option1,Option2,Option3,Option4) VALUES (:id,:code,:remise,:prix,:poids,:hauteur,:largeur,:profondeur,:iddevis,:idpiece,:idmatiere,:idcouleur,:idtva,:option1,:option2,:option3,:option4)");

    	//Assignation des valeurs
    	$q->bindValue(':id', "");
        $q->bindValue(':code', "");
        $q->bindValue(':remise', $Ligne->GetRemise());
        $q->bindValue(':prix', $Ligne->GetPrix());
        $q->bindValue(':poids', $Ligne->GetPoids());
        $q->bindValue(':hauteur', $Ligne->GetHauteur());
        $q->bindValue(':largeur', $Ligne->GetLargeur());
        $q->bindValue(':profondeur', $Ligne->GetProfondeur());
        $q->bindValue(':iddevis', $Ligne->GetIdDevis());
        $q->bindValue(':idpiece', $Ligne->GetIdPiece());
        $q->bindValue(':idmatiere', $Ligne->GetIdMatiere());
        $q->bindValue(':idcouleur', $Ligne->GetIdCouleur());
        $q->bindValue(':idtva', $Ligne->GetIdTva());
        $q->bindValue(':option1', $Ligne->GetOption1());
        $q->bindValue(':option2', $Ligne->GetOption2());
        $q->bindValue(':option3', $Ligne->GetOption3());
        $q->bindValue(':option4', $Ligne->GetOption4());

    	//Execution de la requête
    	$q->execute()or die(print_r($q->errorInfo()));
    }
}