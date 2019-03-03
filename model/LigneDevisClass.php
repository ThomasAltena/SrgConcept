<?php

Class LigneDevis
{
	private $_Id;
	private $_Remise;
	private $_Poids;
	private $_Hauteur;
	private $_Largeur;
	private $_Profondeur;
	private $_IdPiece;
	private $_IdDevis;
    private $_Pos_x_piece;
    private $_Pos_y_piece;
    private $_Ratio_piece;
    private $_Pos_z_piece;

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
    public function GetRemise(){return $this->_Remise;}
    public function GetPoids(){return $this->_Poids;}
    public function GetHauteur(){return $this->_Hauteur;}
    public function GetLargeur(){return $this->_Largeur;}
    public function GetProfondeur(){return $this->_Profondeur;}
    public function GetIdPiece(){return $this->_IdPiece;}
    public function GetIdDevis(){return $this->_IdDevis;}
    public function GetPos_x_piece(){return $this->_Pos_x_piece;}
    public function GetPos_y_piece(){return $this->_Pos_y_piece;}
    public function GetRatio_piece(){return $this->_Ratio_piece;}
    public function GetPos_z_piece(){return $this->_Pos_z_piece;}

    //*set*//
    public function SetId($id){$this -> _Id = (int) $id;}
    public function SetRemise($remise){$this -> _Remise = (int) $remise;}
    public function SetPoids($poids){$this -> _Poids = (int) $poids;}
    public function SetHauteur($hauteur){$this -> _Hauteur = (int) (int) $hauteur;}
    public function SetLargeur($largeur){$this -> _Largeur = (int) $largeur;}
    public function SetProfondeur($profondeur) {$this -> _Profondeur = $profondeur;}
    public function SetIdPiece($piece){$this -> _IdPiece = (int) $piece;}
    public function SetIdDevis($devis){$this-> _IdDevis = (int) $devis;}
    public function SetPos_x_piece($Pos_x_piece){$this -> _Pos_x_piece = (int) $Pos_x_piece;}
    public function SetPos_y_piece($Pos_y_piece){$this -> _Pos_y_piece = (int) $Pos_y_piece;}
    public function SetRatio_piece($Ratio_piece){$this -> _Ratio_piece = (int) $Ratio_piece;}
    public function SetPos_z_piece($Pos_z_piece){$this -> _Pos_z_piece = (int) $Pos_z_piece;}
}
