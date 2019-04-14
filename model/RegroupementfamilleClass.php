<?php

class Regroupementfamille
{
	public $_IdRegroupementFamille;
	private $_LibelleRegroupementFamille;
	private $_PositionRegroupementFamille;
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
	public function GetIdRegroupementFamille(){return $this->_IdRegroupementFamille;}
	public function GetLibelleRegroupementFamille(){return $this->_LibelleRegroupementFamille;}
	public function GetPositionRegroupementFamille(){return $this->_PositionRegroupementFamille;}
	public function GetOriginalObject(){return $this->_OriginalObject;}

	/**SET**/
	public function SetIdRegroupementFamille($IdRegroupementFamille){$this -> _IdRegroupementFamille = $IdRegroupementFamille;}
	public function SetLibelleRegroupementFamille($LibelleRegroupementFamille){$this -> _LibelleRegroupementFamille = $LibelleRegroupementFamille;}
	public function SetPositionRegroupementFamille($PositionRegroupementFamille){$this -> _PositionRegroupementFamille = $PositionRegroupementFamille;}
	public function SetOriginalObject($OriginalObject){$this -> _OriginalObject = $OriginalObject;}

}