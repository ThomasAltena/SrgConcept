<?php

class OptionPiece
{
	public $_IdOptionsPieces;
	private $_IdOption;
	private $_IdPiece;

	public function __construct(array $donnees)
	{
		$this->hydrate($donnees);
	}

	public function hydrate(array $donnees)
	{
		if(isset($donnees)){
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
	public function GetIdOptionsPieces(){return $this->_IdOptionsPieces;}
	public function GetIdOption(){return $this->_IdOption;}
	public function GetIdPiece(){return $this->_IdPiece;}

	/**SET**/
	public function SetIdOptionsPieces($IdOptionsPieces){$this -> _IdOptionsPieces = $IdOptionsPieces;}
	public function SetIdOption($IdOption){$this -> _IdOption = $IdOption;}
	public function SetIdPiece($IdPiece){$this -> _IdPiece = $IdPiece;}

}