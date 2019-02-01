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
                <div class="col-sm row" id="optionsPrincipaleEtSchemaContainer">
                    <!--OPTIONS-->
                    <div class="col-sm" id="optionsPrincipalContainer">
                        <div class="formbox" style="margin-bottom: 1vw;">

                            <!--CHOIX CLIENT-->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width:100px"
                                          id="Id_client_label">Client :</span>
                                </div>
                                <select name="Id_client" id="id_client" aria-describedby=Id_client_label"
                                        class="form-control" select">
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
                            <div class="row">
                                <div class="col-sm">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"
                                               id="myonoffswitch"
                                               checked>
                                        <label class="onoffswitch-label" for="myonoffswitch">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm formbox" id="matiereImageContainer">
                                    <img id="matiereImage" src="" alt=""
                                         style="max-width: inherit; max-height: inherit">
                                </div>
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
                                                value="<?php echo $donnees['Code_famille']; ?>"> <?php echo $donnees['Libelle_famille']; ?></option>
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
                                <div class="col-sm"><img alt="" id="imagePieceSelectionnee" src=""
                                                         style="max-width: inherit; max-height: inherit">
                                </div>
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
                            <div class="input-group" id="selectPieceContainer">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width:100px"
                                          id="Id_piece_label">Piece :</span>
                                </div>
                                <select name="Id_piece" id="select_piece" aria-describedby=Id_piece_label"
                                        onchange="SelectPiece()" class="form-control" disabled>

                                </select>
                            </div>
                        </div>

                    </div>
                    <!--SCHEMA-->
                    <div class="col-sm" id="schemaOptionsContainer">
                        <div class="col-lg-12 formbox" id="schemaPiecesEtSlidersContainer">
                            <div class="col-lg-12" id="schemaPiecesContainer">
                                <img id="imagePieceSelectionneeSchema" src="" alt"">

                            </div>
                            <div id="deplacementPieceSchemaControlsContainer" class="row">
                                <div id="slider-container" class="col-sm row formbox">
                                    <div class="col-sm-3 row" style="margin:0; padding:0">
                                        <h5 class="col-sm" style="margin:0; padding:0">&nbsp;X </h5>
                                        <input type="number" class="col-sm-9" style="margin-bottom: 5px; padding: 0;"
                                               id="pos_x_number" oninput="MoveByNumber()">
                                    </div>

                                    <input type="range" min="-9999" max="9999" value="0" style="margin:0; padding:0"
                                           oninput="MoveBySlider()" class="slider col-sm-9" name="posX"
                                           id="pos_x_slider">
                                </div>
                                <div id="slider-container" class="col-sm row formbox">
                                    <div class="col-sm-3 row" style="margin:0; padding:0">
                                        <h5 class="col-sm" style="margin:0; padding:0">&nbsp;Y </h5>
                                        <input type="number" class="col-sm-9" style="margin-bottom: 5px; padding: 0;"
                                               id="pos_y_number" oninput="MoveByNumber()">
                                    </div>
                                    <input type="range"
                                           min="-9999"
                                           max="9999"
                                           value="0"
                                           style="margin:0; padding:0"
                                           oninput="MoveBySlider()"
                                           class="slider col-sm-9"
                                           name="posY"
                                           id="pos_y_slider">
                                </div>
                                <div id="slider-container" class="col-sm row formbox">
                                    <div class="col-sm-3 row" style="margin:0; padding:0">
                                        <h5 class="col-sm" style="margin:0; padding:0">&nbsp;Z </h5>
                                        <input type="number" class="col-sm-9" style="margin-bottom: 5px; padding: 0;"
                                               id="pos_z_number" oninput="MoveByNumber()">
                                    </div>
                                    <input type="range"
                                           min="-999"
                                           max="999"
                                           value="0"
                                           style="margin:0; padding:0"
                                           oninput="MoveBySlider()"
                                           class="slider col-sm-9"
                                           name="posZ"
                                           id="pos_z_slider">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 row formbox" id="optionsButtonsContainer" style="margin-top: 0;">
                            <div class="col-sm" id="inputOptionsContainer">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="width:100px" id="Hauteur_piece_label">Hauteur :</span>
                                    </div>
                                    <input id="hauteur_piece" type="number" class="form-control"
                                           onchange="UpdatePieceInputOptions()"
                                           placeholder="0" name="Hauteur_piece" aria-describedby="Hauteur_piece_label">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="width:100px" id="Largeur_piece_label">Largeur :</span>
                                    </div>
                                    <input id="largeur_piece" type="number" class="form-control"
                                           onchange="UpdatePieceInputOptions()"
                                           placeholder="0" name="Largeur_piece" aria-describedby="Largeur_piece_label">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="width:100px" id="Profondeur_piece_label">Profondeur :</span>
                                    </div>
                                    <input id="profondeur_piece" type="number" class="form-control"
                                           onchange="UpdatePieceInputOptions()"
                                           placeholder="0" name="Profondeur_piece"
                                           aria-describedby="Profondeur_piece_label">
                                </div>

                                <div class="input-group" id="selectRemiseContainer">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" style="width:100px"
                                          id="Remise_piece_label">Remise :</span>
                                    </div>
                                    <input id="remise_piece" type="number" class="form-control"
                                           placeholder="0" name="Remise_piece" aria-describedby="Remise_piece_label"
                                           min="0" max="500000">
                                </div>
                            </div>
                            <div class="col-sm" id="pieceButtonsContainer">
                                <button class="mb-3 btn btn-primary col-lg-12 hover-effect-a"
                                        onclick="DuplicatePiece()">Ajouter Options
                                </button>
                                <button class="mb-3 btn btn-success col-lg-12 hover-effect-a" id="ajouter_piece_button"
                                        disabled
                                        onclick="SauvegarderNouvellePiece()">Ajouter Piece
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!--PIECES SELECTIONNEES-->
                <div class="col-sm" id="piecesSelectionneeEtOptionsDevisContainer">
                    <div class="formbox col-lg-12" id="piecesSelectionneeEtOptionsPiecesContainer">
                        <div class="row" id="piecesListContainer"
                             style="height: 600px;margin: 0; padding: 0 0 0 20px;">
                        </div>
                        <div class="row" style="height: 25px;margin: 0; padding: 0;">
                            <div class="col-sm" style="text-align: center;" id="pageNumberContainer">

                            </div>
                        </div>
                        <div class="row col-lg-12" style="height: 50px; margin: 0; padding: 0;"
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
    let selectedPiece = new Piece();
    let pieces = [];
    let piecesListCurrentPage = 0;

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
        this.remise = "";
        this.profondeur = "";
        this.selected = false;
        this.loading = false;
    }

    function MoveBySlider() {
        document.getElementById('pos_x_number').value = document.getElementById('pos_x_slider').value;
        document.getElementById('pos_y_number').value = document.getElementById('pos_y_slider').value;
        document.getElementById('pos_z_number').value = document.getElementById('pos_z_slider').value;
        MovePieceImage();
    }

    function MoveByNumber() {
        document.getElementById('pos_x_slider').value = document.getElementById('pos_x_number').value;
        document.getElementById('pos_y_slider').value = document.getElementById('pos_y_number').value;
        document.getElementById('pos_z_slider').value = document.getElementById('pos_z_number').value;
        MovePieceImage();
    }

    function MovePieceImage() {
        let imagePieceSelectionneeSchema = $('#imagePieceSelectionneeSchema');
        let posX = $('#pos_x_slider').val();
        let posY = $('#pos_y_slider').val();
        let posZ = $('#pos_z_slider').val();

        let ratio = 1 + posZ / 1000;

        selectedPiece.pos_x = posX;
        selectedPiece.pos_y = posY;
        selectedPiece.ratio = ratio;

        imagePieceSelectionneeSchema.css({"left": (posX / 10).toString().concat('px')});
        imagePieceSelectionneeSchema.css({"top": (posY / 10).toString().concat('px')});

        imagePieceSelectionneeSchema.css({"max-width": ''});

        let height = selectedPiece.originalHeight * ratio;
        let width = selectedPiece.originalWidth * ratio;

        imagePieceSelectionneeSchema.css({"height": height.toString().concat('px')});
        imagePieceSelectionneeSchema.css({"width": width.toString().concat('px')});
    }

    function UpdatePieceInputOptions() {
        selectedPiece.hauteur = document.getElementById('hauteur_piece').value;
        selectedPiece.largeur = document.getElementById('largeur_piece').value;
        selectedPiece.profondeur = document.getElementById('profondeur_piece').value;
        selectedPiece.remise = document.getElementById('remise_piece').value;
    }

    function FilterSousFamille(code_famille, code_ss_famille_to_select) {
        selectedPiece.code_famille = code_famille;
        let xhttp;

        if (code_famille === "") {
            ResetSousFamilleSelector();
            ResetPieceSelector();
            HideSliders();
            ResetSliders();
            ResetInputOptions();
            HidePieceSelectors();
            HideOptions();
            UpdateImageCount();
            ToggleSubmitPieceButton(false);
            HideSelectedPieceSchema();
            HideSelectedPiecePreview();
            ResetPiecePosition();
        } else {
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    document.getElementById("selectSousFamilleContainer").innerHTML = this.responseText;
                    FilterPieces(document.getElementById("selectPieceContainer").value);
                    if (code_ss_famille_to_select) {
                        var selectSousFamille = document.getElementById("select_ss_famille");
                        for (var x = 0; x < selectSousFamille.options.length; x++) {
                            if (selectSousFamille.options[x].value === code_ss_famille_to_select) {
                                selectSousFamille.selectedIndex = x;
                                break;
                            }
                        }
                    }
                }
            };
            xhttp.open("GET", "getFilteredSousFamille.php?q=" + code_famille, true);
            xhttp.send();
        }
    }

    function FilterPieces(code_sous_famille, code_piece_to_select) {
        let ss_famille_selected_index = document.getElementById("select_ss_famille").selectedIndex;
        if (ss_famille_selected_index >= 0) {
            selectedPiece.code_ss_famille = document.getElementById("select_ss_famille").options[ss_famille_selected_index].value;
        }

        let xhttp;
        if (selectedPiece.code_famille === "" || selectedPiece.code_ss_famille === "") {
            ResetPieceSelector();
            HideSliders();
            ResetSliders();
            ResetInputOptions();
            HidePieceSelectors();
            HideOptions();
            UpdateImageCount();
            ToggleSubmitPieceButton(false);
            HideSelectedPieceSchema();
            HideSelectedPiecePreview();
            ResetPiecePosition();
        } else {
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    document.getElementById("selectPieceContainer").innerHTML = this.responseText;
                    let selectPiece = document.getElementById("select_piece");

                    if (selectPiece.options.length >= 0) {
                        if (code_piece_to_select) {
                            for (let x = 0; x < selectPiece.options.length; x++) {
                                if (selectPiece.options[x].value === code_piece_to_select) {
                                    selectPiece.selectedIndex = x;
                                    break;
                                }
                            }
                        } else {
                            selectPiece.selectedIndex = 0;
                            SelectPiece();
                        }
                    }
                }
            };
            xhttp.open("GET", "getFilteredPieces.php?q=" + selectedPiece.code_famille + "&p=" + code_sous_famille, true);
            xhttp.send();
        }
    }

    function ReloadPieceState() {
        document.getElementById('pos_x_slider').value = selectedPiece.pos_x;
        document.getElementById('pos_y_slider').value = selectedPiece.pos_y;
        document.getElementById('pos_z_slider').value = (selectedPiece.ratio - 1) * 1000;

        document.getElementById('largeur_piece').value = selectedPiece.largeur;
        document.getElementById('profondeur_piece').value = selectedPiece.profondeur;
        document.getElementById('hauteur_piece').value = selectedPiece.hauteur;
        document.getElementById('remise_piece').value = selectedPiece.remise;
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
            "onchange=\"SelectPiece()\" class=\"form-control\" disabled>\n" +
            "\n" +
            "</select>";
    }

    //fonction recup value/ img
    function SelectPiece() {
        let select = document.getElementById('select_piece');
        if (!selectedPiece.loading) {
            if (select.value !== "") {
                let imagePieceSelectionneeSchema = $('#imagePieceSelectionneeSchema');
                let choice = select.selectedIndex;

                selectedPiece.chemin_piece = select.value;
                selectedPiece.id_piece = select.options[choice].id;

                ShowSelectedPieceSchema();
                ShowSelectedPiecePreview();

                //ResetSliders();
                //ResetPiecePosition();

                selectedPiece.originalHeight = imagePieceSelectionneeSchema.height();
                selectedPiece.originalWidth = imagePieceSelectionneeSchema.width();

                ShowSliders();
                ShowPieceSelectors();
                ShowOptions();
                UpdateImageCount();
                ToggleSubmitPieceButton(true);
                ResetPiecePosition();
                MovePieceImage();
            } else {
                ReloadSchema();
                HideSliders();
                ResetSliders();
                ResetInputOptions();
                HidePieceSelectors();
                HideOptions();
                UpdateImageCount();
                ToggleSubmitPieceButton(false);
                HideSelectedPieceSchema();
                HideSelectedPiecePreview();
                ResetPiecePosition();
            }
        } else {

            ShowSelectedPieceSchema();
            ShowSelectedPiecePreview();
            MoveBySlider();
            UpdateImageCount();
            ShowSliders();
            ShowPieceSelectors();
            ShowOptions();
            selectedPiece.loading = false;
        }
    }

    function SelectExistingPiece(piecePosition) {
        selectedPiece = pieces.find(x => x.piecePosition === piecePosition);
        selectedPiece.selected = true;
        selectedPiece.loading = true;
        ReloadSchema();
        ReloadPieceState();
        document.getElementById('pieceButtonsContainer').innerHTML = '<button class="mb-3 btn btn-primary col-lg-12 hover-effect-a"\n' +
            '                                        onclick="" disabled>Ajouter Options\n' +
            '</button>\n' +
            '<button class="mb-3 btn btn-warning col-lg-12 hover-effect-a" id="ajouter_piece_button"\n' +
            '                                        onclick="SauvegarderModificationsPiece()">Sauvegarder Piece\n' +
            '</button>\n' +
            '<button class="btn btn-danger col-lg-12 hover-effect-a" id="effacer_piece_button"\n' +
            '                                        onclick="DeletePiece()">Effacer Piece\n' +
            '</button>';
        document.getElementById("select_famille").value = selectedPiece.code_famille;
        FilterSousFamille(selectedPiece.code_famille, selectedPiece.code_ss_famille);
        FilterPieces(selectedPiece.code_ss_famille, selectedPiece.chemin_piece);

        MovePieceImage();

    }

    function ResetPiecePosition() {
        selectedPiece.ratio = 0;
        selectedPiece.pos_y = 0;
        selectedPiece.pos_x = 0;
    }

    function HideSelectedPieceSchema() {
        document.getElementById('imagePieceSelectionneeSchema').setAttribute("src", "");
        document.getElementById('imagePieceSelectionneeSchema').setAttribute('style', 'visibility: hidden');
    }

    function HideSelectedPiecePreview() {
        document.getElementById('imagePieceSelectionnee').setAttribute("src", "");
        document.getElementById('imagePieceSelectionnee').setAttribute('style', 'visibility: hidden');
    }

    function ShowSelectedPieceSchema() {
        if (selectedPiece.chemin_piece !== "") {
            let imagePieceSelectionnee = document.getElementById('imagePieceSelectionnee');
            imagePieceSelectionnee.setAttribute('style', 'visibility: visible');
            imagePieceSelectionnee.setAttribute("src", selectedPiece.chemin_piece);
            imagePieceSelectionnee.style.width = "inherit";
            imagePieceSelectionnee.style.position = "relative";
        }
    }

    function ShowSelectedPiecePreview() {
        if (selectedPiece.chemin_piece !== "") {
            let imagePieceSelectionneeSchema = document.getElementById('imagePieceSelectionneeSchema');
            imagePieceSelectionneeSchema.setAttribute('style', 'visibility: visible');
            imagePieceSelectionneeSchema.setAttribute("src", selectedPiece.chemin_piece);
            imagePieceSelectionneeSchema.style.position = "absolute";
            imagePieceSelectionneeSchema.style.maxWidth = "600px";
            imagePieceSelectionneeSchema.style.width = "600px";
            imagePieceSelectionneeSchema.style.height = "600px";
        }
    }

    function UpdateImageCount() {
        let piecesCount = document.getElementById('select_piece').options.length;
        let body = '';
        if (piecesCount > 0) {
            let selectedIndex = document.getElementById('select_piece').selectedIndex;
            body = 'Piece ' + (selectedIndex + 1) + '/' + (piecesCount);

        }
        document.getElementById('pieceVueContainerCount').innerHTML = body;
    }

    function SauvegarderNouvellePiece() {
        if (pieces.length) {
            selectedPiece.piecePosition = pieces.length + 1;
        } else {
            selectedPiece.piecePosition = 1;
        }
        pieces.push(selectedPiece);

        selectedPiece = new Piece();

        document.getElementById('imagePieceSelectionnee').setAttribute("src", "");
        document.getElementById('imagePieceSelectionnee').setAttribute('style', 'visibility: hidden');

        ReloadSchema();
        ResetFamilleSelector();
        ResetSousFamilleSelector();
        ResetPieceSelector();

        HideSliders();
        ResetSliders();
        ResetInputOptions();
        HidePieceSelectors();
        HideOptions();
        UpdateImageCount();
        ToggleSubmitPieceButton(false);
        HideSelectedPieceSchema();
        HideSelectedPiecePreview();
        ResetPiecePosition();

        UpdatePiecesListView(-1);
    }

    function SauvegarderModificationsPiece() {
        selectedPiece.selected = false;
        selectedPiece = new Piece();

        document.getElementById('imagePieceSelectionnee').setAttribute("src", "");
        document.getElementById('imagePieceSelectionnee').setAttribute('style', 'visibility: hidden');

        ReloadSchema();
        ResetFamilleSelector();
        ResetSousFamilleSelector();
        ResetPieceSelector();

        HideSliders();
        ResetSliders();
        ResetInputOptions();
        HidePieceSelectors();
        HideOptions();
        UpdateImageCount();
        ToggleSubmitPieceButton(false);
        HideSelectedPieceSchema();
        HideSelectedPiecePreview();
        ResetPiecePosition();

        UpdatePiecesListView();
        ResetOptionsBoutonSchema();
    }

    function ResetOptionsBoutonSchema() {
        document.getElementById('pieceButtonsContainer').innerHTML = '<button class="mb-3 btn btn-primary col-lg-12 hover-effect-a"\n' +
            '                                        onclick="DuplicatePiece()">Ajouter Options\n' +
            '                                </button>\n' +
            '                                <button class="mb-3 btn btn-success col-lg-12 hover-effect-a" id="ajouter_piece_button"\n' +
            '                                        disabled\n' +
            '                                        onclick="SauvegarderNouvellePiece()">Ajouter Piece\n' +
            '                                </button>';
    }

    function HideSliders() {
        document.getElementById('pieceSelectControlContainer').setAttribute('style', 'visibility: hidden');
    }

    function HidePieceSelectors() {
        document.getElementById('deplacementPieceSchemaControlsContainer').setAttribute('style', 'visibility: hidden');
    }

    function HideOptions() {
        document.getElementById('inputOptionsContainer').setAttribute('style', 'visibility: hidden');
        document.getElementById('pieceButtonsContainer').setAttribute('style', 'visibility: hidden');
    }

    function ShowSliders() {
        document.getElementById('pieceSelectControlContainer').setAttribute('style', 'visibility: visible');
    }

    function ShowPieceSelectors() {
        document.getElementById('deplacementPieceSchemaControlsContainer').setAttribute('style', 'visibility: visible');
    }

    function ShowOptions() {
        document.getElementById('inputOptionsContainer').setAttribute('style', 'visibility: visible');
        document.getElementById('pieceButtonsContainer').setAttribute('style', 'visibility: visible');
    }

    function ResetSliders() {
        document.getElementById('pos_x_slider').value = '0';
        document.getElementById('pos_y_slider').value = '0';
        document.getElementById('pos_z_slider').value = '0';
        document.getElementById('pos_x_number').value = '0';
        document.getElementById('pos_y_number').value = '0';
        document.getElementById('pos_z_number').value = '0';
    }

    function ResetInputOptions() {
        document.getElementById('hauteur_piece').value = '0';
        document.getElementById('largeur_piece').value = '0';
        document.getElementById('profondeur_piece').value = '0';
    }

    function ReloadSchema() {
        let body = '';
        pieces.forEach(function (piece) {
            if(!piece.selected){
                let text = '<img alt="Une piece parmis pleins sur schema" id="schema_piece_' + selectedPiece.piecePosition + '" ' +
                    'src="' + piece.chemin_piece + '" ' +
                    'style="height:' + (piece.originalHeight * piece.ratio) + 'px; width:' + (piece.originalWidth * piece.ratio) + 'px;' +
                    'position: absolute; left:' + piece.pos_x / 10 + 'px ; top:' + piece.pos_y / 10 + 'px" >\n';
                body = body + text;
            }
        });

        body = body + '<img alt="La piece couramment selectionnee sur schema" id="imagePieceSelectionneeSchema" src="">\n';
        document.getElementById("schemaPiecesContainer").innerHTML = body;
    }

    function DeletePiece(piecePosition) {
        if (!piecePosition) {
            piecePosition = selectedPiece.piecePosition;
            selectedPiece = new Piece();

            ResetOptionsBoutonSchema();
            ResetFamilleSelector();
            ResetSousFamilleSelector();
            ResetPieceSelector();

            document.getElementById('imagePieceSelectionnee').setAttribute("src", "");
            document.getElementById('imagePieceSelectionnee').setAttribute('style', 'visibility: hidden');

            HideSliders();
            ResetSliders();
            ResetInputOptions();
            HidePieceSelectors();
            HideOptions();
            UpdateImageCount();
            ToggleSubmitPieceButton(false);
            HideSelectedPieceSchema();
            HideSelectedPiecePreview();
        }

        pieces = pieces.filter(x => x.piecePosition !== piecePosition);
        let pos = 1;
        pieces.forEach(piece => {
            piece.piecePosition = pos;
            pos++;
        });

        UpdatePiecesListView(piecesListCurrentPage);
        ReloadSchema();
    }

    function ToggleSubmitPieceButton(bool) {
        $("#ajouter_piece_button").attr("disabled", !bool);
    }

    function UpdatePiecesListView(pageSetNumber) {
        let start = 0;
        let end = 8;

        /* -1 va a la derniere page */
        if (pageSetNumber === -1) {
            end = pieces.length;
            start = Math.floor((pieces.length - 1) / 8) * 8;
            piecesListCurrentPage = Math.floor((pieces.length - 1) / 8);

        } else if (pageSetNumber >= 0) {
            start = pageSetNumber * 8;
            end = start + 8;
        }

        if (!pieces[end - 1]) {
            end = pieces.length;
            start = Math.floor((pieces.length - 1) / 8) * 8;
            piecesListCurrentPage = Math.floor((pieces.length - 1) / 8);
        }

        let body = '<div class="col-sm" id="selectedPiecesListContainerLeft">\n' +
            '\n';

        for (let x = start; x < end; x++) {
            if (x === (start + 4)) {
                body += '</div>\n' +
                    '<div class="col-sm" id="selectedPiecesListContainerRight">\n';
            }

            if (pieces[x]) {
                body += '<div class="col-sm" id="singularSelectedPieceBoxContainer"> \n' +
                    '<div id="deletePieceIconContainer">\n' +
                    '    <div class="btn hover-effect-a" id="deletePieceIcon" onclick="DeletePiece(' + pieces[x].piecePosition + ' )">\n' +
                    '        <i class="fas fa-trash-alt"></i>\n' +
                    '    </div>\n' +
                    '</div>' +
                    '<span id="singularSelectedPieceNumberContainer">' + pieces[x].piecePosition +
                    '</span>' +
                    '<div class="btn hover-effect-a" id="singularSelectedPieceImageSubContainer" ' +
                    'onclick="SelectExistingPiece(' + pieces[x].piecePosition + ')">' +
                    '<img alt="Une piece parmis pleins" id="selectable_piece_' + pieces[x].piecePosition + '" src="' + pieces[x].chemin_piece +
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
        if (page === 0) {
            piecesListCurrentPage = page;
            UpdatePiecesListView(page);
        }
        if (page === -1) {
            UpdatePiecesListView(page);
        }
    }

    function PiecesSelectListGoTo(page) {
        let optionsLength = document.getElementById("select_piece").options.length;
        if (optionsLength > 0) {
            if (page === 0) {
                document.getElementById("select_piece").options.selectedIndex = 0;
                SelectPiece();
            }
            if (page === -1) {
                document.getElementById("select_piece").options.selectedIndex = optionsLength - 1;
                SelectPiece();
            }
        }
    }

    function PiecesSelectListUp() {
        let currentSelected = document.getElementById("select_piece").options.selectedIndex;
        let newSelect = currentSelected - 1;
        if (newSelect >= 0) {
            document.getElementById("select_piece").options.selectedIndex = newSelect;
            SelectPiece();
        }
    }

    function PiecesSelectListDown() {
        let currentSelected = document.getElementById("select_piece").options.selectedIndex;
        let newSelect = currentSelected + 1;
        if (newSelect < document.getElementById("select_piece").options.length) {
            document.getElementById("select_piece").options.selectedIndex = newSelect;
            SelectPiece();
        }
    }

    function DuplicatePiece() {
        let piece = new Piece();
        pieces.push(piece);
        piece.piecePosition = pieces.length;
        UpdatePiecesListView(-1);
    }

    function SetPageNumberContainer() {
        let pageCount;
        pageCount = Math.floor(pieces.length / 8);
        if (Math.floor(pieces.length % 8) > 0) {
            pageCount++;
        }
        document.getElementById('pageNumberContainer').innerHTML = '<i> Page ' +
            (piecesListCurrentPage + 1) +
            '/' +
            pageCount +
            '</i>';
    }

</script>


