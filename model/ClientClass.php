<?php

class Client
{
	public $_IdClient;
	private $_NomClient;
	private $_PrenomClient;
	private $_AdresseClient;
	private $_CodePostalClient;
	private $_VilleClient;
	private $_TelClient;
	private $_MailClient;
	private $_DateCreationClient;
	private $_ProspectClient;
	private $_IdUser;

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
	public function GetIdClient(){return $this->_IdClient;}
	public function GetNomClient(){return $this->_NomClient;}
	public function GetPrenomClient(){return $this->_PrenomClient;}
	public function GetAdresseClient(){return $this->_AdresseClient;}
	public function GetCodePostalClient(){return $this->_CodePostalClient;}
	public function GetVilleClient(){return $this->_VilleClient;}
	public function GetTelClient(){return $this->_TelClient;}
	public function GetMailClient(){return $this->_MailClient;}
	public function GetDateCreationClient(){return $this->_DateCreationClient;}
	public function GetProspectClient(){return $this->_ProspectClient;}
	public function GetIdUser(){return $this->_IdUser;}

	/**SET**/
	public function SetIdClient($IdClient){$this -> _IdClient = $IdClient;}
	public function SetNomClient($NomClient){$this -> _NomClient = $NomClient;}
	public function SetPrenomClient($PrenomClient){$this -> _PrenomClient = $PrenomClient;}
	public function SetAdresseClient($AdresseClient){$this -> _AdresseClient = $AdresseClient;}
	public function SetCodePostalClient($CodePostalClient){$this -> _CodePostalClient = $CodePostalClient;}
	public function SetVilleClient($VilleClient){$this -> _VilleClient = $VilleClient;}
	public function SetTelClient($TelClient){$this -> _TelClient = $TelClient;}
	public function SetMailClient($MailClient){$this -> _MailClient = $MailClient;}
	public function SetDateCreationClient($DateCreationClient){$this -> _DateCreationClient = $DateCreationClient;}
	public function SetProspectClient($ProspectClient){$this -> _ProspectClient = $ProspectClient;}
	public function SetIdUser($IdUser){$this -> _IdUser = $IdUser;}

}