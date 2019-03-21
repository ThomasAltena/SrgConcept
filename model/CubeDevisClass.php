<?php

class CubeDevis
{
	public $_IdCubeDevis;
	private $_HauteurCubeDevis;
	private $_LargeurCubeDevis;
	private $_ProfondeurCubeDevis;
	private $_IdDevis;
	private $_IdPiece;
	private $_IdCube;
	private $_AvantPolisCube;
	private $_AvantScieeCube;
	private $_ArrierePolisCube;
	private $_ArriereScieeCube;
	private $_DroitePolisCube;
	private $_DroiteScieeCube;
	private $_GauchePolisCube;
	private $_GaucheScieeCube;
	private $_DessusPolisCube;
	private $_DessusScieeCube;
	private $_DessousPolisCube;
	private $_DessousScieeCube;
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
	public function GetIdCubeDevis(){return $this->_IdCubeDevis;}
	public function GetHauteurCubeDevis(){return $this->_HauteurCubeDevis;}
	public function GetLargeurCubeDevis(){return $this->_LargeurCubeDevis;}
	public function GetProfondeurCubeDevis(){return $this->_ProfondeurCubeDevis;}
	public function GetIdDevis(){return $this->_IdDevis;}
	public function GetIdPiece(){return $this->_IdPiece;}
	public function GetIdCube(){return $this->_IdCube;}
	public function GetAvantPolisCube(){return $this->_AvantPolisCube;}
	public function GetAvantScieeCube(){return $this->_AvantScieeCube;}
	public function GetArrierePolisCube(){return $this->_ArrierePolisCube;}
	public function GetArriereScieeCube(){return $this->_ArriereScieeCube;}
	public function GetDroitePolisCube(){return $this->_DroitePolisCube;}
	public function GetDroiteScieeCube(){return $this->_DroiteScieeCube;}
	public function GetGauchePolisCube(){return $this->_GauchePolisCube;}
	public function GetGaucheScieeCube(){return $this->_GaucheScieeCube;}
	public function GetDessusPolisCube(){return $this->_DessusPolisCube;}
	public function GetDessusScieeCube(){return $this->_DessusScieeCube;}
	public function GetDessousPolisCube(){return $this->_DessousPolisCube;}
	public function GetDessousScieeCube(){return $this->_DessousScieeCube;}
	public function GetOriginalObject(){return $this->_OriginalObject;}

	/**SET**/
	public function SetIdCubeDevis($IdCubeDevis){$this -> _IdCubeDevis = $IdCubeDevis;}
	public function SetHauteurCubeDevis($HauteurCubeDevis){$this -> _HauteurCubeDevis = $HauteurCubeDevis;}
	public function SetLargeurCubeDevis($LargeurCubeDevis){$this -> _LargeurCubeDevis = $LargeurCubeDevis;}
	public function SetProfondeurCubeDevis($ProfondeurCubeDevis){$this -> _ProfondeurCubeDevis = $ProfondeurCubeDevis;}
	public function SetIdDevis($IdDevis){$this -> _IdDevis = $IdDevis;}
	public function SetIdPiece($IdPiece){$this -> _IdPiece = $IdPiece;}
	public function SetIdCube($IdCube){$this -> _IdCube = $IdCube;}
	public function SetAvantPolisCube($AvantPolisCube){$this -> _AvantPolisCube = $AvantPolisCube;}
	public function SetAvantScieeCube($AvantScieeCube){$this -> _AvantScieeCube = $AvantScieeCube;}
	public function SetArrierePolisCube($ArrierePolisCube){$this -> _ArrierePolisCube = $ArrierePolisCube;}
	public function SetArriereScieeCube($ArriereScieeCube){$this -> _ArriereScieeCube = $ArriereScieeCube;}
	public function SetDroitePolisCube($DroitePolisCube){$this -> _DroitePolisCube = $DroitePolisCube;}
	public function SetDroiteScieeCube($DroiteScieeCube){$this -> _DroiteScieeCube = $DroiteScieeCube;}
	public function SetGauchePolisCube($GauchePolisCube){$this -> _GauchePolisCube = $GauchePolisCube;}
	public function SetGaucheScieeCube($GaucheScieeCube){$this -> _GaucheScieeCube = $GaucheScieeCube;}
	public function SetDessusPolisCube($DessusPolisCube){$this -> _DessusPolisCube = $DessusPolisCube;}
	public function SetDessusScieeCube($DessusScieeCube){$this -> _DessusScieeCube = $DessusScieeCube;}
	public function SetDessousPolisCube($DessousPolisCube){$this -> _DessousPolisCube = $DessousPolisCube;}
	public function SetDessousScieeCube($DessousScieeCube){$this -> _DessousScieeCube = $DessousScieeCube;}
	public function SetOriginalObject($OriginalObject){$this -> _OriginalObject = $OriginalObject;}

}