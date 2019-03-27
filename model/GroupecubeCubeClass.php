<?php

class GroupecubeCube
{
	public $_IdGroupCubeCubes;
	private $_IdCube;
	private $_CodeGroupeCube;
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
	public function GetIdGroupCubeCubes(){return $this->_IdGroupCubeCubes;}
	public function GetIdCube(){return $this->_IdCube;}
	public function GetCodeGroupeCube(){return $this->_CodeGroupeCube;}
	public function GetOriginalObject(){return $this->_OriginalObject;}

	/**SET**/
	public function SetIdGroupCubeCubes($IdGroupCubeCubes){$this -> _IdGroupCubeCubes = $IdGroupCubeCubes;}
	public function SetIdCube($IdCube){$this -> _IdCube = $IdCube;}
	public function SetCodeGroupeCube($CodeGroupeCube){$this -> _CodeGroupeCube = $CodeGroupeCube;}
	public function SetOriginalObject($OriginalObject){$this -> _OriginalObject = $OriginalObject;}

}