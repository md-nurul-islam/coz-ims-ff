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

<div class="barcode-content-for-modal">
    <ul class="barcode-wrapper list-group">
        <li class="list-group-item clearfix">
            <div class="barcode-container"></div>
        </li>
        <li class="list-group-item clearfix">
            <a style="margin: 10px;" class="btn btn-primary pull-right close-modal-item-barcode-view" href="">Export as PDF</a>
        </li>
    </ul>
</div>

<?php
$this->renderPartial('//modals/_item_barcode');
$this->renderPartial('//modals/_item_barcode_view');

$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('/js/custom/item_barcode.js', CClientScript::POS_END);
$cs->registerScriptFile('http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/md5.js', CClientScript::POS_END);
?>