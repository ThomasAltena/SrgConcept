<?php

class Sousfamille
{
	public $_CodeSsFamille;
	private $_LibelleSsFamille;
	private $_CodeFamille;
	private $_RegroupementSsFamille;

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
	public function GetCodeSsFamille(){return $this->_CodeSsFamille;}
	public function GetLibelleSsFamille(){return $this->_LibelleSsFamille;}
	public function GetCodeFamille(){return $this->_CodeFamille;}
	public function GetRegroupementSsFamille(){return $this->_RegroupementSsFamille;}

	/**SET**/
	public function SetCodeSsFamille($CodeSsFamille){$this -> _CodeSsFamille = $CodeSsFamille;}
	public function SetLibelleSsFamille($LibelleSsFamille){$this -> _LibelleSsFamille = $LibelleSsFamille;}
	public function SetCodeFamille($CodeFamille){$this -> _CodeFamille = $CodeFamille;}
	public function SetRegroupementSsFamille($RegroupementSsFamille){$this -> _RegroupementSsFamille = $RegroupementSsFamille;}

}