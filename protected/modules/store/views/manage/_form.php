<div class="col-lg-12">

    <div class="box box-info">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'store-details-form',
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
                <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo $form->textField($model, 'name', array(
                        'size' => 60,
                        'maxlength' => 100,
                        'placeholder' => 'Store Name',
                        'class' => 'form-control',
                    ));
                    ?>
                    <?php echo $form->error($model, 'name', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo $form->textField($model, 'address', array(
                        'size' => 60,
                        'maxlength' => 100,
                        'placeholder' => 'Store Address',
                        'class' => 'form-control',
                    ));
                    ?>
                    <?php echo $form->error($model, 'address', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'place', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo $form->textField($model, 'place', array(
                        'size' => 60,
                        'maxlength' => 100,
                        'placeholder' => 'Store Place',
                        'class' => 'form-control',
                    ));
                    ?>
                    <?php echo $form->error($model, 'place', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'city', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo $form->textField($model, 'city', array(
                        'size' => 60,
                        'maxlength' => 100,
                        'placeholder' => 'Store City',
                        'class' => 'form-control',
                    ));
                    ?>
                    <?php echo $form->error($model, 'city', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>

            <?php
            foreach (Settings::$_bill_header_and_footer_config_keys as $key => $value) {
                if (isset($model_config_data[$key]['id']) && !empty($model_config_data[$key]['id'])) {

                    echo $form->hiddenField($model_config, 'value[' . $key . '][id]', array(
                        'value' => $model_config_data[$key]['id']
                    ));
                }
                ?>

                <div class="form-group">
                    <?php echo CHtml::label('Bill ' . ucfirst($key), get_class($model_config) . '_value_header', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-10">
                        <?php
                        echo $form->textArea($model_config, 'value[' . $key . '][value]', array(
                            'size' => 60,
                            'maxlength' => 100,
                            'placeholder' => 'Bill ' . ucfirst($key),
                            'class' => 'form-control',
                            'value' => ( isset($model_config_data[$key]['value']) ) ? $model_config_data[$key]['value'] : ''
                        ));
                        ?>
                    </div>
                </div>

            <?php } ?>

            <div class="box-footer">
                <?php echo CHtml::submitButton(($model->isNewRecord) ? 'Add' : 'Update', array('id' => 'btn-submit', 'class' => 'btn btn-success btn-flat pull-right')); ?>
            </div>

        </div>

        <?php $this->endWidget(); ?>

    </div>

</div><!-- form -->