<?php

class PieceManager
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
    // public function AddImage(Image $image)
    // {
    //     //Preparation
    //     $q =$this->_Db->prepare('INSERT INTO images(Id_image, Chemin_image) VALUES(:idImage, :cheminImage)');
    //     //Asignation des valeurs
    //     $q->bindValue(':idImage', $image->GetId());
    //     $q->bindValue(':cheminImage', $image->GetChemin());

    //     //Execution de la requete
    //     $q->execute();
    //}

    public function AddPiece(Piece $piece)
    {
    	//Preparation
    	$q =$this->_Db->prepare('INSERT INTO pieces(Id_image, Id_piece, Libelle_piece, Code_piece, Chemin_piece) VALUES(:idImage, :id, :libelle, :code, :chemin)');
    	//Assignation des valeurs
    	$q->bindValue(':idImage', $piece->GetImage());
    	$q->bindValue(':id', $piece->GetId());
    	$q->bindValue(':libelle', $piece->GetLibelle());
        $q->bindValue(':code', $piece->GetCode());
    	$q->bindValue(':chemin', '../public/images/'.$piece->GetLibelle().'.jpg');

    	//Execution de la requete
    	$q->execute();
    }

    /** Supression d'une piéce **/
    public function DeletePiece($id)
    {
    	$this->_Bd->exec('DELETE FROM pieces WHERE Id_piece =' .$id);
    }

    public function UpdatePiece(Piece $piece)
    {
    	$q= $this->_Db->prepare('UPDATE `pieces` SET `Id_image` = :idImage , `Id_piece` = :id, `Libelle_piece` = :libelle');

    	//Assignation des valeurs
    	$q->bindValue(':idImage', $piece->GetImage());
    	$q->bindValue(':id', $piece->GetId());
    	$q->bindValue(':libelle', $piece->GetLibelle());

    	//Exécution de la requete
    	$q->execute();
    }

    /** Retourne un piéce **/
    public function GetPiece($id)
    {
    	//Preparation
    	$q = $this->_Db->prepare('SELECT * FROM pieces WHERE Id_piece = :id');
    	$q->bindValue(':id', $id);
    	$q->execute();

    	//Assignation valeur
    	while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    	{
    		$piece = new Piece($donnees);
    	}

    	return $piece;
    }

    /** Retourne toutes les piéces **/
    public function GetPieces()
    {
    	$pieces = [];
    	$q = $this->_Db->query('SELECT * FROM pieces');

    	while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    	{
    		$pieces[] = new Piece($donnees);
    	}

    	return $pieces;
    }

}