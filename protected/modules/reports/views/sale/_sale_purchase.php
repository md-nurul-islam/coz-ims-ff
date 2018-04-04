<div class="col-lg-12">

    <div class="box box-info">

        <div class="box-body">

            <div class="center col-lg-7">
                <h3 class="text-aqua">Sales / Purchase Report Starting from <?php echo $from_date; ?> till <?php echo $to_date; ?></h3>
            </div>

            <legend></legend>

            <div class="report_table">

                <table class="table table-bordered table-striped table-hover table-condensed">

                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Unit Cost</th>
                            <th>Unit Price</th>
                            <th>Sold Units</th>
                            <th>Total Sold</th>
                            <th>VAT</th>
                            <th>Discount</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        $j = 0;

                        $sum_of_unit_cost = 0.00;
                        $sum_of_unit_price = 0.00;

                        $total_sold_qty = 0;
                        $total_sold_total = 0.00;

                        $total_sold_vat = 0.00;
                        $total_sold_discount = 0.00;

                        foreach ($model as $product_id => $product_data) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $product_data['product_name']; ?>
                                    <?php echo (!empty($product_data['color_name'])) ? "<span class=\"label label-warning\">{$product_data['color_name']}</span>" : ""; ?>
                                    <?php echo (!empty($product_data['size_name'])) ? "<span class=\"label label-success\">{$product_data['size_name']}</span>" : ""; ?>
                                    <?php echo (!empty($product_data['grade_name'])) ? "<span class=\"label label-info\">{$product_data['grade_name']}</span>" : ""; ?>
                                </td>
                                <td>
                                    <?php
                                    $sum_of_unit_cost += floatval($product_data['purchase_price']);
                                    echo number_format($product_data['purchase_price'], 2);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $sum_of_unit_price += floatval($product_data['selling_price']);
                                    echo number_format($product_data['selling_price'], 2); ?>
                                </td>
                                <td>
                                    <?php
                                    echo $product_data['sold_qty'];
                                    $total_sold_qty += intval($product_data['sold_qty']);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $product_data['sold_total'];
                                    $total_sold_total += floatval($product_data['sold_total']);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $product_data['sold_toal_vat'];
                                    $total_sold_vat += floatval($product_data['sold_toal_vat']);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $product_data['sold_total_discount'];
                                    $total_sold_discount += floatval($product_data['sold_total_discount']);
                                    ?>
                                </td>
                            </tr>

                            <?php
                            $j++;
                        }
                        ?>
                    </tbody>

                    <tfoot>
                        <tr><th colspan="7">&nbsp;</th></tr>
                        <tr>
                            <th style="text-align: right;">Totals</th>
                            <th><?php echo number_format($sum_of_unit_cost, 2); ?></th>
                            <th><?php echo number_format($sum_of_unit_price, 2); ?></th>
                            <th><?php echo number_format($total_sold_qty, 2); ?></th>
                            <th><?php echo number_format($total_sold_total, 2); ?></th>
                            <th><?php echo number_format($total_sold_vat, 2); ?></th>
                            <th><?php echo number_format($total_sold_discount, 2); ?></th>
                        </tr>

                    </tfoot>

                </table>

            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>