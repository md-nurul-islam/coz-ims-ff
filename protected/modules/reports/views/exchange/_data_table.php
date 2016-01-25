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

                <table class="table table-bordered table-striped table-hover table-condensed">

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
                        $i = 0;
                        foreach ($model as $data) {

                            foreach ($data as $sale_bill_number => $records) {
                                $sum_returned_sub_total = $records['sum_returned_sub_total'];
                                $sum_exchanged_sub_total = $records['sum_exchanged_sub_total'];
                                $sum_adjustable = $records['sum_adjustable'];

                                unset($records['sum_returned_sub_total']);
                                unset($records['sum_exchanged_sub_total']);
                                unset($records['sum_adjustable']);
                                ?>

                                <tr>
                                    <td colspan="6">Exchange record for Bill Number: <?php echo $sale_bill_number; ?></td>
                                </tr>

                                <?php
//        echo '<pre>';
//        CVarDumper::dump($records);
//        exit;
                                foreach ($records as $exchange_bill_number => $exchange_data) {
                                    $num_rows = count($exchange_data['returned_items']) + count($exchange_data['exchanged_items']);
                                    $j = 0;
                                    foreach ($exchange_data['returned_items'] as $ret_item) {
//                                            var_dump($ret_item);
//                                            exit;
                                        ?>
                                        <tr>
                                            <?php // if ($j == 0) { ?>
                                                <!--<td rowspan="<?php echo $num_rows; ?>"><?php echo $exchange_bill_number; ?></td>-->
                                            <?php // } ?>
                                            <td>&nbsp;</td>
                                            <td>
                                                <?php echo '&nbsp;'; ?>
                                                <span class="label label-warning"><?php echo '&nbsp;'; ?></span>
                                                <span class="label label-success "><?php echo '&nbsp;'; ?></span>
                                                <span class="label label-info"><?php echo '&nbsp;'; ?></span>
                                            </td>
                                            <td><?php echo '&nbsp;'; ?></td>
                                            <td><?php echo '&nbsp;'; ?></td>
                                            <td><?php echo '&nbsp;'; ?></td>
                                            <td><?php echo '&nbsp;'; ?></td>
                                            <?php ?>
                                        </tr>
                                        <?php
                                        $j++;
                                    }
                                }
                                ?>




                                <?php
                            }

                            $i++;
                        }
                        ?>


                    </tbody>

                </table>

            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>