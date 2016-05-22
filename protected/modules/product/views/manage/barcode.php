<div class="col-sm-12">

    <div class="box box-info">

        <div class="box-header">
            <a id="barcode_file_list" class="btn btn-info pull-right" href="javascript:void(0);">Export PDF</a>
        </div>

        <div class="box-body panel panel-body">

            <div class="note">
                *** 100 barcode will be generated at each execution. Once barcode is generated then it will be removed from the list.
            </div>

            <div class="clearfix"></div>

            <div class="form-group col-sm-8">
                <?php
                $this->renderPartial('_barcode_partial', array(
                    'purchaseRecords' => $purchaseRecords,
                    'barcode' => $barcode,
                    'generator' => $generator,
                ));
                ?>
            </div>

            <div class="form-group col-sm-4" id="file_list" style="display: none;"></div>

        </div>

    </div>

</div>

<div class="clearfix"></div>

<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

<script type="text/javascript">
    $(document).ready(function () {

        $(document).on('click', '#barcode_file_list', function () {
            $.ajax({
                url: '/product/manage/barcodeFileList',
                type: 'post',
                dataType: 'json',
                data: {data: 'bulk'},
                success: function (response) {
                    $('#file_list').html('');
                    var html_f_list = '';
                    response.forEach(function (v) {
//                        html_f_list += '<a href="/product/manage/downloadBarcode?barcode=' + v + '">' + v + '</a><br />';
                        html_f_list += '<a href="' + v.url + '">' + v.name + '</a><br />';
                    });
                    $('#file_list').html(html_f_list);
                    $('#file_list').show();
                },
                error: function (e) {
                    console.log(e);
                }
            });
        });

    });
</script>