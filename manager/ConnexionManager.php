<?php

class ConnexionManager
{

	private $_Db;

	public function __construct($db){$this->setDb($db);}

	public function SetDb(PDO $db){$this->_Db = $db;}

	public function ConnexionUser($psd,$password)
	{
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
					 echo("<div class='alert alert-danger'><strong>Inforamtion :  </strong>Mauvais identifiant ou mot de passe !</div>");

			} else{
			//Mise en place dans des var

			$id = $user->GetIdUser();
			$passbdd = $user->GetPassUser();
			$role = $user->GetRoleUser();
			$psdbdd = $user->GetPseudoUser();
			$siret = $user->GetSiretUser();

			if(!empty($passbdd))
			{
					if (password_verify($password, $passbdd))
					{
							$_SESSION['Id_user'] = $id;
							$_SESSION['Pseudo_user'] = $psdbdd;
							$_SESSION['Role_user'] = $role;
							$_SESSION['Siret_role'] = $siret;
							echo("<div class='alert alert-success'><strong>Connexion.</div>");

							if($role == 1){/* A modif plus tard */

							echo('<meta http-equiv="refresh" content="0;URL=../view/UserView.php">');
					}else{
						echo('<meta http-equiv="refresh" content="0;URL=../view/ClientView.php">');
					}

					}
					else{
							echo("<div class='alert alert-danger'><strong>Inforamtion :  </strong>Mauvais identifiant ou mot de passe !</div>");

					}
			}
			else{
							echo("<div class='alert alert-danger'><strong>Inforamtion :  </strong>Mauvais identifiant ou mot de passe !</div>");
					}
			}
	}

}
