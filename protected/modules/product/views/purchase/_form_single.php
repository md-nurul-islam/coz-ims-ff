<div class="col-lg-12">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'product-stock-entries-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'htmlOptions' => array(
            'class' => 'form-horizontal',
        )
    ));
    ?>
    
    <?php if (Yii::app()->user->hasFlash('success')) { ?>
        <div class="alert alert-success">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php } ?>

    <div class="col-lg-6">

        <div class="box box-info">

            <div class="box-body">

                <?php echo $form->errorSummary($model); ?>

                <div class="form-group">
                    <div class="col-sm-10">
                        <label>Fields with <span class="required">*</span> are required.</label>
                    </div>
                </div>

                <?php if (Yii::app()->user->hasFlash('success')) { ?>
                    <div class="success">
                        <?php echo Yii::app()->user->getFlash('success'); ?>
                    </div>
                <?php } ?>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'billnumber', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-9">
                        <?php
                        echo $form->textField($model, 'billnumber', array(
                            'size' => 20,
                            'maxlength' => 120,
                            'class' => 'form-control',
                            'placeholder' => 'Billnumber',
                        ));
                        ?>
                        <?php echo $form->error($model, 'billnumber', array('class' => 'alert alert-danger')); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'purchase_date', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-9">
                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name' => 'ProductStockEntries[purchase_date]',
                            'value' => date('Y-m-d', Settings::getBdLocalTime()),
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'showAnim' => 'blind', //'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                                'changeMonth' => true,
                                'changeYear' => true,
                                'yearRange' => '2000:2099',
                                'minDate' => '2000-01-01', // minimum date
                                'maxDate' => '2099-12-31', // maximum date
                                'monthNamesShort' => Settings::$_month_full_name_for_datepicker,
                            ),
                            'htmlOptions' => array(
                                'style' => 'height: 34px;',
                                'readonly' => true,
                                'class' => 'form-control',
                                'placeholder' => 'Purchase Date',
                            )
                        ));
                        ?>
                        <?php echo $form->error($model, 'purchase_date', array('class' => 'alert alert-danger')); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'due_payment_date', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-9">
                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name' => 'ProductStockEntries[due_payment_date]',
                            //'value'=> date('Y-m-d', Settings::getBdLocalTime()),
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'showAnim' => 'blind', //'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                                'changeMonth' => true,
                                'changeYear' => true,
                                'yearRange' => '2000:2099',
                                'minDate' => '2000-01-01', // minimum date
                                'maxDate' => '2099-12-31', // maximum date
                                'monthNamesShort' => Settings::$_month_full_name_for_datepicker,
                            ),
                            'htmlOptions' => array(
                                'style' => '',
                                'readonly' => true,
                                'class' => 'form-control',
                                'placeholder' => 'Due Payment Date',
                            )
                        ));
                        ?>
                        <?php echo $form->error($model, 'due_payment_date', array('class' => 'alert alert-danger')); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::label('Product Name', 'product_name', array('class' => 'col-sm-2 control-label', 'for' => 'product_details_id')); ?>
                    <?php $product_name = ''; ?>
                    <?php echo CHtml::hiddenField('product_details_id', '', array('size' => 30)); ?>
                    <div class="col-sm-9">
                        <?php
                        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name' => 'product_name',
                            'value' => $product_name,
                            'source' => $this->createUrl('/product/purchase/autocomplete'),
                            'options' =>
                            array(
                                'minLength' => 1,
                                'showAnim' => 'fold',
                                'select' => "js:function(event, data) {
                                $('#product_details_id').val(data.item.id);

                                    $.ajax({
                                        url: '/product/purchase/getlatestprice',
                                        type: 'post',
                                        dataType: 'json',
                                        data: {product_details_id: data.item.id},
                                    }).done(function(data) {
                                    
                                        $('#stock').val(data.stock);
                                        $('#cost').val(data.cost);
                                        $('#price').val(data.price);

                                    }).fail(function() {
                                        
                                    });

                            }",
                            ),
                            'htmlOptions' => array(
                                'size' => 28,
                                'id' => 'product_name',
                                'placeholder' => 'Type Product Name..',
                                'class' => 'form-control',
                            )
                        ));
                        ?>
                        <div class="grade-list horizontal" style="display: none;">

                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ref_num', array('class' => 'col-sm-2 control-label', 'for' => 'ref_num')); ?>
                    <div class="col-sm-9">
                        <?php
                        echo CHtml::textField('ref_num', '', array(
                            'size' => 25,
                            'maxlength' => 150,
                            'class' => 'form-control',
                            'placeholder' => 'Reference Number',
                        ));
                        ?>
                    </div>
                </div>


                <div class="form-group">
                    <?php echo $form->labelEx($model, 'note', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-9">
                        <?php
                        echo $form->textArea($model, 'note', array(
                            'rows' => 6,
                            'cols' => 50,
                            'class' => 'form-control',
                            'placeholder' => 'Note',
                        ));
                        ?>
                        <?php echo $form->error($model, 'note', array('class' => 'alert alert-danger')); ?>
                    </div>
                </div>

            </div>

        </div>
    </div><!-- form -->

    <div class="col-lg-6">

        <div class="box box-info">

            <div class="box-body">

                <div class="form-group">
                    <?php echo CHtml::label('Current Stock', 'stock', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-9">
                        <?php
                        echo CHtml::textField('stock', '', array(
                            'class' => 'form-control',
                            'placeholder' => 'Current Stock',
                            'readonly' => TRUE,
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::label('Last Cost', 'cost', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-9">
                        <?php
                        echo CHtml::textField('cost', '', array(
                            'class' => 'form-control',
                            'placeholder' => 'Last Cost',
                            'readonly' => TRUE,
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::label('Last Price', 'price', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-9">
                        <?php
                        echo CHtml::textField('price', '', array(
                            'class' => 'form-control',
                            'placeholder' => 'Last Price',
                            'readonly' => TRUE,
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::label('New Cost', 'n_cost', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-9">
                        <?php
                        echo CHtml::textField('n_cost', '', array(
                            'class' => 'form-control',
                            'placeholder' => 'New Cost',
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::label('New Price', 'n_price', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-9">
                        <?php
                        echo CHtml::textField('n_price', '', array(
                            'class' => 'form-control',
                            'placeholder' => 'New Price',
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::label('Quantity', 'quantity', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-9">
                        <?php
                        echo CHtml::textField('quantity', '', array(
                            'class' => 'form-control',
                            'placeholder' => 'Quantity',
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::label('Total', 'total', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-9">
                        <?php
                        echo CHtml::textField('total', '', array(
                            'class' => 'form-control',
                            'placeholder' => 'Total',
                            'readonly' => TRUE,
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'payment_method', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-9">
                        <?php
                        echo $form->dropDownList($model, 'payment_method', Settings::$_payment_types, array(
                            'style' => 'width: 100%;',
                            'class' => 'select2'
                        ));
                        ?>
                        <?php echo $form->error($model, 'payment_method', array('class' => 'alert alert-danger')); ?>
                    </div>
                </div>


            </div>

        </div>

    </div>

</div>

<div class="clearfix"></div>

<div class="box-footer">
    <?php
    echo CHtml::submitButton($model->isNewRecord ? 'Purchase' : 'Update', array(
        'id' => 'btn-submit',
        'class' => 'btn btn-info pull-right'
    ));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(document).ready(function () {

        $('#total').val(0.00);

        $(".select2").select2({
            minimumResultsForSearch: Infinity
        });

        $(document).off('keyup', '#quantity').on('keyup', '#quantity', function () {

            var qty = parseInt($(this).val());

            if (isNaN(qty)) {
                $('#total').val(0.00);
                return false;
            }

            var price = $('#n_price').val();
            var total = 0.00;

            if (price != '') {
                price = parseFloat(price);
            } else {
                price = 0.00;
            }

            total = qty * price;
            $('#total').val(total.toFixed(2));
        });


    });
</script>