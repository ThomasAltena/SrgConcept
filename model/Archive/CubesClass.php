<?php

class Client
{
	public $_CodeCube;
	private $_NumeroCube;
	private $_CodePostalClient;
	private $_DateCreationClient;
	private $_MailClient;
	private $_NomClient;
	private $_PrenomClient;
	private $_ProspectClient;
	private $_TelClient;
	private $_VilleClient;
	private $_IdUser;

	//constructeur
	public function __construct(array $donnees)
	{
		$this->hydrate($donnees);
	}

	//*Hydratation de l'objet *//
	public function hydrate(array $donnees)
	{
		if(isset($donnees)){
			foreach ($donnees as $key => $value)
			{
				// Setter
				$method = 'Set'.ucfirst($key);

				// Si le setter correspondant existe.
				if (method_exists($this, $method))
				{
					// On appelle le setter.
					$this->$method($value);
				}
			}
		}

	}

	/**GET**/
	public function GetCode(){return $this->_CodeCube;}
	public function GetAdresse() {return $this->_NumeroCube;}
	public function GetCodePostal() {return $this->_CodePostalClient;}
	public function GetDateCreation() {return $this->_DateCreationClient;}
	public function GetMail() {return $this->_MailClient;}
	public function GetNom() {return $this->_NomClient;}
	public function GetPrenom() {return $this->_PrenomClient;}
	public function GetProspect() {return $this->_ProspectClient;}
	public function GetTel() {return $this->_TelClient;}
	public function GetVille() {return $this->_VilleClient;}
	public function GetIdUser() {return $this->_IdUser;}

	/**SET**/
	public function SetCode($x){$this -> _CodeCube = (int) $x;}
	public function SetAdresse($x){$this -> _NumeroCube = $x;}
	public function SetCodePostal($x){$this -> _CodePostalClient = $x;}
	public function SetDateCrea($x){$this -> _DateCreationClient = $x;}
	public function SetMail($x){$this -> _MailClient = $x;}
	public function SetNom($x){$this -> _NomClient = $x;}
	public function SetPrenom($x){$this -> _PrenomClient = $x;}
	public function SetProspect($x){$this -> _ProspectClient = $x;}
	public function SetTel($x){$this -> _TelClient = $x;}
	public function SetVille($x){$this -> _VilleClient = $x;}
	public function SetIdUser($x){$this -> _IdUserClient = $x;}

}
