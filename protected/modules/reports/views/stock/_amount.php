
<div class="text-center col-sm-12">
    <h3 class="text-aqua">Amount Of Money As Stock</h3>
</div>

<div class="text-center col-sm-12">
    <h5 class="text-red">*** The calculated figure is based on last purchase price / cost, so the actual amount may vary from the below figure.</h5>
</div>

<legend></legend>

<div class="report_table">

    <table class="table table-bordered table-striped table-hover table-condensed">

        <thead>
            <tr>
                <th class="text-center">Total Amount In Stock</th>
                <th class="text-center">Total Stock</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="text-center">
                    <?php // var_dump($model); exit;?>
                    <?php echo number_format($model['total_amount'], 2);?>
                </td>
                <td class="text-center"><?php echo $model['total_quantity'];?></td>
            </tr>
        </tbody>

    </table>

</div>

<!--<div class="clearfix"></div>-->