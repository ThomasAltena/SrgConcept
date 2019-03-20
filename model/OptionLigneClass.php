<?php

class OptionLigne
{
	public $_IdOptionsLignes;
	private $_IdLigne;
	private $_IdOption;

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
	public function GetIdOptionsLignes(){return $this->_IdOptionsLignes;}
	public function GetIdLigne(){return $this->_IdLigne;}
	public function GetIdOption(){return $this->_IdOption;}

	/**SET**/
	public function SetIdOptionsLignes($IdOptionsLignes){$this -> _IdOptionsLignes = $IdOptionsLignes;}
	public function SetIdLigne($IdLigne){$this -> _IdLigne = $IdLigne;}
	public function SetIdOption($IdOption){$this -> _IdOption = $IdOption;}

}