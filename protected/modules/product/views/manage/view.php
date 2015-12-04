<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
            'name' => 'category_id',
            'value' => $model->category->category_name,
        ),
		array(
            'name' => 'supplier_id',
            'value' => $model->supplier->supplier_name,
        ),
		'product_name',
		'purchase_price',
		'selling_price',
	),
)); ?>
