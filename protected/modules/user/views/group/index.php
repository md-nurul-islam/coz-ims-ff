<div class="col-lg-12">
    <div class="box box-info">

        <div class="box-body panel panel-danger">
            <?php
            $this->widget('DataGrid', array(
                'model' => 'Groups',
                'module' => 'user',
                'controller' => 'group',
                'action' => 'getdata'
            ));
            ?>
        </div>
    </div>

</div>