<?php
session_start();

if(empty($_SESSION)){
    header('location:index.php');
} else {
    include('header.php');
}

/**
 * Html2Pdf Library - example
 *
 * HTML => PDF converter
 * distributed under the OSL-3.0 License
 *
 * @package   Html2pdf
 * @author    Laurent MINGUET <webmaster@html2pdf.fr>
 * @copyright 2017 Laurent MINGUET
 */
    require_once 'C:\xampp\htdocs\SRG\vendor\autoload.php';
    use Spipu\Html2Pdf\Html2Pdf;
    use Spipu\Html2Pdf\Exception\Html2PdfException;
    use Spipu\Html2Pdf\Exception\ExceptionFormatter;
      // Initialisation des données

    $db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
    $ManagerDevis = new DevisManager($db);

    ob_start();
    $total = 0;  $total_tva = 0;

    $iddevis = $_GET['iddevis'];
    //var_dump("DEVIS", $iddevis);
    $idclient = $_GET['idclient'];
    //var_dump("CLIENT", $idclient);
    $iduser = $_GET['iduser'];

    $lignedevis =$ManagerDevis->SelectLigneDevisManager($iddevis);
    $devis = $ManagerDevis->GetDevis($iddevis);
    $client = $ManagerDevis->SelectClientDevis($idclient);
    $users = $ManagerDevis->SelectUserDevis($iduser);
    $imageDevis = $ManagerDevis->GetImageDevis($iddevis);

    //UTILISATEUR
        echo ("<table >");
        echo("<tr>");
        echo("<td >");
        echo("<strong>".$users->GetNom(). "</strong><br>");
        echo($users->GetAdresse());
        echo("<strong>SIRET:".$users->GetSiret()."</strong><br>");
        echo("</td>");
        echo ("</tr>");
        echo("</table>");

        //echo ("<img src=".$imageDevis->GetCheminImage()." width='250' height='300' align='right'>");


    //CLIENT
        echo ("<table>");
        echo("<tr>");

        echo("<td><h2>Devis N°".$iddevis."</h2></td></tr>");
        echo("<tr>");
        echo("<td >Emis le ".date('d/m/y')."<br></td></tr>");

        echo("<tr>");
        echo("<td>Par ".$client->GetNom()." ".$client->GetPrenom()."<br></td></tr>");

        echo("<tr>");
        echo("<td>".$client->GetAdresse()."<br></td></tr>");

        echo("<tr>");
        echo("<td>".$client->GetVille()."<br></td></tr>");

        echo("<tr>");
        echo("<td>".$client->GetCodePostal()."<br></td></tr>");

        echo("<tr>");
        echo("<td>".$client->GetTel()."</td></tr>");

        echo("<tr><td>".$client->GetMail()."</td></tr>");
        echo("</table>");

        //echo("<img src="")


    //DEVIS
        echo("
        <div >
        <table  style='border: 1px solid ; width: 100%; '>
            <thead>
                <tr >
                    <th style='width: 50%';>Ref.</th>
                    <th style='width: 10%';>Quantité</th>
                    <th style='width: 10%';>Prix HT</th>
                    <th style='width: 10%';>Remise</th>
                    <th style='width: 10%';>Prix NET</th>
                    <th style='width: 10%';>Prix TTC</th>

                </tr>
            </thead>
            <tbody style='height: 100%';>");
        $sommeTtc = 0;
        $sommeNet = 0;
        foreach ($lignedevis as $lignedeviss) {
            //var_dump($lignedevis);
            $prix = $lignedeviss->GetPrix();
            $remise = $lignedeviss->GetRemise();

            $net = $prix * ($remise / 100);
            $net = $prix - $net;
            $tva = 20;
            $ttc = $net*(1+($tva/100));
            $somme = $ManagerDevis->SommePrix($iddevis);
            $somme = implode($somme);

            $sommeNet+= $net;
            $sommeTtc+= $ttc;


        
            echo("<tr style='height: 100%';>");
                echo("<td>".$lignedeviss->GetId()."</td>");
                echo("<td>1</td>");
                echo("<td>".$lignedeviss->GetPrix()." €</td>");
                echo("<td>".$lignedeviss->GetRemise()." %</td>");
                echo("<td>".$net." €</td>");
                echo("<td>".$ttc." €</td>");
            echo("</tr>");
        }
            $sommeTva = $sommeTtc - $sommeNet;
            echo("</tbody>");
            echo("</table>");
            echo("<br>");

            echo("<table align=right style='border: 1px solid; border-radius: 12px;'>
            <tr>
                <th>Total HT</th>
                <td>".$sommeNet." €</td>
            </tr>
             <tr>
                <th>TVA</th>
                <td>".$sommeTva." €</td>
            </tr>
            <tr>
                <th>Total TTC</th>
                <td>".$sommeTtc." €</td>
            </tr>
            </table>
            </div>");


?>
<?php
    $content = ob_get_clean();
    try {
        $pdf = new HTML2PDF("p","A4","fr");
        $pdf->pdf->SetAuthor('DOE John');
        $pdf->pdf->SetTitle('Devis 14');
        $pdf->pdf->SetSubject('Création d\'un Portfolio');
        $pdf->pdf->SetKeywords('HTML2PDF, Devis, PHP');
        $pdf->writeHTML($content);
        ob_clean();
        $pdf->Output('Devis.pdf');
    } catch (HTML2PDF_exception $e) {
        die($e);
    }
 
?>