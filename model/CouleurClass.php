<?php

Class Couleur
{
	private $_Id;
	private $_Libelle;
	private $_Hexa;

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
    public function GetLibelle(){return $this->_Libelle;}
    public function GetHexa(){return $this->_Hexa;}

    //*set*//
    public function SetId($id){$this -> _Id = (int) $id;}
    public function SetLibelle($libelle){$this -> _Libelle = $libelle;}
    public function SetHexa($hexa){$this -> _Hexa = $hexa;}
}