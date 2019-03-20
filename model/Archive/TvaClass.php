<?php

Class Tva
{
	private $_Id;
	private $_Taux;

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
            $method = substr($method, 0, -4);

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
    public function GetTaux(){return $this->_Taux;}

    /**SET**/
    public function SetId($id){$this -> _Id = (int) $id;}
    public function SetTaux($taux){$this -> _Taux = $taux;}
}