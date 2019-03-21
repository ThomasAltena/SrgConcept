<?php

class User
{
	public $_IdUser;
	private $_NomUser;
	private $_SiretUser;
	private $_AdresseUser;
	private $_DateConnexionUser;
	private $_PseudoUser;
	private $_PassUser;
	private $_RoleUser;
	private $_IdEntreprise;
	private $_OriginalObject;

	public function __construct(array $donnees)
	{
		$this->hydrate($donnees);
	}

	public function hydrate(array $donnees)
	{
		if(isset($donnees)){
			$this->SetOriginalObject($donnees);
			foreach ($donnees as $key => $value)
			{
				$method = 'Set'.ucfirst($key);
				if (method_exists($this, $method))
				{
					$this->$method($value);
				}
			}
		}
	}

	/**GET**/
	public function GetIdUser(){return $this->_IdUser;}
	public function GetNomUser(){return $this->_NomUser;}
	public function GetSiretUser(){return $this->_SiretUser;}
	public function GetAdresseUser(){return $this->_AdresseUser;}
	public function GetDateConnexionUser(){return $this->_DateConnexionUser;}
	public function GetPseudoUser(){return $this->_PseudoUser;}
	public function GetPassUser(){return $this->_PassUser;}
	public function GetRoleUser(){return $this->_RoleUser;}
	public function GetIdEntreprise(){return $this->_IdEntreprise;}
	public function GetOriginalObject(){return $this->_OriginalObject;}

	/**SET**/
	public function SetIdUser($IdUser){$this -> _IdUser = $IdUser;}
	public function SetNomUser($NomUser){$this -> _NomUser = $NomUser;}
	public function SetSiretUser($SiretUser){$this -> _SiretUser = $SiretUser;}
	public function SetAdresseUser($AdresseUser){$this -> _AdresseUser = $AdresseUser;}
	public function SetDateConnexionUser($DateConnexionUser){$this -> _DateConnexionUser = $DateConnexionUser;}
	public function SetPseudoUser($PseudoUser){$this -> _PseudoUser = $PseudoUser;}
	public function SetPassUser($PassUser){$this -> _PassUser = $PassUser;}
	public function SetRoleUser($RoleUser){$this -> _RoleUser = $RoleUser;}
	public function SetIdEntreprise($IdEntreprise){$this -> _IdEntreprise = $IdEntreprise;}
	public function SetOriginalObject($OriginalObject){$this -> _OriginalObject = $OriginalObject;}

}