<div class="col-lg-12 view">
    <div class="box box-info">
        <div class="box-body">

            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">
                    <?php echo CHtml::hiddenField('product_details_id', $data->id); ?>
                    <?php // echo CHtml::hiddenField('current_stock', $data->productStockAvails->quantity); ?>
                    <h4><b><?php echo CHtml::encode($data->billnumber); ?></b></h4>
                </div>

                <div class="panel-body">

                    <ul class="list-group">
                        
                        <li class="list-group-item clearfix">
                            <div class="label-wrapper border-right">
                                <?php echo CHtml::label(CHtml::encode($data->getAttributeLabel('purchase_date')), ''); ?>
                            </div>
                            <div class="info-wrapper">
                                <?php echo CHtml::encode($data->purchase_date); ?>
                            </div>
                        </li>
                        
                        <li class="list-group-item clearfix">
                            <div class="label-wrapper border-right">
                                <?php echo CHtml::label(CHtml::encode($data->getAttributeLabel('due_payment_date')), ''); ?>
                            </div>
                            <div class="info-wrapper">
                                <?php
                                $color = 'N/A';
//                                if (!empty($data->productColor[0]->color)) {
//                                    $color = $data->productColor[0]->color->name;
//                                }
                                echo CHtml::encode($color);
                                ?>
                            </div>
                        </li>
                        
                        <li class="list-group-item clearfix">
                            <div class="label-wrapper border-right">
                                <?php echo CHtml::label(CHtml::encode($data->getAttributeLabel('payment_method')), ''); ?>
                            </div>
                            <div class="info-wrapper">
                                <?php
                                $size = 'N/A';
//                                if (!empty($data->productSize[0]->size)) {
//                                    $size = $data->productSize[0]->size->name;
//                                }
                                echo CHtml::encode($size);
                                ?>
                            </div>
                        </li>
                        
                    </ul>

                    <div class="clearfix"></div>


                </div>


            </div>

        </div>
    </div>



</div>
                    <div class="clearfix"></div>
