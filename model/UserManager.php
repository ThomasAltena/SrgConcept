<?php

Class UserManager
{
    /** Base de données **/
    private $_Db; // Instance de PDO.

    public function __construct($db)
    {
        $this->setDb($db);
    }


    public function SetDb(PDO $db)
    {
        $this->_Db = $db;
    }


    /** Ajout d'un utilisateur **/
    public function AddUser(Utilisateur $user)
    {
        //Preparation
        $q = $this->_Db->prepare('INSERT INTO user(Id_user ,Nom_user, Adresse_user, DateCo_user, Pseudo_user , Pass_user , Role_user, Siret_user) VALUES(:id,:nom, :adresse, :dateco, :pseudo , :pass , :role , :siret)');
        //Assignation valeur

        $q->bindValue(':id', $user->GetId());
        $q->bindValue(':nom', $user->GetNom());
        $q->bindValue(':adresse', $user->GetAdresse());
        $q->bindValue(':dateco', $user->GetDateCo());
        $q->bindValue(':pseudo', $user->GetPseudo());
        $q->bindValue(':pass' , $user->GetPass());
        $q->bindValue(':role', $user->GetRole());
        $q->bindValue(':siret', $user->GetSiret());

        //Execution de la requete
        $q->execute();
    }

    /** Suppression d'un utilisateur **/
    public function DeleteUser($id)
    {
        $this->_Db->exec('DELETE FROM user WHERE Id_user = '.$id);
    }

    /** Mise a jour d'un utilisateur **/
    public function UpdateUser(Utilisateur $user)
    {
        //Preparation
        $q = $this->_Db->prepare('UPDATE `user` SET `Nom_user` = :nom , `Adresse_user` = :adresse, `DateCo_user` = :dateco ,Siret_user = :siret, `Pseudo_user` = :pseudo, `Pass_user` = :pass, `Role_user` = :role WHERE `user`.`Id_user` = :id');
        //Assignation valeur

        $q->bindValue(':id', $user->GetId());
        $q->bindValue(':nom', $user->GetNom());
        $q->bindValue(':adresse', $user->GetAdresse());
        $q->bindValue(':dateco', $user->GetDateCo());
        $q->bindValue(':siret', $user->GetSiret());
        $q->bindValue(':pseudo', $user->GetPseudo());
        $q->bindValue(':pass' , $user->GetPass());
        $q->bindValue(':role', $user->GetRole());

        //Execution de la requete
        $q->execute();
    }

    /** Retourne UN utilisateur **/
    public function GetUser($nom)
    {
        //Preparation
        $q=$this->_Db->prepare('SELECT * FROM user WHERE Nom_user = :nom');
        $q->bindValue(':nom', $nom);
        $q->execute();

        //Assignation valeur
        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $user = new Utilisateur($donnees);
        }

        return $user;
    }

    /**  Retourne tous les utilisateurs **/
    public function GetUsers()
    {
        $users = [];
        $q = $this->_Db->query('SELECT * FROM user');


        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $users[] = new Utilisateur($donnees);
        }

        return $users;
    }

    /** Test de connexion **/

    public function ConnexionUser($psd,$password)
    {
        //preparation
        $q=$this->_Db->prepare('SELECT * From user Where Pseudo_user = :psd');
        $q->bindValue(':psd', $psd);
        $q->execute();

        //Assignation valeur
        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $user = new Utilisateur($donnees);
        }

        if(!isset($user)){
             echo("<div class='alert alert-danger'><strong>Inforamtion :  </strong>Mauvais identifiant ou mot de passe !</div>");

        }else{
        //Mise en place dans des var 

        $id = $user->GetId();
        $passbdd = $user->GetPass();
        $role = $user->GetRole();
        $psdbdd = $user->GetPseudo();
        $siret = $user->GetSiret();

        

        if(!empty($passbdd))
        {
            if (password_verify($password, $passbdd))
            {
                $_SESSION['Id_user'] = $id;
                $_SESSION['Pseudo_user'] = $psdbdd;
                $_SESSION['Role_user'] = $role;
                $_SESSION['Siret_role'] = $siret;
                echo("<div class='alert alert-success'><strong>Connexion.</div>");
                
                if($role == 1){/* A modif plus tard */
                
                header('Location:UserView.php');
                
            }else{
                
               header('Location:ClientView.php');
             
            }
                
            }
            else{
                echo("<div class='alert alert-danger'><strong>Inforamtion :  </strong>Mauvais identifiant ou mot de passe !</div>");

            }
        }
        else{
                echo("<div class='alert alert-danger'><strong>Inforamtion :  </strong>Mauvais identifiant ou mot de passe !</div>");
                
        }
        }

    }




}