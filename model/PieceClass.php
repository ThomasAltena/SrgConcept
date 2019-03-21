<?php

class Piece
{
	public $_IdPiece;
	private $_LibellePiece;
	private $_CodePiece;
	private $_CheminPiece;
	private $_CodeFamille;
	private $_CodeSsFamille;
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
	public function GetIdPiece(){return $this->_IdPiece;}
	public function GetLibellePiece(){return $this->_LibellePiece;}
	public function GetCodePiece(){return $this->_CodePiece;}
	public function GetCheminPiece(){return $this->_CheminPiece;}
	public function GetCodeFamille(){return $this->_CodeFamille;}
	public function GetCodeSsFamille(){return $this->_CodeSsFamille;}
	public function GetCodeGroupeCube(){return $this->_CodeGroupeCube;}
	public function GetOriginalObject(){return $this->_OriginalObject;}

	/**SET**/
	public function SetIdPiece($IdPiece){$this -> _IdPiece = $IdPiece;}
	public function SetLibellePiece($LibellePiece){$this -> _LibellePiece = $LibellePiece;}
	public function SetCodePiece($CodePiece){$this -> _CodePiece = $CodePiece;}
	public function SetCheminPiece($CheminPiece){$this -> _CheminPiece = $CheminPiece;}
	public function SetCodeFamille($CodeFamille){$this -> _CodeFamille = $CodeFamille;}
	public function SetCodeSsFamille($CodeSsFamille){$this -> _CodeSsFamille = $CodeSsFamille;}
	public function SetCodeGroupeCube($CodeGroupeCube){$this -> _CodeGroupeCube = $CodeGroupeCube;}
	public function SetOriginalObject($OriginalObject){$this -> _OriginalObject = $OriginalObject;}

}