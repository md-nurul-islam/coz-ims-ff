<div class="col-lg-12">

    <div class="box box-info">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'product-stock-avail-update_stock-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // See class documentation of CActiveForm for details on this,
            // you need to use the performAjaxValidation()-method described there.
            'enableAjaxValidation' => true,
            'htmlOptions' => array(
                'class' => 'form-horizontal',
            ),
        ));
        ?>
        <div class="box-body">

            <?php echo $form->errorSummary($model); ?>

            <div class="form-group">
                <div class="col-sm-10">
                    <label>Fields with <span class="required">*</span> are required.</label>
                </div>
            </div>

            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="successMessage">
                    <?php echo Yii::app()->user->getFlash('success'); ?>
                </div>
            <?php endif; ?>


            <div class="form-group">
                <?php echo $form->labelEx($model, 'product_details_id', array('class' => 'col-sm-2 control-label')); ?>
                <?php echo $form->hiddenField($model, 'product_details_id'); ?>
                <div class="col-sm-10">
                    <?php echo CHtml::textField('product_name', $model->productDetails->product_name, array(
                        'readonly' => true,
                        'placeholder' => 'Product Name',
                        'class' => 'form-control',
                    ));
                    ?>
                    <?php echo $form->error($model, 'product_details_id', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'quantity', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php echo $form->textField($model, 'quantity', array(
                        'placeholder' => 'Selling Price',
                        'class' => 'form-control',
                    ));
                    ?>
                    <?php echo $form->error($model, 'quantity', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>


            <div class="box-footer">
                <?php echo CHtml::submitButton('Update', array('id' => 'btn-submit', 'class' => 'btn btn-info pull-right')); ?>
            </div>

        </div>

        <?php $this->endWidget(); ?>

    </div>

</div><!-- form -->