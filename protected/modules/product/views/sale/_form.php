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

        <input type="hidden" id="cart_id" value="0" />

        <div class="col-lg-7">

            <div class="box box-info">

                <div class="box-body">

                    <?php echo $form->errorSummary($model); ?>

                    <input type="hidden" id="global_vat" name="global_vat" value="<?php echo Settings::$_vat; ?>" />
                    <input type="hidden" id="global_vat_mode" name="global_vat_mode" value="<?php echo Settings::$_vat_mode; ?>" />
                    <input type="hidden" id="global_discount" name="global_discount" value="<?php echo Settings::$_discount; ?>" />
                    <input type="hidden" id="global_discount_mode" name="global_discount_mode" value="<?php echo Settings::$_discount_mode; ?>" />

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

                            if ($model->advance_sale) {
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
                                    'readonly' => (!$model->advance_sale) ? true : FALSE,
                                    'class' => 'form-control',
                                    'placeholder' => 'Due Payment Date',
                                )
                            ));
                            ?>
                            <?php echo $form->error($model, 'due_payment_date', array('class' => 'alert alert-danger')); ?>
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
                                'placeholder' => 'Type Full Reference Number or Part of Product Name',
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12" id="div_product_list">

                        </div>
                    </div>

                    <div class="panel panel-default">

                        <div class="printable">
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
                                        <th class="vat_cell">Vat</th>
                                        <th class="vat_cell_val">0.00</th>
                                        <th class="discount_cell">Discount</th>
                                        <th class="discount_cell_val">0.00</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Total Items</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-12" id="div_buttons_wrapper">

                            <div class="col-md-8">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary form-control bg-green border-0">Save</button>
                                </div>

                                <div class="col-md-6">
                                    <button type="button" class="btn btn-warning form-control cart-print bg-orange border-0">Print</button>
                                </div>

                                <div class="col-md-12">
                                    <button type="button" class="btn btn-danger form-control border-0">Cancel</button>
                                </div>
                            </div>

                            <div class="col-md-4 pull-right">
                                <button type="button" class="btn btn-success form-control btn-payment bg-green border-0">Payment</button>
                            </div>


                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>
    <!-- CART -->

</div>


<?php $this->endWidget(); ?>
</div>

<?php $this->renderPartial('//modals/_price'); ?>
<?php $this->renderPartial('//modals/_vat'); ?>
<?php
if ($model->advance_sale) {
    $this->renderPartial('//modals/_advance_payment');
} else {
    $this->renderPartial('//modals/_payment');
}
?>
<?php $this->renderPartial('//print/print'); ?>

<style type="text/css">
    .card_information {
        display: none;
    }

    table.payment tr th {
        cursor: pointer;
    }
    table.payment tr:first-child > th, table.payment tr:nth-child(2) > th, table.payment tr:nth-child(3) > th {
        border-bottom: 1px solid #ccc !important;
    }
    table.payment tr th:first-child {
        border-right: 1px solid #ccc !important;
        border-left: 1px solid #ccc !important;
    }

    #div_buttons_wrapper {
        padding: 0;
        margin-top: 20px;
    }
    #div_buttons_wrapper .col-md-6,
    #div_buttons_wrapper .col-md-12,
    #div_buttons_wrapper .col-md-8 {
        padding-left: 0;
        padding-right: 0;
    }
    #div_buttons_wrapper .col-md-4 {
        padding-left: 10px;
        padding-right: 0;
    }
    #div_buttons_wrapper .col-md-4 button {
        height: 68px;
    }
    #div_buttons_wrapper button {
        border-radius: 0;
    }
    label {
        cursor: pointer;
    }
    .vat_options li {
        margin-right: 20px;
    }
    .vat_options li:last-child {
        margin-right: 0;
    }
    .form-horizontal p {
        margin-top: 3px; 
        color: #666666; 
    }
    .vat_cell, .discount_cell {
        cursor: pointer;
        text-decoration: underline;
    }
    tfoot#cart-total tr:first-child {
        background-color: #37a000;
        color: #ffffff;
    }
    tfoot#cart-total tr:last-child {
        background-color: orange;
        color: #ffffff;
    }
    #paymentModal .modal-header, #paymentModal .modal-footer {
        background-color: #3c8dbc;
        color: #ffffff;
    }
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
if ($model->advance_sale) {
    $cs->registerScriptFile('/js/custom/advance_sale_cart.js', CClientScript::POS_END);
} else {
    $cs->registerScriptFile('/js/custom/cart.js', CClientScript::POS_END);
}
$cs->registerScriptFile('/js/custom/print.js', CClientScript::POS_END);
?>
<script type="text/javascript">
    $(document).ready(function () {
        $(".select2").select2({
            minimumResultsForSearch: Infinity,
            width: '100%'
        });
        $(".select2").tooltip();
        $(".select2").tooltip('disable');
    });
</script>