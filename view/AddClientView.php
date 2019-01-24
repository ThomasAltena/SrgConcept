<?php
session_start();

if(empty($_SESSION)){
    header('location:index.php');
} else {
    include('header.php');
}
?>

<link rel="stylesheet" href="../public/css/form.css" type="text/css">

<body>
<div class="container">


    <form id="formbox" action="AddClientView.php" method="post">

        <div class="table-title">
            <h3>Création d'un client</h3>
        </div>


        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" style="width:100px" id="Nom_client_label">Nom:</span>
            </div>
            <input type="text" class="form-control" placeholder="Nom" name="Nom_client" id="Nom_client" aria-describedby="Nom_client_label">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" style="width:100px" id="Prenom_client_label">Prenom:</span>
            </div>
            <input type="text" class="form-control" placeholder="Prenom" name="Prenom_client" id="Prenom_client" aria-describedby="Prenom_client_label">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" style="width:100px" id="Prospect_client_label">Prospect:</span>
            </div>
            <input type="text" class="form-control" placeholder="Prospect" name="Prospect_client" id="Prospect_client" aria-describedby="Prospect_client_label">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" style="width:100px" id="Adresse_client_label">Adresse:</span>
            </div>
            <input type="text" class="form-control" placeholder="Adresse" name="Adresse_client" id="Adresse_client" aria-describedby="Adresse_client_label">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" style="width:100px" id="Ville_client_label">Ville:</span>
            </div>
            <input type="text" class="form-control" placeholder="Ville" name="Ville_client" id="Ville_client" aria-describedby="Ville_client_label">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="CodePostal_client_label">Code postal:</span>
            </div>
            <input type="text" class="form-control" placeholder="Code postal" name="CodePostal_client" id="CodePostal_client" aria-describedby="CodePostal_client_label">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" style="width:100px" id="Mail_client_label">Mail:</span>
            </div>
            <input type="text" class="form-control" placeholder="Mail" name="Mail_client" id="Mail_client" aria-describedby="Mail_client_label">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" style="width:100px" id="Tel_client_label">Teléphone:</span>
            </div>
            <input type="text" class="form-control" placeholder="Teléphone" name="Tel_client" id="Tel_client" aria-describedby="Tel_client_label">
        </div>
        <div class="form-group form-check">
            <button name="go" type="submit" value="" class="btn btn-primary">Envoyer</button>
        </div>
    </form>
</div>

<?php
  
    if(isset($_POST['go'])){
        if($_POST['Nom_client'] != "" || $_POST['Prenom_client'] != "" || $_POST['Prospect_client'] != ""  || $_POST['Adresse_client'] != "" || $_POST['Ville_client'] != "" || $_POST['CodePostal_client'] != "" || $_POST['DateCrea_client'] != "" || $_POST['Mail_client'] != "" || $_POST['Tel_client'] != ""){

            /* Assignation var */
            $id = "";
            $nom = $_POST['Nom_client'];
            $prenom = $_POST['Prenom_client'];
            $prospect = $_POST['Prospect_client'];
            $adresse=  $_POST['Adresse_client'];
            $ville = $_POST['Ville_client'];
            $codepostal = $_POST['CodePostal_client'];
            $mail = $_POST['Mail_client'];
            $date = $date = date("d-m-Y");
            $tel = $_POST['Tel_client'];
            $idUser = $_SESSION['Id_user'];

            /* Construct */
            $client = new Client([
            "Id_client" => $id ,
            "Nom_client" => $nom ,
            "Prenom_client" => $prenom ,
            "Prospect_client" => $prospect ,
            "Adresse_client" => $adresse ,
            "Ville_client" => $ville ,
            "CodePostal_client" => $codepostal ,
            "Mail_client" => $mail ,
            "DateCrea_client" => $date,
            "Tel_client" => $tel ,
            "IdUser_client" => $idUser,
            ]);


            /* BDD*/
            $db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
            $ManagerClient = new ClientManager($db); //Connexion a la BDD


            /** Ajout **/
            $ManagerClient->AddClient($client);

            echo("<div class='alert alert-success'><strong>Félicitation !  </strong> Le client a été crée.</div>");
        }else{
            echo("<div class='alert alert-danger'><strong>Inforamtion :  </strong>Remplissez les champs obligatoires.</div>");
        }
    }
?>
</body>