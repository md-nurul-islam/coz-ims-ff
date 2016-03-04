<div class="col-lg-12">

    <div class="box box-info">

        <div class="box-body">

            <div class="center col-lg-7">
                <h3 class="text-aqua">Cumulative Report Starting from <?php echo $from_date; ?> till <?php echo $to_date; ?></h3>
            </div>

            <legend>
                *** NOTE: <br />
                1. Purchase records are calculated from the beginnings till today, but sales records are calculated between the given date range.
                <br />2. HG: Highest, LW: Lowest, AV: Average, LT: Latest.
                <br />3. Sold items of given date range are showed only.
            </legend>

            <div class="report_table">

                <table class="table table-bordered table-striped table-hover table-condensed">

                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Cost</th>
                            <th>Purchased Units</th>
                            <th>Total Purchased</th>
                            <th>Price</th>
                            <th>Sold Units</th>
                            <th>Total Sold</th>
                            <th>VAT</th>
                            <th>Discount</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        $j = 0;

                        $total_purchased_qty = 0;
                        $total_purchased_total = 0.00;

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
                                    <p>HG: <?php echo number_format($product_data['highest_cost'], 2); ?></p>
                                    <p>LW: <?php echo number_format($product_data['lowest_cost'], 2); ?></p>
                                    <p>AV: <?php echo number_format( ($product_data['purchased_total'] / $product_data['purchased_qty']) , 2); ?></p>
                                    <p>LT: <?php echo number_format($product_data['purchase_price'], 2); ?></p>
                                </td>
                                <td>
                                    <?php
                                    echo $product_data['purchased_qty'];
                                    $total_purchased_qty += intval($product_data['purchased_qty']);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo number_format($product_data['purchased_total'], 2);
                                    $total_purchased_total += floatval($product_data['purchased_total']);
                                    ?>
                                </td>
                                <td>
                                    <p>HG: <?php echo number_format($product_data['highest_price'], 2); ?></p>
                                    <p>LW: <?php echo number_format($product_data['lowest_price'], 2); ?></p>
                                    <p>AV: <?php echo number_format( ($product_data['sold_total'] / $product_data['sold_qty']) , 2); ?></p>
                                    <p>LT: <?php echo number_format($product_data['selling_price'], 2); ?></p>
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
                        <tr><th colspan="9">&nbsp;</th></tr>
                        <tr>
                            <th colspan="2" style="text-align: right;">Totals</th>
                            <th><?php echo $total_purchased_qty; ?></th>
                            <th><?php echo number_format($total_purchased_total, 2); ?></th>
                            <th><?php echo '&nbsp;'; ?></th>
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