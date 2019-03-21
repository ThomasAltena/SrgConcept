<?php

class Devis
{
	public $_IdDevis;
	private $_DateDevis;
	private $_IdClient;
	private $_IdUser;
	private $_CheminSchemaDevis;
	private $_ArchiveDevis;
	private $_CheminFicheFabDevis;
	private $_RemiseDevis;
	private $_FormatDevis;
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
	public function GetIdDevis(){return $this->_IdDevis;}
	public function GetDateDevis(){return $this->_DateDevis;}
	public function GetIdClient(){return $this->_IdClient;}
	public function GetIdUser(){return $this->_IdUser;}
	public function GetCheminSchemaDevis(){return $this->_CheminSchemaDevis;}
	public function GetArchiveDevis(){return $this->_ArchiveDevis;}
	public function GetCheminFicheFabDevis(){return $this->_CheminFicheFabDevis;}
	public function GetRemiseDevis(){return $this->_RemiseDevis;}
	public function GetFormatDevis(){return $this->_FormatDevis;}
	public function GetOriginalObject(){return $this->_OriginalObject;}

	/**SET**/
	public function SetIdDevis($IdDevis){$this -> _IdDevis = $IdDevis;}
	public function SetDateDevis($DateDevis){$this -> _DateDevis = $DateDevis;}
	public function SetIdClient($IdClient){$this -> _IdClient = $IdClient;}
	public function SetIdUser($IdUser){$this -> _IdUser = $IdUser;}
	public function SetCheminSchemaDevis($CheminSchemaDevis){$this -> _CheminSchemaDevis = $CheminSchemaDevis;}
	public function SetArchiveDevis($ArchiveDevis){$this -> _ArchiveDevis = $ArchiveDevis;}
	public function SetCheminFicheFabDevis($CheminFicheFabDevis){$this -> _CheminFicheFabDevis = $CheminFicheFabDevis;}
	public function SetRemiseDevis($RemiseDevis){$this -> _RemiseDevis = $RemiseDevis;}
	public function SetFormatDevis($FormatDevis){$this -> _FormatDevis = $FormatDevis;}
	public function SetOriginalObject($OriginalObject){$this -> _OriginalObject = $OriginalObject;}

}
