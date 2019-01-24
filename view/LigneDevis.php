<!DOCTYPE html>
<html>
<head>
    <title>Monumac</title>
</head>

<?php
session_start();

if (empty($_SESSION)) {
    header('location:index.php');
} else {
    include('header.php');
}


$db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
$ManagerMatiere = new MatiereManager($db); //Connexion a la BDD
$matieres = $ManagerMatiere->GetMatieres();
try {
    $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


$reponse = $bdd->query('SELECT Id_devis, IdClient_devis, IdUser_devis FROM devis ORDER BY Id_devis DESC LIMIT 1');
$IdDevis = $reponse->fetchAll();

foreach ($IdDevis as $IdDevi) ;
$Devis = $IdDevi['Id_devis'];
$User = $IdDevi['IdUser_devis'];
$Client = $IdDevi['IdClient_devis'];
$date = date("d-m-Y");

?>
<link rel="stylesheet" href="../public/css/form.css" type="text/css">

<!-------------------------- Il faut mettre le chemin dans les value -------------------------->
<body>
<div id="content-wrapper">
    <div class='container' style="max-width: 1200px">
        <div class="row">
            <input type="file" id="fileToUpload" name="fileToUpload" style="visibility:hidden">
            <div id='schema'>
                <div style="top: 25%; left: 25%; position: absolute; ">
                    <img id="imgSch1" src="">
                    <img id="imgSch2" style="left: 0%; top: 0%" src="">
                    <img id="imgSch3" src="">
                    <img id="imgSch4" src="">
                    <img id="imgSch5" src="">
                </div>
            </div>
            </input>
            <form action="../devis/NouveauDevis.php" class="form" method="post">
                <div id='devis' class="col-xl-10 col-sm-10 mb-6 margintop">
                    <div id="formbox">
                        <h5 class="card-title" style="width:100%"> Sélectionner un client : </h5>
                        <!-- <input class="mb-2 form-control" style="width:100%" id="myInput" type="text"
                                placeholder="Search..">-->
                        <select name="Id_client" class="mb-2 form-control" style="width:100%" select">
                        <?php

                        $reponse = $bdd->query('SELECT * FROM clients');

                        while ($donnees = $reponse->fetch()) {
                            ?>

                            <option value="<?php echo $donnees['Id_client']; ?>"> <?php echo $donnees['Nom_client']; ?></option>

                            <?php
                        }

                        $_POST['Id_client'];
                        ?>
                        </select>
                    </div>
                </div>
                <!-- Button useless ?
                                <div id='devis' class="col-xl-10 col-sm-10 mb-2 margintop">
                                    <div id="formbox">
                                        <div class="card-body">
                                            <center>
                                                <button name="go" onclick="nouveauDevis()" type="button" value=""
                                                        class="btn btn-primary"
                                                ">Crée devis</button></center>
                                        </div>
                                    </div>
                                </div> -->
                <!-- <form action=echo $url; class="form" method="post"> -->

                <div id="mat" class="col-xl-10 col-sm-10 mb-2 margintop" style="visibility:visible">

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"> Matiére : </h5>
                        </div>
                        <div class="card-body">
                            <!-- Button simple ou double -->
                            <h5>Type de structure :</h5>
                            <div class="form-check form-check-inline">
                                <label><input class="form-check-input" value="Simple" type="radio"
                                              name="Type">Simple</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label><input class="form-check-input" value="Double" type="radio"
                                              name="Type">Double</label>
                            </div>

                            <br/><br/>
                            <h5>Matière :</h5>
                            <select name="Id_matiere" id="select" class="form-control" style="width:50%">
                                <?php

                                $reponse = $bdd->query('SELECT * FROM matieres');

                                while ($donnees = $reponse->fetch()) {
                                    ?>
                                    <option value=" <?php echo $donnees['Id_matiere']; ?>"> <?php echo $donnees['Libelle_matiere']; ?></option>


                                    <?php
                                }
                                ?>
                            </select>
                            <br><br>
                            <!-- <input class="form-control" type="button"  id="Valide1" onclick="suite(2)" value="Suivant" /> <p id="prix1"></p> -->
                            <button type="button" onclick="affichePiece()" class="btn btn-warning x1">Suivant</button>
                        </div>

                    </div>

                </div>
                <!-- Ligne 1 -->
                <div id="piece" class="col-xl-6 col-sm-6 mb-3 margintop piece piece">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"> Selectionner une bordure/base : </h5>
                        </div>
                        <div class="card-body">
                            <h5>Pièce :</h5>
                            <div class="form-check form-check-inline">
                                <!--<p class="card-text">Choix :</p>-->
                                <select name="Id_piece" id="select1" onchange="AfficheImg(1)" class="mb-2 form-control">
                                    <option value="" selected>Choisir la pièce</option>
                                    <?php

                                    $reponse = $bdd->query('SELECT * FROM pieces');

                                    while ($donnees = $reponse->fetch()) {

                                        ?>
                                        <option id="<?php echo $donnees['Chemin_piece']; ?>"
                                                value=" <?php echo $donnees['Id_piece']; ?>"> <?php echo $donnees['Libelle_piece']; ?></option>
                                        <?php
                                    }

                                    ?>
                                </select>


                            </div>
                            <br/>

                            <h5>Option :</h5>


                            <div class="form-inline">
                                <div class="form-group">
                                    <select name="Id_option" id="select" class="form-control">
                                        <option value="0" selected>Aucune</option>
                                        <?php
                                        $reponse = $bdd->query('SELECT * FROM options');
                                        while ($donnees = $reponse->fetch()) {
                                            ?>
                                            <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>

                                    <select name="Id_option2" id="select" class="form-control"
                                            style="margin-left: 10px;">
                                        <option value="0" selected>Aucune</option>
                                        <?php
                                        $reponse = $bdd->query('SELECT * FROM options');
                                        while ($donnees = $reponse->fetch()) {
                                            ?>
                                            <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>

                                    <select name="Id_option3" id="select" class="form-control"
                                            style="margin-left: 10px;">
                                        <option value="0" selected>Aucune</option>
                                        <?php
                                        $reponse = $bdd->query('SELECT * FROM options');
                                        while ($donnees = $reponse->fetch()) {
                                            ?>
                                            <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>

                                    <select name="Id_option4" id="select" class="form-control"
                                            style="margin-left: 10px;">
                                        <option value="0" selected>Aucune</option>
                                        <?php
                                        $reponse = $bdd->query('SELECT * FROM options');
                                        while ($donnees = $reponse->fetch()) {
                                            ?>
                                            <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <br/>
                            <h5>Dimension :</h5>
                            <div class="form-row">
                                <div class="col">
                                    <input type="text" id="h" name="Hauteur1" placeholder="Hauteur"
                                           class="form-control">
                                </div>
                                <div class="col">
                                    <input type="text" id="l" name="Largeur1" placeholder="Largeur"
                                           class="form-control" style="margin-left: 10px;">
                                </div>
                                <div class="col">
                                    <input type="text" id="p" name="Profondeur1" placeholder="Profondeur"
                                           class="form-control" style="margin-left: 10px;">
                                </div>
                            </div>
                            <br/>
                            <h5>Remise :</h5>
                            <div class="form-inline no-margin" style="margin-top: 10px;">
                                <div class="form-group">
                                    <input type="number" id="r" name="Remis1" placeholder="Remise" class="form-control"
                                           min="0" max="500000">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Image Aperçu 1 -->
                <div id="image" class="col-xl-4 col-sm-4 mb-2 margintop image">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"> Aperçu image : </h5>
                        </div>
                        <div class="card-body">
                            <center><img id="img1" src=""></center>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div id="piece2" class="col-xl-6 col-sm-6 mb-3 margintop piece">
                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title"> Selectionner une tombale : </h5>
                        </div>
                        <div class="card-body">
                            <h5>Pièce :</h5>
                            <div class="form-check form-check-inline">
                                <!--<p class="card-text">Choix :</p>-->
                                <select name="Id_piece2" id="select2" onchange="AfficheImg(2)"
                                        class="mb-2 form-control">
                                    <option value="" selected>Choisir la pièce</option>
                                    <?php
                                    $reponse = $bdd->query('SELECT * FROM pieces');
                                    while ($donnees = $reponse->fetch()) {
                                        ?>
                                        <option id="<?php echo $donnees['Chemin_piece']; ?>"
                                                value=" <?php echo $donnees['Id_piece']; ?>"> <?php echo $donnees['Libelle_piece']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <br/>
                            <h5>Option :</h5>

                            <div class="form-inline">
                                <div class="form-group">
                                    <select name="Id_option5" id="select" class="form-control">
                                        <option value="0" selected>Aucune</option>
                                        <?php
                                        $reponse = $bdd->query('SELECT * FROM options');
                                        while ($donnees = $reponse->fetch()) {
                                            ?>
                                            <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>

                                    <select name="Id_option6" id="select" class="form-control"
                                            style="margin-left: 10px;">
                                        <option value="0" selected>Aucune</option>
                                        <?php
                                        $reponse = $bdd->query('SELECT * FROM options');
                                        while ($donnees = $reponse->fetch()) {
                                            ?>
                                            <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>

                                    <select name="Id_option7" id="select" class="form-control"
                                            style="margin-left: 10px;">
                                        <option value="0" selected>Aucune</option>
                                        <?php
                                        $reponse = $bdd->query('SELECT * FROM options');
                                        while ($donnees = $reponse->fetch()) {
                                            ?>
                                            <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>

                                    <select name="Id_option8" id="select" class="form-control"
                                            style="margin-left: 10px;">
                                        <option value="0" selected>Aucune</option>
                                        <?php
                                        $reponse = $bdd->query('SELECT * FROM options');
                                        while ($donnees = $reponse->fetch()) {
                                            ?>
                                            <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <h5>Dimension :</h5>
                            <div class="form-row">
                                <div class="col">
                                    <input type="text" id="h" name="Hauteur2" placeholder="Hauteur"
                                           class="form-control">
                                </div>
                                <div class="col">
                                    <input type="text" id="l" name="Largeur2" placeholder="Largeur"
                                           class="form-control" style="margin-left: 10px;">
                                </div>
                                <div class="col">
                                    <input type="text" id="p" name="Profondeur2" placeholder="Profondeur"
                                           class="form-control" style="margin-left: 10px;">
                                </div>
                            </div>
                            <br/>
                            <h5>Remise :</h5>
                            <div class="form-inline no-margin" style="margin-top: 10px;">
                                <div class="form-group">
                                    <input type="number" id="r" name="Remis2" placeholder="Remise" class="form-control"
                                           min="0" max="500000">
                                </div>
                            </div>
                            <br/>
                            <h5>Position :</h5>
                            <div class="form-inline no-margin" style="margin-top: 10px;">
                                <div class="form-group col-lg-12">
                                    <h5 class="col-lg-1" style="margin:0">X </h5><input type="range" min="-50" max="150"
                                                                                        value="50"
                                                                                        oninput="MoveImage(2)"
                                                                                        class="slider col-lg-11"
                                                                                        name="posX2" id="image_2_pos_x">
                                </div>
                                <div class="form-group col-lg-12">
                                    <h5 class="col-lg-1" style="margin:0">Y </h5><input type="range" min="-50" max="150"
                                                                                        value="50"
                                                                                        oninput="MoveImage(2)"
                                                                                        class="slider col-lg-11"
                                                                                        name="posY2" id="image_2_pos_y">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Image appercu 2 -->
                <div id="image2" class="col-xl-4 col-sm-4 mb-2 margintop image">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"> Aperçu image : </h5>
                        </div>
                        <div class="card-body">
                            <center><img id="img2" src=""></center>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div id="piece3" class="col-xl-6 col-sm-6 mb-3 margintop piece">
                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title"> Selectionner une Stele : </h5>
                        </div>
                        <div class="card-body">
                            <h5>Pièce :</h5>
                            <div class="form-check form-check-inline">
                                <!--<p class="card-text">Choix :</p>-->
                                <select name="Id_piece3" id="select3" onchange="AfficheImg(3)"
                                        class="mb-2 form-control">
                                    <option value="" selected>Choisir la pièce</option>
                                    <?php

                                    $reponse = $bdd->query('SELECT * FROM pieces');

                                    while ($donnees = $reponse->fetch()) {
                                        ?>
                                        <option id="<?php echo $donnees['Chemin_piece']; ?>"
                                                value=" <?php echo $donnees['Id_piece']; ?>"> <?php echo $donnees['Libelle_piece']; ?></option>
                                        <?php
                                    }

                                    ?>
                                </select>


                            </div>
                            <br/>
                            <h5>Option :</h5>
                            <div class="form-inline">
                                <div class="form-group">
                                    <select name="Id_option9" id="select" class="form-control">
                                        <option value="0" selected>Aucune</option>
                                        <?php
                                        $reponse = $bdd->query('SELECT * FROM options');
                                        while ($donnees = $reponse->fetch()) {
                                            ?>
                                            <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>

                                    <select name="Id_option10" id="select" class="form-control"
                                            style="margin-left: 10px;">
                                        <option value="0" selected>Aucune</option>
                                        <?php
                                        $reponse = $bdd->query('SELECT * FROM options');
                                        while ($donnees = $reponse->fetch()) {
                                            ?>
                                            <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>

                                    <select name="Id_option11" id="select" class="form-control"
                                            style="margin-left: 10px;">
                                        <option value="0" selected>Aucune</option>
                                        <?php
                                        $reponse = $bdd->query('SELECT * FROM options');
                                        while ($donnees = $reponse->fetch()) {
                                            ?>
                                            <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>

                                    <select name="Id_option12" id="select" class="form-control"
                                            style="margin-left: 10px;">
                                        <option value="0" selected>Aucune</option>
                                        <?php
                                        $reponse = $bdd->query('SELECT * FROM options');
                                        while ($donnees = $reponse->fetch()) {
                                            ?>
                                            <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <h5>Dimension :</h5>
                            <div class="form-row">
                                <div class="col">
                                    <input type="text" id="h" name="Hauteur3" placeholder="Hauteur"
                                           class="form-control">
                                </div>
                                <div class="col">
                                    <input type="text" id="l" name="Largeur3" placeholder="Largeur"
                                           class="form-control" style="margin-left: 10px;">
                                </div>
                                <div class="col">
                                    <input type="text" id="p" name="Profondeur3" placeholder="Profondeur"
                                           class="form-control" style="margin-left: 10px;">
                                </div>
                            </div>
                            <br/>
                            <h5>Remise :</h5>
                            <div class="form-inline no-margin" style="margin-top: 10px;">
                                <div class="form-group">
                                    <input type="number" id="r" name="Remis3" placeholder="Remise" class="form-control"
                                           min="0" max="500000">
                                </div>
                            </div>

                            <h5>Position :</h5>
                            <div class="form-inline no-margin" style="margin-top: 10px;">
                                <div class="form-group col-lg-12">
                                    <h5 class="col-lg-1" style="margin:0">X </h5><input type="range" min="-50" max="150"
                                                                                        value="50"
                                                                                        oninput="MoveImage(3)"
                                                                                        class="slider col-lg-11"
                                                                                        name="posX2" id="image_3_pos_x">
                                </div>
                                <div class="form-group col-lg-12">
                                    <h5 class="col-lg-1" style="margin:0">Y </h5><input type="range" min="-50" max="150"
                                                                                        value="50"
                                                                                        oninput="MoveImage(3)"
                                                                                        class="slider col-lg-11"
                                                                                        name="posY2" id="image_3_pos_y">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Apercu 3 -->
                    <div id="image3" class="col-xl-4 col-sm-4 mb-2 margintop image">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"> Aperçu image : </h5>
                            </div>
                            <div class="card-body">
                                <center><img id="img3" src=""></center>
                            </div>
                        </div>


                    </div>

                    <!-- Card 4 -->
                    <div id="piece4" class="col-xl-6 col-sm-6 mb-3 margintop piece">
                        <div class="card">

                            <div class="card-header">
                                <h5 class="card-title"> Selectionner une piéce : </h5>
                            </div>
                            <div class="card-body">
                                <h5>Pièce :</h5>
                                <div class="form-check form-check-inline">
                                    <!--<p class="card-text">Choix :</p>-->
                                    <select name="Id_piece4" id="select4" onchange="AfficheImg(4)"
                                            class="mb-2 form-control">
                                        <option value="" selected>Choisir la pièce</option>
                                        <?php

                                        $reponse = $bdd->query('SELECT * FROM pieces');

                                        while ($donnees = $reponse->fetch()) {
                                            ?>
                                            <option id="<?php echo $donnees['Chemin_piece']; ?>"
                                                    value=" <?php echo $donnees['Id_piece']; ?>"> <?php echo $donnees['Libelle_piece']; ?></option>
                                            <?php
                                        }

                                        ?>
                                    </select>


                                </div>
                                <br/>
                                <h5>Option :</h5>


                                <div class="form-inline">
                                    <div class="form-group">
                                        <select name="Id_option13" id="select" class="form-control">
                                            <option value="0" selected>Aucune</option>
                                            <?php
                                            $reponse = $bdd->query('SELECT * FROM options');
                                            while ($donnees = $reponse->fetch()) {
                                                ?>
                                                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>

                                        <select name="Id_option14" id="select" class="form-control"
                                                style="margin-left: 10px;">
                                            <option value="0" selected>Aucune</option>
                                            <?php
                                            $reponse = $bdd->query('SELECT * FROM options');
                                            while ($donnees = $reponse->fetch()) {
                                                ?>
                                                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>

                                        <select name="Id_option15" id="select" class="form-control"
                                                style="margin-left: 10px;">
                                            <option value="0" selected>Aucune</option>
                                            <?php
                                            $reponse = $bdd->query('SELECT * FROM options');
                                            while ($donnees = $reponse->fetch()) {
                                                ?>
                                                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>

                                        <select name="Id_option16" id="select" class="form-control"
                                                style="margin-left: 10px;">
                                            <option value="0" selected>Aucune</option>
                                            <?php
                                            $reponse = $bdd->query('SELECT * FROM options');
                                            while ($donnees = $reponse->fetch()) {
                                                ?>
                                                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <br/>
                                <h5>Dimension :</h5>
                                <div class="form-row">
                                    <div class="col">
                                        <input type="text" id="h" name="Hauteur4" placeholder="Hauteur"
                                               class="form-control">
                                    </div>
                                    <div class="col">
                                        <input type="text" id="l" name="Largeur4" placeholder="Largeur"
                                               class="form-control" style="margin-left: 10px;">
                                    </div>
                                    <div class="col">
                                        <input type="text" id="p" name="Profondeur4" placeholder="Profondeur"
                                               class="form-control" style="margin-left: 10px;">
                                    </div>
                                </div>
                                <br/>
                                <h5>Remise :</h5>
                                <div class="form-inline no-margin" style="margin-top: 10px;">
                                    <div class="form-group">
                                        <input type="number" id="r" name="Remis4" placeholder="Remise"
                                               class="form-control"
                                               min="0" max="500000">
                                    </div>
                                </div>

                                <h5>Position :</h5>
                                <div class="form-inline no-margin" style="margin-top: 10px;">
                                    <div class="form-group col-lg-12">
                                        <h5 class="col-lg-1" style="margin:0">X </h5><input type="range" min="-50" max="150"
                                                                                            value="50"
                                                                                            oninput="MoveImage(4)"
                                                                                            class="slider col-lg-11"
                                                                                            name="posX2" id="image_4_pos_x">
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <h5 class="col-lg-1" style="margin:0">Y </h5><input type="range" min="-50" max="150"
                                                                                            value="50"
                                                                                            oninput="MoveImage(4)"
                                                                                            class="slider col-lg-11"
                                                                                            name="posY2" id="image_4_pos_y">
                                    </div>
                            </div>
                        </div>
                    </div>
                    <!-- Aprecu 4 -->
                    <div id="image4" class="col-xl-4 col-sm-4 mb-2 margintop image">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"> Aperçu image : </h5>
                            </div>
                            <div class="card-body">
                                <center><img id="img4" src=""></center>
                            </div>
                        </div>


                    </div>

                    <!-- Card 5 -->
                    <div id="piece5" class="col-xl-6 col-sm-6 mb-3 margintop piece">
                        <div class="card">

                            <div class="card-header">
                                <h5 class="card-title"> Selectionner une piéce : </h5>
                            </div>
                            <div class="card-body">
                                <h5>Pièce :</h5>
                                <div class="form-check form-check-inline">
                                    <!--<p class="card-text">Choix :</p>-->
                                    <select name="Id_piece5" id="select5" onchange="AfficheImg(5)"
                                            class="mb-2 form-control">
                                        <option value="" selected>Choisir la pièce</option>
                                        <?php

                                        $reponse = $bdd->query('SELECT * FROM pieces');

                                        while ($donnees = $reponse->fetch()) {
                                            ?>
                                            <option id="<?php echo $donnees['Chemin_piece']; ?>"
                                                    value=" <?php echo $donnees['Id_piece']; ?>"> <?php echo $donnees['Libelle_piece']; ?></option>
                                            <?php
                                        }

                                        ?>
                                    </select>


                                </div>
                                <br/>
                                <h5>Option :</h5>


                                <div class="form-inline">
                                    <div class="form-group">
                                        <select name="Id_option17" id="select" class="form-control">
                                            <option value="0" selected>Aucune</option>
                                            <?php
                                            $reponse = $bdd->query('SELECT * FROM options');
                                            while ($donnees = $reponse->fetch()) {
                                                ?>
                                                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>

                                        <select name="Id_option18" id="select" class="form-control"
                                                style="margin-left: 10px;">
                                            <option value="0" selected>Aucune</option>
                                            <?php
                                            $reponse = $bdd->query('SELECT * FROM options');
                                            while ($donnees = $reponse->fetch()) {
                                                ?>
                                                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>

                                        <select name="Id_option19" id="select" class="form-control"
                                                style="margin-left: 10px;">
                                            <option value="0" selected>Aucune</option>
                                            <?php
                                            $reponse = $bdd->query('SELECT * FROM options');
                                            while ($donnees = $reponse->fetch()) {
                                                ?>
                                                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>

                                        <select name="Id_option20" id="select" class="form-control"
                                                style="margin-left: 10px;">
                                            <option value="0" selected>Aucune</option>
                                            <?php
                                            $reponse = $bdd->query('SELECT * FROM options');
                                            while ($donnees = $reponse->fetch()) {
                                                ?>
                                                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <br/>
                                <h5>Dimension :</h5>
                                <div class="form-row">
                                    <div class="col">
                                        <input type="text" id="h" name="Hauteur5" placeholder="Hauteur"
                                               class="form-control">
                                    </div>
                                    <div class="col">
                                        <input type="text" id="l" name="Largeur5" placeholder="Largeur"
                                               class="form-control" style="margin-left: 10px;">
                                    </div>
                                    <div class="col">
                                        <input type="text" id="p" name="Profondeur5" placeholder="Profondeur"
                                               class="form-control" style="margin-left: 10px;">
                                    </div>
                                </div>
                                <br/>
                                <h5>Remise :</h5>
                                <div class="form-inline no-margin" style="margin-top: 10px;">
                                    <div class="form-group">
                                        <input type="number" id="r" name="Remis5" placeholder="Remise"
                                               class="form-control"
                                               min="0" max="500000">
                                    </div>
                                </div>

                                <h5>Position :</h5>
                                <div class="form-inline no-margin" style="margin-top: 10px;">
                                    <div class="form-group col-lg-12">
                                        <h5 class="col-lg-1" style="margin:0">X </h5><input type="range" min="-50" max="150"
                                                                                            value="50"
                                                                                            oninput="MoveImage(5)"
                                                                                            class="slider col-lg-11"
                                                                                            name="posX2" id="image_5_pos_x">
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <h5 class="col-lg-1" style="margin:0">Y </h5><input type="range" min="-50" max="150"
                                                                                            value="50"
                                                                                            oninput="MoveImage(5)"
                                                                                            class="slider col-lg-11"
                                                                                            name="posY2" id="image_5_pos_y">
                                    </div>
                            </div>
                        </div>
                    </div>
                    <!-- Apercu 5 -->
                    <div id="image5" class="col-xl-4 col-sm-4 mb-2 margintop image">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"> Aperçu image : </h5>
                            </div>
                            <div class="card-body">
                                <center><img id="img5" src=""></center>
                            </div>
                        </div>
                    </div>

                    <!--  <div id='valider' class="col-xl-10 col-sm-10 mb-6 margintop">
               <div class="card text-white bg-info o-hidden h-100">
                   <div class="card-body">
                       <center><div class="mr-5" onclick="valideDevis()">Valider le devis</div></center>
                   </div>
                   <div class="card-body">
                       <center><div class="mr-5" onclick="valideDevis()">Recommencer le devis</div></center>
                   </div>
                   <div class="card-body">
                       <center><div class="mr-5" onclick="valideDevis()">Enoyer en liste d'attente</div></center>
                   </div>
               </div>
         </div> -->
                    <div id="Validation" class="col-xl-12 col-sm-12 mb-6"
                         style="visibility: hidden; margin-bottom: 20px;">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"> Validation : </h5>
                            </div>
                            <center>
                                <div class="card-body">
                                    <button id="BtnVoirDevis" class="btn btn-primary">Voir le devis</button>


                                    <a href='LigneDevis.php'>
                                        <button id="BtnRecommencer" class="btn btn-danger x2">Recommencer sans
                                            enregistrer
                                        </button>
                                    </a>


                                    <button onclick="UploadPic()" id="submit" class="btn btn-secondary x2">Valider le
                                        devis
                                    </button>
                                </div>
                            </center>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">

    function MoveImage(idDiv) {
        $posX = $('#image_' + idDiv + '_pos_x').val();
        $posY = $('#image_' + idDiv + '_pos_y').val();
        $('#imgSch' + idDiv).css({"left": $posX.toString().concat('px')});
        $('#imgSch' + idDiv).css({"top": $posY.toString().concat('px')});
    }

    //fonction recup value/ img
    function AfficheImg(idDiv) {
        select = document.getElementById('select' + idDiv);
        choice = select.selectedIndex; // Récupération de l'index du <option> choisi

        valeur = select.options[choice].id; // Récupération du texte du <option> d'index "choice"

        var x = document.getElementById('img' + idDiv);
        x.setAttribute("src", valeur);
        x.style.width = "62%";

        var s = document.getElementById('imgSch' + idDiv);
        s.setAttribute("src", valeur);
        s.style.width = "195px";
        s.style.height = "195px";
        s.style.position = "absolute";
        s.style.top = "0px";
        s.style.left = "0px";
        //s.style.opacity = "0.5";


    }


    function fixDiv() {
        var $cache = $('#schema');
        if ($(window).scrollTop() > -1)
            $cache.css({'position': 'fixed', 'top': '100px '});
    }

    // $(function() {
    //     $("#btnSave").click(function() {
    //         html2canvas($("#schema"), {
    //             onrendered: function(canvas) {
    //                 theCanvas = canvas;
    //                 document.body.appendChild(canvas);

    //                 // Convert and download as image
    //                 Canvas2Image.saveAsPNG(canvas);
    //                 //$("#img-out").append(canvas);
    //                 // Clean up
    //                 //document.body.removeChild(canvas);
    //             }
    //         });
    //     });
    // });

    // function UploadPic() {
    //     // Generate the image data
    //      html2canvas($("#schema"), {
    //      onrendered: function(canvas) {
    //      theCanvas = canvas;
    //      document.body.appendChild(canvas);
    //
    //     // Convert and download as image
    //     Canvas2Image.saveAsPNG(canvas);
    //     var Pic = document.getElementById(canvas).toDataURL("image/png");
    //     Pic = Pic.replace(/^data:image\/(png|jpg);base64,/, "")
    //
    //     // Sending the image data to Server
    //     $.ajax({
    //         type: 'POST',
    //         url: 'Save_Picture.aspx/UploadPic',
    //         data: '{ "imageData" : "' + Pic + '" }',
    //         contentType: 'application/json; charset=utf-8',
    //         dataType: 'json',
    //         success: function (msg) {
    //             alert("Done, Picture Uploaded.");
    //         }
    //     });
    // }

    function nouveauDevis() {
        document.getElementById('mat').style.visibility = "visible";

    }

    function affichePiece() {
        document.getElementById('piece').style.visibility = "visible";
        document.getElementById('image').style.visibility = "visible";

        document.getElementById('piece2').style.visibility = "visible";
        document.getElementById('image2').style.visibility = "visible";

        document.getElementById('piece3').style.visibility = "visible";
        document.getElementById('image3').style.visibility = "visible";

        document.getElementById('piece4').style.visibility = "visible";
        document.getElementById('image4').style.visibility = "visible";

        document.getElementById('piece5').style.visibility = "visible";
        document.getElementById('image5').style.visibility = "visible";

        document.getElementById('Validation').style.visibility = "visible";
    }

    $(window).scroll(fixDiv);
    fixDiv();

</script>


