<?php

require('../model/UserManager.php');
require '../model/ConnexClass.php';
require('../model/ClientClass.php');
require('../model/ClientManager.php');

include('header.php');

/* Mise en place de la base de donnée */
$db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
$ManagerUser = new UserManager($db); //Connexion a la BDD

/** Get tout les utlisateurs **/
$clients = $ManagerUser->GetClients();
foreach ($clients as $unClient){
    echo($unClient->GetNom());
    echo (" ");
    echo($unClient->GetAdresse());
    echo ('<br/>');
}