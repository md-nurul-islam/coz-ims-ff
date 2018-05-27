<?php

$this->renderPartial('_view', array(
    'data' => $model,
    'sales' => $sales,
));

Yii::app()->clientScript->registerCoreScript('jquery');
$cs = Yii::app()->getClientScript();
?>