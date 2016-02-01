<?php
$this->renderPartial('_view', array(
    'data' => $model,
    'purchase' => $purchase,
    'sales' => $sales,
));
?>

<div class="clearfix"></div>

<?php
Yii::app()->clientScript->registerCoreScript('jquery');
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('/js/custom/item_barcode.js', CClientScript::POS_END);
?>