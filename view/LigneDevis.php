<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
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

if ($IdDevis) {
    foreach ($IdDevis as $IdDevi) ;
    $Devis = $IdDevi['Id_devis'];
    $User = $IdDevi['IdUser_devis'];
    $Client = $IdDevi['IdClient_devis'];
}


$date = date("d-m-Y");

?>
<link rel="stylesheet" href="../public/css/form.css" type="text/css">
<link rel="stylesheet" href="../public/css/switch.css" type="text/css">
<!-------------------------- Il faut mettre le chemin dans les value -------------------------->
<body>
<div id="content-wrapper">
    <div class='container' style="max-width: 90%;">
        <div class="form col-lg-12" name="myform" method="post">
            <div class="row col-lg-12">
                <!--OPTIONS ET SCHEMA-->
                <div class="col-sm row" style="max-width: 80%; margin-right: 1vw; height: min-content%; padding-right: 0;">

                    <!--OPTIONS-->
                    <div class="col-sm" style="max-width: 32%; margin-right: 1vw;padding-left: 0; padding-right: 0"">
                        <div class="formbox" style="margin-bottom: 1vw; height:200px">

                            <!--CHOIX CLIENT-->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width:100px" id="Id_client_label">Client :</span>
                                </div>
                                <select name="Id_client" aria-describedby=Id_client_label" class="form-control" select">
                                <?php
                                $reponse = $bdd->query('SELECT * FROM clients');
                                while ($donnees = $reponse->fetch()) {
                                    ?>
                                    <option value="<?php echo $donnees['Id_client']; ?>"> <?php echo $donnees['Nom_client']; ?></option>
                                    <?php
                                }
                                ?>
                                </select>
                            </div>

                            <!--CHOIX MATIERE-->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                <span class="input-group-text" style="width:100px"
                                      id="Id_matiere_label">Matière :</span>
                                </div>
                                <select name="Id_matiere" aria-describedby=Id_matiere_label" id="select"
                                        class="form-control">
                                    <?php
                                    $reponse = $bdd->query('SELECT * FROM matieres');
                                    while ($donnees = $reponse->fetch()) {
                                        ?>
                                        <option value=" <?php echo $donnees['Id_matiere']; ?>"> <?php echo $donnees['Libelle_matiere']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <!--SWITCH DOUBLE SIMPLE-->
                            <div class="mb-3 onoffswitch">
                                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch"
                                       checked>
                                <label class="onoffswitch-label" for="myonoffswitch">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                        <div class="formbox" style="">
                            <!--CHOIX FAMILLE    -->
                            <div class="input-group mb-3" id="selectSousFamilleContainer">
                                <div class="input-group-prepend">
                                <span class="input-group-text" style="width:100px"
                                      id="Id_famille_label">Famille :</span>
                                </div>
                                <select name="Id_famille" aria-describedby=Id_famille_label" id="select_famille" onchange="FilterSousFamille(value)"
                                        class="form-control">
                                    <option value="" selected style="font-style: italic">Aucun</option>
                                    <?php
                                    $_POST = [];
                                    $reponse = $bdd->query('SELECT * FROM familles');
                                    while ($donnees = $reponse->fetch()) {
                                        ?>
                                        <option type="submit" value=" <?php echo $donnees['Code_famille']; ?>"> <?php echo $donnees['Libelle_famille']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <!--CHOIX SOUS FAMILLE-->
                            <div class="input-group mb-3" id="selectSousFamilleContainer">
                                <div class="input-group-prepend">
                                <span class="input-group-text" style="width:100px"
                                      id="Id_ss_famille_label">Sous-fam :</span>
                                </div>
                                <select name="Id_ss_famille" aria-describedby=Id_ss_famille_label" id="select_ss_famille" disabled
                                        class="form-control" onchange="FilterPieces(value)">
                                </select>
                            </div>

                            <!--VUE PIECE-->
                            <div class="formbox" style="width: 100%; height: 359px;">
                                <img id="imgPieceSelectionnee" src="" style="max-width: inherit; max-height: inherit">
                            </div>

                            <!--CHOIX PIECE-->
                            <div class="input-group mb-3" id="selectPieceContainer">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width:100px" id="Id_piece_label">Piece :</span>
                                </div>
                                <select name="Id_piece" id="select_piece" aria-describedby=Id_piece_label"
                                        onchange="AfficheImg(1)" class="form-control" disabled>

                                </select>
                            </div>
                            <!--Hidden Submit button-->
                            <button type="submit" style="visibility: hidden" id="submitButton"></button>
                        </div>
                    </div>

                    <!--SCHEMA-->
                    <div class="col-sm" style="max-width: 100%; padding-right: 0; padding-left: 0;">
                        <div class="col-lg-12 formbox" id="schemaPiecesContainer" style="margin-bottom: 1vw; height: 600px">
                            <img id="imgPieceSelectionneeSchema" src="">
                        </div>
                        <div class="col-lg-12 row formbox" style="margin-top: 0; height: 200px">
                            <div class="col-sm-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="width:100px" id="Hauteur_piece_label">Hauteur :</span>
                                    </div>
                                    <input id="Hauteur_piece" type="number" class="form-control"
                                           placeholder="0" name="Hauteur_piece" aria-describedby="Hauteur_piece_label">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="width:100px" id="Largeur_piece_label">Largeur :</span>
                                    </div>
                                    <input id="Largeur_piece" type="number" class="form-control"
                                           placeholder="0" name="Largeur_piece" aria-describedby="Largeur_piece_label">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="width:100px" id="Profondeur_piece_label">Hauteur :</span>
                                    </div>
                                    <input id="Profondeur_piece" type="number" class="form-control"
                                           placeholder="0" name="Profondeur_piece"
                                           aria-describedby="Profondeur_piece_label">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="width:100px" id="Remise_piece_label">Remise :</span>
                                    </div>
                                    <input id="Remise_piece" type="number" class="form-control"
                                           placeholder="0" name="Remise_piece" aria-describedby="Remise_piece_label"
                                           min="0" max="500000">
                                </div>
                                <button class="mb-3 btn btn-primary col-lg-12" onclick="AjoutePiece()">Ajouter
                                    Options
                                </button>
                                <button class="mb-3 btn btn-success col-lg-12" onclick="AjoutePiece()">Ajouter Piece
                                </button>

                            </div>
                        </div>
                    </div>
                </div>

                <!--PIECES SELECTIONNEES-->
                <div class="col-sm" style="max-width: 19.9%; padding-left: 0; padding-right: 0">
                    <div class="col-sm formbox col-lg-12" style="height: 600px; margin-bottom: 1vw">

                    </div>
                    <div class="col-sm formbox col-lg-12" style="margin-top: 0; height: 200px">
                        <button class="mb-3 btn btn-warning col-lg-12" onclick="AjouterOptions()">Visualiser Devis
                        </button>
                        <button class="mb-3 btn btn-danger col-lg-12" onclick="AjouterOptions()">Sauvegarder Devis
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
    var selectedPiece = new Piece();
    var pieces = new Array();

    function Piece() {
        this.piecePosition = '';
        this.code_famille = "";
        this.code_ss_famille = "";
        this.id_piece = "";
        this.chemin_piece = "";
    }

    function FilterSousFamille(code_famille) {
        selectedPiece.code_famille = code_famille;
        var xhttp;

        if (code_famille == "") {
            ResetSousFamilleSelector();
            ResetPieceSelector();
            return;
        } else {
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("selectSousFamilleContainer").innerHTML = this.responseText;
                }
            };

            xhttp.open("GET", "getFilteredSousFamille.php?q="+code_famille, true);
            xhttp.send();
        }
    }

    function FilterPieces(code_sous_famille) {
        selectedPiece.code_ss_famille = code_sous_famille;
        var xhttp;
        if (selectedPiece.code_famille == "" || selectedPiece.code_ss_famille == "") {
            ResetPieceSelector();
            return;
        } else {
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("selectPieceContainer").innerHTML = this.responseText;
                }
            };

            xhttp.open("GET", "getFilteredPieces.php?q="+selectedPiece.code_famille+"&p="+code_sous_famille, true);
            xhttp.send();
        }
    }

    function ResetFamilleSelector() {
        document.getElementById("selectSousFamilleContainer").innerHTML =
            "<div class=\"input-group-prepend\">\n" +
            "<span class=\"input-group-text\" style=\"width:100px\"\n" +
            "id=\"Id_ss_famille_label\">Sous-fam :</span>\n" +
            "</div>\n" +
            "<select name=\"Id_ss_famille\" aria-describedby=Id_ss_famille_label\" id=\"select_ss_famille\" disabled\n" +
            "class=\"form-control\" onchange=\"FilterPieces(value)\">\n" +
            "</select>";
    }

    function ResetSousFamilleSelector() {
        document.getElementById("selectSousFamilleContainer").innerHTML =
            "<div class=\"input-group-prepend\">\n" +
            "<span class=\"input-group-text\" style=\"width:100px\"\n" +
            "id=\"Id_ss_famille_label\">Sous-fam :</span>\n" +
            "</div>\n" +
            "<select name=\"Id_ss_famille\" aria-describedby=Id_ss_famille_label\" id=\"select_ss_famille\" disabled\n" +
            "class=\"form-control\" onchange=\"FilterPieces(value)\">\n" +
            "</select>";
    }

    function ResetPieceSelector() {
        document.getElementById("selectPieceContainer").innerHTML =
            "<div class=\"input-group-prepend\">\n" +
            "<span class=\"input-group-text\" style=\"width:100px\" id=\"Id_piece_label\">Piece :</span>\n" +
            "</div>\n" +
            "<select name=\"Id_piece\" id=\"select_piece\" aria-describedby=Id_piece_label\"\n" +
            "onchange=\"AfficheImg(1)\" class=\"form-control\" disabled>\n" +
            "\n" +
            "</select>";
    }

    //fonction recup value/ img
    function AfficheImg(idDiv) {
        var select = document.getElementById('select_piece');
        var choice = select.selectedIndex;

        selectedPiece.chemin_piece = select.value;
        selectedPiece.id_piece = select.options[choice].id;

        var s = document.getElementById('imgPieceSelectionnee');

        s.setAttribute("src", selectedPiece.chemin_piece);
        s.style.width = "300px";
        s.style.height = "300px";
        s.style.position = "absolute";

        var s = document.getElementById('imgPieceSelectionneeSchema');

        s.setAttribute("src", selectedPiece.chemin_piece);
        s.style.width = "550";
        s.style.height = "550px";
        s.style.marginLeft = "100px";
        s.style.position = "absolute";
    }

    function AjoutePiece(){
        selectedPiece.piecePosition = pieces.length;
        pieces.push(selectedPiece);
        selectedPiece = new Piece();

        var body = '';

        pieces.forEach(function(piece) {
            var text = '<img id="'+selectedPiece.piecePosition+'" src="' + piece.chemin_piece + '" style="max-width: 550px; height: 550px; margin-left: 100px; position: absolute;" >\n'
            body = body + text;
        });
        body = body + '<img id="imgPieceSelectionneeSchema" src="">\n';
        document.getElementById("schemaPiecesContainer").innerHTML = body;
    }

</script>


