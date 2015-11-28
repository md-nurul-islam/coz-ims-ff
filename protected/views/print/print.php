<div class="print" style="display: none;">

    <style type="text/css">
        .print-wrapper table {
            font-family: Helvetica;
            font-size: 12px;
            width: 100%;
        }
        .print-wrapper table td, table th {
            border: 1px solid #ccc;
            border-spacing: 0;
        }
        .head{
            margin-left: auto;
            margin-right: auto;
            width: 50%;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
        }
        .bill-table{
            width: 100%;
        }
        .bill-print{
            border: 1px solid #000;
        }
        .bill-print thead th{
            background: transparent;
        }
        .td-top-border-1px{
            border-top: 1px solid #000;
        }
        .text-align-left{
            text-align: left;
        }
        .text-align-center{
            text-align: center;
        }
        .text-right-align{
            text-align: right;
        }
        .bold-font{
            font-weight: bold;
        }
        .clearfix {
            clear: both;
        }
        .store-name {
            font-size: 13px;
            font-weight: bold;
            padding: 5px 0;
            text-align: center;
        }
        .store-address {
            font-size: 12px;
            margin-bottom: 15px;
            text-align: center;
        }
        .bill-date, .bill-number {
            float: right;
            font-size: 12px;
            margin-bottom: 2px;
        }
        .bill-number {
            margin-bottom: 8px;
        }
    </style>

    <div class="print-wrapper" style="
         margin-left: auto;
         margin-right: auto;
         width: 300px;
         float: left;
         border: 1px solid #000000;
         ">

        <div class="store-name">
            <?php echo CHtml::encode(Yii::app()->user->storeName); ?>
        </div>

        <div class="clearfix"></div>

        <div class="store-address">
            <?php echo CHtml::encode(Yii::app()->user->storeAddress); ?>
        </div>

        <div class="bill-date">
            Date: <span></span>
        </div>

        <div class="clearfix"></div>

        <div class="bill-number">
            Number: <span></span>
        </div>

    </div>


</div>

<div class="print-btn" style="display: none;">
    <button type="button" id="btn-print">Print</button>
</div>

<style type="text/css">
    .print-btn{
        text-align: center;
        width: 100%;
    }
</style>