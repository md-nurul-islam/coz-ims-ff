<?php
$webroot = Yii::getPathOfAlias('webroot');
$pdfs_path = $webroot . DIRECTORY_SEPARATOR . 'barcode_pdfs' . DIRECTORY_SEPARATOR;
$now = date('Ymd_His');

ob_start();
?>

<div class="print">

    <table>
        <?php
        if (!empty($purchaseRecords)) {
            $c = 0;
            $k = 0;
            $i_purchase_row_ids = array();
            foreach ($purchaseRecords as $pr) {
                ?>
                                        <!--<tr>-->
                <?php
                for ($i = 0; $i < $pr['quantity']; $i++) {
                    $rev_purchase_price = str_replace('.00', '', $pr['purchase_price']);
                    $dotless_rev_purchase_price = strrev($rev_purchase_price);
                    
                    $td_html = "";
                    for ($m = 1; $m <= 3; $m++) {
                        $td_html .= "<td style=\"width: 210px;\">
                                {$generator->getBarcode($pr['code'], $generator::TYPE_EAN_13, 1.8, 60)}
                                <p style=\"font-size: 10px; margin: 0;\">{$pr['product_name']}</p>
                                <p style=\"font-size: 10px; margin: 0;\"> TK {$pr['selling_price']}</p>
                                <p style=\"font-size: 10px; margin: 0;\">{$dotless_rev_purchase_price}K{$pr['code']}-{$pr['quantity']}/{$pr['quantity']}</p>
                            </td>";
                    }
                    if ($i % 3 == 0) {
                        $td_html = "<tr style=\"height: 135px;\">{$td_html}</tr>";
                    } else {
                        $td_html = "";
                    }
                    echo $td_html;
                }
                ?>
                <!--</tr>-->
                <?php
            }
        } else {
            ?>
            <tr>
                <td>
                    <label class="control-label">No Product available to generate barcode.</label>
                </td>
            </tr>
        <?php } ?>
    </table>


</div>

<?php
$s_pdf_content = ob_get_contents();
ob_end_clean();

if (!empty($purchaseRecords)) {
    $pdf = Yii::app()->ePdf->HTML2PDF('P', 'A4', 'en');
//    $pdf->SetDisplayMode('fullpage');
    $pdf->writeHTML($s_pdf_content);
//
//    if (isset($singleItem) && $singleItem) {
//        $pdf->Output($pdfs_path . md5($purchaseRecords[0]['product_details_id']) . '_barcodes.pdf', 'F');
//    } else {
//        $pdf->Output($pdfs_path . $now . '_barcodes.pdf', 'F');
//    }
//    require_once  Yii::app()->getBasePath() . '/vendors/tcpdf/tcpdf.php';
//    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//    // output the HTML content
//    $pdf->writeHTML($s_pdf_content);
//    var_dump($pdf);
//    exit;

    if (isset($singleItem) && $singleItem) {
        $pdf->Output($pdfs_path . md5($purchaseRecords[0]['product_details_id']) . '_barcodes.pdf', 'F');
    } else {
        $pdf->Output($pdfs_path . $now . '_barcodes.pdf', 'F');
    }
}
echo $s_pdf_content;
?>

<script type="text/javascript">
    $(document).on('click', '#btn-print', function () {
        var divContents = $(".print").html();
        var printWindow = window.open('', '', 'height=400, width=800');
        console.log(divContents);
        printWindow.document.write('<html><head><title>Print</title>');
        printWindow.document.write('</head><body >');
        printWindow.document.write(divContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    });
</script>