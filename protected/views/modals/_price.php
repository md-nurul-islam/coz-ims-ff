<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal">

                    <input type="hidden" id="cart_row_id_container" value="" />

                    <div class="form-group">
                        <?php echo CHtml::label('Price', 'price', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-9">
                            <?php
                            echo CHtml::textField('price', '', array(
                                'class' => 'form-control',
                                'placeholder' => 'Price',
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo CHtml::label('Current Stock', 'cur_stock', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-9">
                            <?php
                            echo CHtml::textField('cur_stock', '', array(
                                'class' => 'form-control',
                                'placeholder' => 'Current Stock',
                                'readonly' => TRUE
                            ));
                            ?>
                        </div>
                    </div>

                </form>

            </div>

            <div class="modal-footer">
                <div class="col-md-11">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Update</button>
                </div>
            </div>
        </div>

    </div>
</div>
