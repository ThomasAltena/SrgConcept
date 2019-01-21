<!DOCTYPE html>
<html>
<head>
	<title>Monumac</title>
</head>

<?php 
include('header.php');

$db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
$ManagerMatiere = new MatiereManager($db); //Connexion a la BDD
$matieres = $ManagerMatiere->GetMatieres();
try
{
        $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
}
catch(Exception $e)
{
            die('Erreur : '.$e->getMessage());
}
 

$reponse = $bdd->query('SELECT Id_devis, IdClient_devis, IdUser_devis FROM devis ORDER BY Id_devis DESC LIMIT 1');
$IdDevis = $reponse->fetchAll();

foreach ($IdDevis as $IdDevi);
$Devis = $IdDevi['Id_devis'];
$User = $IdDevi['IdUser_devis'];
$Client = $IdDevi['IdClient_devis'];
$date = date("d-m-Y");

 ?>


<!-------------------------- Il faut mettre le chemin dans les value -------------------------->
<body>
<div id="content-wrapper">
<div class='container'>
  <div class="row">
  <input type="file" id="fileToUpload" name="fileToUpload" style="visibility:hidden">
  <div id='schema'>
    <img id="imgSch1" src="">
    <img id="imgSch2" src="">
    <img id="imgSch3" src="">
    <img id="imgSch4" src="">
    <img id="imgSch5" src="">
  </div>
  </input>

 <form action="../devis/NouveauDevis.php" class="form" method="post">
 <div id='devis' class="col-xl-10 col-sm-10 mb-6 margintop">
        <div class="card text-white bg-info o-hidden h-100">
          <h5 class="card-title"> Sélectionner un client : </h5>
          <input class="col-xl-4 col-sm-4 mb-2 form-control" id="myInput" type="text" placeholder="Search..">
          <select name="Id_client" class="col-xl-4 col-sm-4 mb-2  id="select">
<?php 
 
$reponse = $bdd->query('SELECT * FROM clients');
 
while ($donnees =$reponse->fetch())
{
?>  
  
                <option value="<?php echo $donnees['Id_client'];?>"> <?php echo $donnees['Nom_client']; ?></option>

<?php
}

$_POST['Id_client'];
?>  
                  </select>
            </div>
                </div>
  
	<div id='devis' class="col-xl-10 col-sm-10 mb-6 margintop">
        <div class="card text-white bg-info o-hidden h-100">
            <div class="card-body">
                <center><button name="go" onclick="nouveauDevis()" type="button" value="" class="btn btn-primary"">Crée devis</button></center>
            </div>
        </div>
  </div>
    <!-- <form action=echo $url; class="form" method="post"> -->
   
    <div id="mat" class="col-xl-10 col-sm-10 mb-6 margintop" style="visibility:true">
              <div class="card">
                  <div class="card-header">
                   <h5 class="card-title"> Matiére : </h5>
                  </div>
                  <div class="card-body">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" name="Cadre" type="radio" value="CadreAvec" id="CadreAvec">
                        <label class="form-check-label" for="CadreAvec">Simple</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" name="Cadre" type="radio" value="CadreSans" id="CadreSans">
                        <label class="form-check-label" for="CadreSans">Double</label>
                      </div>
                      <br/><br/>
                      <div class="form-check form-check-inline">
                        <select id="select">
                        <?php 
 
$reponse = $bdd->query('SELECT * FROM matieres');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Id_matiere']; ?>"> <?php echo $donnees['Libelle_matiere']; ?></option>
                

<?php
}
$_POST['Id_matiere'];
?>
                  </select>
                  </div>
                  <br><br>
                  <!-- <input type="button"  id="Valide1" onclick="suite(2)" value="Suivant" /> <p id="prix1"></p> -->
                   <button type="button" onclick="affichePiece()" class="btn btn-warning x1">Suivant</button>
                  </div>

              </div>
              
    </div>
     <!-- Case Ventail/Dim -->
          <div id="piece" class="col-xl-6 col-sm-6 mb-3 margintop piece piece">
            <div class="card">
                <div class="card-header">
                 <h5 class="card-title"> Selectionner une piéce : </h5>
                </div>
                <div class="card-body">

                  <div class="form-check form-check-inline">
                  <!--<p class="card-text">Choix :</p>-->
                  <select id="select1" onchange="AfficheImg(1)">

                        <?php
 
$reponse = $bdd->query('SELECT * FROM pieces');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Chemin_piece']; ?>"> <?php echo $donnees['Code_piece']; ?></option>
<?php
}

?>
                  </select>
                  


                    </div>
                    <br><br/>
                  <label>Selectionne une option :</label>
                  <br>
                  <select id="select">

                        <?php
 
$reponse = $bdd->query('SELECT * FROM options');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
<?php
}

?>
                  </select>

                  <select id="select">

                        <?php
 
$reponse = $bdd->query('SELECT * FROM options');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
<?php
}

?>
                  </select>

                  <select id="select">

                        <?php 
 
$reponse = $bdd->query('SELECT * FROM options');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
<?php
}

?>
                  </select>

                  <select id="select">
                        <?php
 
$reponse = $bdd->query('SELECT * FROM options');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
<?php
}

?>
                  </select>
                  <br><br>

                    <div class="form-inline">
                      <div class="form-group">
                        <input type="number" id="h" name="Hauteur" placeholder="Hauteur" class="form-control" min="0" max="500000">
                        <input type="number" id="l" name="largeur" placeholder="Largeur" class="form-control" min="0" max="500000" style="margin-left: 10px;">
                        <input type="number" id="p" name="Profondeur" placeholder="Profondeur" class="form-control" min="0" max="500000" style="margin-left: 10px;">
                      </div>
                    </div>

                    <div class="form-inline">
                        <div class="form-group">
                            <input type="number" id="h" name="Remise" placeholder="Remise" class="form-control" min="0" max="500000";>
                        </div>
                    </div>

                </div>
            </div>
          </div>

          
     <!-- Case Ventail/Dim -->
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
     <!-- Case Ventail/Dim -->
          <div id="piece2" class="col-xl-6 col-sm-6 mb-3 margintop piece">
            <div class="card">
                <div class="card-header">
                 <h5 class="card-title"> Selectionner une piéce : </h5>
                </div>
                <div class="card-body">

                  <div class="form-check form-check-inline">
                  <!--<p class="card-text">Choix :</p>-->
                  <select id="select2" onchange="AfficheImg(2)">

                        <?php
 
$reponse = $bdd->query('SELECT * FROM pieces');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Chemin_piece']; ?>"> <?php echo $donnees['Code_piece']; ?></option>
<?php
}

?>
                  </select>
                  


                    </div>
                    <br><br/>
                  <label>Selectionne une option :</label>
                  <br>
                  <select id="select">

                        <?php 
 
$reponse = $bdd->query('SELECT * FROM options');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
<?php
}

?>
                  </select>

                  <select id="select">

                        <?php
try
{
        $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
}
catch(Exception $e)
{
            die('Erreur : '.$e->getMessage());
}
 
 
$reponse = $bdd->query('SELECT * FROM options');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
<?php
}

?>
                  </select>

                  <select id="select">

                        <?php
 
$reponse = $bdd->query('SELECT * FROM options');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
<?php
}

?>
                  </select>

                  <select id="select">

                        <?php
 
$reponse = $bdd->query('SELECT * FROM options');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
<?php
}

?>
                  </select>
                  <br><br>

                    <div class="form-inline">
                      <div class="form-group">
                        <input type="number" id="h" name="Hauteur" placeholder="Hauteur" class="form-control" min="0" max="500000"> 
                        <input type="number" id="l" name="Largeur" placeholder="Largeur" class="form-control" min="0" max="500000" style="margin-left: 10px;">
                        <input type="number" id="p" name="Profondeur" placeholder="Profondeur" class="form-control" min="0" max="500000" style="margin-left: 10px;">
                      </div>
                    </div> 
                </div>
            </div>
          </div>

          
     <!-- Case Ventail/Dim -->
          <div id="image2" class="col-xl-4 col-sm-4 mb-2 margintop image">
            <div class="card">
                <div cimagelass="card-header">
                 <h5 class="card-title"> Aperçu image : </h5>
                </div>
                <div class="card-body">
                <center><img id="img2" src=""></center>
                </div>
              </div>
         








 </div>
     <!-- Case Ventail/Dim -->
          <div id="piece3" class="col-xl-6 col-sm-6 mb-3 margintop piece">
            <div class="card">
                <div class="card-header">
                 <h5 class="card-title"> Selectionner une piéce : </h5>
                </div>
                <div class="card-body">

                  <div class="form-check form-check-inline">
                  <!--<p class="card-text">Choix :</p>-->
                  <select id="select3" onchange="AfficheImg(3)">

                        <?php
 
$reponse = $bdd->query('SELECT * FROM pieces');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Chemin_piece']; ?>"> <?php echo $donnees['Code_piece']; ?></option>
<?php
}

?>
                  </select>
                  


                    </div>
                    <br><br/>
                  <label>Selectionne une option :</label>
                  <br>
                  <select id="select">

                        <?php
 
$reponse = $bdd->query('SELECT * FROM options');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
<?php
}

?>
                  </select>

                  <select id="select">

                        <?php
 
$reponse = $bdd->query('SELECT * FROM options');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
<?php
}

?>
                  </select>

                  <select id="select">

                        <?php
 
$reponse = $bdd->query('SELECT * FROM options');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
<?php
}

?>
                  </select>

                  <select id="select">

                        <?php 
 
$reponse = $bdd->query('SELECT * FROM options');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
<?php
}

?>
                  </select>
                  <br><br>

                    <div class="form-inline">
                      <div class="form-group">
                        <input type="number" id="h" name="Hauteur" placeholder="Hauteur" class="form-control" min="0" max="500000"> 
                        <input type="number" id="l" name="Largeur" placeholder="Largeur" class="form-control" min="0" max="500000" style="margin-left: 10px;">
                        <input type="number" id="p" name="Profondeur" placeholder="Profondeur" class="form-control" min="0" max="500000" style="margin-left: 10px;">
                      </div>
                    </div>
                  
                </div>
            </div>
          </div>

          
     <!-- Case Ventail/Dim -->
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
     <!-- Case Ventail/Dim -->
          <div id="piece4" class="col-xl-6 col-sm-6 mb-3 margintop piece">
            <div class="card">
                <div class="card-header">
                 <h5 class="card-title"> Selectionner une piéce : </h5>
                </div>
                <div class="card-body">

                  <div class="form-check form-check-inline">
                  <!--<p class="card-text">Choix :</p>-->
                  <select id="select4" onchange="AfficheImg(4)">

                        <?php 
 
$reponse = $bdd->query('SELECT * FROM pieces');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Chemin_piece']; ?>"> <?php echo $donnees['Code_piece']; ?></option>
<?php
}

?>
                  </select>
                  


                    </div>
                    <br><br/>
                  <label>Selectionne une option :</label>
                  <br>
                  <select id="select">

                        <?php 
 
$reponse = $bdd->query('SELECT * FROM options');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
<?php
}

?>
                  </select>

                  <select id="select">

                        <?php 
 
$reponse = $bdd->query('SELECT * FROM options');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
<?php
}

?>
                  </select>

                  <select id="select">

                        <?php 
 
$reponse = $bdd->query('SELECT * FROM options');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
<?php
}

?>
                  </select>

                  <select id="select">

                        <?php
 
$reponse = $bdd->query('SELECT * FROM options');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
<?php
}

?>
                  </select>
                  <br><br>

                    <div class="form-inline">
                      <div class="form-group">
                        <input type="number" id="h" name="Hauteur" placeholder="Hauteur" class="form-control" min="0" max="500000"> 
                        <input type="number" id="l" name="Largeur" placeholder="Largeur" class="form-control" min="0" max="500000" style="margin-left: 10px;">
                        <input type="number" id="p" name="Profondeur" placeholder="Profondeur" class="form-control" min="0" max="500000" style="margin-left: 10px;">
                      </div>
                    </div>
                  
                </div>
            </div>
          </div>

          
     <!-- Case Ventail/Dim -->
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
     <!-- Case Ventail/Dim -->
          <div id="piece5" class="col-xl-6 col-sm-6 mb-3 margintop piece">
            <div class="card">
                <div class="card-header">
                 <h5 class="card-title"> Selectionner une piéce : </h5>
                </div>
                <div class="card-body">

                  <div class="form-check form-check-inline">
                  <!--<p class="card-text">Choix :</p>-->
                  <select id="select5" onchange="AfficheImg(5)">

                        <?php
 
$reponse = $bdd->query('SELECT * FROM pieces');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Chemin_piece']; ?>"> <?php echo $donnees['Code_piece']; ?></option>
<?php
}

?>
                  </select>
                  


                    </div>
                    <br><br/>
                  <label>Selectionne une option :</label>
                  <br>
                  <select id="select">

                        <?php
  
$reponse = $bdd->query('SELECT * FROM options');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
<?php
}

?>
                  </select>

                  <select id="select">

                        <?php
 
$reponse = $bdd->query('SELECT * FROM options');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
<?php
}

?>
                  </select>

                  <select id="select">

                        <?php
try
{
        $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
}
catch(Exception $e)
{
            die('Erreur : '.$e->getMessage());
}
 
 
$reponse = $bdd->query('SELECT * FROM options');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
<?php
}

?>
                  </select>

                  <select id="select">

                        <?php
 
$reponse = $bdd->query('SELECT * FROM options');
 
while ($donnees = $reponse->fetch())
{
?>
                <option value=" <?php echo $donnees['Id_option']; ?>"> <?php echo $donnees['Libelle_option']; ?></option>
<?php
}

?>
                  </select>
                  <br><br>

                    <div class="form-inline">
                      <div class="form-group">
                        <input type="number" id="h" name="Hauteur" placeholder="Hauteur" class="form-control" min="0" max="500000"> 
                        <input type="number" id="l" name="Largeur" placeholder="Largeur" class="form-control" min="0" max="500000" style="margin-left: 10px;">
                        <input type="number" id="p" name="Profondeur" placeholder="Profondeur" class="form-control" min="0" max="500000" style="margin-left: 10px;">
                      </div>
                    </div>
                  
                </div>
            </div>
          </div>

          
     <!-- Case Ventail/Dim -->
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
   <div id="Validation" class="col-xl-12 col-sm-12 mb-6">
              <div class="card">
                  <div class="card-header">
                   <h5 class="card-title"> Validation : </h5>
                  </div>
                  <center><div class="card-body">
                    <a href="pdfD/newPDF.pdf" target="_blank"><button onclick="VoirDevis()" id="BtnVoirDevis" class="btn btn-primary">Voir le devis</button></a>

                    <a href='index.php'><button id="BtnRecommencer" class="btn btn-danger x2">Recommencer sans enregistrer</button></a>

                    <button id="BtnRecommencerSave" class="btn btn-secondary x2">Recommencer en enregistrant</button>

                    <button onclick="UploadPic()" id="submit" class="btn btn-success x2">Valider le devis</button>
                  </div></center>
              </div>
            </div>

          </div>
        </div>
</div>
</body>
<script type="text/javascript">


//fonction recup value/ img 
function AfficheImg(idDiv){
select = document.getElementById('select'+ idDiv);
choice = select.selectedIndex  // Récupération de l'index du <option> choisi
 
valeur= select.options[choice].value; // Récupération du texte du <option> d'index "choice"
  
  var x = document.getElementById('img' + idDiv);
  x.setAttribute("src",valeur);
  x.style.width = "62%";

  var s = document.getElementById('imgSch' + idDiv);
  s.setAttribute("src",valeur);
  s.style.width = "195px";
  s.style.height = "195px";
  s.style.position= "absolute";
  s.style.top= "0px";
  s.style.left= "0px";
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

  document.getElementById('valider').style.visibility = "visible";
}

$(window).scroll(fixDiv);
fixDiv();

</script>


