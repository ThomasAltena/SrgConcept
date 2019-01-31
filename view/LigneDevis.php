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
    <div class='container' style="max-width: 100%;">
        <div class="form col-lg-12" name="myform" method="post">
            <div class="row col-lg-12" style="min-width: 1250px">
                <!--OPTIONS ET SCHEMA-->
                <div class="col-sm row"
                     style="max-width: 80%; margin-right: 1vw; height: min-content%; padding-right: 0;">

                    <!--OPTIONS-->
                    <div class="col-sm"
                         style="max-width: 32%; min-width: 260px; margin-right: 1vw;padding-left: 0; padding-right: 0">
                        <div class="formbox" style="margin-bottom: 1vw; height:200px">

                            <!--CHOIX CLIENT-->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width:100px"
                                          id="Id_client_label">Client :</span>
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
                                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"
                                       id="myonoffswitch"
                                       checked>
                                <label class="onoffswitch-label" for="myonoffswitch">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                        <div class="formbox" style="padding-right: 0;padding-left: 0">
                            <!--CHOIX FAMILLE    -->
                            <div class="input-group mb-3" id="selectFamilleContainer">
                                <div class="input-group-prepend">
                                <span class="input-group-text" style="width:100px"
                                      id="Id_famille_label">Famille :</span>
                                </div>
                                <select name="Id_famille" aria-describedby=Id_famille_label" id="select_famille"
                                        onchange="FilterSousFamille(value)"
                                        class="form-control">
                                    <option value="" selected style="font-style: italic">Aucun</option>
                                    <?php
                                    $_POST = [];
                                    $reponse = $bdd->query('SELECT * FROM familles');
                                    while ($donnees = $reponse->fetch()) {
                                        ?>
                                        <option type="submit"
                                                value=" <?php echo $donnees['Code_famille']; ?>"> <?php echo $donnees['Libelle_famille']; ?></option>
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
                                <select name="Id_ss_famille" aria-describedby=Id_ss_famille_label"
                                        id="select_ss_famille"
                                        disabled
                                        class="form-control" onchange="FilterPieces(value)">
                                </select>
                            </div>

                            <!--VUE PIECE-->
                            <div class="formbox row" id="pieceVueEtControlContainer">
                                <span id="pieceVueContainerCount"></span>
                                <div class="col-sm"><img id="imgPieceSelectionnee" src=""
                                                         style="max-width: inherit; max-height: inherit"></div>
                                <div class="col-sm"
                                     id="pieceSelectControlContainer">
                                    <div class="col-sm btn hover-effect-a" id="piece-select-controls"
                                         onclick="PiecesSelectListGoTo(0)"><i
                                                class="fas fa-step-backward fa-rotate-90"></i>
                                    </div>
                                    <div class="col-sm btn hover-effect-a" id="piece-select-controls"
                                         onclick="PiecesSelectListUp()">
                                        <i class="fas fa-chevron-left fa-rotate-90"></i>
                                    </div>
                                    <div class="col-sm btn hover-effect-a" id="piece-select-controls"
                                         onclick="PiecesSelectListDown()">
                                        <i class="fas fa-chevron-right fa-rotate-90"></i>
                                    </div>
                                    <div class="col-sm btn hover-effect-a" id="piece-select-controls"
                                         onclick="PiecesSelectListGoTo(-1)">
                                        <i class="fas fa-step-forward fa-rotate-90"></i>
                                    </div>
                                </div>
                            </div>

                            <!--CHOIX PIECE-->
                            <div class="input-group mb-3" id="selectPieceContainer">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width:100px"
                                          id="Id_piece_label">Piece :</span>
                                </div>
                                <select name="Id_piece" id="select_piece" aria-describedby=Id_piece_label"
                                        onchange="AfficheImg()" class="form-control" disabled>

                                </select>
                            </div>

                            <div class="input-group" id="selectRemiseContainer">
                                <div class="input-group-prepend">
                                <span class="input-group-text" style="width:100px"
                                      id="Remise_piece_label">Remise :</span>
                                </div>
                                <input id="Remise_piece" type="number" class="form-control"
                                       placeholder="0" name="Remise_piece" aria-describedby="Remise_piece_label"
                                       min="0" max="500000">
                            </div>
                        </div>

                    </div>
                    <!--SCHEMA-->
                    <div class="col-sm" id="schemaOptionsContainer">
                        <div class="col-lg-12 formbox" id="schemaPiecesContainer"
                             style="margin-bottom: 1vw; min-height: 600px">
                            <img id="imgPieceSelectionneeSchema" src="">
                        </div>
                        <div class="col-lg-12 row formbox" style="margin-top: 0;">
                            <div class="col-sm-4">
                                <div class="slider-container col-lg-12 row mb-3">
                                    <h5 class="col-sm-1" style="margin:0; padding:0">X </h5><input type="range"
                                                                                                   min="-5000"
                                                                                                   max="6000"
                                                                                                   value="0"
                                                                                                   style="margin:0; padding:0"
                                                                                                   oninput="MoveImage()"
                                                                                                   class="slider col-sm-11"
                                                                                                   name="posX"
                                                                                                   id="pos_x">
                                </div>
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
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="width:100px" id="Profondeur_piece_label">Profondeur :</span>
                                    </div>
                                    <input id="Profondeur_piece" type="number" class="form-control"
                                           placeholder="0" name="Profondeur_piece"
                                           aria-describedby="Profondeur_piece_label">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="slider-container row col-lg-12 mb-3">
                                    <h5 class="col-sm-1" style="margin:0; padding:0">Y </h5><input type="range"
                                                                                                   min="-1000"
                                                                                                   max="5000"
                                                                                                   value="0"
                                                                                                   style="margin:0; padding:0"
                                                                                                   oninput="MoveImage()"
                                                                                                   class="slider col-sm-11"
                                                                                                   name="posY"
                                                                                                   id="pos_y">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="slider-container row col-lg-12 mb-3">
                                    <h5 class="col-sm-1" style="margin:0; padding:0">Z </h5><input type="range"
                                                                                                   min="-1000"
                                                                                                   max="1000"
                                                                                                   value="0"
                                                                                                   style="margin:0; padding:0"
                                                                                                   oninput="MoveImage()"
                                                                                                   class="slider col-sm-11"
                                                                                                   name="posZ"
                                                                                                   id="pos_z">
                                </div>
                                <button class="mb-3 btn btn-primary col-lg-12 hover-effect-a"
                                        onclick="DuplicatePiece()">Ajouter Options
                                </button>
                                <button class="mb-3 btn btn-success col-lg-12 hover-effect-a" id="ajouter_piece_button"
                                        disabled
                                        onclick="SauvegardePiece()">Sauvegarder Piece
                                </button>
                                <button class="btn btn-danger col-lg-12 hover-effect-a" id="effacer_piece_button"
                                        disabled
                                        onclick="EffacerPiece()">Effacer Piece
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!--PIECES SELECTIONNEES-->
                <div class="col-sm" style="max-width: 326px; padding-left: 0; padding-right: 0">
                    <div class="formbox col-lg-12"
                         style="height: 700px; margin-bottom: 1vw; padding: 25px 0 0 0">
                        <div class="row" id="piecesListContainer"
                             style="height: 600px;margin: 0; padding: 0px 0px 0px 20px;">
                        </div>
                        <div class="row" style="height: 25px;margin: 0; padding: 0px;">
                            <div class="col-sm" style="text-align: center;" id="pageNumberContainer">

                            </div>
                        </div>
                        <div class="row col-lg-12" style="height: 50px; margin: 0; padding: 0px;"
                             id="piecesListControls">
                            <div class="col-sm btn hover-effect-a" style="padding-top: 12px;"
                                 onclick="PiecesListGoTo(0)"><i
                                        class="fas fa-step-backward"></i>
                            </div>
                            <div class="col-sm btn hover-effect-a" style="padding-top: 12px;"
                                 onclick="PiecesListPageLeft()">
                                <i class="fas fa-chevron-left"></i>
                            </div>
                            <div class="col-sm btn hover-effect-a" style="padding-top: 12px;"
                                 onclick="PiecesListPageRight()">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                            <div class="col-sm btn hover-effect-a" style="padding-top: 12px;"
                                 onclick="PiecesListGoTo(-1)">
                                <i class="fas fa-step-forward"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm formbox col-lg-12" style="margin-top: 0;">
                        <button class="mb-3 btn btn-primary col-lg-12 hover-effect-a" disabled onclick="">Visualiser
                            Devis
                        </button>
                        <button class="btn btn-success col-lg-12 hover-effect-a" disabled onclick="">Sauvegarder Devis
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
    var piecesListCurrentPage = 0;

    function Piece() {
        this.piecePosition = '';
        this.code_famille = "";
        this.code_ss_famille = "";
        this.id_piece = "";
        this.chemin_piece = "";
        this.pos_x = "";
        this.pos_y = "";
        this.ratio = "";
        this.originalHeight = "";
        this.originalWidth = "";
        this.hauteur = "";
        this.largeur = "";
        this.profondeur = "";
        this.selected = false;
    }

    function MoveImage() {
        var posX = $('#pos_x').val();
        var posY = $('#pos_y').val();
        var posZ = $('#pos_z').val();

        var ratio = 1 + posZ / 1000;

        selectedPiece.pos_x = posX;
        selectedPiece.pos_y = posY;
        selectedPiece.ratio = ratio;
        $('#imgPieceSelectionneeSchema').css({"left": (posX / 10).toString().concat('px')});
        $('#imgPieceSelectionneeSchema').css({"top": (posY / 10).toString().concat('px')});

        $('#imgPieceSelectionneeSchema').css({"max-width": ''});

        var height = selectedPiece.originalHeight * ratio;
        var width = selectedPiece.originalWidth * ratio;

        $('#imgPieceSelectionneeSchema').css({"height": height.toString().concat('px')});
        $('#imgPieceSelectionneeSchema').css({"width": width.toString().concat('px')});
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
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("selectSousFamilleContainer").innerHTML = this.responseText;
                    FilterPieces(document.getElementById("selectPieceContainer").value);
                }
            };

            xhttp.open("GET", "getFilteredSousFamille.php?q=" + code_famille, true);
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
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("selectPieceContainer").innerHTML = this.responseText;
                    AfficheImg();
                }
            };
            xhttp.open("GET", "getFilteredPieces.php?q=" + selectedPiece.code_famille + "&p=" + code_sous_famille, true);
            xhttp.send();
        }
    }

    function ResetFamilleSelector() {
        document.getElementById("select_famille").value = "";
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
            "onchange=\"AfficheImg()\" class=\"form-control\" disabled>\n" +
            "\n" +
            "</select>";
    }

    //fonction recup value/ img
    function AfficheImg() {
        var select = document.getElementById('select_piece');
        if (select.value != "") {
            ToggleSubmitPieceButton(false);
            var choice = select.selectedIndex;

            selectedPiece.chemin_piece = select.value;
            selectedPiece.id_piece = select.options[choice].id;

            var s = document.getElementById('imgPieceSelectionnee');
            s.removeAttribute('hidden');

            s.setAttribute("src", selectedPiece.chemin_piece);
            s.style.width = "inherit";
            s.style.position = "relative";

            var s = document.getElementById('imgPieceSelectionneeSchema');

            s.setAttribute("src", selectedPiece.chemin_piece);
            s.style.position = "absolute";
            s.style.maxWidth = "600px";
            s.style.width = "600px";
            s.style.height = "600px";
            
            selectedPiece.originalHeight = $('#imgPieceSelectionneeSchema').height();
            selectedPiece.originalWidth = $('#imgPieceSelectionneeSchema').width();
            AfficheImageCount();
            MoveImage();
        } else {
            ToggleSubmitPieceButton(true);
        }
    }

    function AfficheImageCount(){
        var piecesCount = document.getElementById('select_piece').options.length;
        var body = '';
        if(piecesCount > 0){
            var selectedIndex = document.getElementById('select_piece').selectedIndex;
            body = 'Piece ' + selectedIndex + '/' + (piecesCount - 1);

        }
        document.getElementById('pieceVueContainerCount').innerHTML = body;
    }

    function SelectPiece(piecePosition) {
        /* selectedPiece = pieces.find(x => x.piecePosition == piecePosition);
         document.getElementById("select_famille").value = selectedPiece.code_famille;
         FilterSousFamille(selectedPiece.code_famille);

         document.getElementById("select_ss_famille").value = selectedPiece.code_ss_famille;
         FilterPieces(selectedPiece.code_ss_famille);
         document.getElementById("select_piece").value = selectedPiece.chemin_piece;*/
    }

    function SauvegardePiece() {
        if (pieces.length) {
            selectedPiece.piecePosition = pieces.length + 1;
        } else {
            selectedPiece.piecePosition = 1;
        }
        pieces.push(selectedPiece);
        selectedPiece = new Piece();
        document.getElementById('imgPieceSelectionnee').setAttribute("src", "");
        document.getElementById('imgPieceSelectionnee').setAttribute("hidden", true);

        var body = '';

        pieces.forEach(function (piece) {
            var text = '<img id="schema_piece_' + selectedPiece.piecePosition + '" ' +
                'src="' + piece.chemin_piece + '" ' +
                'style="height:' + (piece.originalHeight * piece.ratio) + 'px; width:' + (piece.originalWidth * piece.ratio) + 'px;' +
                'position: absolute; left:' + piece.pos_x / 10 + 'px ; top:' + piece.pos_y / 10 + 'px" >\n'
            body = body + text;
        });

        body = body + '<img id="imgPieceSelectionneeSchema" src="">\n';
        document.getElementById("schemaPiecesContainer").innerHTML = body;
        ResetFamilleSelector();
        ResetSousFamilleSelector();
        ResetPieceSelector();
        UpdatePiecesListView(-1);
        ToggleSubmitPieceButton(true);
    }

    function ToggleSubmitPieceButton(bool) {
        $("#ajouter_piece_button").attr("disabled", bool);
    }

    function UpdatePiecesListView(pageSetNumber) {
        var start = 0;
        var end = 8;

        /* -1 va a la derniere page */
        if (pageSetNumber == -1) {
            end = pieces.length;
            start = Math.floor((pieces.length - 1) / 8) * 8;
            piecesListCurrentPage = Math.floor((pieces.length - 1) / 8);

        } else if (pageSetNumber >= 0) {
            start = pageSetNumber * 8;
            end = start + 8;
        }

        var body = '<div class="col-sm" id="selectedPiecesListContainerLeft">\n' +
            '\n';

        for (var x = start; x < end; x++) {
            if (x == start + 4) {
                body += '</div>\n' +
                    '<div class="col-sm" id="selectedPiecesListContainerRight">\n';
            }

            if (pieces[x]) {
                console.log(pieces);
                body += '<div class="col-sm" id="singularSelectedPieceBoxContainer"> \n' +
                    '<span id="singularSelectedPieceNumberContainer">' + pieces[x].piecePosition +
                    '</span>' +
                    '<div class="btn hover-effect-a" ' +
                    'style="width: 135px; height:135px; padding: 0; border:0;" onclick="SelectPiece(\'+pieces[x].piecePosition+\')">' +
                    '<img id="selectable_piece_' + pieces[x].piecePosition + '" src="' + pieces[x].chemin_piece +
                    '" style="max-width: 135px; height: 135px; "' +
                    ' >\n' +
                    '</div></div>\n';
            }
        }
        body += '</div>';

        document.getElementById("piecesListContainer").innerHTML = body;
        SetPageNumberContainer();
    }

    function PiecesListPageRight() {
        if ((piecesListCurrentPage * 8) + 8 < pieces.length) {
            piecesListCurrentPage++;
            UpdatePiecesListView(piecesListCurrentPage);
        }
    }

    function PiecesListPageLeft() {
        if (piecesListCurrentPage >= 1) {
            piecesListCurrentPage--;
            UpdatePiecesListView(piecesListCurrentPage);
        }
    }

    function PiecesListGoTo(page) {
        if (page == 0) {
            piecesListCurrentPage = page;
            UpdatePiecesListView(page);
        }
        if (page == -1) {
            UpdatePiecesListView(page);
        }
    }

    function PiecesSelectListGoTo(page) {
        var optionsLength = document.getElementById("select_piece").options.length;
        if (optionsLength > 0) {
            var currentSelected = document.getElementById("select_piece").options.selectedIndex;
            if (page == 0) {
                document.getElementById("select_piece").options.selectedIndex = 0;
                AfficheImg();
            }
            if (page == -1) {
                document.getElementById("select_piece").options.selectedIndex = optionsLength - 1;
                AfficheImg();
            }
        }
    }

    function PiecesSelectListUp() {
        var currentSelected = document.getElementById("select_piece").options.selectedIndex;
        var newSelect = currentSelected - 1;
        if (newSelect >= 0) {
            document.getElementById("select_piece").options.selectedIndex = newSelect;
            AfficheImg();
        }
    }

    function PiecesSelectListDown() {
        var currentSelected = document.getElementById("select_piece").options.selectedIndex;
        var newSelect = currentSelected + 1;
        if (newSelect < document.getElementById("select_piece").options.length) {
            document.getElementById("select_piece").options.selectedIndex = newSelect;
            AfficheImg();
        }
    }

    function DuplicatePiece() {
        if (pieces[0]) {
            var piece = new Piece();
            pieces.push(piece);
            piece.piecePosition = pieces.length;
        } else {
            var piece = new Piece();
            pieces.push(piece);
            piece.piecePosition = pieces.length;
        }
        UpdatePiecesListView(-1);
    }

    function SetPageNumberContainer() {
        var pageCount;
        pageCount = Math.floor(pieces.length / 8);
        if (Math.floor(pieces.length % 8) > 0) {
            pageCount++;
        }

        var body = '<i> Page ' +
            (piecesListCurrentPage + 1) +
            '/' +
            pageCount +
            '</i>'
        document.getElementById('pageNumberContainer').innerHTML = body;
    }

</script>


