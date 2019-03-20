<?php

class TvaManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddTva(Tva $Tva){
		$q = $this->_Db->prepare('INSERT INTO tva VALUES(:IdTva, :TauxTva)');
		$q->bindValue(':IdTva', $Tva->GetIdTva());
		$q->bindValue(':TauxTva', $Tva->GetTauxTva());
		$q->execute();
	}

	public function UpdateTva(Tva $Tva){
		$q = $this->_Db->prepare('UPDATE tva SET `TauxTva` = :TauxTva WHERE IdTva = :IdTva ');
		$q->bindValue(':IdTva', $Tva->GetIdTva());
		$q->bindValue(':TauxTva', $Tva->GetTauxTva());
		$q->execute();
	}

	public function DeleteTva( $id){
		$this->_Db->exec('DELETE FROM tva WHERE IdTva ='.$id);
	}

	public function GetTva( $id){
		$q = $this->_Db->prepare('SELECT * FROM tva WHERE IdTva ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Tva = new Tva($donnees);}
		return $Tva;
	}

	public function GetAllTva(){
		$Tvas = [];
		$q = $this->_Db->query('SELECT * FROM tva');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Tvas[] = new Tva($donnees);}
		return $Tvas;
	}

}