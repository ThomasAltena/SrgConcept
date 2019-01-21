<?php

Class Devis
{
	private $_Id;
	private $_Code;
	private $_Date;
	private $_IdClient;
	private $_IdUser;
	private $_Libelle;
	private $_CheminImage;

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
    public function GetCode(){return $this->_Code;}
    public function GetDate(){return $this->_Date;}
    public function GetIdClient(){return $this->_IdClient;}
    public function GetIdUser(){return $this->_IdUser;}
    public function GetLibelle(){return $this->_Libelle;}
    public function GetCheminImage(){return $this->_CheminImage;}

    //*Set*//
    public function SetId($id){$this -> _Id = (int) $id;}
    public function SetCode($code){$this -> _Code = $code;}
    public function SetDate($date){return $this -> _Date = $date;}
    public function SetIdClient($idclient){return $this -> _IdClient = $idclient;}
    public function SetIdUser($iduser){return $this -> _IdUser = $iduser;}
    public function SetLibelle($libelle){return $this-> _Libelle = $libelle;}
    public function SetCheminImage($chemin){return $this-> _CheminImage = $chemin;}
}