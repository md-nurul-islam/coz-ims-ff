<div class="col-lg-12">

    <div class="box box-info">

        <div class="box-body">

            <div class="center col-lg-7">
                <h3 class="text-aqua">Differential Report Starting from <?php echo $from_date; ?> till <?php echo $to_date; ?></h3>
            </div>

            <legend></legend>

            <div class="report_table">

                <table class="table table-bordered table-striped table-hover table-condensed">

                    <thead>
                        <tr>
                            <th>Item</th>
                            <th class="text-center">Total Purchased Quantity</th>
                            <th class="text-center">Total Sold Quantity</th>
                            <th class="text-center">Total Purchased Amount</th>
                            <th class="text-center">Total Sold Amount</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $total_purchased_amount = 0;
                        $total_purchased_qty = 0;
                        $total_sold_amount = 0;
                        $total_sold_qty = 0;

                        foreach ($model as $row) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $row['product_name']; ?>                                    
                                    <?php echo (!empty($row['color_name'])) ? "<span class=\"label label-warning\">{$row['color_name']}</span>" : ""; ?>
                                    <?php echo (!empty($row['size_name'])) ? "<span class=\"label label-success\">{$row['size_name']}</span>" : ""; ?>
                                    <?php echo (!empty($row['grade_name'])) ? "<span class=\"label label-info\">{$row['grade_name']}</span>" : ""; ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $purchase_qty = intval($row['purchase_quantity']);
                                    $total_purchased_qty += $purchase_qty;
                                    echo $purchase_qty;
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $sold_qty = intval($row['sold_quantity']);
                                    $total_sold_qty += $sold_qty;
                                    echo $sold_qty;
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $sold_amount = intval($row['sold_subtotal']);
                                    $total_sold_amount += $sold_amount;
                                    echo number_format($sold_amount, 2);
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $purchase_amount = intval($row['purchase_subtotal']);
                                    $total_purchased_amount += $purchase_amount;
                                    echo number_format($purchase_amount, 2);
                                    ?>
                                </td>
                                <?php ?>
                            </tr>

                        <?php } ?>

                        <tr><td colspan="5">&nbsp;</td></tr>

                        <tr>
                            <th class="text-right">Total</th>
                            <th class="text-center"><?php echo number_format($total_purchased_qty, 2); ?></th>
                            <th class="text-center"><?php echo number_format($total_sold_qty, 2); ?></th>
                            <th class="text-center"><?php echo number_format($total_sold_amount, 2); ?></th>
                            <th class="text-center"><?php echo number_format($total_purchased_amount, 2); ?></th>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>
    </div>
</div>

<div class="clearfix"></div>