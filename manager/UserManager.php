<?php

class UserManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function AddUser(User $User){
		$q = $this->_Db->prepare('INSERT INTO users VALUES(:IdUser, :NomUser, :SiretUser, :AdresseUser, :DateConnexionUser, :PseudoUser, :PassUser, :RoleUser, :IdEntreprise)');
		$q->bindValue(':IdUser', $User->GetIdUser());
		$q->bindValue(':NomUser', $User->GetNomUser());
		$q->bindValue(':SiretUser', $User->GetSiretUser());
		$q->bindValue(':AdresseUser', $User->GetAdresseUser());
		$q->bindValue(':DateConnexionUser', $User->GetDateConnexionUser());
		$q->bindValue(':PseudoUser', $User->GetPseudoUser());
		$q->bindValue(':PassUser', $User->GetPassUser());
		$q->bindValue(':RoleUser', $User->GetRoleUser());
		$q->bindValue(':IdEntreprise', $User->GetIdEntreprise());
		if(!$q->execute()) {
				return [false,$q->errorInfo()];
		} else {
			return [true,$this->_Db->lastInsertId()];
		}
	}

	public function UpdateUser(User $User){
		$q = $this->_Db->prepare('UPDATE users SET `NomUser` = :NomUser, `SiretUser` = :SiretUser, `AdresseUser` = :AdresseUser, `DateConnexionUser` = :DateConnexionUser, `PseudoUser` = :PseudoUser, `PassUser` = :PassUser, `RoleUser` = :RoleUser, `IdEntreprise` = :IdEntreprise WHERE IdUser = :IdUser ');
		$q->bindValue(':IdUser', $User->GetIdUser());
		$q->bindValue(':NomUser', $User->GetNomUser());
		$q->bindValue(':SiretUser', $User->GetSiretUser());
		$q->bindValue(':AdresseUser', $User->GetAdresseUser());
		$q->bindValue(':DateConnexionUser', $User->GetDateConnexionUser());
		$q->bindValue(':PseudoUser', $User->GetPseudoUser());
		$q->bindValue(':PassUser', $User->GetPassUser());
		$q->bindValue(':RoleUser', $User->GetRoleUser());
		$q->bindValue(':IdEntreprise', $User->GetIdEntreprise());
		$q->execute();
	}

	public function DeleteUser($id){
		$this->_Db->exec('DELETE FROM users WHERE IdUser ='.$id);
	}

	public function GetUser($id){
		$q = $this->_Db->prepare('SELECT * FROM users WHERE IdUser ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$User = new User($donnees);}
		return $User;
	}

	public function GetUserAndEntrepriseOriginalObject($id){
		$EntrepriseManager = new EntrepriseManager($this->_Db);
		$q = $this->_Db->prepare('SELECT * FROM users WHERE IdUser ='.$id);
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){
			$User = $donnees;
			$User['entreprise'] = $EntrepriseManager->GetEntreprise($User['IdEntreprise'])->GetOriginalObject();
		}
		return $User;
	}

	public function GetAllUser(){
		$Users = [];
		$q = $this->_Db->query('SELECT * FROM users');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){$Users[] = new User($donnees);}
		return $Users;
	}
}
