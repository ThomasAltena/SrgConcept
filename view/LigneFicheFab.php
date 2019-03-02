<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
  <title>Monumac</title>
</head>
<link rel="stylesheet" href="../public/css/form.css" type="text/css">
<?php
session_start();

if (empty($_SESSION)) {
  header('location:index.php');
} else {
  include('header.php');
}

$q = $_GET['q'];

try {
  $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
} catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}

$query = 'SELECT * FROM devis WHERE Id_devis = '.$q.'';
$reponse = $bdd->query($query);

while ($devi = $reponse->fetch()){
  $deviModel = new Devis($devi);
  ?>
  <input hidden id='devisId' value='<?php echo json_encode($devi); ?>'>
  <?php
}

$query = 'SELECT * FROM lignes_devis WHERE Id_devis = '.$deviModel->GetId().'';
$reponse = $bdd->query($query);
$lignes = array();
while ($donnees = $reponse->fetch()){
  array_push($lignes, $donnees);
}
?>
<input hidden id='lignesDevis' value='<?php echo json_encode($lignes); ?>'>
<?php



$query = 'SELECT * FROM clients WHERE Id_client = '.$deviModel->GetIdClient().'';
$reponse = $bdd->query($query);
while ($donnees = $reponse->fetch()){
  $clientModel = new Client($donnees);
}

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
          <div class="col-sm row" style="width:500px">
            <!--OPTIONS-->
            <div class="col-sm">
              <div class="formbox" style="margin-bottom: 1vw;">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Devis N˚</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-describedby="basic-addon1" value="<?php echo $deviModel->GetId(); ?>">
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Client :</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-describedby="basic-addon1" value="<?php echo $clientModel->GetNom(); ?> <?php echo $clientModel->GetPrenom(); ?> " >
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Date :</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-describedby="basic-addon1" value="<?php echo $deviModel->GetDate(); ?>">
                </div>
              </div>
            </div>
            <!--SCHEMA-->

          </div>

          <!--PIECES SELECTIONNEES-->
          <div class="col-sm">
            <div class="col-sm formbox row" style="max-width:1000px; min-width:1000px; max-height:700px; min-height:700px; padding:0" id="schemaContainer">

            </div>
          </div>
          <div class="col-sm">

          </div>
        </div>
      </div>
    </div>
  </div>


</body>
<script type="text/javascript">
let action = 'drag';
let currentMouseRotation = null;
let currentMouseDistance = null;
let actionEnCours = false;

let devis = JSON.parse(document.getElementById('devisId').value);
let lignes = JSON.parse(document.getElementById('lignesDevis').value);
let app = new PIXI.autoDetectRenderer(1000, 700, {backgroundColor: 0xEEEEEE});
document.getElementById('schemaContainer').appendChild(app.view);
let schemaGroup;
let donneesGroup;
let flechesGroup;
let dragGroup;
let shadowGroup;
let stage;


setBackground();
addGroups();
fillGroups();
animate();

$(document).ready(function () {
  $(document).on("keydown", function (e) {
    if(!actionEnCours){
      if(event.ctrlKey && !event.shiftKey){
        action = 'rotate';
      }
      if(event.shiftKey && !event.ctrlKey){
        action = 'ratiate';
      }
      if(event.shiftKey && event.ctrlKey){
        action = 'ratiateAndRotate';
      }
    }
  });

  $(document).on("keyup", function (e) {
    if(!actionEnCours){
      if(event.ctrlKey){
        action = 'drag';
      }
      if(event.shiftKey){
        action = 'drag';
      }
    }
  });

});
window.WebFontConfig = {
  google: {
    families: ['Roboto', 'Arvo:700italic', 'Podkova:700']
  }
};

function setBackground(){
  stage = new PIXI.Container();
  let background = new PIXI.Graphics();

  background.beginFill(0xEEEEEE);
  background.drawRect(0,0,1000,700);
  background.endFill();

  stage.addChild(background);
  stage.interactive = true;
}

function addGroups(){
  // z-index = 0, sorting = true;
  schemaGroup = new PIXI.display.Group(0, true);
  donneesGroup = new PIXI.display.Group(1, function (sprite) {
    //blue bunnies go up
    sprite.zOrder = +sprite.y;
  });
  let flechesGroup = new PIXI.display.Group(2, function (sprite) {
    //blue bunnies go up
    sprite.zOrder = +sprite.y;
  });
  // Drag is the best layer, dragged element is above everything else
  dragGroup = new PIXI.display.Group(3, false);

  // Shadows are the lowest
  shadowGroup = new PIXI.display.Group(-1, false);

  //specify display list component
  app.stage = new PIXI.display.Stage();
  app.stage.group.enableSort = true;
  //sorry, group cant exist without layer yet :(

  app.stage.addChild(new PIXI.display.Layer(schemaGroup));
  app.stage.addChild(new PIXI.display.Layer(donneesGroup));
  app.stage.addChild(new PIXI.display.Layer(flechesGroup));
  app.stage.addChild(new PIXI.display.Layer(dragGroup));
  app.stage.addChild(new PIXI.display.Layer(shadowGroup));

  let blurFilter = new PIXI.filters.BlurFilter();
  blurFilter.blur = 0.5;
}

function fillGroups(){
  // create a texture from an image path
  let texture_Schema = PIXI.Texture.fromImage(devis.CheminImage_devis);
  let schemaImage = new PIXI.Sprite(texture_Schema);
  schemaImage.position.set(100,0);
  schemaImage.parentGroup = schemaGroup;
  stage.addChild(schemaImage);
  subscribe(schemaImage);

  let i = 1;
  lignes.forEach(function(ligne) {
    let donnes = new PIXI.Text('H: '+ligne.Hauteur_ligne+' L: '+ligne.Largeur_ligne+' P: '+ligne.Hauteur_ligne, {
      fontFamily: 'Roboto',
      fontSize: 25,
      fill: 'black',
      align: 'left'
    });
    donnes.parentGroup = donneesGroup;
    stage.addChild(donnes);
    donnes.position.set(80,23 * i);
    donnes.anchor.set(0.5);
    subscribe(donnes);
    i++;
  });
}

//let bitmapText = new PIXI.extras.BitmapText("text using a fancy font!", {font: "VCR OSD MONO", align: "right"});

function animate() {
  requestAnimationFrame(animate);
  // render the container
  app.render(stage);
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
  let gr = new PIXI.Graphics();
  gr.beginFill(0x0, 1);
  //yes , I know bunny size, I'm sorry for this hack
  let scale = 1.1;
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
    actionEnCours = true;
    switch(action) {
      case 'drag':
        this.dragPoint = event.data.getLocalPosition(this.parent);
        this.dragPoint.x -= this.x;
        this.dragPoint.y -= this.y;
        break;
      case 'rotate':
      currentMouseRotation = calculateAngle(app.plugins.interaction.mouse.global.x, app.plugins.interaction.mouse.global.y, this.position.x, this.position.y);
      break;
      case 'ratiate':
      currentMouseDistance = getDistance(app.plugins.interaction.mouse.global.x, app.plugins.interaction.mouse.global.y, this.position.x, this.position.y);
      break;
      break;
      case 'ratiateAndRotate':
      currentMouseRotation = calculateAngle(app.plugins.interaction.mouse.global.x, app.plugins.interaction.mouse.global.y, this.position.x, this.position.y);
      currentMouseDistance = getDistance(app.plugins.interaction.mouse.global.x, app.plugins.interaction.mouse.global.y, this.position.x, this.position.y);
      break;
      default:
      break;
    }
  }
}

function onDragEnd() {
  if (this.dragging) {
    this.dragging = false;
    this.parentGroup = this.oldGroup;
    this.data = null;
    actionEnCours = false;
    action = 'drag';
  }
}

/* Voir Demo Rotation http://proclive.io/shooting-tutorial/ */
function onDragMove() {
  if (this.dragging) {
    switch(action) {
      case 'drag':
        let newPosition = this.data.getLocalPosition(this.parent);
        this.x = newPosition.x - this.dragPoint.x;
        this.y = newPosition.y - this.dragPoint.y;
        break;
      case 'rotate':
        rotateObject(this);
      break;
      case 'ratiate':
        ratiateObject(this);
      break;
      case 'ratiateAndRotate':
        rotateObject(this);
        ratiateObject(this);
      break;
      default:
      break;
    }
  }
}

function rotateObject(object){
  let newMouseRotation = calculateAngle(app.plugins.interaction.mouse.global.x, app.plugins.interaction.mouse.global.y, object.position.x, object.position.y);
  let rotationDiff = newMouseRotation - currentMouseRotation;
  object.rotation += rotationDiff;
  currentMouseRotation = newMouseRotation;
}

function ratiateObject(object){
  let newMouseDistance = getDistance(app.plugins.interaction.mouse.global.x, app.plugins.interaction.mouse.global.y, object.position.x, object.position.y);
  let distanceDiff = newMouseDistance - currentMouseDistance;
  let ratio = 1 + (distanceDiff*0.01);

  object.scale.x *= ratio;
  object.scale.y *= ratio;
  currentMouseDistance = newMouseDistance;
}

function getDistance(mx, my, px, py){
  let dist_Y = my - py;
  let dist_X = mx - px;
  let distance = Math.sqrt((dist_Y*dist_Y)+(dist_X*dist_X))
  return distance
}

function calculateAngle(mx, my, px, py){
  let self = this;
  let dist_Y = my - py;
  let dist_X = mx - px;
  let angle = Math.atan2(dist_Y,dist_X);
  //let degrees = angle * 180/ Math.PI;
  return angle;
}

</script>
