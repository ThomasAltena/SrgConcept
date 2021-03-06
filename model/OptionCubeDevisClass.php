<?php

class OptionCubeDevis
{
	public $_IdOptionsCubeDevis;
	private $_IdDevis;
	private $_IdOption;
	private $_IdCubeDevis;
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
	public function GetIdOptionsCubeDevis(){return $this->_IdOptionsCubeDevis;}
	public function GetIdDevis(){return $this->_IdDevis;}
	public function GetIdOption(){return $this->_IdOption;}
	public function GetIdCubeDevis(){return $this->_IdCubeDevis;}
	public function GetOriginalObject(){return $this->_OriginalObject;}

	/**SET**/
	public function SetIdOptionsCubeDevis($IdOptionsCubeDevis){$this -> _IdOptionsCubeDevis = $IdOptionsCubeDevis;}
	public function SetIdDevis($IdDevis){$this -> _IdDevis = $IdDevis;}
	public function SetIdOption($IdOption){$this -> _IdOption = $IdOption;}
	public function SetIdCubeDevis($IdCubeDevis){$this -> _IdCubeDevis = $IdCubeDevis;}
	public function SetOriginalObject($OriginalObject){$this -> _OriginalObject = $OriginalObject;}

}
