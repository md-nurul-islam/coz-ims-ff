<div class="col-lg-12">

    <div class="box box-info">

        <div class="box-body">

            <?php
            if ($model) {
                $this->renderPartial("_{$pView}", array(
                    'model' => $model,
                    'msg' => $msg,
                ));
            } else {
                ?>
                <div class="center col-lg-6">
                    <h3 class="text-aqua"><?php echo $msg; ?></h3>
                </div>
            <?php } ?>

        </div>
    </div>
</div>

<div class="clearfix"></div>

<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>