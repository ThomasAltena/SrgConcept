<?php

class Piece
{
	private $_Id;
	private $_Libelle;
  private $_Code;
	private $_CodeSs;
	private $_CodeFamille;
  private $_Chemin;

	//constructeur
    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }


    //*Hydratation de l'objet *//
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value)
        {

            // Setter
            $method = 'Set'.ucfirst($key);
            $method = substr($method, 0, -6);

            // Si le setter correspondant existe.
            if (method_exists($this, $method))
            {
             	// On appelle le setter.
                $this->$method($value);
            }
        }

    }

    //*get//
    public function GetId(){return $this->_Id;}
    public function GetLibelle(){return $this->_Libelle;}
		public function GetCode(){return $this->_Code;}
		public function GetCodeSs(){return $this->_CodeSs;}
		public function GetCodeFamille(){return $this->_CodeFamille;}
    public function GetChemin(){return $this->_Chemin;}

    //*set*//
    public function SetId($id){$this -> _Id = (int) $id;}
    public function SetLibelle($libelle){$this -> _Libelle = $libelle;}
		public function SetCode($code){$this -> _Code = $code;}
		public function SetCodeSs($codeSs){$this -> _CodeSs = $codeSs;}
		public function SetCodeFamille($codeFamille){$this -> _CodeFamille = $codeFamille;}
    public function SetChemin($chemin){$this -> _Chemin = $chemin;}
}
