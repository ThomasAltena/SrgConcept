<?php

class OptionCubeDevisManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddOptionCubeDevis(OptionCubeDevis $OptionCubeDevis){
		$q = $this->_Db->prepare('INSERT INTO options_cubes_devis VALUES(:IdOptionsCubeDevis, :IdDevis, :IdOption, :IdPiece)');
		$q->bindValue(':IdOptionsCubeDevis', $OptionCubeDevis->GetIdOptionsCubeDevis());
		$q->bindValue(':IdDevis', $OptionCubeDevis->GetIdDevis());
		$q->bindValue(':IdOption', $OptionCubeDevis->GetIdOption());
		$q->bindValue(':IdPiece', $OptionCubeDevis->GetIdPiece());
		if(!$q->execute()) {
				return [false,$q->errorInfo()];
		} else {
			return [true,$this->_Db->lastInsertId()];
		}
	}

	public function UpdateOptionCubeDevis(OptionCubeDevis $OptionCubeDevis){
		$q = $this->_Db->prepare('UPDATE options_cubes_devis SET `IdDevis` = :IdDevis, `IdOption` = :IdOption, `IdPiece` = :IdPiece WHERE IdOptionsCubeDevis = :IdOptionsCubeDevis ');
		$q->bindValue(':IdOptionsCubeDevis', $OptionCubeDevis->GetIdOptionsCubeDevis());
		$q->bindValue(':IdDevis', $OptionCubeDevis->GetIdDevis());
		$q->bindValue(':IdOption', $OptionCubeDevis->GetIdOption());
		$q->bindValue(':IdPiece', $OptionCubeDevis->GetIdPiece());
		$q->execute();
	}

	public function DeleteOptionCubeDevis( $id){
		$this->_Db->exec('DELETE FROM options_cubes_devis WHERE IdOptionsCubeDevis ='.$id);
	}

	public function GetOptionCubeDevis( $id){
		$q = $this->_Db->prepare('SELECT * FROM options_cubes_devis WHERE IdOptionsCubeDevis ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$OptionCubeDevis = new OptionCubeDevis($donnees);}
		return $OptionCubeDevis;
	}

	public function GetAllOptionCubeDevis(){
		$OptionCubeDeviss = [];
		$q = $this->_Db->query('SELECT * FROM options_cubes_devis');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$OptionCubeDeviss[] = new OptionCubeDevis($donnees);}
		return $OptionCubeDeviss;
	}

}
