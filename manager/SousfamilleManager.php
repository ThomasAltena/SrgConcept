<?php

class SousfamilleManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddSousfamille(Sousfamille $Sousfamille){
		$q = $this->_Db->prepare('INSERT INTO sousfamilles VALUES(:CodeSsFamille, :LibelleSsFamille, :CodeFamille, :RegroupementSsFamille)');
		$q->bindValue(':CodeSsFamille', $Sousfamille->GetCodeSsFamille());
		$q->bindValue(':LibelleSsFamille', $Sousfamille->GetLibelleSsFamille());
		$q->bindValue(':CodeFamille', $Sousfamille->GetCodeFamille());
		$q->bindValue(':RegroupementSsFamille', $Sousfamille->GetRegroupementSsFamille());
		$q->execute();
	}

	public function UpdateSousfamille(Sousfamille $Sousfamille){
		$q = $this->_Db->prepare('UPDATE sousfamilles SET `LibelleSsFamille` = :LibelleSsFamille, `CodeFamille` = :CodeFamille, `RegroupementSsFamille` = :RegroupementSsFamille WHERE CodeSsFamille = :CodeSsFamille ');
		$q->bindValue(':CodeSsFamille', $Sousfamille->GetCodeSsFamille());
		$q->bindValue(':LibelleSsFamille', $Sousfamille->GetLibelleSsFamille());
		$q->bindValue(':CodeFamille', $Sousfamille->GetCodeFamille());
		$q->bindValue(':RegroupementSsFamille', $Sousfamille->GetRegroupementSsFamille());
		$q->execute();
	}

	public function DeleteSousfamille($id){
		$this->_Db->exec('DELETE FROM sousfamilles WHERE CodeSsFamille ='.$id);
	}

	public function GetSousfamille($id){
		$q = $this->_Db->prepare('SELECT * FROM sousfamilles WHERE CodeSsFamille ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Sousfamille = new Sousfamille($donnees);}
		return $Sousfamille;
	}

	public function GetAllSousfamille(){
		$Sousfamilles = [];
		$q = $this->_Db->query('SELECT * FROM sousfamilles');
		if(!empty($q)){
			while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Sousfamilles[] = new Sousfamille($donnees);}
		}
		return $Sousfamilles;
	}

	public function GetSousfamilleByFamilleOrderByRegroupement($codeFamille){
		$Sousfamilles = [];
		$q = $this->_Db->prepare('SELECT * FROM sousfamilles WHERE CodeFamille = :CodeFamille ORDER BY RegroupementSsFamille ASC, LibelleSsFamille ASC');
		$q->bindValue(':CodeFamille', $codeFamille);
		$q->execute();
		if(!empty($q)){
			while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Sousfamilles[] = new Sousfamille($donnees);}
		}
		return $Sousfamilles;
	}

}
