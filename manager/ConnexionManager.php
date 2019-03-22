<?php

class ConnexionManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function ConnexionUser($psd,$password)
	{
		$result = '';
		//preparation
		$q=$this->_Db->prepare('SELECT * From users Where PseudoUser = :psd');
		$q->bindValue(':psd', $psd);
		$q->execute();

		//Assignation valeur
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$user = new User($donnees);
		}

		if(!isset($user)){
			$result = "WrongLogin";
		} else{
			//Mise en place dans des var
			$id = $user->GetIdUser();
			$passbdd = $user->GetPassUser();
			$role = $user->GetRoleUser();
			$psdbdd = $user->GetPseudoUser();
			$siret = $user->GetSiretUser();

			if(!empty($passbdd)) {
				if (password_verify($password, $passbdd))
				{
					$_SESSION['Id_user'] = $id;
					$_SESSION['Pseudo_user'] = $psdbdd;
					$_SESSION['Role_user'] = $role;
					$_SESSION['Siret_role'] = $siret;
					$result = "Success";
				}	else {
					$result = "WrongLogin";
				}
			}	else {
				$result = "WrongLogin";
			}
		}
		return $result;
	}
}
