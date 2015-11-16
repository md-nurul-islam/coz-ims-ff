<div class="row">
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

    <div class="col-lg-12">

        <div class="col-lg-8">

            <div class="box box-info">

                <div class="box-body">

                    <?php echo $form->errorSummary($model); ?>

                    <div class="form-group">
                        <div class="col-sm-10">
                            <label>Fields with <span class="required">*</span> are required.</label>
                        </div>
                    </div>

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
                        <?php echo $form->labelEx($model, 'sale_date', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-9">
                            <?php
                            $time = Settings::getBdLocalTime();
                            $due_time = $time;

                            if ($model->advance_sale_list) {
                                $time = strtotime(date('Y-m-d', $time) . '+1 day');
                                $due_time = strtotime(date('Y-m-d', $time) . '+1 day');
                            }

                            if (!empty($model->sale_date)) {
                                $time = strtotime($model->sale_date);
                            }

                            if (!empty($model->due_payment_date)) {
                                $due_time = strtotime($model->due_payment_date);
                            }

                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'name' => 'ProductStockSales[sale_date]',
                                'value' => date('Y-m-d', $time),
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
                                    'placeholder' => 'Sale Date',
                                )
                            ));
                            ?>
                            <?php echo $form->error($model, 'sale_date', array('class' => 'alert alert-danger')); ?>
                        </div>
                    </div>



                    <?php if (!$edit) { ?>

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
                            <?php echo $form->labelEx($model, 'product_details_id', array('class' => 'col-sm-2 control-label', 'for' => 'product_details_id')); ?>
                            <div class="col-sm-9">
                                <?php echo CHtml::hiddenField('product_details_id', '', array('size' => 30)); ?>
                                <?php
                                echo CHtml::textField('product_name', '', array(
                                    'size' => 30,
                                    'class' => 'form-control',
                                    'placeholder' => 'Product Name',
                                ));
                                ?>
                                <div id="div_product_list" style="display: none; width: 202px; clear: both;"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'quantity', array('class' => 'col-sm-2 control-label', 'for' => 'quantity')); ?>
                            <div class="col-sm-9">
                                <?php
                                echo CHtml::textField('quantity', '', array(
                                    'size' => 10,
                                    'class' => 'form-control',
                                    'placeholder' => 'Quantity',
                                ));
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'item_selling_price', array('class' => 'col-sm-2 control-label', 'for' => 'item_selling_price')); ?>
                            <div class="col-sm-9">
                                <?php
                                echo CHtml::textField('item_selling_price', '', array(
                                    'size' => 10,
                                    'maxlength' => 12,
                                    'readonly' => false,
                                    'class' => 'form-control',
                                    'placeholder' => 'Selling Price',
                                ));
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo CHtml::label('Avail Stock', 'avail_stock', array('class' => 'col-sm-2 control-label', 'for' => 'avail_stock')); ?>
                            <div class="col-sm-9">
                                <?php
                                echo CHtml::textField('avail_stock', '', array(
                                    'maxlength' => 12,
                                    'size' => 10,
                                    'readonly' => true,
                                    'class' => 'form-control',
                                    'placeholder' => 'Billnumber',
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
                                    'class' => 'form-control',
                                    'placeholder' => 'Item Subtotal',
                                ));
                                ?>
                            </div>
                        </div>

                    <?php } ?>

                    <?php if ($edit) { ?>

                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'ref_num', array('class' => 'col-sm-2 control-label', 'for' => 'ref_num')); ?>
                            <div class="clear"></div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'product_details_id', array('class' => 'col-sm-2 control-label', 'for' => 'product_details_id')); ?>
                            <div class="clear"></div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'quantity', array('class' => 'col-sm-2 control-label', 'for' => 'quantity')); ?>
                            <div class="clear"></div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'item_selling_price', array('class' => 'col-sm-2 control-label', 'for' => 'item_selling_price')); ?>
                            <div class="clear"></div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'item_subtotal', array('class' => 'col-sm-2 control-label', 'for' => 'item_subtotal')); ?>
                            <div class="clear"></div>
                        </div>

                    <?php } ?>


                    <?php
                    if (!empty($ar_cart)) {
                        for ($i = 0; $i < sizeof($ar_cart['product_details_id']); $i++) {
                            ?>
                            <div class="cart_div" id="<?php echo $i; ?>">
                                <div class="form-group">
                                    <input id="ref_num<?php echo $i; ?>" type="text" name="ProductStockSales[ref_num][]" value='<?php echo $ar_cart['ref_num'][$i]; ?>' maxlength="150" size="25" readonly="readonly" />
                                </div>
                                <div class="form-group">
                                    <input id="product_details_id<?php echo $i; ?>" type="hidden" name="ProductStockSales[product_details_id][]" value="<?php echo $ar_cart['product_details_id'][$i]; ?>" />
                                    <input id="product_details_name<?php echo $i; ?>" type="text" name="ProductStockSales[product_details_name][]" value='<?php echo "{$ar_cart['product_details_name'][$i]}"; ?>' size="30" readonly="readonly" />
                                </div>
                                <div class="left margin-right-30">
                                    <input id="quantity<?php echo $i; ?>" type="text" name="ProductStockSales[quantity][]" value="<?php echo $ar_cart['quantity'][$i]; ?>" size="10" readonly="readonly" />
                                </div>
                                <div class="left margin-right-30">
                                    <input id="item_selling_price<?php echo $i; ?>" type="text" name="ProductStockSales[item_selling_price][]" value="<?php echo $ar_cart['selling_price'][$i]; ?>" maxlength="12" size="10" readonly="readonly" />
                                </div>

                                <?php if (!$edit) { ?>
                                    <div class="form-group">
                                        <input id="cur_stock<?php echo $i; ?>" type="text" name="cur_stock[]" value="<?php echo $ar_cart['cur_stock'][$i]; ?>" readonly="readonly" size="10" maxlength="12" />
                                    </div>
                                <?php } ?>

                                <div class="form-group">
                                    <input id="item_subtotal<?php echo $i; ?>" class="sub_total" type="text" name="ProductStockSales[item_subtotal][]" value="<?php echo $ar_cart['item_subtotal'][$i]; ?>" maxlength="12" readonly="readonly" />        		
                                </div>
                                <?php if (!$edit) { ?>
                                    <div class="custom-buttons">
                                        <img class="edit-button" data="<?php echo $i; ?>" alt="Edit" src="/images/icons/edit.png" width="20" />
                                        <img class="delete-button" data="<?php echo $i; ?>" alt="Delete" src="/images/icons/delete.png" width="20" />
                                    </div>
                                <?php } ?>
                            </div>
                            <?php
                        }
                    }
                    ?>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'dis_amount', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-9">
                            <?php
                            echo $form->textField($model, 'dis_amount', array(
                                'class' => 'form-control',
                                'placeholder' => 'Discount',
                            ));
                            ?>
                            <?php echo $form->error($model, 'dis_amount', array('class' => 'alert alert-danger')); ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'grand_total_payable', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-9">
                            <?php
                            echo $form->textField($model, 'grand_total_payable', array(
                                'readonly' => true,
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
                                'readonly' => ($edit && !$model->advance_sale_list) ? TRUE : FALSE,
                                'class' => 'form-control',
                                'placeholder' => 'Grand Total Paid',
                            ));
                            ?>
                            <?php echo $form->error($model, 'grand_total_paid', array('class' => 'alert alert-danger')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'grand_total_balance', array('class' => 'col-sm-2 control-label', 'id' => 'balance_lable')); ?>
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
                                'name' => 'ProductStockSales[due_payment_date]',
                                'value' => date('Y-m-d', $due_time),
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
                                    'placeholder' => 'Due Payment Date',
                                )
                            ));
                            ?>
                            <?php echo $form->error($model, 'due_payment_date', array('class' => 'alert alert-danger')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'payment_method', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-9">
                            <?php
                            echo $form->dropDownList($model, 'payment_method', Settings::$_payment_types, array(
                                'style' => 'width: 100%;',
                                'class' => 'form-control select2'
                            ));
                            ?>
                            <?php echo $form->error($model, 'payment_method', array('class' => 'alert alert-danger')); ?>
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
                                'placeholder' => 'Billnumber',
                            ));
                            ?>
                            <?php echo $form->error($model, 'note', array('class' => 'alert alert-danger')); ?>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <div class="box-footer">
        <?php
        echo CHtml::submitButton($model->isNewRecord ? 'Sale' : 'Update', array(
            'id' => 'btn-submit',
            'class' => 'btn btn-info pull-right'
        ));
        ?>
    </div>

    <?php $this->endWidget(); ?>
</div>


<script type="text/javascript">

    var prod_id = '';
    var prod_name = '';
    var reference_num = '';
    var qty = 0;
    var price = 0.00;
    var sub_total = 0.00;
    var cur_stock = 0;
    var cart_div = 1;
    var grand_total_1 = 0.00;

    function get_subtotal() {

        if ($('#quantity').val() == '') {
            alert('Please Provide Quantity.');
            setTimeout(function () {
                $('#quantity').focus();
            }, 1);
            return false;
        }

        price = parseFloat($('#item_selling_price').val());
        qty = parseInt($('#quantity').val());

        if (qty <= 0) {
            alert('Please Provide Quantity.');
            setTimeout(function () {
                $('#quantity').focus();
            }, 1);
            return false;
        }

        sub_total = parseFloat(qty * price).toFixed(2);
        $('#item_subtotal').val(sub_total);

        return true;
    }

    function add_to_cart() {

        prod_id = $('#product_details_id').val();

        prod_name = $('#product_name').val();
        reference_num = $('#ref_num').val();
        cur_stock = $('#avail_stock').val();

        var cart_row_html = '<div class="row cart_div" id="' + cart_div + '">' +
                '<div class="form-group">' +
                '<input id="ref_num' + cart_div + '" type="text" name="ProductStockSales[ref_num][]" value="' + reference_num + '" maxlength="150" size="25" readonly="readonly" />' +
                '</div>' +
                '<div class="form-group">' +
                '<input id="product_details_id' + cart_div + '" type="hidden" name="ProductStockSales[product_details_id][]" value="' + prod_id + '" />' +
                '<input id="product_details_name' + cart_div + '" type="text" name="ProductStockSales[product_details_name][]" value=\'' + prod_name + '\' size="30" readonly="readonly" />' +
                '</div>' +
                '<div class="left margin-right-30">' +
                '<input id="quantity' + cart_div + '" type="text" name="ProductStockSales[quantity][]" value="' + qty + '" size="10" readonly="readonly" />' +
                '</div>' +
                '<div class="left margin-right-30">' +
                '<input id="item_selling_price' + cart_div + '" type="text" name="ProductStockSales[item_selling_price][]" value="' + price.toFixed(2) + '" maxlength="12" size="10" readonly="readonly" />' +
                '</div>' +
                '<div class="form-group">' +
                '<input id="cur_stock' + cart_div + '" type="text" name="cur_stock[]" value="' + cur_stock + '" readonly="readonly" size="10" maxlength="12" />' +
                '</div>' +
                '<div class="form-group">' +
                '<input id="item_subtotal' + cart_div + '" class="sub_total" type="text" name="ProductStockSales[item_subtotal][]" value="' + sub_total + '" maxlength="12" readonly="readonly" />' +
                '</div>' +
                '<div class="custom-buttons">' +
                '<img class="edit-button" data="' + cart_div + '" alt="Edit" src="/images/icons/edit.png" width="20" />' +
                '<img class="delete-button" data="' + cart_div + '" alt="Delete" src="/images/icons/delete.png" width="20" />' +
                '</div>' +
                '</div>';

        $('#cart-row').append(cart_row_html);
        $('#ProductStockSales_grand_total_paid').val(0.00);
        cart_div += 1;
        setTimeout(function () {
            $('#ref_num').focus();
        }, 1);
        $('#div_product_list').html('');
        $('#div_product_list').hide();
        return true;
    }

    function reset_fields() {
        $('#item_selling_price').val('');
        $('#quantity').val('');
        $('#product_details_id').val('');
        $('#product_name').val('');
        $('#ref_num').val('');
        $('#avail_stock').val('');
        $('#item_subtotal').val('');

        return true;
    }

    function edit_current_row(cart_div_id) {

        prod_id = $('#product_details_id' + cart_div_id).val();
        prod_name = $('#product_details_name' + cart_div_id).val();
        reference_num = $('#ref_num' + cart_div_id).val();
        qty = $('#quantity' + cart_div_id).val();
        price = $('#item_selling_price' + cart_div_id).val();
        cur_stock = $('#cur_stock' + cart_div_id).val();
        sub_total = $('#item_subtotal' + cart_div_id).val();

        $('#product_details_id').val(prod_id);
        $('#product_name').val(prod_name);
        $('#ref_num').val(reference_num);
        $('#quantity').val(qty);
        $('#item_selling_price').val(price);
        $('#avail_stock').val(cur_stock);
        $('#item_subtotal').val(sub_total);

        return true;
    }

    function calculate_grand_total() {

        var grand_total = 0.00;

        $('#cart-row').find('input[class="sub_total"]').each(function () {
            grand_total += parseFloat($(this).val());
        });

        grand_total = grand_total.toFixed(2);
        grand_total_1 = grand_total;
        $('#ProductStockSales_grand_total_payable').val(grand_total);
        return true;
    }

    function calculate_balance() {
        var paid = 0.00;
        var balance = 0.00;
        grand_total = parseFloat($('#ProductStockSales_grand_total_payable').val());

        paid = parseFloat($('#ProductStockSales_grand_total_paid').val());

<?php if ($model->advance_sale_list && !$edit) { ?>
            balance = grand_total - paid;
<?php } else { ?>
            balance = paid - grand_total;
<?php } ?>

        if (paid > grand_total) {
            $('#balance_lable').text('Return');
        } else {
            $('#balance_lable').text('Due');
        }

        balance = Math.abs(balance);
        balance = balance.toFixed(2);

        $('#ProductStockSales_grand_total_balance').val(balance);
        return true;
    }

    $(document).ready(function () {

        $(document).on('keypress', function (e) {

            if (e.keyCode == 13) {
                return false;
            }

        });

<?php if ($edit) { ?>
            grand_total_1 = $('#ProductStockSales_grand_total_payable').val();

            var dis_cnt = $('#ProductStockSales_dis_amount').val();

            if (dis_cnt != '' && dis_cnt > 0) {
                var grand_total_2 = 0.00;
                $('#cart-row').find('input[class="sub_total"]').each(function () {
                    grand_total_2 += parseFloat($(this).val());
                });
                grand_total_1 = grand_total_2;
            }

<?php } ?>

<?php if (!$edit) { ?>
            $('#product-stock-entries-form').submit(function () {
                if ($('#product_details_id').length <= 0 || $('#ProductStockSales_grand_total_paid').val() == '' || parseInt($('#ProductStockSales_grand_total_paid').val()) <= 0) {
                    return false;
                }
            });
<?php } ?>

        $('#ref_num').blur(function () {
            var ref_num = $(this).val();

            if (ref_num == '') {
                return false;
            }

            $.ajax({
                url: 'product_stock_info',
                type: 'post',
                dataType: "json",
                data: {ref_num: ref_num},
                success: function (data) {
                    var prod_list = '';
                    if ((data.response != undefined)) {
                        if ((data.response.length) > 1) {
                            $.each(data.response, function (k, v) {
                                prod_list += '<span class="prod-list-span">\n\
                                                <input class="prod-list-radio" id="prod_' + v.product_id + '" type="radio" value="' + v.product_id + '" name="product_list" />\n\
                                                <label class="prod-list-label" for="prod_' + v.product_id + '">' + v.product_name + '</label>\n\
                                                <input type="hidden" id="prod_price_' + v.product_id + '" value="' + v.price + '" >\n\
                                                <input type="hidden" id="prod_cur_stock_' + v.product_id + '" value="' + v.cur_stock + '" >\n\
                                            </span>';
                            });
                            $('#div_product_list').html('');
                            $('#div_product_list').html(prod_list);
                            $('#div_product_list').show();
                        } else {

                            if (data.response[0].cur_stock <= 0) {
                                alert('Product: --' + data.response[0].product_name + '-- is out of stock.');
                                return false;
                            }

                            $('#div_product_list').html('');
                            $('#div_product_list').hide();
                            $('#product_name').val(data.response[0].product_name);
                            $('#product_details_id').val(data.response[0].product_id);
                            $('#item_selling_price').val(data.response[0].price);
                            $('#avail_stock').val(data.response[0].cur_stock);
                        }
                    }

                },
                error: function () {

                }
            });

        });

        //        $('#quantity').blur(function() {
        $('#item_selling_price').blur(function () {

            var qty = parseInt($('#quantity').val());
            //            var qty = parseInt($(this).val());
            var cur_stock = parseInt($('#avail_stock').val());

            if (qty > cur_stock) {
                alert('Quantity is more than available stock.');
                setTimeout(function () {
                    $('#quantity').focus();
                }, 1);
                return false;
            }

            if (get_subtotal() === true) {
                if (add_to_cart() === true) {
                    if (reset_fields()) {
                        calculate_grand_total();
                        calculate_balance();
                    }
                }
            }
        });

        $(document).on('click', '.delete-button', function () {
            var row_num = $(this).attr('data');
            $("div[id=" + row_num + "]").remove();
            calculate_grand_total();
        });

        $(document).on('click', '.prod-list-radio', function () {
            var ref_num = $('#ref_num').val();
            var prod_id = $(this).val();

            $.ajax({
                url: 'product_stock_info',
                type: 'post',
                dataType: "json",
                data: {prod_id: prod_id, ref_num: ref_num},
                success: function (data) {

                    if (data.response[0].cur_stock <= 0) {
                        alert('Product: --' + data.response[0].product_name + '-- is out of stock.');
                        return false;
                    }


                    $('#product_name').val(data.response[0].product_name);
                    $('#product_details_id').val(data.response[0].product_id);
                    $('#item_selling_price').val(data.response[0].price);
                    $('#avail_stock').val(data.response[0].cur_stock);
                },
                error: function () {

                }
            });
        });

        $(document).on('click', '.edit-button', function () {
            var row_num = $(this).attr('data');
            if (edit_current_row(row_num)) {
                $("div[id=" + row_num + "]").remove();
            }
            calculate_grand_total();
        });

        $(document).on('keyup', '#ProductStockSales_grand_total_paid', function () {
            calculate_balance();
        });

        $(document).on('keyup', '#ProductStockSales_dis_amount', function () {

            if ($(this).val() == '') {
                $('#ProductStockSales_grand_total_payable').val(grand_total_1);
            } else {
                var dis_amnt = parseFloat($(this).val());
                var total_payable = grand_total_1 - dis_amnt;
                $('#ProductStockSales_grand_total_payable').val(total_payable.toFixed(2));

<?php if ($edit) { ?>
                    calculate_balance();
<?php } ?>
            }

        });
    });
</script>