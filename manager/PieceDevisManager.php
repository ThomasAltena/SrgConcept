<?php

class PieceDevisManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddPieceDevis(PieceDevis $PieceDevis){
		$q = $this->_Db->prepare('INSERT INTO pieces_devis VALUES(:IdPieceDevis, :IdPiece, :IdDevis)');
		$q->bindValue(':IdPieceDevis', $PieceDevis->GetIdPieceDevis());
		$q->bindValue(':IdPiece', $PieceDevis->GetIdPiece());
		$q->bindValue(':IdDevis', $PieceDevis->GetIdDevis());
		$q->execute();
	}

	public function UpdatePieceDevis(PieceDevis $PieceDevis){
		$q = $this->_Db->prepare('UPDATE pieces_devis SET `IdPiece` = :IdPiece, `IdDevis` = :IdDevis WHERE IdPieceDevis = :IdPieceDevis ');
		$q->bindValue(':IdPieceDevis', $PieceDevis->GetIdPieceDevis());
		$q->bindValue(':IdPiece', $PieceDevis->GetIdPiece());
		$q->bindValue(':IdDevis', $PieceDevis->GetIdDevis());
		$q->execute();
	}

	public function DeletePieceDevis( $id){
		$this->_Db->exec('DELETE FROM pieces_devis WHERE IdPieceDevis ='.$id);
	}

	public function GetPieceDevis( $id){
		$q = $this->_Db->prepare('SELECT * FROM pieces_devis WHERE IdPieceDevis ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$PieceDevis = new PieceDevis($donnees);}
		return $PieceDevis;
	}

	public function GetAllPieceDevis(){
		$PieceDeviss = [];
		$q = $this->_Db->query('SELECT * FROM pieces_devis');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$PieceDeviss[] = new PieceDevis($donnees);}
		return $PieceDeviss;
	}

	public function GetPieceDevisByDevis($id){
		$PieceDeviss = [];
		$q = $this->_Db->query('SELECT * FROM pieces_devis WHERE IdDevis = '.$id);
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$PieceDeviss[] = new PieceDevis($donnees);}
		return $PieceDeviss;
	}

}
