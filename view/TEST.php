<?php
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
    require('../model/DevisManager.php');
    use Spipu\Html2Pdf\Html2Pdf;
    use Spipu\Html2Pdf\Exception\Html2PdfException;
    use Spipu\Html2Pdf\Exception\ExceptionFormatter;
      // Initialisation des données
 
    ob_start();
    $total = 0;  $total_tva = 0;
    $id = $_GET['id'];
    var_dump($id);
?>
 
///// Insertion du CSS 
 
<page backtop="10mm" backleft="10mm" backright="10mm" backbottom="10mm" footer="page;">
 
    <page_footer>
        <hr />
        <p>Fait a Paris, le <?php echo date("d/m/y"); ?></p>
        <p>Signature du particulier, suivie de la mension manuscrite "bon pour accord".</p>
        <p>&amp;nbsp;</p>
    </page_footer>
 
    <table style="vertical-align: top;">
        <tr>
            <td class="75p">
                <strong><?php echo $UserDevis['Nom_user']." ".$UserDevis['Siret_user']; ?></strong><br />
                <?php echo nl2br($UserDevis['address']); ?><br />
                <strong>SIRET:</strong> <?php echo $user['siret']; ?><br />
                <?php echo $user['email']; ?>
            </td>
            <td class="25p">
                <strong><?php echo $client['firstname']." ".$client['lastname']; ?></strong><br />
                <?php echo nl2br($client['address']); ?><br />
            </td>
        </tr>
    </table>
 
   <table style="margin-top: 50px;">
        <tr>
            <td class="50p"><h2>Devis n°14</h2></td>
            <td class="50p" style="text-align: right;">Emis le <?php echo date("d/m/y"); ?></td>
        </tr>
        <tr>
            <td style="padding-top: 15px;" colspan="2"><strong>Objectif:</strong> <?php echo $project['name']; ?></td>
        </tr>
    </table>
 
    <table style="margin-top: 30px;" class="border">
        <thead>
            <tr>
                <th class="60p">Description</th>
                <th class="10p">Quantité</th>
                <th class="15p">Prix Unitaire</th>
                <th class="15p">Montant</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?php echo $task['description']; ?></td>
                <td><?php echo $task['quantity']; ?></td>
                <td><?php echo $task['price']; ?> &amp;euro;</td>
                <td><?php
                        $price_tva = $task['price']*1.2;
                        echo $price_tva;
                    ?>
                &amp;euro;</td>
 
                <?php
                    $total += $task['price'];
                    $total_tva += $price_tva;
                ?>
            </tr>
            <?php endforeach ?>
 
            <tr>
                <td class="space"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
 
            <tr>
                <td colspan="2" class="no-border"></td>
                <td style="text-align: center;" rowspan="3"><strong>Total:</strong></td>
                <td>HT : <?php echo $total; ?> &amp;euro;</td>
            </tr>
            <tr>
                <td colspan="2" class="no-border"></td>
                <td>TVA : <?php echo ($total_tva - $total); ?> &amp;euro;</td>
            </tr>
            <tr>
                <td colspan="2" class="no-border"></td>
                <td>TTC : <?php echo $total_tva; ?> &amp;euro;</td>
            </tr>
        </tbody>
    </table>
 
</page>
 
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