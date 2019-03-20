<?php

class OptionPieceManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddOptionPiece(OptionPiece $OptionPiece){
		$q = $this->_Db->prepare('INSERT INTO options_pieces VALUES(:IdOptionsPieces, :IdOption, :IdPiece)');
		$q->bindValue(':IdOptionsPieces', $OptionPiece->GetIdOptionsPieces());
		$q->bindValue(':IdOption', $OptionPiece->GetIdOption());
		$q->bindValue(':IdPiece', $OptionPiece->GetIdPiece());
		$q->execute();
	}

	public function UpdateOptionPiece(OptionPiece $OptionPiece){
		$q = $this->_Db->prepare('UPDATE options_pieces SET `IdOption` = :IdOption, `IdPiece` = :IdPiece WHERE IdOptionsPieces = :IdOptionsPieces ');
		$q->bindValue(':IdOptionsPieces', $OptionPiece->GetIdOptionsPieces());
		$q->bindValue(':IdOption', $OptionPiece->GetIdOption());
		$q->bindValue(':IdPiece', $OptionPiece->GetIdPiece());
		$q->execute();
	}

	public function DeleteOptionPiece( $id){
		$this->_Db->exec('DELETE FROM options_pieces WHERE IdOptionsPieces ='.$id);
	}

	public function GetOptionPiece( $id){
		$q = $this->_Db->prepare('SELECT * FROM options_pieces WHERE IdOptionsPieces ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$OptionPiece = new OptionPiece($donnees);}
		return $OptionPiece;
	}

	public function GetAllOptionPiece(){
		$OptionPieces = [];
		$q = $this->_Db->query('SELECT * FROM options_pieces');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$OptionPieces[] = new OptionPiece($donnees);}
		return $OptionPieces;
	}

}