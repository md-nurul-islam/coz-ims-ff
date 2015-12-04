<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'supplier_name',
        'supplier_address',
        'supplier_contact1',
        'supplier_contact2',
        'balance',
    ),
));
?>
