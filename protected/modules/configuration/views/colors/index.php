<div class="col-lg-12">

    <div class="box box-info">

        <div class="box-body">

            <?php
            $this->widget('DataGrid', array(
                'model' => 'Color',
                'module' => 'configuration',
                'controller' => 'colors',
                'action' => 'getdata'
            ));
            ?>
        </div>
    </div>
</div>

<div class="clearfix"></div>