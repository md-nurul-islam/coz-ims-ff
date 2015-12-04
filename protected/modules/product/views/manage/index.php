<div class="col-lg-12">

    <?php if (Yii::app()->user->hasFlash('success')) { ?>
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php } ?>

    <div class="box box-info">

        <div class="box-body">
            <?php
            $this->widget('DataGrid', array(
                'model' => 'ProductDetails',
                'module' => 'product',
                'controller' => 'manage',
                'action' => 'getdata'
            ));
            ?>
        </div>
    </div>
</div>
<div class="clearfix"></div>