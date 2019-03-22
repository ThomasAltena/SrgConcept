<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
  <title>Monumac</title>
</head>
<link rel="stylesheet" href="../public/css/form.css" type="text/css">
<?php
session_start();

if (empty($_SESSION)) {
  header('location:/SrgConcept/view/index.php');

} else {
  include('header.php');
}

$q = $_GET['q'];

try {
  $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
} catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}

?>
<script src="../pixi.min.js"></script>
<script src="../pixi-layers.js"></script>

<link rel="stylesheet" href="../public/css/form.css" type="text/css">
<link rel="stylesh\eet" href="../public/css/switch.css" type="text/css">
<!-------------------------- Il faut mettre le chemin dans les value -------------------------->
<body style="overflow: scroll;">
  <div id="content-wrapper">
    <div class='container' style="min-width: 1600px;">
      <div>
        <div class="row">
          <!--OPTIONS ET SCHEMA-->
          <div class="col-sm row" style="min-width: 400px; max-width: 400px">
            <!--OPTIONS-->
            <div class="col-sm" style="padding:0" id="test">
              <div class="formbox" style="margin-bottom: 1vw;">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Devis N˚</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-describedby="basic-addon1" id="devisId" value="<?php echo $q; ?>">
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Client :</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-describedby="basic-addon1" id="clientLibelle" value="" >
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Date :</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-describedby="basic-addon1" id="dateLibelle" value="">
                </div>
                <button class="mb-3 btn btn-default col-lg-12 hover-effect-a" onclick="addArrow()">Ajouter Fleche
                </button>

                <div class="input-group mb-3">
                  <input type="text" class="form-control hover-effect-a" aria-describedby="basic-addon1" id="textToAdd" aria-label="Text" value="" >
                  <button class="input-group-append btn hover-effect-a btn-default" style="padding:1; margin:0; border:0" onclick="addText()">
                    Ajouter Text
                  </button>
                </div>
              </div>
              <div class="formbox">
                <!-- <button class="mb-3 btn btn-primary col-lg-12 hover-effect-a" disabled onclick="">Visualiser
                    Fiche
                </button> -->
                <button class="btn btn-success col-lg-12 hover-effect-a" onclick="saveFicheFab()">Sauvegarder Fiche
                </button>
              </div>
            </div>
          </div>

          <div class="col-sm formbox" style="max-width:700px; min-width:700px; max-height:650px; min-height:650px; padding:0; margin-right:1vw; margin-left:1vw;">
            <!--SCHEMA FICHE DE FABRICATION-->
            <div class="col-sm" style="max-width:700px; min-width:700px; max-height:600px; min-height:600px; padding:0; backgroundColor:white" id="schemaContainer">

            </div>
            <!--OPTIONS FICHE DE FABRICATION-->
            <div class="row col-lg-12" style="height: 50px; margin: 0; padding: 0;"
                 id="piecesListControls">
              <div class="col-sm btn hover-effect-a" id="undoButton" style="padding-top: 12px;"
                   onclick="undo()">CTRL+Z &nbsp
                   <i class="fas fa-undo"></i>
              </div>
              <div class="col-sm btn hover-effect-a" id="redoButton" style="padding-top: 12px;"
                   onclick="redo()">CTRL+Y &nbsp
                  <i class="fas fa-redo"></i>
              </div>
              <div class="col-sm btn hover-effect-a" id="rotationButton" style="padding-top: 12px;"
                   onclick="toggleRotation()">CTRL+CLICK &nbsp
                  <i class="fas fa-sync-alt"></i>
              </div>
              <div class="col-sm btn hover-effect-a" id="ratiationButton" style="padding-top: 12px;"
                   onclick="toggleRatiation()">SHIFT+CLICK &nbsp
                  <i class="fas fa-expand"></i>
              </div>
            </div>
          </div>
          <!--PIECES FICHE DE FABRICATION-->
          <div class="col-sm formbox" style="padding:0; max-height:650px; min-height:650px; min-width:400px; max-width:400px;">
            <div class="col-sm" style="max-height:600px; min-height:600px; min-width:400px; max-width:400px; padding:5px; overflow:scroll" id="piecesListView" >

            </div>
            <div class="row col-lg-12" style="height: 50px; margin: 0; padding: 0;"
                 id="piecesListControls">
              <div class="col-sm btn hover-effect-a" style="padding-top: 12px;"
                   onclick="loadList('pieces')">PIECES
              </div>
              <div class="col-sm btn hover-effect-a" style="padding-top: 12px;"
                   onclick="loadList('arrows')">FLECHES
              </div>
              <div class="col-sm btn hover-effect-a" style="padding-top: 12px;"
                   onclick="loadList('texts')">TEXT
              </div>
            </div>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>


</body>
<script type="text/javascript">
let listContents = 'pieces';
let arrowSource = '../public/images/arrow.png';
let action = 'drag';
let currentMouseRotation = null;
let currentMouseDistance = null;
let actionEnCours = false;

let devisId = JSON.parse(document.getElementById('devisId').value);
let devis = null;
let app = new PIXI.autoDetectRenderer(700, 600, {backgroundColor: 0xFFFFFF});
document.getElementById('schemaContainer').appendChild(app.view);
let schemaGroup;
let donneesGroup;
let arrowsGroup;
let textGroup;
let dragGroup;
let shadowGroup;
let stage;
let history = [];
let historyIndex = 0;
let startState = [];
let endState = [];
let layers = [];
let arrows = [];
let texts = [];

let controlKey = false;
let shiftKey = false;

getDevisData();

function getDevisData() {
  let xhttp;
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      try {
        let response = JSON.parse(this.responseText);
        if(!response.error){
          devis = response.data;

          fillDevisInfo();
          setBackground();
          addGroups();
          loadSchema();
          loadPieces();
          animate();
        } else {
          console.log(response.error);
          //TODO add crash message
        }
      } catch (e) {
        console.log(this.responseText);
      }
    }
  };
  xhttp.open("GET", "../controller/DevisController.php?functionname=" + 'GetAllDevisInfo' + "&devisId=" + devisId, true);
  xhttp.send();
}

$(document).ready(function () {
  $(document).on("keydown", function (e) {
    if(!actionEnCours){
      if(event.ctrlKey){
        if(!controlKey){
          controlKey = true;
          toggleHighlightButton(controlKey, '#rotationButton');
        }
      }
      if(event.shiftKey){
        if(!shiftKey){
          shiftKey = true;
          toggleHighlightButton(shiftKey, '#ratiationButton');
        }
      }
      if(event.ctrlKey && event.keyCode == 90 ){
        clickButton('#undoButton');

      }
      if(event.ctrlKey && event.keyCode == 89 ){
        clickButton('#redoButton');
      }
    }
  });
  $(document).keyup(function (e) {
    if(!event.ctrlKey){
      if(controlKey){
        controlKey = false;
        toggleHighlightButton(controlKey, '#rotationButton');
      }
    }
    if(!event.shiftKey){
      if(shiftKey){
        shiftKey = false;
        toggleHighlightButton(shiftKey, '#ratiationButton');
      }
    }
  });
});

function toggleRotation(){
  controlKey = !controlKey;
  toggleHighlightButton(controlKey, '#rotationButton');
}

function toggleRatiation(){
  shiftKey = !shiftKey;
  toggleHighlightButton(shiftKey, '#ratiationButton');
}

function clickButton(id){
  $(id).click();
  toggleHighlightButton(true, id);
  setTimeout(function(){ toggleHighlightButton(false, id); }, 100);
}

function toggleHighlightButton(bool, id){
  if(bool){
    $(id).addClass('buttonActive');
  } else {
    $(id).removeClass('buttonActive');
  }
}

window.WebFontConfig = {
  google: {
    families: ['Roboto', 'Arvo:700italic', 'Podkova:700']
  }
};

function fillDevisInfo(){
  document.getElementById('clientLibelle').value = devis.client.Nom_client.toUpperCase() + ' ' + devis.client.Prenom_client;
  document.getElementById('dateLibelle').value = devis.Date_devis;
}

function setBackground(){
  stage = new PIXI.Container();
  let background = new PIXI.Graphics();

  background.beginFill(0xFFFFFF);
  background.drawRect(0,0,1000,700);
  background.endFill();

  stage.addChild(background);
  stage.interactive = true;
}

function loadPieces(){
  body = '';
  let i = 1;
  devis.lignes.forEach(function(ligne){
    let donnees = new PIXI.Text('' + ligne.Hauteur_ligne+' x '+ligne.Largeur_ligne+' x '+ligne.Hauteur_ligne +'', {
      fontFamily: 'Roboto',
      fontSize: 25,
      fill: 'black',
      align: 'left'
    });

    donnees.buttonMode = true;
    donnees.parentGroup = donneesGroup;
    stage.addChild(donnees);
    donnees.position.set((donnees.width/2)+10,23 * i);
    donnees.anchor.set(0.5);
    subscribe(donnees);

    let graphics ;
    layers.push({'ligne': ligne, 'parent': donnees, 'child': graphics, 'index': i-1});

    body += generatePieceListHtml(ligne, i-1);
    i++;
  });

  document.getElementById("piecesListView").innerHTML = body;
}

function generatePieceListHtml(ligne, index){
  let action = "'pieces'";
  body = '';
  body += '<div class="row formbox col-lg-12 hover-effect-b" style="margin: 0 0 5px 0; height:150px; padding:0"';
  body += 'onmouseenter="addHighlight('+ index + ',' + action + ')"';
  body += 'onmouseleave="removeHighlight('+ index + ',' + action + ')" >';
  body += '<div class="col-sm" style="width: 150px; max-width:150px; padding:0; margin: 0 1px 0 0">';
  body += '<img alt="Une piece parmis pleins" style="left:0;max-width: 150px; min-width:150px;" src="'+ ligne.piece.Chemin_piece +'">';
  body += '</div>';
  body += '<div class="col-sm" style="height: 150px; max-height: 150px; padding:0; margin; 0">';
  body += '<span>Code: ' + ligne.piece.Code_piece + '<br>Famille: ' + ligne.piece.CodeFamille_piece + ' - ' + ligne.piece.CodeSs_piece;
  body += '<br>Hauteur: ' + ligne.Hauteur_ligne + 'cm<br>Largeur: ' + ligne.Largeur_ligne + 'cm<br>Profondeur: ' + ligne.Profondeur_ligne + 'cm';
  body += '<br>Remise: ' + ligne.Remise_ligne + '</span>';
  body += '</div></div>';
  return body;
}

function generateTextListHtml(parent, index){
  text = texts[index];
  let action = "'texts'";
  body = '';
  body += '<div class="row formbox col-lg-12 hover-effect-b" style="margin: 0 0 5px 0; height:50px; padding:0"';
  body += 'onmouseenter="addHighlight('+ index + ',' + action + ')"';
  body += 'onmouseleave="removeHighlight('+ index + ',' + action + ')" >';

  body += '<span style="padding: 12px 0 0 50px;">' + text.data + '</span>';

  body += '<div class="btn hover-effect-a" style="color: red; position: absolute; left: 5px top: 5px;" onclick="removeText(' + index + ' )">\n';
  body += '<i class="fas fa-trash-alt"></i>\n';
  body += '</div>\n';
  body += '</div>';
  return body;
}

function generateFlecheListHtml(parent, index){
  let action = "'arrows'";
  body = '';
  body += '<div class="row formbox col-lg-12 hover-effect-b" style="margin: 0 0 5px 0; height:50px; padding:0"';
  body += 'onmouseenter="addHighlight('+ index + ',' + action + ')"';
  body += 'onmouseleave="removeHighlight('+ index + ',' + action + ')" >';

  body += '<img alt="Une piece parmis pleins" style="left:0;" src="'+ arrowSource +'">';

  body += '<div class="btn hover-effect-a" style="color: red; position: absolute; left: 5px top: 5px;" onclick="removeArrow(' + index + ' )">\n';
  body += '<i class="fas fa-trash-alt"></i>\n';
  body += '</div>\n';
  body += '</div>';
  return body;
}

function loadList(action){
  listContents = action;
  switch (action) {
    case 'pieces':
      body = '';
      layers.forEach(function(layer){
        body += generatePieceListHtml(layer.ligne, layer.index);
      });
      document.getElementById("piecesListView").innerHTML = body;
      break;
    case 'arrows':
      body = '';
      arrows.forEach(function(layer){
        body += generateFlecheListHtml(layer.parent, layer.index);
      });
      document.getElementById("piecesListView").innerHTML = body;

      break;
    case 'texts':
      body = '';
      texts.forEach(function(layer){
        body += generateTextListHtml(layer.parent, layer.index);
      });
      document.getElementById("piecesListView").innerHTML = body;

      break;
    default:
      body = '';
      layers.forEach(function(layer){
        body += generatePieceListHtml(layer.ligne, layer.index);
      });
      arrows.forEach(function(layer){
        body += generateFlecheListHtml(layer.parent, layer.index);
      });
      document.getElementById("piecesListView").innerHTML = body;
      break;
  }
}

function addHighlight(index, type){
  switch (type) {
    case 'pieces':
      layer = layers[index];
      break;
    case 'arrows':
      layer = arrows[index];
      break;
    case 'texts':
      layer = texts[index];
      break;
    default:
      break;
  }
  layer.child = new PIXI.Graphics();
  layer.child.lineStyle(2, 0xFF0000);

  // Dessiner le rectangle a la position 0,0. Les coordonnees interne (x, y) du rectangle sont basee la ou on la Dessiner
  // SI on la dessine a 50,100 (global), cela devient 0 , 0 pour le rectangle (tres ennuyant) tandis que auqnd on charge un sprit ou un text
  // les coordonees 0,0 du spirte ou text sont celles du global et le x, y du sprite ou text est la ou on le charge.
  layer.child.drawRect(0,0, layer.parent.width, layer.parent.height);

  layer.child.pivot.set(layer.parent.width/2, layer.parent.height/2);

  layer.child.x = layer.parent.x;
  layer.child.y = layer.parent.y;
  layer.child.rotation = layer.parent.rotation;

  stage.addChild(layer.child);
}

function removeHighlight(index, type){
  switch (type) {
    case 'pieces':
      layer = layers[index];
      break;
    case 'arrows':
      layer = arrows[index];
      break;
    case 'texts':
      layer = texts[index];
      break;
    default:
      break;
  }
  stage.removeChild(layer.child);
}

function addText(){
  let data = document.getElementById('textToAdd').value;
  document.getElementById('textToAdd').value = '';
  let index = texts.length;
  let graphics ;
  let text = new PIXI.Text(data, {
    fontFamily: 'Roboto',
    fontSize: 25,
    fill: 'black',
    align: 'left'
  });

  text.buttonMode = true;
  text.parentGroup = textGroup;
  text.position.set(200,200);
  text.anchor.set(0.5);

  subscribe(text);

  stage.addChild(text);
  texts.push({'parent': text, 'child': graphics, 'index': index, 'data': data});

  if(listContents == 'texts'){
    loadList(listContents);
  }
  addHistory('add',{'child': text, 'index': index, 'parent': stage, 'container': texts, 'data': data}, 'text' );
}

function addArrow(){
  let texture_arrow = PIXI.Texture.fromImage(arrowSource);
  let graphics;
  let arrow = new PIXI.Sprite(texture_arrow);
  let index = arrows.length;

  arrow.position.set(200,200);
  arrow.parentGroup = arrowsGroup;
  arrow.anchor.set(0.5);

  subscribe(arrow);

  stage.addChild(arrow);
  arrows.push({'parent': arrow, 'child': graphics, 'index': index });

  if(listContents == 'arrows'){
    loadList(listContents);
  }
  addHistory('add',{'child': arrow, 'index': index, 'parent': stage, 'container': arrows}, 'arrow' );
}

function removeText(index){
  text = texts[index].parent;
  data = texts[index].data;
  graphics = texts[index].child;
  stage.removeChild(text);
  if(graphics){
    graphics.destroy();
  }
  texts.splice(index, 1);

  recalculateIndex(texts);
  loadList(listContents);
  addHistory('remove',{'child': text, 'index': index, 'parent': stage, 'container': texts, 'data': data}, 'text' );
}

function removeArrow(index){
  arrow = arrows[index].parent;
  graphics = arrows[index].child;
  stage.removeChild(arrow);
  if(graphics){
    graphics.destroy();
  }

  arrows.splice(index, 1);

  recalculateIndex(arrows);
  loadList(listContents);
  addHistory('remove',{'child': arrow, 'index': index, 'parent': stage, 'container': arrows}, 'arrow' );
}

function recalculateIndex(array){
  for(let i = 0; i < array.length; i++){
    array[i].index = i;
  }
}


function addGroups(){
  // z-index = 0, sorting = true;
  schemaGroup = new PIXI.display.Group(0, true);
  donneesGroup = new PIXI.display.Group(1, function (sprite) {
    //blue bunnies go up
    sprite.zOrder = +sprite.y;
  });
  let arrowsGroup = new PIXI.display.Group(2, function (sprite) {
    //blue bunnies go up
    sprite.zOrder = +sprite.y;
  });
  let textGroup = new PIXI.display.Group(3, function (sprite) {
    //blue bunnies go up
    sprite.zOrder = +sprite.y;
  });
  // Drag is the best layer, dragged element is above everything else
  dragGroup = new PIXI.display.Group(4, false);

  // Shadows are the lowest
  shadowGroup = new PIXI.display.Group(-1, false);

  //specify display list component
  app.stage = new PIXI.display.Stage();
  app.stage.group.enableSort = true;
  //sorry, group cant exist without layer yet :(

  app.stage.addChild(new PIXI.display.Layer(schemaGroup));
  app.stage.addChild(new PIXI.display.Layer(donneesGroup));
  app.stage.addChild(new PIXI.display.Layer(arrowsGroup));
  app.stage.addChild(new PIXI.display.Layer(textGroup));
  app.stage.addChild(new PIXI.display.Layer(dragGroup));
  app.stage.addChild(new PIXI.display.Layer(shadowGroup));

  let blurFilter = new PIXI.filters.BlurFilter();
  blurFilter.blur = 0.5;
}

function loadSchema(){
  let texture_Schema = PIXI.Texture.fromImage(devis.CheminImage_devis);
  let schemaImage = new PIXI.Sprite(texture_Schema);
  schemaImage.position.set(schemaImage.width,schemaImage.height);


  schemaImage.parentGroup = schemaGroup;
  schemaImage.position.set(350,300);
  schemaImage.anchor.set(0.5);
  stage.addChild(schemaImage);
  subscribe(schemaImage);
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

function onDragStart(event) {
  if (!this.dragging) {
    copyState(startState, this);

    this.data = event.data;
    this.oldGroup = this.parentGroup;
    this.parentGroup = dragGroup;
    this.dragging = true;
    actionEnCours = true;

    if(controlKey && !shiftKey){
      action = 'rotate';
    } else if(shiftKey && !controlKey){
      action = 'ratiate';
    } else if(shiftKey && controlKey){
      action = 'ratiateAndRotate';
    } else {
      action = 'drag';
    }

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

    copyState(endState, this);
    let different = compareStates(startState, endState);
    if(different){
      addHistory('move', {'startState': startState, 'endState': endState}, 'state');
    }
  }
}

/* Voir Demo Rotation http://proclive.io/shooting-tutorial/ */
function onDragMove() {
  if (this.dragging && actionEnCours) {
    switch(action) {
      case 'drag':
        moveObject(this);
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

function copyState(stateHolder, stateToSave){
  stateHolder['object'] = stateToSave;
  stateHolder['x'] = stateToSave.x;
  stateHolder['y'] = stateToSave.y;
  stateHolder['rotation'] = stateToSave.rotation;
  stateHolder['ratio'] = 1;
}

/*
* Retourne vrai si il y a une difference et faux si elles sont pareil.
*/
function compareStates(startState, endState){
  if(startState.x != endState.x){
    return true;
  }
  if(startState.y != endState.y){
    return true;
  }
  if(startState.rotation != endState.rotation){
    return true;
  }
  if(startState.ratio != 1){
    return true;
  }
  return false;
}

function moveObject(object){
  let newPosition = object.data.getLocalPosition(object.parent);
  object.x = newPosition.x - object.dragPoint.x;
  object.y = newPosition.y - object.dragPoint.y;
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

  // On garde le ratio pour concerver les changements sur l'etat original
  startState['ratio'] = startState['ratio'] * ratio;
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

function addHistory(action, objects, type){
  let historyItem = [];
  switch (action) {
    case 'move':
      if(type == 'state'){
        endState['ratio'] = startState['ratio'];
        historyItem['action'] = action;
        historyItem['type'] = type;
        historyItem['start'] = Object.assign({}, objects.startState);
        historyItem['end'] = Object.assign({}, objects.endState);
      }
      break;
    case 'add':
      if(type == 'arrow'){
        historyItem['action'] = action;
        historyItem['type'] = type;
        historyItem['child'] = objects.child;
        historyItem['parent'] = objects.parent;
        historyItem['index'] = objects.index;
        historyItem['container'] = objects.container;
      }
      if(type == 'text'){
        historyItem['action'] = action;
        historyItem['type'] = type;
        historyItem['child'] = objects.child;
        historyItem['parent'] = objects.parent;
        historyItem['index'] = objects.index;
        historyItem['container'] = objects.container;
        historyItem['data'] = objects.data;
      }
      break;
    case 'remove':
      if(type == 'arrow'){
        historyItem['action'] = action;
        historyItem['type'] = type;
        historyItem['child'] = objects.child;
        historyItem['parent'] = objects.parent;
        historyItem['index'] = objects.index;
        historyItem['container'] = objects.container;
      }
      if(type == 'text'){
        historyItem['action'] = action;
        historyItem['type'] = type;
        historyItem['child'] = objects.child;
        historyItem['parent'] = objects.parent;
        historyItem['index'] = objects.index;
        historyItem['container'] = objects.container;
        historyItem['data'] = objects.data;
      }
      break;
      break;
    default:
  }

  if(history.length >  0){
    history = history.slice(0,historyIndex);
  }


  history.push(historyItem);
  historyIndex = history.length;
}

function undo(){
  if(historyIndex > 0 && history.length > 0){
    historyIndex--;
    let historyItem = history[historyIndex];
    switch (historyItem.action) {
      case 'move':
        if(historyItem.type == 'state'){
          let previousState = historyItem.start;
          let object = previousState.object;

          object.x = previousState.x;
          object.y = previousState.y;
          object.rotation = previousState.rotation;
          object.scale.x /= previousState.ratio;
          object.scale.y /= previousState.ratio;
        }
        break;
      case 'add':
        if(historyItem.type == 'arrow'){
          containerItem = historyItem.container[historyItem.index];
          arrow = containerItem.parent;
          graphics = containerItem.child;

          historyItem.parent.removeChild(arrow);
          if(graphics){
            graphics.destroy();
          }

          historyItem.container.splice(historyItem.index, 1);

          recalculateIndex(arrows);
          if(listContents == 'arrows'){
            loadList(listContents);
          }
        }
        if(historyItem.type == 'text'){
          containerItem = historyItem.container[historyItem.index];
          text = containerItem.parent;
          graphics = containerItem.child;

          historyItem.parent.removeChild(text);
          if(graphics){
            graphics.destroy();
          }

          historyItem.container.splice(historyItem.index, 1);

          recalculateIndex(texts);
          if(listContents == 'texts'){
            loadList(listContents);
          }
        }
        break;
      case 'remove':
        if(historyItem.type == 'arrow'){
          let graphics;
          historyItem.parent.addChild(historyItem.child);
          historyItem.container.splice(historyItem.index, 0, {'parent': historyItem.child, 'child': graphics, 'index': historyItem.index });

          recalculateIndex(arrows);
          if(listContents == 'arrows'){
            loadList(listContents);
          }
        }
        if(historyItem.type == 'text'){
          let graphics;
          historyItem.parent.addChild(historyItem.child);
          historyItem.container.splice(historyItem.index, 0, {'parent': historyItem.child, 'child': graphics, 'index': historyItem.index, 'data': historyItem.data });
          recalculateIndex(texts);
          if(listContents == 'texts'){
            loadList(listContents);
          }
        }
        break;
      default:
        break;
    }
  }
}

function redo(){
  if(historyIndex < history.length ){
    let historyItem = history[historyIndex];

    switch (historyItem.action) {
      case 'move':
        if(historyItem.type == 'state'){
          let nextState = historyItem.end;
          let object = nextState.object;

          object.x = nextState.x;
          object.y = nextState.y;
          object.rotation = nextState.rotation;
          object.scale.x *= nextState.ratio;
          object.scale.y *= nextState.ratio;
        }
        break;
      case 'add':
        if(historyItem.type == 'arrow'){

          let graphics;
          historyItem.parent.addChild(historyItem.child);
          historyItem.container.splice(historyItem.index, 0, {'parent': historyItem.child, 'child': graphics, 'index': historyItem.index });
          recalculateIndex(arrows);

          if(listContents == 'arrows'){
            loadList(listContents);
          }
        }
        if(historyItem.type == 'text'){

          let graphics;
          historyItem.parent.addChild(historyItem.child);
          historyItem.container.splice(historyItem.index, 0, {'parent': historyItem.child, 'child': graphics, 'index': historyItem.index, 'data': historyItem.data });
          recalculateIndex(texts);

          if(listContents == 'texts'){
            loadList(listContents);
          }
        }
        break;
      case 'remove':
        if(historyItem.type == 'arrow'){
          containerItem = historyItem.container[historyItem.index];
          arrow = containerItem.parent;
          graphics = containerItem.child;

          historyItem.parent.removeChild(arrow);
          if(graphics){
            graphics.destroy();
          }

          historyItem.container.splice(historyItem.index, 1);

          recalculateIndex(arrows);
          if(listContents == 'arrows'){
            loadList(listContents);
          }
        }
        if(historyItem.type == 'text'){
          containerItem = historyItem.container[historyItem.index];
          text = containerItem.parent;
          graphics = containerItem.child;

          historyItem.parent.removeChild(text);
          if(graphics){
            graphics.destroy();
          }

          historyItem.container.splice(historyItem.index, 1);

          recalculateIndex(texts);
          if(listContents == 'texts'){
            loadList(listContents);
          }
        }
        break;
      default:
        break;
    }

    historyIndex++;
  }

  if(listContents != 'pieces'){
    loadList(listContents);
  }

}

function saveFicheFab(){
  let image = app.plugins.extract.image(stage);

  let arguments = [devisId, image.src];
  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      responseText = JSON.parse(this.responseText);
      if(responseText.error){
        console.log(responseText);
      } else {
        saved = true;
      }
    }
  };
  xhttp.open("POST", "../controller/DevisController.php?functionname=" + 'SaveFicheFab' , true);
  xhttp.send(JSON.stringify(arguments));
}
</script>
