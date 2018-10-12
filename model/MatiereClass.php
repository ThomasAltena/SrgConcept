<?php

class Matiere
{
	private $_Id;
	private $_Code;
	private $_Libelle;
    private $_Prix;

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
            $method = substr($method, 0, -8);

            // Si le setter correspondant existe.
            if (method_exists($this, $method))
            {
                // On appelle le setter.
                $this->$method($value);
            }
        }

    }

    //*get*//
    public function GetId(){return $this->_Id;}
    public function GetCode(){return $this->_Code;}
    public function GetLibelle(){return $this->_Libelle;}
    public function GetPrix(){return $this->_Prix;}

    //*set*//
 	public function SetId($id){$this -> _Id = (int) $id;}
 	public function SetCode($code){$this -> _Code = $code;}
 	public function SetLibelle($libelle){$this -> _Libelle = $libelle;}
    public function SetPrix($prix){$this -> _Prix = $prix;}

}