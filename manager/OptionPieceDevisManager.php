<?php

class OptionPieceDevisManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddOptionPieceDevis(OptionPieceDevis $OptionPieceDevis){
		$q = $this->_Db->prepare('INSERT INTO options_pieces_devis VALUES(:IdOptionsPiecesDevis, :IdDevis, :IdOption, :IdPiece)');
		$q->bindValue(':IdOptionsPiecesDevis', $OptionPieceDevis->GetIdOptionsPiecesDevis());
		$q->bindValue(':IdDevis', $OptionPieceDevis->GetIdDevis());
		$q->bindValue(':IdOption', $OptionPieceDevis->GetIdOption());
		$q->bindValue(':IdPiece', $OptionPieceDevis->GetIdPiece());
		$q->execute();
	}

	public function UpdateOptionPieceDevis(OptionPieceDevis $OptionPieceDevis){
		$q = $this->_Db->prepare('UPDATE options_pieces_devis SET `IdDevis` = :IdDevis, `IdOption` = :IdOption, `IdPiece` = :IdPiece WHERE IdOptionsPiecesDevis = :IdOptionsPiecesDevis ');
		$q->bindValue(':IdOptionsPiecesDevis', $OptionPieceDevis->GetIdOptionsPiecesDevis());
		$q->bindValue(':IdDevis', $OptionPieceDevis->GetIdDevis());
		$q->bindValue(':IdOption', $OptionPieceDevis->GetIdOption());
		$q->bindValue(':IdPiece', $OptionPieceDevis->GetIdPiece());
		$q->execute();
	}

	public function DeleteOptionPieceDevis( $id){
		$this->_Db->exec('DELETE FROM options_pieces_devis WHERE IdOptionsPiecesDevis ='.$id);
	}

	public function GetOptionPieceDevis( $id){
		$q = $this->_Db->prepare('SELECT * FROM options_pieces_devis WHERE IdOptionsPiecesDevis ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$OptionPieceDevis = new OptionPieceDevis($donnees);}
		return $OptionPieceDevis;
	}

	public function GetAllOptionPieceDevis(){
		$OptionPieceDeviss = [];
		$q = $this->_Db->query('SELECT * FROM options_pieces_devis');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$OptionPieceDeviss[] = new OptionPieceDevis($donnees);}
		return $OptionPieceDeviss;
	}

}