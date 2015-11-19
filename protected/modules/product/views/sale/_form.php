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

        <div class="col-lg-7">

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


        <!-- CART -->
        <div class="col-lg-5">

            <div class="box box-info">
                <div class="box-body no-border">

                    <div class="form-group">
                        <div class="col-md-12">
                            <?php
                            echo CHtml::textField('ref_num', '', array(
                                'size' => 25,
                                'maxlength' => 150,
                                'class' => 'form-control',
                                'placeholder' => 'Type Reference Number',
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12" id="div_product_list">

                        </div>
                    </div>

                    <div class="panel panel-default">

                        <table class="table table-hover table-bordered table-responsive table-condensed">

                            <thead>
                                <tr>
                                    <th class="col-sm-6">Item</th>
                                    <th class="col-sm-1">Price</th>
                                    <th class="col-sm-2">Qty</th>
                                    <th class="col-sm-2">Total</th>
                                    <th class="col-sm-1"></th>
                                </tr>
                            </thead>

                            <tbody id="cart-row"></tbody>

                            <tfoot id="cart-total">
                                <tr>
                                    <th colspan="2">Total Items</th>
                                    <th></th>
                                    <th colspan="3"></th>
                                </tr>
                            </tfoot>

                        </table>

                    </div>
                </div>
            </div>

        </div>
        <!-- CART -->

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

<style type="text/css">
    .label {
        font-size: 14px;
    }
    i.fa-trash-o {
        color: #CC0000;
        cursor: pointer;
        font-size: 18px;
    }
    #div_product_list {
        display: none;
    }
    #div_product_list .radio-inline label {
        font-weight: 600;
        margin-right: 10px;
    }
    #div_product_list .radio-inline label:last-child {
        margin-right: 0;
    }
    .cart_qty {
        height: 30px;
    }
    #cart-row td {
        cursor: pointer;
    }
</style>

<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('/js/custom/cart.js', CClientScript::POS_END);
?>
