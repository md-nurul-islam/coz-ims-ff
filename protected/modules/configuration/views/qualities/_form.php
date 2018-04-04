<div class="col-lg-12">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'quality-details-form',
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

    <?php if (Yii::app()->user->hasFlash('success')) { ?>
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php } ?>

    <div class="box box-info">

        <div class="box-body">

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
                        'maxlength' => 120,
                        'placeholder' => 'Quality Name',
                        'class' => 'form-control',
                    ));
                    ?>
                    <?php echo $form->error($model, 'name', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>

            <?php if (!empty($model->id)) { ?>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'code', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-10">
                        <?php
                        echo $form->textField($model, 'code', array(
                            'size' => 60,
                            'maxlength' => 120,
                            'placeholder' => 'Quality Code',
                            'class' => 'form-control',
                            'readonly' => TRUE
                        ));
                        ?>
                        <?php echo $form->error($model, 'code', array('class' => 'alert alert-danger')); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php
                    $data = array('0' => 'Inactive', '1' => 'Active');
                    ?>
                    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-10">
                        <?php
                        echo $form->dropDownList($model, 'status', $data, array(
                            'class' => 'select2',
                            'style' => 'width: 100%;'
                        ));
                        ?>
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

<script type="text/javascript">
    $(document).ready(function () {
        $(".select2").select2({
            minimumResultsForSearch: Infinity
        });
    });
</script>