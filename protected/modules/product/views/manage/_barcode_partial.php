<?php ob_start(); ?>

<table>
    <?php
    if (!empty($purchaseRecords)) {
        $c = 0;
        $k = 0;
        $i_purchase_row_ids = array();
        foreach ($purchaseRecords as $pr) {
            ?>
            <tr>
                <?php
                $i_td_cnt = count($pr);
                for ($i = 0; $i < $i_td_cnt; $i++) {
                    $rev_purchase_price = str_replace('.00', '', $pr['purchase_price']);
                    $dotless_rev_purchase_price = strrev($rev_purchase_price);
                    ?>
                    <td style="width: 150px; padding-bottom: 15px;">
                        <?php echo $generator->getBarcode($pr['code'], $generator::TYPE_EAN_13, 1.25, 30); ?>
                        <p style="margin: 0px; font-size: 13px; letter-spacing: 0.8px;"><?php echo $pr['code'] . rand(0, 9); ?></p>
                        <p style="margin: 0px; font-size: 11px; letter-spacing: 0.5px;"><?php echo $pr['product_name']; ?></p>
                        <p style="margin: 0px; font-size: 11px; letter-spacing: 0.5px;"><?php echo "TK {$pr['selling_price']}"; ?></p>
                        <p style="margin: 0px; font-size: 10px;"><?php echo "{$dotless_rev_purchase_price}K{$pr['code']}-{$pr['quantity']}/{$pr['quantity']}"; ?></p>
                    </td>
                    <?php
                }
                ?>
            </tr>
            <?php
        }
    } else {
        ?>
        <tr>
            <td>
                <label><h3 class="text-danger text-center">No Product available to generate barcode.</h3></label>
                <!--<label class="control-label text-danger text-center"></label>-->
            </td>
        </tr>
    <?php } ?>
</table>

<?php
$s_pdf_content = ob_get_contents();
ob_end_clean();

if (!empty($purchaseRecords)) {
    $pdf = Yii::app()->ePdf->HTML2PDF('P', 'A4', 'en');
    $pdf->writeHTML($s_pdf_content);

    $webroot = Yii::getPathOfAlias('webroot');
    $now = date('Ymd_His');

    if (isset($singleItem) && $singleItem) {
        $pdfs_path = $webroot . DIRECTORY_SEPARATOR . 'barcode_pdfs' . DIRECTORY_SEPARATOR;
        $pdf->Output($pdfs_path . md5($purchaseRecords[0][0]['product_details_id']) . '_barcodes.pdf', 'F');
    } else {
        $pdfs_path = $webroot . DIRECTORY_SEPARATOR . 'bulk_barcode' . DIRECTORY_SEPARATOR;
        $pdf->Output("{$pdfs_path}{$now}_barcodes.pdf", 'F');
    }
}
echo $s_pdf_content;
?>