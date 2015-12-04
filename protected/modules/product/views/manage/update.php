<?php

$this->renderPartial('_form', array(
    'model' => $model,
    'category_name' => $category_name,
    'supplier_name' => $supplier_name,
    'grades' => $grades,
    'ar_product_id' => $ar_product_id,
    'sizes' => $sizes,
    'colors' => $colors,
));
?>