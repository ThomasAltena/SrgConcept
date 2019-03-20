<?php

class Entreprise
{
	public $_IdEntreprise;
	private $_SiretEntreprise;
	private $_LibelleEntreprise;
	private $_AdresseEntreprise;
	private $_RoleEntreprise;

	public function __construct(array $donnees)
	{
		$this->hydrate($donnees);
	}

	public function hydrate(array $donnees)
	{
		if(isset($donnees)){
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
	public function GetIdEntreprise(){return $this->_IdEntreprise;}
	public function GetSiretEntreprise(){return $this->_SiretEntreprise;}
	public function GetLibelleEntreprise(){return $this->_LibelleEntreprise;}
	public function GetAdresseEntreprise(){return $this->_AdresseEntreprise;}
	public function GetRoleEntreprise(){return $this->_RoleEntreprise;}

	/**SET**/
	public function SetIdEntreprise($IdEntreprise){$this -> _IdEntreprise = $IdEntreprise;}
	public function SetSiretEntreprise($SiretEntreprise){$this -> _SiretEntreprise = $SiretEntreprise;}
	public function SetLibelleEntreprise($LibelleEntreprise){$this -> _LibelleEntreprise = $LibelleEntreprise;}
	public function SetAdresseEntreprise($AdresseEntreprise){$this -> _AdresseEntreprise = $AdresseEntreprise;}
	public function SetRoleEntreprise($RoleEntreprise){$this -> _RoleEntreprise = $RoleEntreprise;}

}