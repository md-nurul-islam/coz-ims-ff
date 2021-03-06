<?php
/* @var $this PurchaseController */
/* @var $model ExchangeProducts */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'product-exchange-entries-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'action' => '/product/exchange/create',
    ));
    ?>

    <?php if (Yii::app()->user->hasFlash('success')) { ?>
        <div class="success">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php } ?>

    <?php echo $form->errorSummary($model); ?>
    
    <?php  if (!$edit) { ?>
        <fieldset class="custom-color">

            <div class="left margin-right">
                <?php echo $form->labelEx($model, 'exchange_date'); ?>
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'name' => 'ExchangeProducts[exchange_date]',
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
                        'style' => 'cursor: pointer; ',
                        'disabled' => true,
                    ),
                ));
                ?>
                <?php echo $form->error($model, 'sale_date'); ?>
            </div>

        </fieldset>
    <?php } ?>

    <?php if (!$edit) { ?>
        <fieldset>

            <div class="left margin-right-20">
                <?php echo $form->labelEx($model, 'ref_num', array('class' => 'font-left', 'for' => 'ref_num')); ?>
                <div class="clear"></div>
                <?php echo CHtml::textField('ref_num', '', array('size' => 25, 'maxlength' => 150)); ?>
            </div>

            <div class="left margin-right-20">
                <?php echo $form->labelEx($model, 'exchange_product_details_id', array('class' => 'font-left', 'for' => 'product_details_id')); ?>
                <div class="clear"></div>
                <?php echo CHtml::hiddenField('product_details_id', '', array('size' => 30)); ?>
                <?php echo CHtml::textField('product_name', '', array('size' => 30, 'readonly' => true)); ?>
                <div id="div_product_list" style="display: none; width: 202px; clear: both;"></div>
            </div>

            <div class="left margin-right-20">
                <?php echo $form->labelEx($model, 'exchange_product_quantity', array('class' => 'font-left', 'for' => 'quantity')); ?>
                <div class="clear"></div>
                <?php echo CHtml::textField('quantity', '', array('size' => 10,)); ?>
            </div>

            <div class="left margin-right-20">
                <?php echo $form->labelEx($model, 'price', array('class' => 'font-left', 'for' => 'item_selling_price')); ?>
                <div class="clear"></div>
                <?php echo CHtml::textField('item_selling_price', '', array('size' => 10, 'maxlength' => 12, 'readonly' => true)); ?>
            </div>

            <div class="left margin-right-20">
                <?php echo CHtml::label('Avail Stock', 'avail_stock', array('class' => 'font-left', 'for' => 'item_subtotal')); ?>
                <div class="clear"></div>
                <?php echo CHtml::textField('avail_stock', '', array('maxlength' => 12, 'size' => 10, 'readonly' => true)); ?>
            </div>

            <div class="left">
                <?php echo $form->labelEx($model, 'exchange_product_subtotal', array('class' => 'font-left', 'for' => 'item_subtotal')); ?>
                <div class="clear"></div>
                <?php echo CHtml::textField('item_subtotal', '', array('maxlength' => 12, 'readonly' => true)); ?>
            </div>
        </fieldset>
    <?php } ?>

    <?php if ($edit) { ?>
        <fieldset>

            <div class="left margin-right-20">
                <?php echo $form->labelEx($model, 'ref_num', array('class' => 'font-left', 'for' => 'ref_num', 'style' => 'width: 175px;')); ?>
                <div class="clear"></div>
            </div>

            <div class="left margin-right-20">
                <?php echo $form->labelEx($model, 'product_details_id', array('class' => 'font-left', 'for' => 'product_details_id', 'style' => 'width: 200px;')); ?>
                <div class="clear"></div>
            </div>

            <div class="left margin-right-20">
                <?php echo $form->labelEx($model, 'quantity', array('class' => 'font-left', 'for' => 'quantity', 'style' => 'width: 95px;')); ?>
                <div class="clear"></div>
            </div>

            <div class="left margin-right-20">
                <?php echo $form->labelEx($model, 'item_selling_price', array('class' => 'font-left', 'for' => 'item_selling_price', 'style' => 'width: 95px;')); ?>
                <div class="clear"></div>
            </div>

            <div class="left">
                <?php echo $form->labelEx($model, 'item_subtotal', array('class' => 'font-left', 'for' => 'item_subtotal', 'style' => 'width: 95px;')); ?>
                <div class="clear"></div>
            </div>
        </fieldset>
    <?php } ?>

    <fieldset id="cart-row">
        <input type="hidden" name="sales_id" value="<?php echo $model->sales_id; ?>" />
        <?php
        if (!empty($ar_cart)) {
            for ($i = 0; $i < sizeof($ar_cart['product_details_id']); $i++) {
                ?>
                <div class="row cart_div" id="<?php echo $i; ?>">
                    <div class="left margin-right-20">
                        <img id="product_details_id_<?php echo $i; ?>" class="cart_row" data="<?php echo $i; ?>" alt="Delete" src="/images/icons/delete.png" width="20" />
                        <input type="hidden" name="ExchangeProducts[product_details_id][]" value="<?php echo $ar_cart['product_details_id'][$i]; ?>" />
                    </div>
                    
                    <div class="left margin-right-20">
                        <input id="ref_num<?php echo $i; ?>" type="text" name="ExchangeProducts[ref_num][]" value='<?php echo $ar_cart['ref_num'][$i]; ?>' maxlength="150" size="25" />
                    </div>
                    <div class="left margin-right-20">
                        <input id="product_details_name<?php echo $i; ?>" type="text" name="ExchangeProducts[product_details_name][]" value='<?php echo "{$ar_cart['product_details_name'][$i]}"; ?>' size="30" />
                    </div>
                    <div class="left margin-right-30">
                        <input id="quantity_<?php echo $i; ?>" type="text" name="ExchangeProducts[quantity][]" class="qty" value="<?php echo $ar_cart['quantity'][$i]; ?>" size="10" >
                    </div>
                    <div class="left margin-right-30">
                        <input id="item_selling_price<?php echo $i; ?>" type="text" name="ExchangeProducts[item_selling_price][]" value="<?php echo $ar_cart['selling_price'][$i]; ?>" maxlength="12" size="10" >
                    </div>
                    
                    <?php if(!$edit) {?>
                        <div class="left margin-right-20">
                            <input id="cur_stock<?php echo $i; ?>" type="text" name="cur_stock[]" value="<?php echo $ar_cart['cur_stock'][$i]; ?>" size="10" maxlength="12" >
                        </div>
                    <?php } ?>
                    
                    <div class="left">
                        <input id="item_subtotal<?php echo $i; ?>" class="sub_total" type="text" name="ExchangeProducts[item_subtotal][]" value="<?php echo $ar_cart['item_subtotal'][$i]; ?>" maxlength="12" >        		
                    </div>
                    <?php if ($edit) { ?>
                    <div class="custom-buttons">
                        
                    </div>
                    <?php } ?>
                </div>
                <?php
            }
        }
        ?>
    </fieldset>
    
    <?php if (!$edit) { ?>
        <fieldset class="custom-color">

            <div class="row">
                <div class="left">
                    <?php echo $form->labelEx($model, 'dis_amount'); ?>
                    <?php echo $form->textField($model, 'dis_amount'); ?>
                    <?php echo $form->error($model, 'dis_amount'); ?>
                </div>
                
                <div class="left">
                    <label for="'balance">Balance</label>
                    <input name="balance" id="balance" readonly="readonly" type="text" maxlength="13" value="<?php echo number_format($main_prod_total, 2) ; ?>" >
                    <input name="sales_id" id="sales_id" readonly="readonly" type="hidden" maxlength="13" value="<?php echo $sales_id; ?>" >
                </div>

            </div>

            <div class="row">
                <div class="left">
                    <?php echo $form->labelEx($model, 'grand_total_payable'); ?>
                    <?php echo $form->textField($model, 'grand_total_payable', array('readonly' => true)); ?>
                    <?php echo $form->error($model, 'grand_total_payable'); ?>
                </div>

                <div class="left">
                    <?php echo $form->labelEx($model, 'grand_total_paid'); ?>
                    <?php echo $form->textField($model, 'grand_total_paid', array('size' => 12, 'maxlength' => 12, 'readonly' => ($edit) ? TRUE : FALSE )); ?>
                    <?php echo $form->error($model, 'grand_total_paid'); ?>
                </div>

                <div class="left">
                    <?php echo $form->labelEx($model, 'grand_total_balance'); ?>
                    <?php echo $form->textField($model, 'grand_total_balance', array('size' => 12, 'maxlength' => 12, 'readonly' => true)); ?>
                    <?php echo $form->error($model, 'grand_total_balance'); ?>
                </div>
            </div>

            <div class="row">
                <div class="left">
                    <?php echo $form->labelEx($model, 'due_payment_date'); ?>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name' => 'ExchangeProducts[due_payment_date]',
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
                            'style' => '',
                            'readonly' => true,
                        ),
                    ));
                    ?>
                    <?php echo $form->error($model, 'due_payment_date'); ?>
                </div>

                <div class="left">
                    <?php echo $form->labelEx($model, 'payment_method'); ?>
                    <?php echo $form->dropDownList($model, 'payment_method', Settings::$_payment_types, array('style' => 'width: 92px;')); ?>
                    <?php echo $form->error($model, 'payment_method'); ?>
                </div>

                <div class="left">
                    <?php echo $form->labelEx($model, 'note'); ?>
                    <?php echo $form->textArea($model, 'note', array('rows' => 6, 'cols' => 50)); ?>
                    <?php echo $form->error($model, 'note'); ?>
                </div>

            </div>
        </fieldset>
    <?php } ?>
    
    <div class="row left submit-btn">
        <?php echo CHtml::submitButton(!$edit ? 'Exchange' : 'Start', array('id' => 'btn-submit')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->


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
            setTimeout(function() {
                $('#quantity').focus();
            }, 1);
            return false;
        }

        price = parseFloat($('#item_selling_price').val());
        qty = parseInt($('#quantity').val());

        if (qty <= 0) {
            alert('Please Provide Quantity.');
            setTimeout(function() {
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
                '<div class="left margin-right-20">' +
                '<input id="ref_num' + cart_div + '" type="text" name="ExchangeProducts[ref_num][]" value="' + reference_num + '" maxlength="150" size="25" readonly="readonly" />' +
                '</div>' +
                '<div class="left margin-right-20">' +
                '<input id="product_details_id' + cart_div + '" type="hidden" name="ExchangeProducts[product_details_id][]" value="' + prod_id + '" />' +
                '<input id="product_details_name' + cart_div + '" type="text" name="ExchangeProducts[product_details_name][]" value=\'' + prod_name + '\' size="30" readonly="readonly" />' +
                '</div>' +
                '<div class="left margin-right-30">' +
                '<input id="quantity' + cart_div + '" type="text" name="ExchangeProducts[quantity][]" value="' + qty + '" size="10" readonly="readonly" />' +
                '</div>' +
                '<div class="left margin-right-30">' +
                '<input id="item_selling_price' + cart_div + '" type="text" name="ExchangeProducts[item_selling_price][]" value="' + price.toFixed(2) + '" maxlength="12" size="10" readonly="readonly" />' +
                '</div>' +
                '<div class="left margin-right-20">' +
                '<input id="cur_stock' + cart_div + '" type="text" name="cur_stock[]" value="' + cur_stock + '" readonly="readonly" size="10" maxlength="12" />' +
                '</div>' +
                '<div class="left">' +
                '<input id="item_subtotal' + cart_div + '" class="sub_total" type="text" name="ExchangeProducts[item_subtotal][]" value="' + sub_total + '" maxlength="12" readonly="readonly" />' +
                '</div>' +
                '<div class="custom-buttons">' +
                '<img class="edit-button" data="' + cart_div + '" alt="Edit" src="/images/icons/edit.png" width="20" />' +
                '<img class="delete-button" data="' + cart_div + '" alt="Delete" src="/images/icons/delete.png" width="20" />' +
                '</div>' +
                '</div>';

        $('#cart-row').append(cart_row_html);
        $('#ExchangeProducts_grand_total_paid').val(0.00);
        cart_div += 1;
        setTimeout(function() {
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
        
        var _balance = parseFloat($('#balance').val());
        var grand_total = 0.00;

        $('#cart-row').find('input[class="sub_total"]').each(function() {
            grand_total += parseFloat($(this).val());
        });

        grand_total = grand_total - _balance;
        grand_total = grand_total.toFixed(2);
        grand_total_1 = grand_total;
        $('#ExchangeProducts_grand_total_payable').val(grand_total);
        return true;
    }

    function calculate_balance() {
        var paid = 0.00;
        var balance = 0.00;
        grand_total = parseFloat($('#ExchangeProducts_grand_total_payable').val());

        paid = parseFloat($('#ExchangeProducts_grand_total_paid').val());

        balance = paid - grand_total;
        balance = balance.toFixed(2);

        $('#ExchangeProducts_grand_total_balance').val(balance);
        return true;
    }
    
    $(document).ready(function() {
        
        var old_qty = 0;
        var row_id = 0;
        var old_sub_total = 0;
        
        $('.cart_row').click(function(){
            var _ar_row_id = $(this).attr('id').split('_');
            row_id = _ar_row_id[_ar_row_id.length - 1];
            $('#' + row_id).html('');
        });
        
        $('.qty').focus(function(){
            
            var _ar_row_id = $(this).attr('id').split('_');
            row_id = _ar_row_id[_ar_row_id.length - 1];
            
            old_qty  =  parseInt($(this).val());
            old_sub_total = $('#item_subtotal' + row_id).val();
            
        });
        
        $('.qty').change(function(){
            
            var new_qty = parseInt($(this).val());
            
            if ( new_qty > old_qty ) {
                alert('Exchanging quantity is more than bought.');
                setTimeout(function(){
                    $('#quantity_' + row_id).focus();
                }, 1);
            }else if ( new_qty <= 0 ) {
                alert('0 quantity cannot be exchanged.');
                
                setTimeout(function(){
                    $('#quantity_' + row_id).focus();
                }, 1);
                
            }else{
                
                var new_sub_total = (new_qty * parseFloat($('#item_selling_price' + row_id).val()));
                
                $('#item_subtotal' + row_id).val(new_sub_total.toFixed(2));
            }
            
        });
        
        <?php if($edit){ ?>
            grand_total_1 = $('#ExchangeProducts_grand_total_payable').val();

            var dis_cnt = $('#ExchangeProducts_dis_amount').val();

            if( dis_cnt != '' && dis_cnt > 0 ) {
                var grand_total_2 = 0.00;
                $('#cart-row').find('input[class="sub_total"]').each(function() {
                                    grand_total_2 += parseFloat($(this).val());
                                });
                grand_total_1 = grand_total_2;
            }

    <?php } ?>

    <?php if(!$edit){ ?>
            $('#product-exchange-entries-form').submit(function() {
                if ($('#product_details_id').length <= 0 || $('#ExchangeProducts_grand_total_paid').val() == '' || parseInt($('#ExchangeProducts_grand_total_paid').val()) <= 0) {
                    return false;
                }
            });
    <?php } ?>

    $('#ref_num').blur(function() {
        var ref_num = $(this).val();

        if (ref_num == '') {
            return false;
        }

        $.ajax({
            url: 'product_stock_info',
            type: 'post',
            dataType: "json",
            data: {ref_num: ref_num},
            success: function(data) {
                var prod_list = '';
                if ((data.response.length) > 1) {
                    $.each(data.response, function(k, v) {
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
                    $('#div_product_list').html('');
                    $('#div_product_list').hide();
                    $('#product_name').val(data.response[0].product_name);
                    $('#product_details_id').val(data.response[0].product_id);
                    $('#item_selling_price').val(data.response[0].price);
                    $('#avail_stock').val(data.response[0].cur_stock);
                }
            },
            error: function() {

            }
        });

    });

    $('#quantity').blur(function() {

        var qty = parseInt($(this).val());
        var cur_stock = parseInt($('#avail_stock').val());

        if (qty > cur_stock) {
            alert('Quantity is more than available stock.');
            setTimeout(function() {
                $('#quantity').focus();
            }, 1);
            return false;
        }

        if (get_subtotal() == true) {
            if (add_to_cart() == true) {
                if (reset_fields()) {
                    calculate_grand_total();
                    calculate_balance();
                }
            }
        }
    });

    $(document).on('click', '.delete-button', function() {
        var row_num = $(this).attr('data');
        $("div[id=" + row_num + "]").remove();
        calculate_grand_total();
    });

    $(document).on('click', '.prod-list-radio', function() {
        var ref_num = $('#ref_num').val();
        var prod_id = $(this).val();

        $.ajax({
            url: 'product_stock_info',
            type: 'post',
            dataType: "json",
            data: {prod_id: prod_id, ref_num: ref_num},
            success: function(data) {
                $('#product_name').val(data.response[0].product_name);
                $('#product_details_id').val(data.response[0].product_id);
                $('#item_selling_price').val(data.response[0].price);
                $('#avail_stock').val(data.response[0].cur_stock);
            },
            error: function() {

            }
        });
    });

    $(document).on('click', '.edit-button', function() {
        var row_num = $(this).attr('data');
        if (edit_current_row(row_num)) {
            $("div[id=" + row_num + "]").remove();
        }
        calculate_grand_total();
    });

    $(document).on('keyup', '#ExchangeProducts_grand_total_paid', function() {
        calculate_balance();
    });

    $(document).on('keyup', '#ExchangeProducts_dis_amount', function() {

        if ($(this).val() == '') {
            $('#ExchangeProducts_grand_total_payable').val(grand_total_1);
        } else {
            var dis_amnt = parseFloat($(this).val());
            var total_payable = grand_total_1 - dis_amnt;
            $('#ExchangeProducts_grand_total_payable').val(total_payable.toFixed(2));

            <?php if($edit) { ?>
                calculate_balance();
            <?php } ?>
        }

    });
        
    });
</script>