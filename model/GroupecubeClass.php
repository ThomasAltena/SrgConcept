<?php

class Groupecube
{
	public $_CodeGroupeCube;
	private $_LibelleGroupeCube;
	private $_NombreGroupeCube;
	private $_Regroupement;
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
	public function GetCodeGroupeCube(){return $this->_CodeGroupeCube;}
	public function GetLibelleGroupeCube(){return $this->_LibelleGroupeCube;}
	public function GetNombreGroupeCube(){return $this->_NombreGroupeCube;}
	public function GetRegroupement(){return $this->_Regroupement;}
	public function GetOriginalObject(){return $this->_OriginalObject;}

	/**SET**/
	public function SetCodeGroupeCube($CodeGroupeCube){$this -> _CodeGroupeCube = $CodeGroupeCube;}
	public function SetLibelleGroupeCube($LibelleGroupeCube){$this -> _LibelleGroupeCube = $LibelleGroupeCube;}
	public function SetNombreGroupeCube($NombreGroupeCube){$this -> _NombreGroupeCube = $NombreGroupeCube;}
	public function SetRegroupement($Regroupement){$this -> _Regroupement = $Regroupement;}
	public function SetOriginalObject($OriginalObject){$this -> _OriginalObject = $OriginalObject;}

}