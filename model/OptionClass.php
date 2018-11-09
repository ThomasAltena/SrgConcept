<?php

Class Option
{

	private $_Id;
	private $_Libelle;
    private $_Code;
	private $_Prix;

	//constructeur
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
            $method = substr($method, 0, -7);

            // Si le setter correspondant existe.
            if (method_exists($this, $method))
            {
                // On appelle le setter.
                $this->$method($value);
            }
        }

    }

    //*GET*//
    public function GetId(){return $this->_Id;}
    public function GetLibelle(){return $this->_Libelle;}
    public function GetCode(){return $this -> _Code;}
    public function GetPrix(){return $this->_Prix;}

    //*SET*//
    public function SetId($id){$this -> _Id = (int) $id;}
    public function SetLibelle($libelle){$this -> _Libelle = $libelle;}
    public function SetCode($code){$this -> _Code = $code;}
    public function SetPrix($prix){$this -> _Prix = $prix;}
}