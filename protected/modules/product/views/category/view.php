<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Title</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        Start creating your amazing application!
    </div><!-- /.box-body -->
    <div class="box-footer">
        Footer
    </div><!-- /.box-footer-->
</div><!-- /.box -->

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'category_name',
        'category_description',
    ),
));
?>
