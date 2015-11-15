<div class="col-lg-12">

    <div class="box box-info">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'category-details-form',
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
                <?php echo $form->labelEx($model, 'category_name', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo $form->textField($model, 'category_name', array(
                        'size' => 60,
                        'maxlength' => 120,
                        'placeholder' => 'Category Name',
                        'class' => 'form-control',
                    ));
                    ?>
                    <?php echo $form->error($model, 'category_name', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'category_description', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo $form->textArea($model, 'category_description', array(
                        'size' => 60,
                        'rows' => 5,
                        'cols' => 45,
                        'maxlength' => 250,
                        'placeholder' => 'Category Description',
                        'class' => 'form-control',
                    ));
                    ?>
                    <?php echo $form->error($model, 'category_description', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>

            <div class="box-footer">
                <?php echo CHtml::submitButton(($model->isNewRecord) ? 'Add' : 'Update', array('id' => 'btn-submit', 'class' => 'btn btn-info pull-right')); ?>
            </div>

        </div>

        <?php $this->endWidget(); ?>

    </div>

</div><!-- form -->