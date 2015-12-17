<div class="col-lg-12">
    <div class="box box-info">

        <div class="box-body panel panel-danger">
            <?php
            $this->widget('DataGrid', array(
                'model' => 'ProductStockEntries',
                'module' => 'product',
                'controller' => 'purchase',
                'action' => 'getdata'
            ));
            ?>
        </div>
    </div>

</div>

<div class="clearfix"></div>