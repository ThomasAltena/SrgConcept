<?php

class PieceManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddPiece(Piece $Piece){
		$q = $this->_Db->prepare('INSERT INTO pieces VALUES(:IdPiece, :LibellePiece, :CodePiece, :CheminPiece, :CodeFamille, :CodeSsFamille, :CodeGroupeCube)');
		$q->bindValue(':IdPiece', $Piece->GetIdPiece());
		$q->bindValue(':LibellePiece', $Piece->GetLibellePiece());
		$q->bindValue(':CodePiece', $Piece->GetCodePiece());
		$q->bindValue(':CheminPiece', $Piece->GetCheminPiece());
		$q->bindValue(':CodeFamille', $Piece->GetCodeFamille());
		$q->bindValue(':CodeSsFamille', $Piece->GetCodeSsFamille());
		$q->bindValue(':CodeGroupeCube', $Piece->GetCodeGroupeCube());
		$q->execute();
	}

	public function UpdatePiece(Piece $Piece){
		$q = $this->_Db->prepare('UPDATE pieces SET `LibellePiece` = :LibellePiece, `CodePiece` = :CodePiece, `CheminPiece` = :CheminPiece, `CodeFamille` = :CodeFamille, `CodeSsFamille` = :CodeSsFamille, `CodeGroupeCube` = :CodeGroupeCube WHERE IdPiece = :IdPiece ');
		$q->bindValue(':IdPiece', $Piece->GetIdPiece());
		$q->bindValue(':LibellePiece', $Piece->GetLibellePiece());
		$q->bindValue(':CodePiece', $Piece->GetCodePiece());
		$q->bindValue(':CheminPiece', $Piece->GetCheminPiece());
		$q->bindValue(':CodeFamille', $Piece->GetCodeFamille());
		$q->bindValue(':CodeSsFamille', $Piece->GetCodeSsFamille());
		$q->bindValue(':CodeGroupeCube', $Piece->GetCodeGroupeCube());
		$q->execute();
	}

	public function DeletePiece( $id){
		$this->_Db->exec('DELETE FROM pieces WHERE IdPiece ='.$id);
	}

	public function GetPiece( $id){
		$q = $this->_Db->prepare('SELECT * FROM pieces WHERE IdPiece ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Piece = new Piece($donnees);}
		return $Piece;
	}

	public function GetAllPiece(){
		$Pieces = [];
		$q = $this->_Db->query('SELECT * FROM pieces');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Pieces[] = new Piece($donnees);}
		return $Pieces;
	}

}