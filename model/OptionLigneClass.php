<?php

class OptionLigne
{
	public $_IdOptionsLignes;
	private $_IdLigne;
	private $_IdOption;
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
	public function GetIdOptionsLignes(){return $this->_IdOptionsLignes;}
	public function GetIdLigne(){return $this->_IdLigne;}
	public function GetIdOption(){return $this->_IdOption;}
	public function GetOriginalObject(){return $this->_OriginalObject;}

	/**SET**/
	public function SetIdOptionsLignes($IdOptionsLignes){$this -> _IdOptionsLignes = $IdOptionsLignes;}
	public function SetIdLigne($IdLigne){$this -> _IdLigne = $IdLigne;}
	public function SetIdOption($IdOption){$this -> _IdOption = $IdOption;}
	public function SetOriginalObject($OriginalObject){$this -> _OriginalObject = $OriginalObject;}

}