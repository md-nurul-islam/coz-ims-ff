<div class="col-lg-12">

    <div class="box box-info">

        <div class="box-body">

            <div class="wide form">

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

                <div class="form-group">
                    <?php echo CHtml::label('From Date', 'from_date', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-9">
                        <?php
                        if ($advance_sale_list) {
                            $today = date('Y-m-d', strtotime($today . '+1 day'));
                        }

                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name' => 'from_date',
                            'value' => (isset($from_date) && !empty($from_date)) ? $from_date : $today,
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
                                'style' => 'cursor: pointer;',
                                'readonly' => true,
                                'class' => 'form-control'
                            ),
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::label('To Date', 'to_date', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-9">
                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name' => 'to_date',
                            'value' => (isset($to_date) && !empty($to_date)) ? $to_date : $today,
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
                                'style' => 'cursor: pointer;',
                                'readonly' => true,
                                'class' => 'form-control'
                            ),
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-11">
                        <?php echo CHtml::submitButton('Generate', array('id' => 'btn-submit', 'class' => 'btn btn-success btn-flat pull-right')); ?>
                    </div>
                </div>

                <?php $this->endWidget(); ?>

            </div>

        </div>
    </div>
</div>

<?php if ($model) { ?>
    <?php
    $this->renderPartial('_data_table', array(
        'model' => $model,
        'msg' => $msg,
        'advance_sale_list' => FALSE,
        'today' => $today,
        'from_date' => $from_date,
        'to_date' => $to_date,));
    ?>
<?php } else if (!empty($msg)) { ?>

    <div class="col-lg-12">

        <div class="box box-info">

            <div class="box-body">

                <div class="center col-lg-6">
                    <h3 class="text-danger text-center"><?php echo $msg; ?></h3>
                </div>
            </div>
        </div>
    </div>

<?php } ?>