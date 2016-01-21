
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
                            <th colspan="5">Returned items for Bill Number: </th>
                        </tr>
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
                        $j = 0;
                        $num_records = sizeof($model);

                        $total_gross = 0.00;
                        $total_discount = 0.00;
                        $total_vat = 0.00;

                        $total_balance = 0.00;
                        $total_amount_given = 0.00;

                        $total_net = 0.00;

                        foreach ($model as $k => $v) {

                            $j++;

                            $discount = $v['discount'];
                            unset($v['discount']);

                            $vat = $v['vat'];
                            unset($v['vat']);

                            $balance = $v['balance'];
                            unset($v['balance']);

                            $gross = $v['bill_total'] + $vat;
                            unset($v['bill_total']);

                            $net = ($gross - $discount) - $vat;

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
                                    <td>
                                        <?php echo $c['prod_name']; ?>
                                        <span class="label label-warning"><?php echo $c['color_name']; ?></span>
                                        <span class="label label-success "><?php echo $c['size_name']; ?></span>
                                        <span class="label label-info"><?php echo $c['grade_name']; ?></span>
                                    </td>
                                    <td><?php echo $c['qty']; ?></td>
                                    <td><?php echo $c['price']; ?></td>
                                    <td><?php echo number_format($c['item_sub_total'], 2); ?></td>
                                    <?php ?>
                                </tr>

                                <?php
                                $i++;
                            }
                            ?>

                            <?php if ($advance_sale_list) { ?>
                                <tr>
                                    <td colspan="5" style="text-align: right;">Advance</td>
                                    <td><?php echo number_format($amount_given, 2); ?></td>
                                </tr>
                            <?php } ?>

                            <?php if ($advance_sale_list) { ?>
                                <tr>
                                    <td colspan="5" style="text-align: right;">Due</td>
                                    <td><?php echo number_format($balance, 2); ?></td>
                                </tr>
                            <?php } ?>

                            <tr>
                                <td colspan="5" style="text-align: right;">Vat</td>
                                <td><?php echo number_format($vat, 2); ?></td>
                            </tr>

                            <tr>
                                <td colspan="5" style="text-align: right;">Discount</td>
                                <td><?php echo number_format($discount, 2); ?></td>
                            </tr>

                            <tr>
                                <td colspan="5" style="text-align: right;">Gross</td>
                                <td><?php echo number_format($gross, 2); ?></td>
                            </tr>

                            <tr>
                                <td colspan="5" style="text-align: right;">Net</td>
                                <td><?php echo number_format($net, 2); ?></td>
                            </tr>

                            <?php if ($j < $num_records) { ?>
                                <tr><td colspan="6">&nbsp;</td></tr>
                            <?php } ?>
                            <?php
                            $total_gross += $gross;
                            $total_vat += $vat;
                            $total_net += $net;

                            if ($advance_sale_list) {
                                $total_amount_given += $amount_given;
                            }
                            $total_discount += $discount;
                            $total_balance += $balance;
                        }
                        ?>
                        <tr><td colspan="6" style="border-bottom: none;">&nbsp;</td></tr>
                        <tr><td colspan="6" style="border-top: none;">&nbsp;</td></tr>

                        <tr>
                            <td colspan="5" style="text-align: right;">Total Gross</td>
                            <td><?php echo number_format($total_gross, 2); ?></td>
                        </tr>

                        <?php if ($advance_sale_list) { ?>
                            <tr>
                                <td colspan="5" style="text-align: right;">Total Advance</td>
                                <td><?php echo number_format($total_amount_given, 2); ?></td>
                            </tr>
                        <?php } ?>

                        <tr>
                            <td colspan="5" style="text-align: right;">Total Vat</td>
                            <td><?php echo number_format($total_vat, 2); ?></td>
                        </tr>

                        <tr>
                            <td colspan="5" style="text-align: right;">Total Discount</td>
                            <td><?php echo number_format($total_discount, 2); ?></td>
                        </tr>

                        <tr>
                            <td colspan="5" style="text-align: right;">Total Net</td>
                            <td><?php echo number_format($total_net, 2); ?></td>
                        </tr>

                        <?php if ($advance_sale_list) { ?>
                            <tr>
                                <td colspan="5" style="text-align: right;">Total Due</td>
                                <td><?php echo number_format($total_balance, 2); ?></td>
                            </tr>
                        <?php } ?>

                    </tbody>

                </table>

            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>