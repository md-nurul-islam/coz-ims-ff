<div class="col-lg-12">

    <div class="box box-info">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'product-details-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation' => false,
            'htmlOptions' => array(
                'class' => 'form-horizontal',
            ),
        ));
        ?>

        <div class="box-body">

            <div class="form-group">
                <div class="col-sm-10">
                    <label>Fields with <span class="required">*</span> are required.</label>
                </div>
            </div>


            <div class="form-group">
                <?php echo $form->labelEx($model, 'category_id', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php echo $form->hiddenField($model, 'category_id'); ?>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'name' => 'category_name',
                        'value' => $category_name,
                        'source' => $this->createUrl('category/autocomplete'),
                        'options' =>
                        array(
                            'minLength' => '3',
                            'showAnim' => 'fold',
                            'select' => "js:function(event, data) {
                            $('#ProductDetails_category_id').val(data.item.id);
                        }",
                        ),
                        'htmlOptions' => array(
                            'style' => 'height:34px;',
                            'size' => 60,
                            'placeholder' => 'Type Category Name..',
                            'class' => 'form-control',
                        ),
                    ));
                    ?>
                    <?php echo $form->error($model, 'category_id', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'supplier_id', array('class' => 'col-sm-2 control-label')); ?>
                <?php echo $form->hiddenField($model, 'supplier_id'); ?>
                <div class="col-sm-10">
                    <?php
                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'name' => 'supplier_name',
                        'value' => $supplier_name,
                        'source' => $this->createUrl('/supplier/manage/autocomplete'),
                        'options' =>
                        array(
                            'minLength' => 'a',
                            'showAnim' => 'fold',
                            'select' => "js:function(event, data) {
                            $('#ProductDetails_supplier_id').val(data.item.id);
                        }",
                        ),
                        'htmlOptions' => array(
                            'style' => 'height:34px;',
                            'size' => 60,
                            'placeholder' => 'Type Supplier Name..',
                            'class' => 'form-control',
                        ),
                    ));
                    ?>
                    <?php echo $form->error($model, 'supplier_id', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'product_name', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo $form->textField($model, 'product_name', array(
                        'size' => 60,
                        'maxlength' => 255,
                        'class' => 'form-control',
                        'placeholder' => 'Product Name',
                    ));
                    ?>
                    <?php echo $form->error($model, 'product_name', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>

            <div class="form-group">

                <?php echo CHtml::label('Available Qualities', '', array('class' => 'col-sm-2 control-label')); ?>

                <div class="col-sm-10">
                    <ul class="list-inline">
                        <?php foreach ($grades as $grade) { ?>
                            <li>
                                <?php
                                $checked = FALSE;
                                if (isset($ar_product_id)) {
                                    if (in_array($grade->id, $ar_product_id)) {
                                        $checked = TRUE;
                                    }
                                }
                                ?>
                                <?php
                                echo CHtml::radioButton('ProductGrade[grade_id]', $checked, array(
                                    'value' => $grade->id,
                                    'id' => strtolower($grade->name),
                                    'class' => 'flat-red'
                                ));
                                ?>
                                <?php echo CHtml::label($grade->name, strtolower($grade->name), array('class' => 'control-label')); ?>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

            </div>

            <div class="form-group">

                <?php echo CHtml::label('Available Sizes', '', array('class' => 'col-sm-2 control-label')); ?>

                <div class="col-sm-10">
                    <ul class="list-inline">
                        <?php foreach ($sizes as $size) { ?>
                            <li>
                                <?php
                                $checked = FALSE;
                                if (isset($ar_product_id)) {
                                    if (in_array($size->id, $ar_product_id)) {
                                        $checked = TRUE;
                                    }
                                }
                                ?>
                                <?php
                                echo CHtml::radioButton('ProductSize[size_id]', $checked, array(
                                    'value' => $size->id,
                                    'id' => strtolower($size->name),
                                    'class' => 'flat-red'
                                ));
                                ?>
                                <?php echo CHtml::label($size->name, strtolower($size->name), array('class' => 'control-label')); ?>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

            </div>

            <div class="form-group">

                <?php echo CHtml::label('Available Colors', '', array('class' => 'col-sm-2 control-label')); ?>

                <div class="col-sm-10">
                    <ul class="list-inline">
                        <?php foreach ($colors as $color) { ?>
                            <li>
                                <?php
                                $checked = FALSE;
                                if (isset($ar_product_id)) {
                                    if (in_array($colors->id, $ar_product_id)) {
                                        $checked = TRUE;
                                    }
                                }
                                ?>
                                <?php
                                echo CHtml::radioButton('ProductColor[color_id]', $checked, array(
                                    'value' => $color->id,
                                    'id' => strtolower($color->name),
                                    'class' => 'flat-red'
                                ));
                                ?>
                                <?php echo CHtml::label($color->name, strtolower($color->name), array('class' => 'control-label')); ?>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

            </div>

            <?php if (!$model->isNewRecord) { ?>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'purchase_price', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-10">
                        <?php
                        echo $form->textField($model, 'purchase_price', array(
                            'size' => 10,
                            'maxlength' => 10,
                            'class' => 'form-control',
                            'placeholder' => 'Purchase Price',
                        ));
                        ?>
                        <?php echo $form->error($model, 'purchase_price', array('class' => 'alert alert-danger')); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'selling_price', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-10">
                        <?php
                        echo $form->textField($model, 'selling_price', array(
                            'size' => 10,
                            'maxlength' => 10,
                            'placeholder' => 'Selling Price',
                            'class' => 'form-control',
                        ));
                        ?>
                        <?php echo $form->error($model, 'selling_price', array('class' => 'alert alert-danger')); ?>
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
                        <?php echo $form->error($model, 'status', array('class' => 'alert alert-danger')); ?>
                    </div>
                </div>
            <?php } ?>

            <div class="box-footer">
                <?php echo CHtml::submitButton(($model->isNewRecord) ? 'Add' : 'Update', array('id' => 'btn-submit', 'class' => 'btn btn-info pull-right')); ?>
            </div>

        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>

<div class="clearfix"></div>

<script type="text/javascript">
    $(document).ready(function () {
        $(".select2").select2({
            minimumResultsForSearch: Infinity
        });
    });
</script>