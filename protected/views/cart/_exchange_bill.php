<?php
$global_grand_total_bill = $data[0]['grand_total_bill'];
$global_grand_total_returnable = $data[0]['grand_total_returnable'];
$global_grand_total_adjustable = $data[0]['grand_total_adjustable'];
$global_grand_total_paid = $data[0]['grand_total_paid'];
$global_grand_total_balance = $data[0]['grand_total_balance'];
$global_discount = $data[0]['discount'];
$global_vat = $data[0]['vat'];
$sale_bill_number = $data[0]['billnumber'];
$exchange_bill_number = $data[0]['exchange_billnumber'];
$sale_date = $data[0]['sale_date'];
$exchange_date = $data[0]['exchange_date'];

$total_subtotal = 0;
?>

<div class="hidden_bill_number" style="display: none;"><?php echo $bill_number; ?></div>
<div class="hidden_sale_date" style="display: none;"><?php echo date('Y-m-d', strtotime($sale_date)); ?></div>
<div class="hidden_exchange_bill_number" style="display: none;"><?php echo $exchange_bill_number; ?></div>
<div class="hidden_exchange_date" style="display: none;"><?php echo date('Y-m-d', strtotime($exchange_date)); ?></div>

<table class="table table-hover table-bordered table-responsive table-condensed">
    <thead>
        <tr>
            <th colspan="4" class="col-sm-12">Returned Items</th>
        </tr>
        <tr>
            <th class="col-sm-6">Item</th>
            <th class="col-sm-1">Price</th>
            <th class="col-sm-2">Qty</th>
            <th class="col-sm-2">Total</th>
        </tr>
    </thead>
    <tbody id="returned-cart-row">
        <?php
        $i = 0;
        foreach ($data as $row) {
            $total_qty = 0;
            $total_subtotal += floatval($row['sub_total']);
            ?>
            <tr>
                <td><?php echo $row['product_name']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php
                    $total_qty += $row['quantity'];
                    echo $row['quantity'];
                    ?></td>
                <td><?php echo number_format($row['sub_total'], 2); ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot id="returned-cart-total">
        <tr>
            <th colspan="3" class="vat_cell">Total</th>
            <th class="vat_cell_val"><?php echo number_format($total_subtotal, 2); ?></th>
        </tr>
    </tfoot>
</table>

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
        $i = 0;
        foreach ($data as $row) {
            $total_qty = 0;
            $total_subtotal += floatval($row['sub_total']);
            ?>
            <tr>
                <td><?php echo $row['product_name']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php
                    $total_qty += $row['quantity'];
                    echo $row['quantity'];
                    ?></td>
                <td><?php echo number_format($row['sub_total'], 2); ?></td>
            </tr>
            <?php
            $i++;
        }
        ?>

    </tbody>

    <tfoot id="cart-total">
        <tr>
            <th colspan="3" class="vat_cell">Total</th>
            <th class="vat_cell_val"><?php echo number_format($total_subtotal, 2); ?></th>
        </tr>
        <tr>
            <th colspan="3" class="vat_cell">Vat</th>
            <th class="vat_cell_val"><?php echo number_format($global_vat, 2); ?></th>
        </tr>
        <tr>
            <th colspan="3" class="discount_cell">Discount</th>
            <th class="discount_cell_val"><?php echo number_format($global_discount, 2); ?></th>
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
            <th colspan="3">Gross</th>
            <th><?php echo number_format((($global_grand_total + $global_vat) - $global_discount), 2); ?></th>
        </tr>
        <tr>
            <th colspan="3">Paid</th>
            <th><?php echo number_format($global_total_paid, 2); ?></th>
        </tr>
        <tr>
            <th colspan="3">Changes</th>
            <th><?php echo number_format($global_total_balance, 2); ?></th>
        </tr>
    </tfoot>

</table>