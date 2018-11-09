<?php

class Client
{
	private $_Id;
	private $_Adresse;
	private $_CodePostal;
	private $_DateCreation;
	private $_Mail;
	private $_Nom;
	private $_Prenom;
	private $_Prospect;
	private $_Tel;
	private $_Ville;
	private $_IdUser;

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

    /**GET**/
    public function GetId(){return $this->_Id;}
    public function GetAdresse() {return $this->_Adresse;}
    public function GetCodePostal() {return $this->_CodePostal;}
    public function GetDateCreation() {return $this->_DateCreation;}
    public function GetMail() {return $this->_Mail;}
    public function GetNom() {return $this->_Nom;}
    public function GetPrenom() {return $this->_Prenom;}
    public function GetProspect() {return $this->_Prospect;}
    public function GetTel() {return $this->_Tel;}
    public function GetVille() {return $this->_Ville;}
    public function GetIdUser() {return $this->_IdUser;}

    /**SET**/
    public function SetId($id){$this -> _Id = (int) $id;}
    public function SetAdresse($adresse){$this -> _Adresse = $adresse;}
    public function SetCp($codepostal){$this -> _CodePostal = $codepostal;}
    public function SetDateCrea($datecreation){$this -> _DateCreation = $datecreation;}
    public function SetMail($mail){$this -> _Mail = $mail;}
    public function SetNom($nom){$this -> _Nom = $nom;}
    public function SetPrenom($prenom){$this -> _Prenom = $prenom;}
    public function SetProspect($prospect){$this -> _Prospect = $prospect;}
    public function SetTel($tel){$this -> _Tel = $tel;}
    public function SetVille($ville){$this -> _Ville = $ville;}
    public function SetIdUser($iduser){$this -> _IdUser = $iduser;}

}