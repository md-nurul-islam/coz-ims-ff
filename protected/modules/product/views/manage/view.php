<?php
$this->renderPartial('_view', array(
    'data' => $model,
));
?>

<div class="clearfix"></div>

<?php
Yii::app()->clientScript->registerCoreScript('jquery');
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('/js/custom/item_barcode.js', CClientScript::POS_END);
?>