<?php

class PieceManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddPieceArray($Piece){
		if(!is_array($Piece)){
			$Piece = get_object_vars($Piece);
		}
		$piece = new Piece($Piece);
		return $this->AddPiece($piece);
	}

	public function AddPiece(Piece $Piece){
		$q = $this->_Db->prepare('INSERT INTO pieces VALUES(:IdPiece, :LibellePiece, :CodePiece, :CheminPiece, :CodeFamille, :CodeSsFamille, :CodeGroupeCube)');
		$q->bindValue(':IdPiece', $Piece->GetIdPiece());
		$q->bindValue(':LibellePiece', $Piece->GetLibellePiece());
		$q->bindValue(':CodePiece', $Piece->GetCodePiece());
		$q->bindValue(':CheminPiece', $Piece->GetCheminPiece());
		$q->bindValue(':CodeFamille', $Piece->GetCodeFamille());
		$q->bindValue(':CodeSsFamille', $Piece->GetCodeSsFamille());
		$q->bindValue(':CodeGroupeCube', $Piece->GetCodeGroupeCube());
		if(!$q->execute()) {
				return [false,$q->errorInfo()];
		} else {
			return $this->_Db->lastInsertId();
		}
	}

	public function UpdatePieceArray($Piece){
		if(!is_array($Piece)){
			$Piece = get_object_vars($Piece);
		}
		$piece = new Piece($Piece);
		$this->UpdatePiece($piece);
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

	public function DeletePiece($id){
		$this->_Db->exec('DELETE FROM pieces WHERE IdPiece ='.$id);
	}

	public function GetPiece($id){
		$q = $this->_Db->prepare('SELECT * FROM pieces WHERE IdPiece ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Piece = new Piece($donnees);}
		return $Piece;
	}

	public function GetAllPiece(){
		$Pieces = [];
		$q = $this->_Db->query('SELECT * FROM pieces');
		if(!empty($q)){
			while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Pieces[] = new Piece($donnees);}
		}
		return $Pieces;
	}

	public function GetPiecesByFamilleSsFamilleFormat($codeFamille, $codeSsFamille, $format){
		$Pieces = [];

		$q = $this->_Db->prepare('SELECT * FROM pieces WHERE CodeFamille = :CodeFamille && CodeSsFamille = :CodeSsFamille && (CodePiece REGEXP :format || CodePiece REGEXP :dualFormat) ORDER BY LibellePiece ASC');
		$q->bindValue(':CodeFamille', $codeFamille);
		$q->bindValue(':CodeSsFamille', $codeSsFamille);
		$q->bindValue(':dualFormat', "^SD");

	  if($format == 'simple'){
			$q->bindValue(':format', "^S");
	  } else {
			$q->bindValue(':format', "^D");
	  }

		$q->execute();
		if(!empty($q)){
			while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Pieces[] = new Piece($donnees);}
		}
		return $Pieces;
	}
}
