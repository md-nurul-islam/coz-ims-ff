<div class="panel panel-default">
    <div class="panel-body">

        <div class="report_table">

            <table class="table table-bordered table-striped table-hover table-condensed exchangables">

                <thead>
                    <tr>
                        <th>Ref. Number</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Vat</th>
                        <th>Item Total</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    $total_gross = $model[0]['grand_total'];
                    $total_discount = $model[0]['discount'];
                    $total_vat = $model[0]['vat'];
                    $total_paid = $model[0]['grand_total_paid'];
                    $total_balance = $model[0]['grand_total_balance'];

                    foreach ($model as $k => $v) {
                        ?>
                        <tr>
                            <td><?php echo $v['reference_number']; ?></td>
                            <td class="product_info" data-id="<?php echo $v['product_id']; ?>"><?php echo $v['product_name']; ?></td>
                            <td class="quantity"><?php echo $v['quantity']; ?></td>
                            <td class="price"><?php echo $v['price']; ?></td>
                            <td class="item_discount"><?php echo $v['item_discount']; ?></td>
                            <td class="item_vat"><?php echo $v['item_vat']; ?></td>
                            <td class="sub_btotal"><?php echo number_format($v['sub_total'], 2); ?></td>
                            <td>
                                <?php echo CHtml::checkBox('exchange', '', array('class' => 'exchange')); ?>
                            </td>
                            <?php ?>
                        </tr>
                    <?php } ?>

                    <tr>
                        <td colspan="4" style="text-align: right;">&nbsp;</td>
                        <td class="total_discount"><?php echo number_format($total_discount, 2); ?></td>
                        <td class="total_vat"><?php echo number_format($total_vat, 2); ?></td>
                        <td><?php echo number_format($total_gross, 2); ?></td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align: right;">Total</td>
                        <td><?php echo number_format(($total_gross - $total_discount), 2); ?></td>
                    </tr>

                </tbody>
                
            </table>

        </div>
    </div>
</div>