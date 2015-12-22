<div id="itemModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Generate Bar-code</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal">

                    <div class="form-group">
                        <?php echo CHtml::label('Number of Bar-code', 'num_barcode', array('class' => 'col-sm-4 control-label')); ?>
                        <div class="col-sm-7">
                            <?php
                            echo CHtml::textField('num_barcode', '', array(
                                'class' => 'form-control',
                                'placeholder' => 'Number of Bar-code',
                            ));
                            ?>
                        </div>
                    </div>

                </form>

            </div>

            <div class="modal-footer">
                <div class="col-md-11">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Generate</button>
                </div>
            </div>
            
        </div>

    </div>
</div>
