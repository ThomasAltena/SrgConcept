<?php

class Option
{
	public $_IdOption;
	private $_CodeOption;
	private $_LibelleOption;
	private $_DureeOption;
	private $_UniteOption;
	private $_Cote1Option;
	private $_Cote2Option;
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
	public function GetIdOption(){return $this->_IdOption;}
	public function GetCodeOption(){return $this->_CodeOption;}
	public function GetLibelleOption(){return $this->_LibelleOption;}
	public function GetDureeOption(){return $this->_DureeOption;}
	public function GetUniteOption(){return $this->_UniteOption;}
	public function GetCote1Option(){return $this->_Cote1Option;}
	public function GetCote2Option(){return $this->_Cote2Option;}
	public function GetOriginalObject(){return $this->_OriginalObject;}

	/**SET**/
	public function SetIdOption($IdOption){$this -> _IdOption = $IdOption;}
	public function SetCodeOption($CodeOption){$this -> _CodeOption = $CodeOption;}
	public function SetLibelleOption($LibelleOption){$this -> _LibelleOption = $LibelleOption;}
	public function SetDureeOption($DureeOption){$this -> _DureeOption = $DureeOption;}
	public function SetUniteOption($UniteOption){$this -> _UniteOption = $UniteOption;}
	public function SetCote1Option($Cote1Option){$this -> _Cote1Option = $Cote1Option;}
	public function SetCote2Option($Cote2Option){$this -> _Cote2Option = $Cote2Option;}
	public function SetOriginalObject($OriginalObject){$this -> _OriginalObject = $OriginalObject;}

}