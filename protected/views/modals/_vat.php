<div id="vatModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Vat & Discount</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal">

                    <input type="hidden" id="vat_cart_row_id_container" value="" />

                    <div class="form-group">
                        <?php echo CHtml::label('Vat', 'vat', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-9">
                            <?php
                            echo CHtml::textField('vat', '', array(
                                'class' => 'form-control',
                                'placeholder' => 'Vat (eg: 5%)',
                            ));
                            ?>
                            <p>eg: 5%</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo CHtml::label('Discount', 'discount', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-9">
                            <?php
                            echo CHtml::textField('discount', '', array(
                                'class' => 'form-control',
                                'placeholder' => 'Discount (eg: 5/5%)'
                            ));
                            ?>
                            <p>eg: 5/5%</p>
                        </div>
                    </div>

                    <!--div class="form-group">
                        <label class="col-sm-3">Vat Options</label>
                        <div class="col-sm-8">
                            <ul class="list-inline vat_options">
                                <li>
                                    <?php
//                                    echo CHtml::radioButton('vat_option', false, array(
//                                        'value' => 'itemized_vat',
//                                        'id' => 'itemized_vat',
//                                        'class' => 'flat-red'
//                                    ));
                                    ?>
                                    <?php // echo CHtml::label('Itemized Vat', 'itemized_vat', array('class' => 'control-label')); ?>
                                </li>

                                <li>
                                    <?php
//                                    echo CHtml::radioButton('vat_option', false, array(
//                                        'value' => 'on_total_vat',
//                                        'id' => 'on_total',
//                                        'class' => 'flat-red'
//                                    ));
                                    ?>
                                    <?php // echo CHtml::label('On Total vat', 'on_total', array('class' => 'control-label')); ?>
                                </li>

                                <li>
                                    <?php
//                                    echo CHtml::radioButton('vat_option', false, array(
//                                        'value' => 'no_vat',
//                                        'id' => 'no_vat',
//                                        'class' => 'flat-red'
//                                    ));
                                    ?>
                                    <?php // echo CHtml::label('No Vat', 'no_vat', array('class' => 'control-label')); ?>
                                </li>
                            </ul>

                        </div>
                    </div-->
                    
                    <!--div class="form-group">
                        <label class="col-sm-3">Discount Options</label>
                        <div class="col-sm-8">
                            <ul class="list-inline discount_options">
                                <li>
                                    <?php
//                                    echo CHtml::radioButton('discount_option', false, array(
//                                        'value' => 'itemized_discount',
//                                        'id' => 'itemized_discount',
//                                        'class' => 'flat-red'
//                                    ));
                                    ?>
                                    <?php // echo CHtml::label('Itemized Discount', 'itemized_discount', array('class' => 'control-label')); ?>
                                </li>

                                <li>
                                    <?php
//                                    echo CHtml::radioButton('discount_option', false, array(
//                                        'value' => 'on_total_discount',
//                                        'id' => 'on_total_discount',
//                                        'class' => 'flat-red'
//                                    ));
                                    ?>
                                    <?php // echo CHtml::label('On Total Discount', 'on_total_discount', array('class' => 'control-label')); ?>
                                </li>

                                <li>
                                    <?php
//                                    echo CHtml::radioButton('discount_option', false, array(
//                                        'value' => 'no_discount',
//                                        'id' => 'no_discount',
//                                        'class' => 'flat-red'
//                                    ));
                                    ?>
                                    <?php // echo CHtml::label('No Discount', 'no_discount', array('class' => 'control-label')); ?>
                                </li>
                            </ul>

                        </div>
                    </div-->

                </form>

            </div>

            <div class="modal-footer">
                <div class="col-md-11">
                    <button type="button" class="btn btn-info vat_discount" data-dismiss="modal">Apply</button>
                </div>
            </div>
        </div>

    </div>
</div>
