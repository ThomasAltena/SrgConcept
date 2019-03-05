<?php

Class OptionLigne
{
	private $_Id;
	private $_IdOption;
	private $_IdLigne;

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
            $method = substr($method, 0, -12);
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
		public function GetIdOption(){return $this->_IdOption;}
		public function GetIdLigne(){return $this->_IdLigne;}


    //*set*//
    public function SetId($Id){$this -> _Id = (int) $Id;}
		public function SetIdOption($IdOption){$this -> _IdOption = (int) $IdOption;}
		public function SetIdLigne($IdLigne){$this -> _IdLigne = (int) $IdLigne;}
}
