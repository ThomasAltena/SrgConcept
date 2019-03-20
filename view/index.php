<!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>-->

<!--<link rel="stylesheet" href="../public/css/bootstrap/css/bootstrap.css" type="text/css">
-->
<link rel="stylesheet" href="../public/css/login.css" type="text/css">
<link rel="stylesheet" href="../public/css/form.css" type="text/css">

<!------ Include the above in your HEAD tag ---------->

<?php
session_start();

if(empty($_SESSION)){
    include('header.php');
} else {
    header('location:ClientView.php');
}
?>

<form action="index.php" method="post">
<div class="login-wrap">
    <div class="login-html">
        <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Connexion</label>
        <input id="tab-2" type="radio" name="tab" class="for-pwd"><label for="tab-2" class="tab">Aide</label>
        <div class="login-form">
            <div class="sign-in-htm">
                <div class="group">
                    <label for="user" class="label">Pseudo ou Email</label>
                    <input id="user" type="text" class="input" name="Pseudo_user">
                </div>
                <div class="group">
                    <label for="pass" class="label">Mot de passe</label>
                    <input id="pass" type="password" class="input" data-type="password" name="Pass_user">
                </div>
                <div class="group">
                    <input type="submit" class="button" value="Connexion" name="go">
                </div>
                <div class="hr"></div>
            </div>
            <div class="for-pwd-htm">
                <div class="group">
                    <label for="user" class="label">Pseudo ou Email</label>
                    <input id="user" type="text" class="input">
                </div>
                <div class="group">
                    <input type="submit" class="button" value="Récuperer mot de passe">
                </div>
                <div class="hr"></div>
            </div>
        </div>
    </div>
</div>
</form>
<?php
if(isset($_POST['go'])){

    if($_POST['Pseudo_user'] != "" && $_POST['Pass_user'] != ""){

        /* Assignation var */
        $psd= $_POST['Pseudo_user'];
        $pass= $_POST['Pass_user'];


        /* BDD*/
        $db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
        $ConnexionManager = new ConnexionManager($db); //Connexion a la BDD

        $ConnexionManager->ConnexionUser($psd,$pass);
    }
    else{
        echo("<div class='alert alert-danger'><strong>Information :  </strong>Remplissez les deux champs.</div>");
    }
}
?>
