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
    	$q = $this->_Db->prepare("INSERT INTO lignes_devis VALUES (:id,:remise,:poids,:hauteur,:largeur,:profondeur,:iddevis,:idpiece,:Pos_x_piece,:Pos_y_piece,:Ratio_piece,:Pos_z_piece)");

    	//Assignation des valeurs
    	$q->bindValue(':id', "");
        $q->bindValue(':remise', $Ligne->GetRemise());
        $q->bindValue(':poids', $Ligne->GetPoids());
        $q->bindValue(':hauteur', $Ligne->GetHauteur());
        $q->bindValue(':largeur', $Ligne->GetLargeur());
        $q->bindValue(':profondeur', $Ligne->GetProfondeur());
        $q->bindValue(':iddevis', $Ligne->GetIdDevis());
        $q->bindValue(':idpiece', $Ligne->GetIdPiece());
        $q->bindValue(':Pos_x_piece', $Ligne->GetPos_x_piece());
        $q->bindValue(':Pos_y_piece', $Ligne->GetPos_y_piece());
        $q->bindValue(':Ratio_piece', $Ligne->GetRatio_piece());
        $q->bindValue(':Pos_z_piece', $Ligne->GetPos_z_piece());

    	//Execution de la requête
    	//$q->execute()or die(print_r($q->errorInfo()));

        //Execution de la requete
        if(!$q->execute()) {
            return [false,$q->errorInfo()];
        }
        return [true, 'OK'];
    }
}