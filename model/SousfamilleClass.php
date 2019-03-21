<?php

class Sousfamille
{
	public $_CodeSsFamille;
	private $_LibelleSsFamille;
	private $_CodeFamille;
	private $_RegroupementSsFamille;
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
	public function GetCodeSsFamille(){return $this->_CodeSsFamille;}
	public function GetLibelleSsFamille(){return $this->_LibelleSsFamille;}
	public function GetCodeFamille(){return $this->_CodeFamille;}
	public function GetRegroupementSsFamille(){return $this->_RegroupementSsFamille;}
	public function GetOriginalObject(){return $this->_OriginalObject;}

	/**SET**/
	public function SetCodeSsFamille($CodeSsFamille){$this -> _CodeSsFamille = $CodeSsFamille;}
	public function SetLibelleSsFamille($LibelleSsFamille){$this -> _LibelleSsFamille = $LibelleSsFamille;}
	public function SetCodeFamille($CodeFamille){$this -> _CodeFamille = $CodeFamille;}
	public function SetRegroupementSsFamille($RegroupementSsFamille){$this -> _RegroupementSsFamille = $RegroupementSsFamille;}
	public function SetOriginalObject($OriginalObject){$this -> _OriginalObject = $OriginalObject;}

}