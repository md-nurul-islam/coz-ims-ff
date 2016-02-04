<?php $this->pageTitle = Yii::app()->name . ' - Error'; ?>

<h2 class="h2">Error <?php echo $code; ?></h2>

<div class="alert alert-warning">
    <?php echo CHtml::encode($message); ?>
</div>

<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>