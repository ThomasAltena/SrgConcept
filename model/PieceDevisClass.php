<?php

class PieceDevis
{
	public $_IdPieceDevis;
	private $_IdPiece;
	private $_IdDevis;
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
	public function GetIdPieceDevis(){return $this->_IdPieceDevis;}
	public function GetIdPiece(){return $this->_IdPiece;}
	public function GetIdDevis(){return $this->_IdDevis;}
	public function GetOriginalObject(){return $this->_OriginalObject;}

	/**SET**/
	public function SetIdPieceDevis($IdPieceDevis){$this -> _IdPieceDevis = $IdPieceDevis;}
	public function SetIdPiece($IdPiece){$this -> _IdPiece = $IdPiece;}
	public function SetIdDevis($IdDevis){$this -> _IdDevis = $IdDevis;}
	public function SetOriginalObject($OriginalObject){$this -> _OriginalObject = $OriginalObject;}

}