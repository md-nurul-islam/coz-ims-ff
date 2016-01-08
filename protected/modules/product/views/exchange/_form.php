<div class="row">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'product-stock-exchange-form',
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

        <div class="col-lg-6">
            <div class="box box-info">
                <div class="box-body">
                    
                    <div class="form-group">
                        <?php echo $form->labelEx($sale_model, 'billnumber', array('class' => 'col-sm-3 control-label')); ?>
                        <div class="col-sm-8">
                            <?php
                            echo $form->textField($sale_model, 'billnumber', array(
                                'size' => 20,
                                'maxlength' => 120,
                                'class' => 'form-control',
                                'placeholder' => 'Billnumber',
                            ));
                            ?>
                            <?php echo $form->error($sale_model, 'billnumber', array('class' => 'alert alert-danger')); ?>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>
    <?php $this->endWidget(); ?>
</div>