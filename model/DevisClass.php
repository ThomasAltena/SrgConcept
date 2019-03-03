<?php

Class Devis
{
	private $_Id;
	//private $_Code;
	private $_Date;
	private $_IdClient;
	private $_IdUser;
	private $_CheminImage;
    private $_IdMatiere;

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

    //*get*//
    public function GetId(){return $this->_Id;}
    public function GetIdMatiere(){return $this->_IdMatiere;}
    public function GetDate(){return $this->_Date;}
    public function GetIdClient(){return $this->_IdClient;}
    public function GetIdUser(){return $this->_IdUser;}
    public function GetCheminImage(){return $this->_CheminImage;}

    //*Set*//
    public function SetId($id){$this -> _Id = (int) $id;}
    public function SetIdMatiere($idMatiere){$this -> _IdMatiere = (int) $idMatiere;}
    public function SetDate($date){return $this -> _Date = $date;}
    public function SetIdClient($idclient){return $this -> _IdClient = (int) $idclient;}
    public function SetIdUser($iduser){return $this -> _IdUser = (int) $iduser;}
    public function SetCheminImage($chemin){return $this-> _CheminImage = $chemin;}
}
