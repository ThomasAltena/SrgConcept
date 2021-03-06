<?php

class Famille
{
	public $_CodeFamille;
	private $_LibelleFamille;
	private $_RegroupementFamille;
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
	public function GetCodeFamille(){return $this->_CodeFamille;}
	public function GetLibelleFamille(){return $this->_LibelleFamille;}
	public function GetRegroupementFamille(){return $this->_RegroupementFamille;}
	public function GetOriginalObject(){return $this->_OriginalObject;}

	/**SET**/
	public function SetCodeFamille($CodeFamille){$this -> _CodeFamille = $CodeFamille;}
	public function SetLibelleFamille($LibelleFamille){$this -> _LibelleFamille = $LibelleFamille;}
	public function SetRegroupementFamille($RegroupementFamille){$this -> _RegroupementFamille = $RegroupementFamille;}
	public function SetOriginalObject($OriginalObject){$this -> _OriginalObject = $OriginalObject;}

}