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
                    <?php echo $form->labelEx($model, 'product_details_id', array('class' => 'col-sm-2 control-label', 'for' => 'product_details_id')); ?>
                    <?php $product_name = ''; ?>
                    <?php echo CHtml::hiddenField('product_details_id', '', array('size' => 30)); ?>
                    <div class="col-sm-9">
                        <?php
                        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name' => 'product_name',
                            'value' => $product_name,
                            'source' => $this->createUrl('/product/manage/autocomplete'),
                            'options' =>
                            array(
                                'minLength' => 1,
                                'showAnim' => 'fold',
                                'select' => "js:function(event, data) {
                                $('#product_details_id').val(data.item.id);
                            }",
                            ),
                            'htmlOptions' => array(
                                'size' => 28,
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
                    <?php echo $form->labelEx($model, 'quantity', array('class' => 'col-sm-2 control-label', 'for' => 'quantity')); ?>
                    <div class="col-sm-9">
                        <?php
                        echo CHtml::textField('quantity', '', array(
                            'size' => 6,
                            'class' => 'form-control',
                            'placeholder' => 'Quantity',
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'purchase_price', array('class' => 'col-sm-2 control-label', 'for' => 'purchase_price')); ?>
                    <div class="col-sm-9">
                        <?php
                        echo CHtml::textField('purchase_price', '', array(
                            'size' => 7,
                            'maxlength' => 12,
                            'class' => 'form-control',
                            'placeholder' => 'Purchase Price',
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'selling_price', array('class' => 'col-sm-2 control-label', 'for' => 'selling_price')); ?>
                    <div class="col-sm-9">
                        <?php
                        echo CHtml::textField('selling_price', '', array(
                            'size' => 7,
                            'maxlength' => 12,
                            'class' => 'form-control',
                            'placeholder' => 'Selling Price',
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::label('Avail Stock', 'avail_stock', array('class' => 'col-sm-2 control-label', 'for' => 'item_subtotal')); ?>
                    <div class="col-sm-9">
                        <?php
                        echo CHtml::textField('avail_stock', '', array(
                            'maxlength' => 12,
                            'size' => 6,
                            'readonly' => true,
                            'class' => 'form-control',
                            'placeholder' => 'Available Stock',
                        ));
                        ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'item_subtotal', array('class' => 'col-sm-2 control-label', 'for' => 'item_subtotal')); ?>
                    <div class="col-sm-9">
                        <?php
                        echo CHtml::textField('item_subtotal', '', array(
                            'maxlength' => 12,
                            'size' => 8,
                            'class' => 'form-control',
                            'placeholder' => 'Purchase Price',
                        ));
                        ?>
                    </div>
                </div>

            </div>

        </div>
    </div><!-- form -->

    <div class="col-lg-6">

        <div class="box box-info">

            <div class="box-body">

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'supplier_id', array('class' => 'col-sm-2 control-label')); ?>
                    <?php $supplier_name = ''; ?>
                    <?php echo $form->hiddenField($model, 'supplier_id'); ?>
                    <div class="col-sm-9">
                        <?php
                        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name' => 'supplier_name',
                            'value' => $supplier_name,
                            'source' => $this->createUrl('/supplier/manage/autocomplete'),
                            'options' =>
                            array(
                                'minLength' => 1,
                                'showAnim' => 'fold',
                                'select' => "js:function(event, data) {
                                    $('#ProductStockEntries_supplier_id').val(data.item.id);
                                }",
                            ),
                            'htmlOptions' => array(
                                'size' => 20,
                                'placeholder' => 'Type Supplier Name..',
                                'class' => 'form-control',
                            )
                        ));
                        ?>
                        <?php echo $form->error($model, 'supplier_id', array('class' => 'alert alert-danger')); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'grand_total_payable', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-9">
                        <?php
                        echo $form->textField($model, 'grand_total_payable', array(
                            'class' => 'form-control',
                            'placeholder' => 'Grand Total Payable',
                        ));
                        ?>
                        <?php echo $form->error($model, 'grand_total_payable', array('class' => 'alert alert-danger')); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'grand_total_paid', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-9">
                        <?php
                        echo $form->textField($model, 'grand_total_paid', array(
                            'size' => 12,
                            'maxlength' => 12,
                            'class' => 'form-control',
                            'placeholder' => 'Grand Total Paid',
                        ));
                        ?>
                        <?php echo $form->error($model, 'grand_total_paid', array('class' => 'alert alert-danger')); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'grand_total_balance', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-9">
                        <?php
                        echo $form->textField($model, 'grand_total_balance', array(
                            'size' => 12,
                            'maxlength' => 12,
                            'readonly' => true,
                            'class' => 'form-control',
                            'placeholder' => 'Grand Total Balance',
                        ));
                        ?>
                        <?php echo $form->error($model, 'grand_total_balance', array('class' => 'alert alert-danger')); ?>
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
                    <?php echo $form->labelEx($model, 'payment_type', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-9">
                        <?php
                        echo $form->dropDownList($model, 'payment_type', Settings::$_payment_types, array(
                            'style' => 'width: 100%;',
                            'class' => 'select2'
                        ));
                        ?>
                        <?php echo $form->error($model, 'payment_type', array('class' => 'alert alert-danger')); ?>
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
        $(".select2").select2({
            minimumResultsForSearch: Infinity
        });
    });
</script>

<script type="text/javascript">

    var prod_id = '';
    var prod_name = '';
    var reference_num = '';
    var qty = 0;
    var cost = 0.00;
    var price = 0.00;
    var sub_total = 0.00;
    var cur_stock = 0;
    var cart_div = 1;

    function get_subtotal() {

        if ($('#quantity').val() == '') {
            alert('Please Provide Quantity.');
            setTimeout(function () {
                $('#quantity').focus();
            }, 1);
            return false;
        }

        if ($('#purchase_price').val() == '') {
            alert('Please Provide Cost.');
            return false;
        }

        if ($('#selling_price').val() == '') {
            alert('Please Provide Selling Price.');
            return false;
        }

        cost = parseFloat($('#purchase_price').val());
        price = parseFloat($('#selling_price').val());
        qty = parseInt($('#quantity').val());

        if (qty <= 0) {
            alert('Please Provide Quantity.');
            setTimeout(function () {
                $('#quantity').focus();
            }, 1);
            return false;
        }

        if (cost <= 0.00) {
            alert('Invalid Cost.');
            return false;
        }

        if (price <= 0.00) {
            alert('Invalid Selling Price.');
            setTimeout(function () {
                $('#selling_price').focus();
            }, 1);
            return false;
        }

        if (price < cost) {
            alert('Selling Price Cannot be smaller than Cost.');
            setTimeout(function () {
                $('#selling_price').focus();
            }, 1);
            return false;
        }

        sub_total = parseFloat(qty * cost).toFixed(2);
        $('#item_subtotal').val(sub_total);

        return true;
    }

    function calculate_grand_total() {
        var grand_total = 0.00;

        grand_total = sub_total;
        $('#ProductStockEntries_grand_total_payable').val(grand_total);
        $('#ProductStockEntries_grand_total_paid').val(grand_total);
        return true;
    }

    function calculate_balance() {
        var paid = 0.00;
        var balance = 0.00;
        var grand_total = parseFloat($('#ProductStockEntries_grand_total_payable').val());

        paid = parseFloat($('#ProductStockEntries_grand_total_paid').val());

        if (paid <= 0) {
            alert('Paid should be larger Zero.');
            return false;
        }

        if (paid > grand_total) {
            alert('Paid amount should not be larger than Grand Total.');
            return false;
        }

        balance = grand_total - paid;
        balance = balance.toFixed(2);

        $('#ProductStockEntries_grand_total_balance').val(balance);
        return true;
    }

    $(document).ready(function () {

        $('#product-stock-entries-form').submit(function () {
            if ($('#product_details_id').length <= 0 || $('#supplier_name').val() == '') {
                return false;
            }
        });

        $('#ref_num').blur(function () {
            var ref_num = $(this).val();

//            if (ref_num == '') {
//                return false;
//            }

            var prod_id = $('#product_details_id').val();

            $.ajax({
                url: 'product_stock_info',
                type: 'post',
                dataType: "json",
                data: {prod_id: prod_id, ref_num: ref_num},
                success: function (data) {
                    $('#purchase_price').val(data.cost);
                    $('#selling_price').val(data.price);
                    $('#avail_stock').val(data.cur_stock);

                    var html_grade_list = 'Quality';

                    html_grade_list += '<ul class="radio-list full-width">';
                    for (var key in data.grades) {

                        html_grade_list += '<li>';
                        html_grade_list += '<input name="grade" type="radio" value="' + data.grades[key].id + '" >';
                        html_grade_list += '<label>' + data.grades[key].name + '</label>';
                        html_grade_list += '</li>';
                    }
                    html_grade_list += '</ul>';

                    $('.grade-list').html('');
                    $('.grade-list').html(html_grade_list);
                    $('.grade-list').show();

                },
                error: function (e) {

                }
            });

        });

        $('#selling_price').blur(function () {

            if (get_subtotal() == true) {
                calculate_grand_total();
            }

        });

        $(document).on('keyup', '#ProductStockEntries_grand_total_paid', function () {
            calculate_balance();
        });

    })
</script>

<style type="text/css">
    .horizontal li label {
        margin-left: 5px;
        padding-top: 4px !important;
        text-align: left !important;
    }
    .horizontal ul li {
        width: 40%;
    }
</style>