<div class="col-lg-12 view">
    <div class="box box-info">
        <div class="box-body">

            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">
                    <h4><b><?php echo CHtml::encode($data->product_name); ?></b></h4>
                </div>

                <div class="panel-body">

                    <ul class="list-group">
                        <li class="list-group-item clearfix">
                            <div class="label-wrapper border-right">
                                <?php echo CHtml::label(CHtml::encode($data->getAttributeLabel('category_id')), ''); ?>
                            </div>
                            <div class="info-wrapper">
                                <?php echo CHtml::encode($data->category->category_name); ?>
                            </div>
                        </li>
                        <li class="list-group-item clearfix">
                            <div class="label-wrapper border-right">
                                <?php echo CHtml::label(CHtml::encode($data->getAttributeLabel('supplier_id')), ''); ?>
                            </div>
                            <div class="info-wrapper">
                                <?php echo CHtml::encode($data->supplier->supplier_name); ?>
                            </div>
                        </li>
                        <li class="list-group-item clearfix">
                            <div class="label-wrapper border-right">
                                <?php echo CHtml::label(CHtml::encode('Color'), ''); ?>
                            </div>
                            <div class="info-wrapper">
                                <?php
                                $color = 'N/A';
                                if (!empty($data->productColor[0]->color)) {
                                    $color = $data->productColor[0]->color->name;
                                }
                                echo CHtml::encode($color);
                                ?>
                            </div>
                        </li>
                        <li class="list-group-item clearfix">
                            <div class="label-wrapper border-right">
                                <?php echo CHtml::label(CHtml::encode('Size'), ''); ?>
                            </div>
                            <div class="info-wrapper">
                                <?php
                                $size = 'N/A';
                                if (!empty($data->productSize[0]->size)) {
                                    $size = $data->productSize[0]->size->name;
                                }
                                echo CHtml::encode($size);
                                ?>
                            </div>
                        </li>
                        <li class="list-group-item clearfix">
                            <div class="label-wrapper border-right">
                                <?php echo CHtml::label(CHtml::encode('Quality'), ''); ?>
                            </div>
                            <div class="info-wrapper">
                                <?php
                                $grade = 'N/A';
                                if (!empty($data->productGrade[0]->grade)) {
                                    $grade = $data->productGrade[0]->grade->name;
                                }
                                echo CHtml::encode($grade);
                                ?>
                            </div>
                        </li>
                        <li class="list-group-item clearfix">
                            <div class="label-wrapper border-right">
                                <?php echo CHtml::label(CHtml::encode($data->getAttributeLabel('purchase_price')), ''); ?>
                            </div>
                            <div class="info-wrapper">
                                <?php echo CHtml::encode($data->purchase_price); ?>
                            </div>
                        </li>
                        <li class="list-group-item clearfix">
                            <div class="label-wrapper border-right">
                                <?php echo CHtml::label(CHtml::encode($data->getAttributeLabel('selling_price')), ''); ?>
                            </div>
                            <div class="info-wrapper">
                                <?php echo CHtml::encode($data->selling_price); ?>
                            </div>
                        </li>
                        <li class="list-group-item clearfix">
                            <div class="label-wrapper border-right">
                                <?php echo CHtml::label(CHtml::encode($data->getAttributeLabel('status')), ''); ?>
                            </div>
                            <div class="info-wrapper">
                                <?php
                                $str_class = 'btn btn-danger';
                                $status = 0;
                                if ($data->status == 1) {
                                    $str_class = 'btn btn-success';
                                    $status = $data->status;
                                }
                                ?>
                                <button type="button" class="<?php echo $str_class; ?>">
                                    <?php echo CHtml::encode(Settings::$_default_status[$status]); ?>
                                </button>
                            </div>
                        </li>
                    </ul>

                </div>

                <div class="panel-footer pull-right">
                    <?php echo CHtml::button('Get Barcode', array('id' => 'gen-barcode', 'class' => 'btn btn-info')); ?>
                </div>

            </div>

        </div>
    </div>
</div>

<?php $this->renderPartial('//modals/_item_barcode'); ?>