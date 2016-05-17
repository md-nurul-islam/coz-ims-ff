<?php
$webroot = Yii::getPathOfAlias('webroot');
$pdfs_path = $webroot . DIRECTORY_SEPARATOR . 'barcode_pdfs' . DIRECTORY_SEPARATOR;
$now = date('Ymd_His');

ob_start();
?>

<div class="print">

    <style type="text/css" media="all">
        .note {
            color: red;
            font-size: 20px;
            margin-bottom: 30px;
            margin-left: auto; 
            margin-right: auto; 
            text-align: center;
            width: 100%;
        }
        .code-wrapper {
            float: left;
            margin-bottom: 15px;
            margin-left: 70px;
            text-align: center;
            width: 11%;
        }
        .left-margin-0 {
            margin-left: 0;
        }
        .prod_barcode {
            float: left;
            width: 100%;
        }
        .prod_barcode img {
            float: left;
            width: 100%;
        }
        .clearfix {
            clear: both;
        }
        .prod_name, .prod_ptice, .prod_ref_num {
            /*font-family: 'Tahoma';*/
            font-size: 10px;
        }
    </style>
    <?php // echo Yii::app()->getBaseUrl(true);    ?>

    <?php
    if (!empty($purchaseRecords)) {
        $c = 0;
        $k = 0;
        $i_purchase_row_ids = array();
        foreach ($purchaseRecords as $pr) {
            ?>
            <?php
            for ($i = 0; $i < $pr['quantity']; $i++) {
                $left_0 = '';
                if ($i % 5 == 0) {
                    $left_0 = ' left-margin-0 clearfix';
                }
                ?>
                <div class="code-wrapper<?php echo $left_0; ?>">
                    <div class="prod_barcode">
                        <?php
                        echo $barcode_img = $generator->getBarcode($pr['code'], $generator::TYPE_EAN_13, 2, 70);
//                        $barcode_img_b_64 = base64_encode($barcode_img);
                        ?>
                        <!--<div style="background-image: url('<?php // echo 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAJPSURBVDjLpZPLS5RhFMYfv9QJlelTQZwRb2OKlKuINuHGLlBEBEOLxAu46oL0F0QQFdWizUCrWnjBaDHgThCMoiKkhUONTqmjmDp2GZ0UnWbmfc/ztrC+GbM2dXbv4ZzfeQ7vefKMMfifyP89IbevNNCYdkN2kawkCZKfSPZTOGTf6Y/m1uflKlC3LvsNTWArr9BT2LAf+W73dn5jHclIBFZyfYWU3or7T4K7AJmbl/yG7EtX1BQXNTVCYgtgbAEAYHlqYHlrsTEVQWr63RZFuqsfDAcdQPrGRR/JF5nKGm9xUxMyr0YBAEXXHgIANq/3ADQobD2J9fAkNiMTMSFb9z8ambMAQER3JC1XttkYGGZXoyZEGyTHRuBuPgBTUu7VSnUAgAUAWutOV2MjZGkehgYUA6O5A0AlkAyRnotiX3MLlFKduYCqAtuGXpyH0XQmOj+TIURt51OzURTYZdBKV2UBSsOIcRp/TVTT4ewK6idECAihtUKOArWcjq/B8tQ6UkUR31+OYXP4sTOdisivrkMyHodWejlXwcC38Fvs8dY5xaIId89VlJy7ACpCNCFCuOp8+BJ6A631gANQSg1mVmOxxGQYRW2nHMha4B5WA3chsv22T5/B13AIicWZmNZ6cMchTXUe81Okzz54pLi0uQWp+TmkZqMwxsBV74Or3od4OISPr0e3SHa3PX0f3HXKofNH/UIG9pZ5PeUth+CyS2EMkEqs4fPEOBJLsyske48/+xD8oxcAYPzs4QaS7RR2kbLTTOTQieczfzfTv8QPldGvTGoF6/8AAAAASUVORK5CYII=';     ?>'); "></div>-->
                        <!--<img src="data:image/png;base64,<?php // echo $barcode_img_b_64;     ?>" >-->
                        <?php // echo '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAJPSURBVDjLpZPLS5RhFMYfv9QJlelTQZwRb2OKlKuINuHGLlBEBEOLxAu46oL0F0QQFdWizUCrWnjBaDHgThCMoiKkhUONTqmjmDp2GZ0UnWbmfc/ztrC+GbM2dXbv4ZzfeQ7vefKMMfifyP89IbevNNCYdkN2kawkCZKfSPZTOGTf6Y/m1uflKlC3LvsNTWArr9BT2LAf+W73dn5jHclIBFZyfYWU3or7T4K7AJmbl/yG7EtX1BQXNTVCYgtgbAEAYHlqYHlrsTEVQWr63RZFuqsfDAcdQPrGRR/JF5nKGm9xUxMyr0YBAEXXHgIANq/3ADQobD2J9fAkNiMTMSFb9z8ambMAQER3JC1XttkYGGZXoyZEGyTHRuBuPgBTUu7VSnUAgAUAWutOV2MjZGkehgYUA6O5A0AlkAyRnotiX3MLlFKduYCqAtuGXpyH0XQmOj+TIURt51OzURTYZdBKV2UBSsOIcRp/TVTT4ewK6idECAihtUKOArWcjq/B8tQ6UkUR31+OYXP4sTOdisivrkMyHodWejlXwcC38Fvs8dY5xaIId89VlJy7ACpCNCFCuOp8+BJ6A631gANQSg1mVmOxxGQYRW2nHMha4B5WA3chsv22T5/B13AIicWZmNZ6cMchTXUe81Okzz54pLi0uQWp+TmkZqMwxsBV74Or3od4OISPr0e3SHa3PX0f3HXKofNH/UIG9pZ5PeUth+CyS2EMkEqs4fPEOBJLsyske48/+xD8oxcAYPzs4QaS7RR2kbLTTOTQieczfzfTv8QPldGvTGoF6/8AAAAASUVORK5CYII=">'; ?>
                        <?php // echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($pr['code'], $generator::TYPE_EAN_13, 1.5, 70)) . '">'; ?>
                    </div>
                    <div class="prod_name"><?php echo $pr['product_name']; ?></div>
                    <div class="prod_ptice"><?php echo ' TK ' . $pr['selling_price']; ?></div>
                    <div class="prod_ref_num">
                        <?php
                        $rev_purchase_price = str_replace('.00', '', $pr['purchase_price']);
                        $dotless_rev_purchase_price = strrev($rev_purchase_price);

                        echo $dotless_rev_purchase_price;
                        ?>K<?php echo $pr['code']; ?>-<?php echo $pr['quantity'] . '/' . $pr['quantity']; ?>
                    </div>
                </div>
                <?php
                $c++;
                if ($c % 45 == 0) {
                    ?>
                    <p style="page-break-after:always;"></p>
                <?php } ?>
                <?php
            }
            $k++;
        }
    } else {
        ?>
        <label class="control-label">No Product available to generate barcode.</label>
    <?php } ?>

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