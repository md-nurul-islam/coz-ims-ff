<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'customer-details-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'customer_name',
        'customer_address',
        'customer_contact1',
        'customer_contact2',
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
?>
