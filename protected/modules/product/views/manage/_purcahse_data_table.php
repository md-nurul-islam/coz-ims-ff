<div class="report_table col-sm-6">

    <?php if (!empty($purchase)) { ?>

        <table class="table table-bordered table-striped table-hover table-condensed">

            <thead>
                <tr>
                    <th>Bill Number</th>
                    <th>Ref. Number</th>
                    <th>Quantity</th>
                    <th>Cost</th>
                    <th>Price</th>
                    <th>Item Total</th>
                </tr>
            </thead>

            <tbody>

                <?php
                $j = 0;
                $num_records = sizeof($purchase);

                $total_gross = 0.00;
                $total_discount = 0.00;
                $total_vat = 0.00;

                $total_balance = 0.00;
                $total_amount_given = 0.00;

                $total_net = 0.00;

                foreach ($purchase as $k => $v) {

                    $j++;

                    $gross = $v['bill_total'];
                    unset($v['bill_total']);

                    $discount = $v['discount'];
                    unset($v['discount']);

                    $vat = $v['vat'];
                    unset($v['vat']);

                    $balance = $v['balance'];
                    unset($v['balance']);

                    $net = $gross - $discount;

                    $amount_given = $v['amount_given'];
                    unset($v['amount_given']);
                    ?>

                    <?php
                    $num_rows = sizeof($v['cart_items']);
                    $i = 0;
                    foreach ($v['cart_items'] as $c) {
                        ?>

                        <tr>
                            <?php if ($i == 0) { ?>
                                <td rowspan="<?php echo $num_rows; ?>"><?php echo $k; ?></td>
                            <?php } ?>

                            <td><?php echo $c['ref_num']; ?></td>
                            <td><?php echo $c['qty']; ?></td>
                            <td><?php echo $c['cost']; ?></td>
                            <td><?php echo $c['price']; ?></td>
                            <td><?php echo $c['item_sub_total']; ?></td>
                            <?php ?>
                        </tr>

                        <?php
                        $i++;
                    }
                    ?>

                    <tr>
                        <td colspan="5" style="text-align: right;">Gross</td>
                        <td><?php echo number_format($gross, 2); ?></td>
                    </tr>

                    <tr>
                        <td colspan="5" style="text-align: right;">Vat</td>
                        <td><?php echo number_format($vat, 2); ?></td>
                    </tr>

                    <tr>
                        <td colspan="5" style="text-align: right;">Discount</td>
                        <td><?php echo number_format($discount, 2); ?></td>
                    </tr>

                    <tr>
                        <td colspan="5" style="text-align: right;">Net</td>
                        <td><?php echo number_format($net, 2); ?></td>
                    </tr>

                    <?php if ($j < $num_records) { ?>
                        <tr><td colspan="5">&nbsp;</td></tr>
                    <?php } ?>
                    <?php
                    $total_gross += $gross;
                    $total_vat += $vat;
                    $total_net += $net;


                    $total_discount += $discount;
                    $total_balance += $balance;
                }
                ?>
                <tr><td colspan="5" style="border-bottom: none;">&nbsp;</td></tr>
                <tr><td colspan="5" style="border-top: none;">&nbsp;</td></tr>

                <tr>
                    <td colspan="5" style="text-align: right;">Total Gross</td>
                    <td><?php echo number_format($total_gross, 2); ?></td>
                </tr>

                <tr>
                    <td colspan="5" style="text-align: right;">Total Discount</td>
                    <td><?php echo number_format($total_discount, 2); ?></td>
                </tr>

                <tr>
                    <td colspan="5" style="text-align: right;">Total Vat</td>
                    <td><?php echo number_format($total_vat, 2); ?></td>
                </tr>

                <tr>
                    <td colspan="5" style="text-align: right;">Total Net</td>
                    <td><?php echo number_format($total_net, 2); ?></td>
                </tr>

            </tbody>

        </table>

    <?php } else { ?>
        <div class="alert alert-warning">
            <!--<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>-->
            No Record Found.
        </div>
    <?php } ?>

</div>