<?php

class Tva
{
	public $_IdTva;
	private $_TauxTva;
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
	public function GetIdTva(){return $this->_IdTva;}
	public function GetTauxTva(){return $this->_TauxTva;}
	public function GetOriginalObject(){return $this->_OriginalObject;}

	/**SET**/
	public function SetIdTva($IdTva){$this -> _IdTva = $IdTva;}
	public function SetTauxTva($TauxTva){$this -> _TauxTva = $TauxTva;}
	public function SetOriginalObject($OriginalObject){$this -> _OriginalObject = $OriginalObject;}

}