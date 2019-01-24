<?php

Class LigneDevis 
{
	private $_Id;
	private $_Code;
	private $_Remise;
	private $_Prix;
	private $_Poids;
	private $_Hauteur;
	private $_Largeur;
	private $_Profondeur;
	private $_IdPiece;
	private $_IdMatiere;
	private $_IdCouleur;
	private $_IdTva;
	private $_IdDevis;
	private $_Option1;
	private $_Option2;
	private $_Option3;
	private $_Option4;
	private $_Option5;


	  //constructeur
    public function __construct(array $donnees)
    {
        if ($donnees == []) {

        }else{
            $this->hydrate($donnees);

        }

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
    public function GetRemise(){return $this->_Remise;}
    public function GetPrix(){return $this->_Prix;}
    public function GetPoids(){return $this->_Poids;}
    public function GetHauteur(){return $this->_Hauteur;}
    public function GetLargeur(){return $this->_Largeur;}
    public function GetIdPiece(){return $this->_IdPiece;}
    public function GetIdMatiere(){return $this->_IdMatiere;}
    public function GetIdCouleur(){return $this->_IdCouleur;}
    public function GetIdTva(){return $this->_IdTva;}
    public function GetIdDevis(){return $this->_IdDevis;}
    public function GetOption1(){return $this->_Option1;}
    public function GetOption2(){return $this->_Option2;}
    public function GetOption3(){return $this->_Option3;}
    public function GetOption4(){return $this->_Option4;}
    public function GetOption5(){return $this->_Option5;}
    public function GetProfondeur(){return $this->_Profondeur;}

    //*set*//
    public function SetId($id){$this -> _Id = (int) $id;}
    public function SetCode($code){$this -> _Code = $code;}
    public function SetRemise($remise){$this -> _Remise = $remise;}
    public function SetPrix($prix){$this -> _Prix = $prix;}
    public function SetPoids($poids){$this -> _Poids = $poids;}
    public function SetHauteur($hauteur){$this -> _Hauteur = $hauteur;}
    public function SetLargeur($largeur){$this -> _Largeur = $largeur;}
    public function SetIdpiece($piece){$this -> _IdPiece = $piece;}
    public function SetIdmatiere($matiere){$this -> _IdMatiere = $matiere;}
    public function SetIdcouleur($couleur){$this -> _IdCouleur = $couleur;}
    public function SetIdtva($tva){$this -> _IdTva = $tva;}
    public function SetIddevis($devis){$this-> _IdDevis = $devis;}
    public function SetOption1($option1){$this -> _Option1 = $option1;}
    public function SetOption2($option2){$this -> _Option2 = $option2;}
    public function SetOption3($option3){$this -> _Option3 = $option3;}
    public function SetOption4($option4){$this -> _Option4 = $option4;}
    public function SetOption5($option5){$this -> _Option5 = $option5;}
    public  function SetProfondeur($profondeur) {$this -> _Profondeur = $profondeur;}
} 