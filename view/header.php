<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}



header("Cache-Control:no-cache");

spl_autoload_register(function ($class_name) {
  if(strpos($class_name, 'Manager')){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/SrgConcept/manager/'. $class_name . '.php');
  } else {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/SrgConcept/model/'. $class_name . 'Class.php');
  }
});

require_once($_SERVER['DOCUMENT_ROOT'] . '/SrgConcept/model/UploadClass.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/SrgConcept/model/UploadCroquisClass.php');
?>

<!DOCTYPE html>
<html>
<head>
  <style>
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/SrgConcept/public/css/normalize.css'); ?>
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/SrgConcept/public/css/form.css'); ?>

  </style>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--  Glyphicon  -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
</head>

<header style="min-width: 1250px">
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark" style="min-width: 1250px">
    <!-- Brand -->
    <a class="navbar-brand" href="#">Accueil</a>

    <!-- Links -->
    <ul class="navbar-nav">
      <?php
      //var_dump($_SESSION);
      /* Verif si la session est vide */
      if(!empty($_SESSION)){
        if($_SESSION['Role_user'] == 1)
        {             //Si c'est un admin on ajoute les menus
          ?>
          <li class='nav-item'>
            <div class='dropdown '>
              <a class='dropdown-toggle nav-link' href='/SrgConcept/view/UserView.php' role='button' id='dropdownMenuLink' data-toggle='dropdown'>
                Utilisateurs
              </a>
              <div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
                <a class='dropdown-item' href='/SrgConcept/view/UserView.php'>
                  Liste
                </a>
                <a class='dropdown-item' href='/SrgConcept/view/AddUserView.php'>
                  Création
                </a>
              </div>
            </div>
          </li>
          <li class='nav-item'>
            <div class='dropdown'>
              <a class='dropdown-toggle nav-link' href='/SrgConcept/view/ClientView.php' role='button' id='dropdownMenuLink' data-toggle='dropdown'>
                Clients
              </a>
              <div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
                <a class='dropdown-item' href='/SrgConcept/view/ClientView.php'>
                  Liste
                </a>
                <a class='dropdown-item' href='/SrgConcept/view/AddClientView.php'>
                  Création
                </a>
              </div>
            </div>
          </li>
          <li class='nav-item'>
            <div class='dropdown'>
              <a class='dropdown-toggle nav-link' href='/SrgConcept/view/UserView.php' role='button' id='dropdownMenuLink' data-toggle='dropdown'>
                Matiéres
              </a>
              <div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
                <a class='dropdown-item' href='/SrgConcept/view/MatiereView.php'>
                  Liste
                </a>
                <a class='dropdown-item' href='/SrgConcept/view/AddMatiereView.php'>
                  Création
                </a>
              </div>
            </div>
          </li>
          <li class='nav-item'>
            <div class='dropdown'>
              <a class='nav-link' href='/SrgConcept/view/PieceView/PieceMainViewModel.php'>
                Piéces
              </a>
            </div>
          </li>
          <li class='nav-item'>
            <a class='nav-link' href='/SrgConcept/view/OptionView.php'>
              Option
            </a>
          </li>
          <li class='nav-item'>
            <a class='nav-link' href='/SrgConcept/view/TVAView.php'>
              TVA
            </a>
          </li>
          <li class='nav-item'>
            <div class='dropdown'>
              <a class='dropdown-toggle nav-link' href='/SrgConcept/view/DevisView.php' role='button' id='dropdownMenuLink' data-toggle='dropdown'>
                Devis
              </a>
              <div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
                <a class='dropdown-item' href='/SrgConcept/view/DevisView.php'>
                  Liste
                </a>
                <a class='dropdown-item' href='/SrgConcept/view/AddDevisView/AddDevisDessinViewModel.php'>
                  Création
                </a>
              </div>
            </div>
          </li>

          <?php

        } else{ //C'est pas des admin afficher
          ?>

          <?php
        }
      }

      //Si la connexion est bonne ou pas
      if(isset($_SESSION['Id_user'])){
        ?>
        <li class='nav-item'>
          <a class='btn btn-outline-danger my-2 my-sm-0' href='/SrgConcept/view/Logout.php'>
            Déconnexion
          </a>
        </li>
        <?php
      } else {
        ?>
        <li class='nav-item'>
          <a class='btn btn-outline-success my-2 my-sm-0' href='/SrgConcept/view/Index.php'>
            Connexion
          </a>
        </li>
        <?php
      }
      ?>
    </ul>
  </nav>
</header>
