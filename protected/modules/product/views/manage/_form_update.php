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
                    <?php echo CHtml::hiddenField('product_details_id', $model['id']); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo CHtml::label('Category Name', 'category_name', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php echo CHtml::hiddenField('category_id', $model['category_id']); ?>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'name' => 'category_name',
                        'value' => $model['category_name'],
                        'source' => $this->createUrl('category/autocomplete'),
                        'options' =>
                        array(
                            'minLength' => '3',
                            'showAnim' => 'fold',
                            'select' => "js:function(event, data) {
                            $('#category_id').val(data.item.id);
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
                </div>
            </div>

            <div class="form-group">
                <?php echo CHtml::label('Supplier Name', 'supplier_name', array('class' => 'col-sm-2 control-label')); ?>
                <?php echo CHtml::hiddenField('supplier_id', $model['supplier_id']); ?>
                <div class="col-sm-10">
                    <?php
                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'name' => 'supplier_name',
                        'value' => $model['supplier_name'],
                        'source' => $this->createUrl('/supplier/manage/autocomplete'),
                        'options' =>
                        array(
                            'minLength' => 'a',
                            'showAnim' => 'fold',
                            'select' => "js:function(event, data) {
                            $('#supplier_id').val(data.item.id);
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
                </div>
            </div>

            <div class="form-group">
                <?php echo CHtml::label('Product Name', 'product_name', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo CHtml::textField('product_name', $model['product_name'], array(
                        'size' => 60,
                        'maxlength' => 255,
                        'class' => 'form-control',
                        'placeholder' => 'Product Name',
                    ));
                    ?>
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
                                if ($model['grade_id'] == $grade->id) {
                                    $checked = TRUE;
                                }
                                ?>
                                <?php
                                echo CHtml::radioButton('grade_id', $checked, array(
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
                                if ($model['size_id'] == $size->id) {
                                    $checked = TRUE;
                                }
                                ?>
                                <?php
                                echo CHtml::radioButton('size_id', $checked, array(
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
                                if ($model['color_id'] == $color->id) {
                                    $checked = TRUE;
                                }
                                ?>
                                <?php
                                echo CHtml::radioButton('color_id', $checked, array(
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

            <div class="form-group">
                <?php echo CHtml::label('Purchase Price', 'purchase_price', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo CHtml::textField('purchase_price', $model['purchase_price'], array(
                        'size' => 10,
                        'maxlength' => 10,
                        'class' => 'form-control',
                        'placeholder' => 'Purchase Price',
                        'readonly' => TRUE,
                    ));
                    ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo CHtml::label('Selling Price', 'selling_price', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo CHtml::textField('selling_price', $model['selling_price'], array(
                        'size' => 10,
                        'maxlength' => 10,
                        'placeholder' => 'Selling Price',
                        'class' => 'form-control',
                        'readonly' => TRUE,
                    ));
                    ?>
                </div>
            </div>
            
            <?php if (!Yii::app()->user->isSuperAdmin) { ?>
                <div class="form-group">
                    <?php echo CHtml::label('Available Stock', 'available_stock', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-10">
                        <?php
                        echo CHtml::textField('available_stock', $model['quantity'], array(
                            'size' => 10,
                            'maxlength' => 10,
                            'class' => 'form-control',
                            'placeholder' => 'Available Stock',
                        ));
                        ?>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <?php
                $data = array('0' => 'Inactive', '1' => 'Active');
                ?>
                <?php echo CHtml::label('status', 'status', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo CHtml::dropDownList('status', $model['status'], $data, array(
                        'class' => 'select2',
                        'style' => 'width: 100%;'
                    ));
                    ?>
                </div>
            </div>

            <div class="box-footer">
                <?php echo CHtml::submitButton('Update', array('id' => 'btn-submit', 'class' => 'btn btn-info pull-right')); ?>
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