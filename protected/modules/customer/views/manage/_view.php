<div class="col-lg-12 view">
    <div class="box box-info">
        <div class="box-body">

            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">
                    <?php echo CHtml::hiddenField('customer_details_id', $data->id); ?>
                    <h4><b><?php echo CHtml::encode($data->customer_name); ?></b></h4>
                </div>

                <div class="panel-body">
                    <ul class="list-group">

                        <li class="list-group-item clearfix">
                            <div class="label-wrapper border-right">
                                <?php echo CHtml::label(CHtml::encode($data->getAttributeLabel('customer_address')), ''); ?>
                            </div>
                            <div class="info-wrapper">
                                <?php echo CHtml::encode($data->customer_address); ?>
                            </div>
                        </li>

                        <li class="list-group-item clearfix">
                            <div class="label-wrapper border-right">
                                <?php echo CHtml::label(CHtml::encode($data->getAttributeLabel('customer_contact1')), ''); ?>
                            </div>
                            <div class="info-wrapper">
                                <?php echo CHtml::encode($data->customer_contact1); ?>
                            </div>
                        </li>

                        <li class="list-group-item clearfix">
                            <div class="label-wrapper border-right">
                                <?php echo CHtml::label(CHtml::encode($data->getAttributeLabel('customer_contact2')), ''); ?>
                            </div>
                            <div class="info-wrapper">
                                <?php echo CHtml::encode($data->customer_contact2); ?>
                            </div>
                        </li>
                        <li class="list-group-item clearfix">
                            <div class="label-wrapper border-right">
                                <?php echo CHtml::label(CHtml::encode($data->getAttributeLabel('status')), ''); ?>
                            </div>
                            <div class="info-wrapper" style="padding-bottom: 5px; padding-top: 6px;">
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

            </div>

        </div>

    </div>

    <div class="box box-info">

        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">
                <h4 class="text-bold text-green">Latest 10 Sale</h4>
            </div>

            <div class="panel-body">
                <?php $this->renderPartial('_sale_data_table', array('sales' => $sales,)); ?>
            </div>


        </div>

    </div>
    
</div>
