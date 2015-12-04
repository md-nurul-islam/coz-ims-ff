<div class="col-lg-12">

    <div class="box box-info">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'supplier-details-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
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
            
            <div class="form-group">
                <?php echo $form->labelEx($model, 'supplier_name', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo $form->textField($model, 'supplier_name', array(
                        'size' => 60,
                        'maxlength' => 255,
                        'placeholder' => 'Supplier Name',
                        'class' => 'form-control',
                    ));
                    ?>
                    <?php echo $form->error($model, 'supplier_name', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'supplier_address', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo $form->textArea($model, 'supplier_address', array(
                        'rows' => 6,
                        'cols' => 45,
                        'placeholder' => 'Supplier Address',
                        'class' => 'form-control',
                    ));
                    ?>
                    <?php echo $form->error($model, 'supplier_address', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'supplier_contact1', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo $form->textField($model, 'supplier_contact1', array(
                        'size' => 60,
                        'maxlength' => 100,
                        'placeholder' => 'Supplier Contact 1',
                        'class' => 'form-control',
                    ));
                    ?>
                    <?php echo $form->error($model, 'supplier_contact1', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'supplier_contact2', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo $form->textField($model, 'supplier_contact2', array(
                        'size' => 60,
                        'maxlength' => 100,
                        'placeholder' => 'Supplier Contact 2',
                        'class' => 'form-control',
                    ));
                    ?>
                    <?php echo $form->error($model, 'supplier_contact2', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>

            <?php if ($show_balance) { ?>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'balance', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-10">
                        <?php
                        echo $form->textField($model, 'balance', array(
                            'size' => 60,
                            'maxlength' => 100,
                            'placeholder' => 'Balance',
                            'class' => 'form-control',
                            'readonly' => true
                        ));
                        ?>
                        <?php echo $form->error($model, 'balance', array('class' => 'alert alert-danger')); ?>
                    </div>
                </div>
            <?php } ?>


        </div><!-- /.box-body -->

        <div class="box-footer">
            <?php echo CHtml::submitButton(($model->isNewRecord) ? 'Add' : 'Update', array('id' => 'btn-submit', 'class' => 'btn btn-info pull-right')); ?>
        </div><!-- /.box-footer -->

        <?php $this->endWidget(); ?>

    </div><!-- /.box -->

</div>