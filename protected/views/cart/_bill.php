<?php
$global_grand_total = $data[0]['grand_total'];
$global_discount = $data[0]['discount'];
$global_vat = $data[0]['vat'];
$bill_number = $data[0]['billnumber'];
$sale_date = $data[0]['sale_date'];
$payment_amount = $payment_amount;
?>

<div class="hidden_bill_number" style="display: none;"><?php echo $bill_number; ?></div>
<div class="hidden_sale_date" style="display: none;"><?php echo date('Y-m-d', strtotime($sale_date)); ?></div>

<table class="table table-hover table-bordered table-responsive table-condensed">

    <thead>
        <tr>
            <th class="col-sm-6">Item</th>
            <th class="col-sm-1">Price</th>
            <th class="col-sm-2">Qty</th>
            <th class="col-sm-2">Total</th>
        </tr>
    </thead>

    <tbody id="cart-row">

        <?php
        $i = 1;
        foreach ($data as $row) {
            $total_qty = 0;
            ?>
            <tr>
                <td><?php echo $row['product_name']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php
                    $total_qty += $row['quantity'];
                    echo $row['quantity'];
                    ?></td>
                <td><?php echo $row['sub_total']; ?></td>
            </tr>
            <?php
            $i++;
        }
        ?>

    </tbody>

    <tfoot id="cart-total">
        <tr>
            <th colspan="3" class="vat_cell">Vat</th>
            <th class="vat_cell_val"><?php echo $global_vat; ?></th>
        </tr>
        <tr>
            <th colspan="3" class="discount_cell">Discount</th>
            <th class="discount_cell_val"><?php echo $global_discount; ?></th>
        </tr>
        <tr>
            <th colspan="3">Total Items</th>
            <th><?php echo $i; ?></th>
        </tr>
        <tr>
            <th colspan="3">Total Quantity</th>
            <th><?php echo $total_qty; ?></th>
        </tr>
        <tr>
            <th colspan="3">Total Gross</th>
            <th><?php echo $global_grand_total; ?></th>
        </tr>
        <tr>
            <th colspan="3">Changes</th>
            <th><?php echo $payment_amount - $global_grand_total; ?></th>
        </tr>
    </tfoot>

</table>