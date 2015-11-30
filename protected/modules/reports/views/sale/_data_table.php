
<div class="col-lg-12">

    <div class="box box-info">

        <div class="box-body">

            <div class="center col-lg-7">
                <h3>Sales Report Starting from <?php // echo $from_date; ?> till <?php // echo $to_date; ?></h3>
            </div>

            <div class="panel panel-body panel-default">
                
                <table class="table table-bordered table-striped table-hover table-condensed">
                    
                    <tbody>
                        <tr>
                            <th>Bill Number</th>
                            <th>Ref. Number</th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Item Total</th>
                        </tr>

                        <?php
                        $j = 0;
                        $num_records = sizeof($model);

                        $total_paid = 0.00;
                        $total_amount = 0.00;
                        $total_discount = 0.00;
                        $total_balance = 0.00;
                        $total_amount_given = 0.00;

                        foreach ($model as $k => $v) {

                            $j++;

                            $bill_total = $v[0]['bill_total'];
                            unset($v[0]['bill_total']);

                            $amount_given = $v[0]['amount_given'];
                            unset($v[0]['amount_given']);

                            $discount = $v[0]['discount'];
                            unset($v[0]['discount']);

                            $balance = $v[0]['balance'];
                            unset($v[0]['balance']);
                            ?>

                            <?php
                            $i = 0;
                            $num_rows = sizeof($v[0]);
                            foreach ($v[0] as $c) {
                                ?>

                                <tr>
                                    <?php if ($i == 0) { ?>
                                        <td rowspan="<?php echo $num_rows; ?>"><?php echo $k; ?><?php echo ($c['is_advance'] == 1) ? ' (Adv)' : ''; ?></td>
                                    <?php } ?>

                                    <td><?php echo $c['ref_num']; ?></td>
                                    <td style="text-align: left;"><?php echo $c['prod_name']; ?></td>
                                    <td><?php echo $c['qty']; ?></td>
                                    <td><?php echo $c['price']; ?></td>
                                    <td><?php echo $c['item_sub_total']; ?></td>

                                </tr>

                                <?php
                                $i++;
                            }
                            ?>

                            <tr>
                                <td colspan="5" style="text-align: right;">Amount</td>
                                <td><?php echo number_format($bill_total + $discount, 2); ?></td>
                            </tr>

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
                                <td colspan="5" style="text-align: right;">Discount</td>
                                <td><?php echo number_format($discount, 2); ?></td>
                            </tr>

                            <?php if ($j < $num_records) { ?>
                                <tr><td colspan="6">&nbsp;</td></tr>
                            <?php } ?>
                            <?php
                            $total_paid += $bill_total;
                            $total_amount += ($bill_total + $discount);
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
                            <td colspan="5" style="text-align: right;">Total Bill</td>
                            <td><?php echo number_format($total_amount, 2); ?></td>
                        </tr>

                        <?php if ($advance_sale_list) { ?>
                            <tr>
                                <td colspan="5" style="text-align: right;">Total Advance</td>
                                <td><?php echo number_format($total_amount_given, 2); ?></td>
                            </tr>
                        <?php } ?>

                        <?php if (!$advance_sale_list) { ?>
                            <tr>
                                <td colspan="5" style="text-align: right;">Total Collected Amount</td>
                                <td><?php echo number_format($total_paid, 2); ?></td>
                            </tr>
                        <?php } ?>

                        <tr>
                            <td colspan="5" style="text-align: right;">Total Discount</td>
                            <td><?php echo number_format($total_discount, 2); ?></td>
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