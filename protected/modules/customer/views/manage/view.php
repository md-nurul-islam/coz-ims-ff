<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'customer_name',
        'customer_address',
        'customer_contact1',
        'customer_contact2',
        'balance',
    ),
));
?>
