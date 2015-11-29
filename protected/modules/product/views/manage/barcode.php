<div class="col-lg-12">

    <div class="box box-info">

        <div class="box-body panel panel-body">

            <div class="note">
                *** 100 barcode will be generated at each execution. Once barcode is generated then it will be removed from the list.
            </div>

            <div class="clearfix"></div>

            <div class="form-group col-lg-12">
                <?php $this->renderPartial('_barcode_partial', array('purchaseRecords' => $purchaseRecords, 'pdf' => $pdf, 'barcode' => $barcode,)); ?>
            </div>

            <div class="clearfix"></div>
            
            <div class="form-group col-lg-12" id="file_list" style="display: none;">
                
            </div>

        </div>

    </div>

</div>

<div class="box-footer">
    <a id="barcode_file_list" class="btn btn-info pull-right" href="javascript:void(0);">Export PDF</a>
</div>

<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

<script type="text/javascript">
    $(document).ready(function () {

        $(document).on('click', '#barcode_file_list', function () {
            $.ajax({
                url: '/product/manage/barcodeFileList',
                type: 'post',
                dataType: 'json',
                data: {data: 'data'},
                success: function (response) {
                    $('#file_list').html('');
                    var html_f_list = '';
                    response.forEach(function (v) {
                        html_f_list += '<a href="/product/manage/downloadBarcode?barcode=' + v + '">' + v + '</a><br />';
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