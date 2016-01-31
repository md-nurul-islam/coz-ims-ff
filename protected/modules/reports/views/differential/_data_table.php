<div class="col-lg-12">

    <div class="box box-info">

        <div class="box-body">


            <div class="center col-lg-7">
                <h3 class="text-aqua">Stock Report Till Now</h3>
            </div>

            <legend></legend>

            <div class="report_table">

                <table class="table table-bordered table-striped table-hover table-condensed">

                    <thead>
                        <tr>
                            <th>Item</th>
                            <th class="text-center">Total Purchased</th>
                            <th class="text-center">Total Sold</th>
                            <th class="text-center">Available Stock</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $total_purchased = 0;
                        $total_sold = 0;
                        $total_available = 0;

                        foreach ($model as $row) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $row['product_name']; ?>
                                    <span class="label label-warning"><?php // echo $c['color_name'];           ?></span>
                                    <span class="label label-success "><?php // echo $c['size_name'];           ?></span>
                                    <span class="label label-info"><?php // echo $c['grade_name'];           ?></span>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $total_purchased += $row['purchased_quantity'];
                                    echo intval($row['purchased_quantity']);
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $total_sold += $row['sold_quantity'];
                                    echo intval($row['sold_quantity']);
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $total_available += $row['current_quantity'];
                                    echo $row['current_quantity'];
                                    ?>
                                </td>
                                <?php ?>
                            </tr>

                        <?php } ?>
                        <tr>
                            <td class="text-right">Total</td>
                            <td class="text-center"><?php echo $total_purchased; ?></td>
                            <td class="text-center"><?php echo $total_sold; ?></td>
                            <td class="text-center"><?php echo $total_available; ?></td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>
    </div>
</div>

<div class="clearfix"></div>