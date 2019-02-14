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


$date = date("d-m-Y");

?>
<script src="../pixi.min.js"></script>
<script src="../pixi-layers.js"></script>

<link rel="stylesheet" href="../public/css/form.css" type="text/css">
<link rel="stylesh\eet" href="../public/css/switch.css" type="text/css">
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

                    </div>
                    <!--SCHEMA-->
                    <div class="col-sm" id="schemaOptionsContainer">

                    </div>
                </div>

                <!--PIECES SELECTIONNEES-->
                <div class="col-sm" id="piecesSelectionneeEtOptionsDevisContainer">

                </div>
            </div>
        </div>
    </div>
</div>


</body>
<script type="text/javascript">// This is demo of pixi-display.js, https://github.com/gameofbombs/pixi-display
    // Drag the rabbits to understand what's going on

    var app = new PIXI.Application(950, 600, {backgroundColor: 0xEEEEEE});
    document.getElementById('schemaOptionsContainer').appendChild(app.view);
    //document.body.appendChild(app.view);

    //META STUFF, groups exist without stage just fine

    // z-index = 0, sorting = true;
    var greenGroup = new PIXI.display.Group(0, true);
    greenGroup.on('sort', function (sprite) {
        //green bunnies go down
        sprite.zOrder = -sprite.y;
    });

    // z-index = 1, sorting = true, we can provide zOrder function directly in constructor
    var blueGroup = new PIXI.display.Group(1, function (sprite) {
        //blue bunnies go up
        sprite.zOrder = +sprite.y;
    });

    // Drag is the best layer, dragged element is above everything else
    var dragGroup = new PIXI.display.Group(2, false);

    // Shadows are the lowest
    var shadowGroup = new PIXI.display.Group(-1, false);

    //specify display list component
    app.stage = new PIXI.display.Stage();
    app.stage.group.enableSort = true;
    //sorry, group cant exist without layer yet :(
    app.stage.addChild(new PIXI.display.Layer(greenGroup));
    app.stage.addChild(new PIXI.display.Layer(blueGroup));
    app.stage.addChild(new PIXI.display.Layer(dragGroup));
    app.stage.addChild(new PIXI.display.Layer(shadowGroup));

    var blurFilter = new PIXI.filters.BlurFilter();
    blurFilter.blur = 0.5;

    // create a texture from an image path
    var texture_green = PIXI.Texture.fromImage('../public/images/figure-65.png');
    var texture_blue = PIXI.Texture.fromImage('../public/images/figure-65.png');

    // make obsolete containers. Why do we need them?
    // Just to show that we can do everything without caring of actual parent container
    var bunniesOdd = new PIXI.Container();
    var bunniesEven = new PIXI.Container();
    var bunniesBlue = new PIXI.Container();
    app.stage.addChild(bunniesOdd);
    app.stage.addChild(bunniesBlue);
    app.stage.addChild(bunniesEven);

    var ind = [];
    for (var i = 0; i < 1; i++) {
        //let bunny = new PIXI.BitmapText("text using a fancy font!", {font: "35px Times New Roman", align: "right"});
        //bunny.width = 150;
        //bunny.height = 100;
        //bunny.position.set(100 + 20 * i, 100 + 20 * i);
        //bunny.anchor.set(0.5);
        // that thing is required
        //bunny.parentGroup = greenGroup;
        if (i % 2 == 0) {
            //bunniesEven.addChild(bunny);
        } else {
            //bunniesOdd.addChild(bunny);
        }
        //subscribe(bunny);
        //addShadow(bunny);
    }

    for (var i = 0; i >= 0; i--) {
        var bunny = new PIXI.Sprite(texture_blue);
        bunny.width = 150;
        bunny.height = 100;
        bunny.position.set(400 + 20 * i, 400 - 20 * i);
        bunny.anchor.set(0.5);
        // that thing is required
        bunny.parentGroup = blueGroup;
        bunniesBlue.addChild(bunny);
        subscribe(bunny);
        addShadow(bunny);
    }

    function subscribe(obj) {
        obj.interactive = true;
        obj.on('mousedown', onDragStart)
            .on('touchstart', onDragStart)
            .on('mouseup', onDragEnd)
            .on('mouseupoutside', onDragEnd)
            .on('touchend', onDragEnd)
            .on('touchendoutside', onDragEnd)
            .on('mousemove', onDragMove)
            .on('touchmove', onDragMove);
    }

    function addShadow(obj) {
        var gr = new PIXI.Graphics();
        gr.beginFill(0x0, 1);
        //yes , I know bunny size, I'm sorry for this hack
        var scale = 1.1;
        gr.drawRect(-25/2 * scale, -36/2 * scale, 25 * scale, 36 * scale);
        gr.endFill();
        gr.filters = [blurFilter];

        gr.parentGroup = shadowGroup;
        obj.addChild(gr);
    }

    function onDragStart(event) {
        if (!this.dragging) {
            this.data = event.data;
            this.oldGroup = this.parentGroup;
            this.parentGroup = dragGroup;
            this.dragging = true;

            this.scale.x *= 1.1;
            this.scale.y *= 1.1;
            this.dragPoint = event.data.getLocalPosition(this.parent);
            this.dragPoint.x -= this.x;
            this.dragPoint.y -= this.y;
        }
    }

    function onDragEnd() {
        if (this.dragging) {
            this.dragging = false;
            this.parentGroup = this.oldGroup;
            this.scale.x /= 1.1;
            this.scale.y /= 1.1;
            // set the interaction data to null
            this.data = null;
        }
    }

    function onDragMove() {
        if (this.dragging) {
            var newPosition = this.data.getLocalPosition(this.parent);
            this.x = newPosition.x - this.dragPoint.x;
            this.y = newPosition.y - this.dragPoint.y;
        }
    }


</script>



