<?php
$grand_real_returned_sub_total = $model['grand_real_returned_sub_total'];
$grand_sum_exchanged_sub_total = $model['grand_sum_exchanged_sub_total'];
$grand_sum_adjustable = $model['grand_sum_adjustable'];

unset($model['grand_real_returned_sub_total']);
unset($model['grand_sum_exchanged_sub_total']);
unset($model['grand_sum_adjustable']);
?>

<div class="col-lg-12">

    <div class="box box-info">

        <div class="box-body">

            <div class="center col-lg-7">
                <h3 class="text-aqua">Exchange Report Starting from <?php echo $from_date; ?> till <?php echo $to_date; ?></h3>
            </div>

            <legend></legend>

            <div class="report_table">

                <table class="exchange_report table table-bordered table-striped table-hover table-condensed">

                    <thead>
                        <tr>
                            <th>Bill Number</th>
                            <th>Ref. Number</th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Item Total</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        $k = 0;
                        foreach ($model as $data) {
                            foreach ($data as $sale_bill_number => $records) {
                                $sum_returned_sub_total = $records['sum_returned_sub_total'];
                                $sum_exchanged_sub_total = $records['sum_exchanged_sub_total'];
                                $sum_adjustable = $records['sum_adjustable'];

                                unset($records['sum_returned_sub_total']);
                                unset($records['sum_exchanged_sub_total']);
                                unset($records['sum_adjustable']);
                                ?>
                                <?php if ($k > 0) { ?>
                                    <tr>
                                        <td colspan="6">&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="6">Exchange records for Bill Number: <?php echo $sale_bill_number; ?></td>
                                </tr>

                                <?php foreach ($records as $exchange_bill_number => $exchange_data) { ?>
                                    <?php
                                    $ret_items_subtotal = 0.00;
                                    $exc_items_subtotal = 0.00;
                                    $sale_discount = 0.00;

                                    $num_row_span = count($exchange_data['returned_items']) + count($exchange_data['exchanged_items']) + 7;
                                    $i = 0;
                                    foreach ($exchange_data['returned_items'] as $return_row) {
                                        ?>
                                        <tr>
                                            <?php if ($i == 0) { ?>
                                                <td rowspan="<?php echo $num_row_span; ?>" class="abs-middle"><?php echo $exchange_bill_number; ?></td>
                                            <?php } ?>
                                            <td><?php echo $return_row['reference_number']; ?></td>
                                            <td class="text-danger"><?php echo $return_row['product_name'] . ' (Ret.)'; ?></td>
                                            <td><?php echo $return_row['quantity']; ?></td>
                                            <td><?php echo $return_row['price']; ?></td>
                                            <td>
                                                <?php
                                                $ret_items_subtotal += floatval($return_row['sub_total']);
                                                echo $return_row['sub_total'];
                                                ?>
                                            </td>
                                        </tr>

                                        <?php
                                        $i++;
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="4" class="text-right">Returned Items Total</td>
                                        <td><?php echo number_format($ret_items_subtotal, 2); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right">Returned Items Discount</td>
                                        <td>
                                            <?php
                                            if ($ret_items_subtotal > floatval($sum_returned_sub_total)) {
                                                $sale_discount = $ret_items_subtotal - $sum_returned_sub_total;
                                            }
                                            echo '-' . number_format($sale_discount, 2);
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right">Returnable Total</td>
                                        <td><?php echo number_format($ret_items_subtotal - $sale_discount, 2); ?></td>
                                    </tr>

                                    <tr>
                                        <td colspan="5">&nbsp;</td>
                                    </tr>

                                    <?php foreach ($exchange_data['exchanged_items'] as $exchange_row) { ?>
                                        <tr>
                                            <td><?php echo $exchange_row['reference_number']; ?></td>
                                            <td class="text-success"><?php echo $exchange_row['product_name'] . ' (Exc.)'; ?></td>
                                            <td><?php echo $exchange_row['quantity']; ?></td>
                                            <td><?php echo $exchange_row['price']; ?></td>
                                            <td>
                                                <?php
                                                $exc_items_subtotal += floatval($exchange_row['sub_total']);
                                                echo $exchange_row['sub_total'];
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <tr>
                                        <td colspan="4" class="text-right">Exchanged Items Total</td>
                                        <td><?php echo number_format($exc_items_subtotal, 2); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right">Total Adjustable</td>
                                        <td><?php echo number_format(($exc_items_subtotal - $ret_items_subtotal) + $sale_discount, 2); ?></td>
                                    </tr>

                                    <?php
                                }
                                ?>
                                <?php
                            }
                            ?>

                            <?php $k++;
                        }
                        ?>
                        <tr>
                            <td colspan="6">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right">Total Returned</td>
                            <td><?php echo number_format($grand_real_returned_sub_total, 2); ?></td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right">Total Exchanged</td>
                            <td><?php echo number_format($grand_sum_exchanged_sub_total, 2); ?></td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right">Total Adjusted</td>
                            <td><?php echo number_format($grand_sum_adjustable, 2); ?></td>
                        </tr>
                    </tbody>

                </table>

            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>