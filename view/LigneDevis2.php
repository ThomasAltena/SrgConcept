<!DOCTYPE html>
<html>
<head>
	<title>Monumac</title>
</head>

<?php include('header.php');

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
 ?>


<!-------------------------- Il faut mettre le chemin dans les value -------------------------->
<body >
	<input type="text" id="MV" value="2.8" hidden="hidden"/>
	<input type="text" id="PT" value="7800" hidden="hidden" />
<div class='container'>

	<div id='schema'>
		<img id="imgSch1" src="">
		<img id="imgSch2" src="">
		<img id="imgSch3" src="">
		<img id="imgSch4" src="">
		<img id="imgSch5" src="">
	</div>
<div class='row'>
	<div id="Div1" class="Sel col-8">
 
       <label for="Piece">Selectionnez une piéce ?</label><br />
       <select id="select1" onchange="AfficheImg(1)" >
       <option value=""></option>

<?php
try
{
        $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
}
catch(Exception $e)
{
            die('Erreur : '.$e->getMessage());
}
 
 
$reponse = $bdd->query('SELECT * FROM pieces');
 
while ($donnees = $reponse->fetch())
{
?>
		            <option value=" <?php echo $donnees['Chemin_piece']; ?>"> <?php echo $donnees['Code_piece']; ?></option>
<?php
}
 
$reponse->closeCursor();
 
?>
		</select>
<img id="img1" src="">
		</br></br>
			<input name="hauteur" type="text" class="text1" placeholder="Hauteur"> <input name="largeur" type="text" class="text1" placeholder="Largeur"> <input name="profondeur" type="text" class="text1" placeholder="Profondeur">
		</br></br>
		<label for="Piece">Selectionnez une ou plusieurs option ?</label><br />
		<select id="select1" onchange="AfficheImg(1)" >
        <option value=""></option>

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
 
$reponse->closeCursor();
 
?>
		</select>
		</br></br>
		<label for="Piece">Selectionnez une matiére ?</label><br />
		<select id="select1" onchange="AfficheImg(1)" >
        <option value=""></option>

<?php
try
{
        $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
}
catch(Exception $e)
{
            die('Erreur : '.$e->getMessage());
}
 
 
$reponse = $bdd->query('SELECT * FROM matieres');
 
while ($donnees = $reponse->fetch())
{
?>
		            <option value=" <?php echo $donnees['Id_matiere']; ?>"> <?php echo $donnees['Libelle_matiere']; ?></option>

<?php
}
 
$reponse->closeCursor();
 
?>
		</select>
		</br></br>
				<label for="Piece">Selectionnez une couleur de matiére ?</label><br />
		<select id="select1" onchange="AfficheImg(1)" >
        <option value=""></option>

<?php
try
{
        $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
}
catch(Exception $e)
{
            die('Erreur : '.$e->getMessage());
}
 
 
$reponse = $bdd->query('SELECT * FROM couleurs');
 
while ($donnees = $reponse->fetch())
{
?>
		            <option value=" <?php echo $donnees['Id_couleur']; ?>"> <?php echo $donnees['Libelle_couleur']; ?></option>

<?php
}
 
$reponse->closeCursor();
 
?>
		</select>
		</br></br>
			<input type="text" class="text1" placeholder="Remise" name="Remise">
		<br><br>
			<button name="submit" type="submit" value="" class="btn btn-primary"">Valider la piéce</button>
			<input type="button"  id="Valide1" onclick="suite(2)" value="Suivant" /> <p id="prix1"></p>

		</div>




<?php
  if(isset($_POST['submit'])){
   //if($_POST['Chemin_piece'] != "" && $_POST['Code_piece'] != "" && $_POST['hauteur'] != "" && $_POST['largeur'] != "" && $_POST['profondeur'] != ""){
    echo "test";
    /* Assignation var */
    $id = "";
    $code = $_POST['Code_piece'];
    $Remise = $_POST['Remise'];
    $prix = $_POST['prix1'] ;
    $poids = "10"; 
    $hauteur = $_POST['hauteur'];
    $largeur = $_POST['largeur'];
    $profondeur = $_POST['profondeur'];
    $idpiece = $POST['Id_piece'];
    $idmatiere = $_POST['Id_matiere'];
    $idcouleur = $_POST['Id_couleur'];
    $idtva = "10";
    $option1 = $_POST['Id_option'];
    $option2 = "1";
    $option3 = "1";
    $option4 = "1";
    $option5 = "1";


    /* Construct */
    $ligne = new LigneDevis([
    "Id_ligne" => $id,
    "Code_ligne" => $libelle,
    "Remise_ligne" => $code,
    "Prix_ligne" => $prix,
    "Poids_ligne" => $poids,
    "Hauteur_ligne" => $hauteur,
    "Largeur_ligne" => $largeur,
    "Profondeur_ligne" => $profondeur,
    "Id_piece" => $idpiece,
    "Id_matiere" => $ipmatiere,
    "Id_couleur" => $idcouleur,
    "Id_tva" => $idtva,
    "Option1" => $option1,
    "Option2" => $option2,
    "Option3" => $option3,
    "Option4" => $option4,
    "Option5" => $option5,

    //"fileToUpload" => $image,
    ]);

    /* BDD*/
  $db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
  $ManagerLigneDevis = new LigneDevisManager($db); //Connexion a la BDD


  /** Ajout **/
  $ManagerLigneDevis->AddLigne($ligne);

  echo("<div class='alert alert-success'><strong>Félicitation !  </strong> Le nouvelle piéce a été ajoutée.</div>");
//}else{
  //echo("<div class='alert alert-danger'><strong>Inforamtion :  </strong>Remplissez les champs obligatoires.</div>");
//}

}

?>
</div>
<!------------------------------------------------------------------------------------- Div2 -------->
<div class='row'>
	<div id="Div2" class="Sel col-8">
       <label for="Piec2">Selectionnez une piéce ?</label><br />
       <select id="select2" onchange="AfficheImg(2)" >
       <option value=""></option>

<?php
try
{
        $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
}
catch(Exception $e)
{
            die('Erreur : '.$e->getMessage());
}
 
 
$reponse = $bdd->query('SELECT * FROM pieces');
 
while ($donnees = $reponse->fetch())
{
?>
		            <option value=" <?php echo $donnees['Chemin_piece']; ?>"> <?php echo $donnees['Code_piece']; ?></option>
<?php
}
 
$reponse->closeCursor();
 
?>
</select>
<img id="img2" src="">
		</br></br>
			<input type="text" class="text2" placeholder="Hauteur"> <input type="text" class="text2" placeholder="Largeur"> <input type="text" class="text2" placeholder="Profondeur">
		</br></br>
			<button name="go" type="submit" value="" class="btn btn-primary"">Valider la piéce</button>
			<input type="button" id="Valide2" onclick="suite(3)" value="Suivant" /> <p id="prix2"></p>
		</div>
	</div>
<!------------------------------------------------------------------------------ Div3 -->
<div class='row'>
	<div id="Div3" class="Sel col-8">
       <label for="Piec3">Selectionnez une piéce ?</label><br />
       <select id="select3" onchange="AfficheImg(3)" >
       <option value=""></option>

<?php
try
{
        $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
}
catch(Exception $e)
{
            die('Erreur : '.$e->getMessage());
}
 
 
$reponse = $bdd->query('SELECT * FROM pieces');
 
while ($donnees = $reponse->fetch())
{
?>
		            <option value=" <?php echo $donnees['Chemin_piece']; ?>"> <?php echo $donnees['Code_piece']; ?></option>
<?php
}
 
$reponse->closeCursor();
 
?>
</select>
<img id="img3" src="">
		</br></br>
			<input type="text" class="text3" placeholder="Hauteur"> <input type="text" class="text3" placeholder="Largeur"> <input type="text" class="text3" placeholder="Profondeur">
		</br></br>
			<button name="go" type="submit" value="" class="btn btn-primary"">Valider la piéce</button>
			<input type="button" id="Valide3" onclick="suite(4)" value="Suivant" /> <p id="prix3"></p>
	</div>
</div>

<!------------------------------------------------------------------------------------- Div4 -->
<div class='row'>
	<div id="Div4" class="Sel col-8">
       <label for="Piec4">Selectionnez une piéce ?</label><br />
       <select id="select4" onchange="AfficheImg(4)" >
       <option value=""></option>

<?php
try
{
        $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
}
catch(Exception $e)
{
            die('Erreur : '.$e->getMessage());
}
 
 
$reponse = $bdd->query('SELECT * FROM pieces');
 
while ($donnees = $reponse->fetch())
{
?>
		            <option value=" <?php echo $donnees['Chemin_piece']; ?>"> <?php echo $donnees['Code_piece']; ?></option>
<?php
}
 
$reponse->closeCursor();
 
?>
</select>
<img id="img4" src="">
		</br></br>
			<input type="text" class="text4" placeholder="Hauteur"> <input type="text" class="text2" placeholder="Largeur"> <input type="text" class="text4" placeholder="Profondeur">
		</br></br>
			<button name="go" type="submit" value="" class="btn btn-primary"">Valider la piéce</button>
			<input type="button" id="Valide4" onclick="suite(5)" value="Suivant" /> <p id="prix4"></p>

		</div>
	</div>

<!------------------------------------------------------------------------------------- Div5 -->
<div class='row'>
	<div id="Div5" class="Sel col-8">
       <label for="Piec5">Selectionnez une piéce ?</label><br />
       <select id="select5" onchange="AfficheImg(5)" >
       <option value=""></option>

<?php
try
{
        $bdd = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
}
catch(Exception $e)
{
            die('Erreur : '.$e->getMessage());
}
 
 
$reponse = $bdd->query('SELECT * FROM pieces');
 
while ($donnees = $reponse->fetch())
{
?>
		            <option value=" <?php echo $donnees['Chemin_piece']; ?>"> <?php echo $donnees['Code_piece']; ?></option>
<?php
}
 
$reponse->closeCursor();
 
?>
</select>
<img id="img5" src="">
		</br></br>
			<input type="text" class="text5" placeholder="Hauteur"> <input type="text" class="text5" placeholder="Largeur"> <input type="text" class="text5" placeholder="Profondeur">
		</br></br>
			<button name="go" type="submit" value="" class="btn btn-primary"">Valider la piéce</button>
			<input type="button" id="Valide5" onclick="suite(6)" value="Suivant" /> <p id="prix5"></p>
		</div>
	</div>

</div>
</div>
</body>
<footer>
	<input type="button" id="validation" name="Validation" value="Valider le devis" onclick="window.location.href='../view/Devis.php?iddevis=<?php echo $Devis ?>&idclient=<?php echo $Client ?>&iduser=<?php echo $User ?>'">
	<input type="button" id="btnSave">
</footer>
</html>

<script type="text/javascript">

//Fonction afficher la div suivante/calcule prix
	function suite(idDivSuite){
	document.getElementById('Div'+idDivSuite).style.visibility="visible";
	t = idDivSuite - 1;
	var pt = document.getElementById('PT').value;
	var mv = document.getElementById('MV').value;
	var t1 =document.getElementsByClassName('text'+ t)[0].value;
	var t2 =document.getElementsByClassName('text'+ t)[1].value;
	var t3 =document.getElementsByClassName('text'+ t)[2].value;
	t1 = parseFloat(t1);
	t2 = parseFloat(t2);
	t3 = parseFloat(t3);
	var cm = t1 * t2 *t3;
	var m = cm / 1000000;
	var tonne = m * mv;
	var pf = tonne * pt;
	var testprix = isNaN(pf);
	if(testprix === true){
		document.getElementById('prix' + t).innerHTML = "Erreur de calcul";
	}else{
		document.getElementById('prix' + t).innerHTML = pf.toFixed(2) + '€';
	}

	var r = document.getElementById('Valide'+ t).value;
	if(r == 'Débloquer'){

		document.getElementById('Valide'+ t).value = 'Bloquer';
		document.getElementById('select' + t).disabled = "";
		document.getElementsByClassName('text'+ t)[0].disabled = "";
		document.getElementsByClassName('text'+ t)[1].disabled = "";
		document.getElementsByClassName('text'+ t)[2].disabled = "";

	}else{
		document.getElementById('Valide'+ t).value = 'Débloquer';
		document.getElementById('select' + t).disabled = "true";
		document.getElementsByClassName('text'+ t)[0].disabled = "true";
		document.getElementsByClassName('text'+ t)[1].disabled = "true";
		document.getElementsByClassName('text'+ t)[2].disabled = "true";
	}

}

//fonction recup value/ img 
function AfficheImg(idDiv){
select = document.getElementById('select'+ idDiv);
choice = select.selectedIndex  // Récupération de l'index du <option> choisi
 
valeur= select.options[choice].value; // Récupération du texte du <option> d'index "choice"
	
	var x = document.getElementById('img' + idDiv);
	x.setAttribute("src",valeur);
	x.style.width = "15%";

	var s = document.getElementById('imgSch' + idDiv);
	s.setAttribute("src",valeur);
	s.style.width = "80%";
	s.style.height = "280%";
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

$(function() { 
    $("#btnSave").click(function() { 
        html2canvas($("#schema"), {
            onrendered: function(canvas) {
                theCanvas = canvas;
                document.body.appendChild(canvas);

                // Convert and download as image 
                Canvas2Image.saveAsPNG(canvas); 
                //$("#img-out").append(canvas);
                // Clean up 
                //document.body.removeChild(canvas);
            }
        });
    });
}); 


$(window).scroll(fixDiv);
fixDiv();

</script>
