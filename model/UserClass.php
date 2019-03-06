<?php

Class User
{
    private $_Id;
    private $_Nom;
    private $_Adresse;
    private $_DateCo;
    private $_Pseudo;
    private $_Pass;
    private $_Role;
    private $_Siret;

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
            $method = substr($method, 0, -5);

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
    public function GetNom(){return $this->_Nom;}
    public function GetAdresse(){return $this->_Adresse;}
    public function GetDateCo(){return $this->_DateCo;}
    public function GetSiret(){return $this->_Siret;}
    public function GetPseudo(){return $this->_Pseudo;}
    public function GetPass(){return $this->_Pass;}
    public function GetRole(){return $this->_Role;}



    //*Set*//
    public function SetId($id){$this -> _Id = (int) $id;}
    public function SetNom($nom){$this -> _Nom = $nom;}
    public function SetAdresse($addr){$this -> _Adresse = $addr;}
    public function SetDateCo($co){$this -> _DateCo = $co;}
    public function SetSiret($dev){$this -> _Siret = $dev;}
    public function SetPseudo($ps){$this -> _Pseudo = $ps;}
    public function SetPass($pass){$this -> _Pass = $pass;}
    public function SetRole($rol){$this -> _Role = $rol;}
}
