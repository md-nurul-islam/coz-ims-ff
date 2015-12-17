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
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php } ?>

    <?php
    if (isset($ar_cart['errors']) && !empty($ar_cart['errors'])) {
        foreach ($ar_cart['errors'] as $error) {
            ?>
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $error; ?>
            </div>
            <?php
        }
    }
    ?>

    <div class="col-lg-6">

        <div class="box box-info">

            <div class="box-body">

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
                    <?php echo $form->labelEx($model, 'billnumber', array('class' => 'col-sm-4 control-label')); ?>
                    <div class="col-sm-7">
                        <?php
                        echo $form->textField($model, 'billnumber', array(
                            'size' => 20,
                            'maxlength' => 120,
                            'class' => 'form-control',
                            'placeholder' => 'Billnumber',
                            'disabled' => $model->isNewRecord ? FALSE : TRUE
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'purchase_date', array('class' => 'col-sm-4 control-label')); ?>
                    <div class="col-sm-7">
                        <?php
                        if ($model->isNewRecord || empty($model->purchase_date) || $model->purchase_date == '0000-00-00') {
                            $purchase_date = (isset($ar_cart['purchase_date']) && !empty($ar_cart['purchase_date'])) ? $ar_cart['purchase_date'] : date('Y-m-d', Settings::getBdLocalTime());
                        } else {
                            $purchase_date = $model->purchase_date;
                        }

                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name' => 'ProductStockEntries[purchase_date]',
                            'value' => $purchase_date,
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
                                'disabled' => $model->isNewRecord ? FALSE : TRUE
                            )
                        ));
                        ?>
                        <?php echo $form->error($model, 'purchase_date', array('class' => 'alert alert-danger')); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'due_payment_date ', array('class' => 'col-sm-4 control-label')); ?>
                    <div class="col-sm-7">
                        <?php
                        if ($model->isNewRecord || empty($model->due_payment_date) || $model->due_payment_date == '0000-00-00') {
                            $due_payment_date = (isset($ar_cart['due_payment_date']) && !empty($ar_cart['due_payment_date'])) ? $ar_cart['due_payment_date'] : date('Y-m-d', Settings::getBdLocalTime());
                        } else {
                            $due_payment_date = $model->purchase_date;
                        }

                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name' => 'ProductStockEntries[due_payment_date ]',
                            'value' => $due_payment_date,
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
                    <?php echo CHtml::label('Product Name', 'product_name', array('class' => 'col-sm-4 control-label', 'for' => 'product_details_id')); ?>

                    <?php
                    if ($model->isNewRecord || empty($model->purchaseCart->purchaseCartItems[0]->productDetails->product_name)) {
                        $product_name = (isset($ar_cart['product_name']) && !empty($ar_cart['product_name'])) ? $ar_cart['product_name'] : '';
                    } else {
                        $product_name = $model->purchaseCart->purchaseCartItems[0]->productDetails->product_name;
                    }

                    if (!$model->isNewRecord) {

                        $product_name .= '-';
                        if (empty($model->purchaseCart->purchaseCartItems[0]->productDetails->productColor[0]->color)) {
                            $product_name .= '';
                        } else {
                            $product_name .= $model->purchaseCart->purchaseCartItems[0]->productDetails->productColor[0]->color->name;
                        }

                        $product_name .= '-';
                        if (empty($model->purchaseCart->purchaseCartItems[0]->productDetails->productGrade[0]->grade)) {
                            $product_name .= '';
                        } else {
                            $product_name .= $model->purchaseCart->purchaseCartItems[0]->productDetails->productGrade[0]->grade->name;
                        }

                        $product_name .= '-';
                        if (empty($model->purchaseCart->purchaseCartItems[0]->productDetails->productSize[0]->size)) {
                            $product_name .= '';
                        } else {
                            $product_name .= $model->purchaseCart->purchaseCartItems[0]->productDetails->productSize[0]->size->name;
                        }
                        $product_name .= '-' . $model->purchaseCart->purchaseCartItems[0]->productDetails->supplier->supplier_name;
                    }

                    if ($model->isNewRecord || empty($model->purchaseCart->purchaseCartItems[0]->productDetails->id)) {
                        $product_details_id = (isset($ar_cart['product_details_id']) && !empty($ar_cart['product_details_id'])) ? $ar_cart['product_details_id'] : 0;
                    } else {
                        $product_details_id = $model->purchaseCart->purchaseCartItems[0]->productDetails->id;
                    }
                    ?>
                    <?php echo CHtml::hiddenField('product_details_id', $product_details_id, array('size' => 30)); ?>

                    <div class="col-sm-7">
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
                                        
                                        $('#n_cost').val(data.cost);
                                        $('#n_price').val(data.price);

                                    }).fail(function() {
                                        
                                    });

                            }",
                            ),
                            'htmlOptions' => array(
                                'size' => 28,
                                'id' => 'product_name',
                                'placeholder' => 'Type Product Name..',
                                'class' => 'form-control',
                                'disabled' => $model->isNewRecord ? FALSE : TRUE
                            )
                        ));
                        ?>
                        <div class="grade-list horizontal" style="display: none;">

                        </div>
                    </div>
                </div>

                <!--                <div class="form-group">
                <?php // echo $form->labelEx($model, 'ref_num', array('class' => 'col-sm-4 control-label', 'for' => 'ref_num'));     ?>
                                    <div class="col-sm-7">
                <?php
//                        echo CHtml::textField('ref_num', '', array(
//                            'size' => 12,
//                            'maxlength' => 12,
//                            'class' => 'form-control',
//                            'placeholder' => 'Reference Number',
//                        ));
                ?>
                                    </div>
                                </div>-->


                <div class="form-group">
                    <?php echo $form->labelEx($model, 'note', array('class' => 'col-sm-4 control-label')); ?>
                    <div class="col-sm-7">
                        <?php
                        if ($model->isNewRecord || empty($model->note)) {
                            $note = (isset($ar_cart['note']) && !empty($ar_cart['note'])) ? $ar_cart['note'] : '';
                        } else {
                            $note = $model->note;
                        }

                        echo $form->textArea($model, 'note', array(
                            'rows' => 3,
                            'class' => 'form-control',
                            'placeholder' => 'Note',
                            'value' => $note
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
                    <?php echo CHtml::label('Current Stock', 'stock', array('class' => 'col-sm-4 control-label')); ?>
                    <div class="col-sm-7">
                        <?php
                        if ($model->isNewRecord || empty($model->purchaseCart->purchaseCartItems[0]->productDetails->productStockAvails)) {
                            $stock = (isset($ar_cart['stock']) && !empty($ar_cart['stock'])) ? $ar_cart['stock'] : '';
                        } else {
                            $stock = $model->purchaseCart->purchaseCartItems[0]->productDetails->productStockAvails->quantity;
                        }

                        echo CHtml::textField('stock', $stock, array('class' => 'form-control',
                            'placeholder' => 'Current Stock',
                            'readonly' => TRUE,
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::label('Last Cost', 'cost', array('class' => 'col-sm-4 control-label')); ?>
                    <div class="col-sm-7">
                        <?php
                        if ($model->isNewRecord || empty($model->purchaseCart->purchaseCartItems[0]->productDetails->purchase_price)) {
                            $latest_cost = (isset($ar_cart['cost']) && !empty($ar_cart['cost'])) ? $ar_cart['cost'] : '';
                        } else {
                            $latest_cost = $model->purchaseCart->purchaseCartItems[0]->productDetails->purchase_price;
                        }

                        echo CHtml::textField('cost', $latest_cost, array(
                            'class' => 'form-control',
                            'placeholder' => 'Last Cost',
                            'readonly' => TRUE,
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::label('Last Price', 'price', array('class' => 'col-sm-4 control-label')); ?>
                    <div class="col-sm-7">
                        <?php
                        if ($model->isNewRecord || empty($model->purchaseCart->purchaseCartItems[0]->productDetails->selling_price)) {
                            $latest_price = (isset($ar_cart['price']) && !empty($ar_cart['price'])) ? $ar_cart['price'] : '';
                        } else {
                            $latest_price = $model->purchaseCart->purchaseCartItems[0]->productDetails->selling_price;
                        }

                        echo CHtml::textField('price', $latest_price, array(
                            'class' => 'form-control',
                            'placeholder' => 'Last Price',
                            'readonly' => TRUE,
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::label('New Cost', 'n_cost', array('class' => 'col-sm-4 control-label')); ?>
                    <div class="col-sm-7">
                        <?php
                        if ($model->isNewRecord || empty($model->purchaseCart->purchaseCartItems[0])) {
                            $newest_cost = (isset($ar_cart['n_cost']) && !empty($ar_cart['n_cost'])) ? $ar_cart['n_cost'] : '';
                        } else {
                            $newest_cost = $model->purchaseCart->purchaseCartItems[0]->cost;
                        }

                        echo CHtml::textField('n_cost', $newest_cost, array(
                            'class' => 'form-control',
                            'placeholder' => 'New Cost',
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::label('New Price', 'n_price', array('class' => 'col-sm-4 control-label')); ?>
                    <div class="col-sm-7">
                        <?php
                        if ($model->isNewRecord || empty($model->purchaseCart->purchaseCartItems[0])) {
                            $newest_price = (isset($ar_cart['n_price']) && !empty($ar_cart['n_price'])) ? $ar_cart['n_price'] : '';
                        } else {
                            $newest_price = $model->purchaseCart->purchaseCartItems[0]->price;
                        }

                        echo CHtml::textField('n_price', $newest_price, array(
                            'class' => 'form-control',
                            'placeholder' => 'New Price',
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::label('Quantity <span class="required">*</span>', 'quantity', array('class' => 'col-sm-4 control-label')); ?>
                    <div class="col-sm-7">
                        <?php
                        if ($model->isNewRecord || empty($model->purchaseCart->purchaseCartItems[0])) {
                            $quanity = (isset($ar_cart['quantity']) && !empty($ar_cart['quantity'])) ? $ar_cart['quantity'] : 0;
                        } else {
                            $quanity = $model->purchaseCart->purchaseCartItems[0]->quantity;
                        }

                        echo CHtml::textField('quantity', $quanity, array(
                            'class' => 'form-control',
                            'placeholder' => 'Quantity',
                            'required' => TRUE,
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::label('Total', 'total', array('class' => 'col-sm-4 control-label')); ?>
                    <div class="col-sm-7">
                        <?php
                        if ($model->isNewRecord || empty($model->purchaseCart->purchaseCartItems[0])) {
                            $sub_total = (isset($ar_cart['total']) && !empty($ar_cart['total'])) ? $ar_cart['total'] : 0.00;
                        } else {
                            $sub_total = $model->purchaseCart->purchaseCartItems[0]->sub_total;
                        }

                        echo CHtml::textField('total', $sub_total, array(
                            'class' => 'form-control',
                            'placeholder' => 'Total',
                            'readonly' => TRUE,
                            'required' => TRUE,
                        ));
                        ?>
                    </div>
                </div>

                <!--                <div class="form-group">
                <?php // echo $form->labelEx($model, 'payment_method', array('class' => 'col-sm-4 control-label'));     ?>
                                    <div class="col-sm-7">
                <?php
//                        echo $form->dropDownList($model, 'payment_method', Settings::$_payment_types, array(
//                            'style' => 'width: 100%;',
//                            'class' => 'select2'
//                        ));
                ?>
                                    </div>
                                </div>-->


            </div>

        </div>

    </div>

    <div class="form-group col-lg-12 pull-right">
        <div class="col-sm-12">
            <?php
            echo CHtml::submitButton($model->isNewRecord ? 'Purchase' : 'Update', array(
                'id' => 'btn-submit',
                'class' => 'btn btn-info pull-right'
            ));
            ?>
        </div>
    </div>

</div>

<div class="clearfix"></div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(document).ready(function () {

<?php if ($model->isNewRecord) { ?>
            $('#total').val(0.00);
<?php } ?>

        $(".select2").select2({
            minimumResultsForSearch: Infinity
        });

        $(document).off('keyup', '#quantity').on('keyup', '#quantity', function () {

            var qty = parseInt($(this).val());

            if (isNaN(qty)) {
                $('#total').val(0.00);
                return false;
            }

            var price = $('#n_cost').val();
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