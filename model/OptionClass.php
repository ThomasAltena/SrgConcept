<?php

class Option
{
	public $_IdOption;
	private $_LibelleOption;
	private $_CodeOption;
	private $_PrixOption;
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
	public function GetLibelleOption(){return $this->_LibelleOption;}
	public function GetCodeOption(){return $this->_CodeOption;}
	public function GetPrixOption(){return $this->_PrixOption;}
	public function GetOriginalObject(){return $this->_OriginalObject;}

	/**SET**/
	public function SetIdOption($IdOption){$this -> _IdOption = $IdOption;}
	public function SetLibelleOption($LibelleOption){$this -> _LibelleOption = $LibelleOption;}
	public function SetCodeOption($CodeOption){$this -> _CodeOption = $CodeOption;}
	public function SetPrixOption($PrixOption){$this -> _PrixOption = $PrixOption;}
	public function SetOriginalObject($OriginalObject){$this -> _OriginalObject = $OriginalObject;}

}