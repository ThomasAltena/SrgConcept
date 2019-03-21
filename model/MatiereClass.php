<?php

class Matiere
{
	public $_IdMatiere;
	private $_CodeMatiere;
	private $_LibelleMatiere;
	private $_PrixMatiere;
	private $_CheminMatiere;
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
	public function GetIdMatiere(){return $this->_IdMatiere;}
	public function GetCodeMatiere(){return $this->_CodeMatiere;}
	public function GetLibelleMatiere(){return $this->_LibelleMatiere;}
	public function GetPrixMatiere(){return $this->_PrixMatiere;}
	public function GetCheminMatiere(){return $this->_CheminMatiere;}
	public function GetOriginalObject(){return $this->_OriginalObject;}

	/**SET**/
	public function SetIdMatiere($IdMatiere){$this -> _IdMatiere = $IdMatiere;}
	public function SetCodeMatiere($CodeMatiere){$this -> _CodeMatiere = $CodeMatiere;}
	public function SetLibelleMatiere($LibelleMatiere){$this -> _LibelleMatiere = $LibelleMatiere;}
	public function SetPrixMatiere($PrixMatiere){$this -> _PrixMatiere = $PrixMatiere;}
	public function SetCheminMatiere($CheminMatiere){$this -> _CheminMatiere = $CheminMatiere;}
	public function SetOriginalObject($OriginalObject){$this -> _OriginalObject = $OriginalObject;}

}