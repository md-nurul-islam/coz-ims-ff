<div class="form-group">
    
    <?php var_dump($data); exit;?>

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