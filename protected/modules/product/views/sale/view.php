<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'sales_id',
        'transaction_id',
        'billnumber',
        'customer_id',
        'supplier_id',
        'category_id',
        'ref_num',
        'product_details_id',
        'quantity',
        'item_selling_price',
        'serial_num',
        'sale_date',
        'item_subtotal',
        'discount_percentage',
        'dis_amount',
        'tax',
        'tax_dis',
        'grand_total_payable',
        'grand_total_paid',
        'grand_total_balance',
        'due_payment_date',
        'payment_method',
        'note',
    ),
));
?>
