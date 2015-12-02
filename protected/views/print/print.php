<div class="print" style="display: none;">

    <style type="text/css">
        .print-wrapper table {
            font-family: Helvetica;
            font-size: 14px;
            width: 100%;
        }
        .print-wrapper table td, .print-wrapper table th {
            border: 1px solid #ccc;
            border-spacing: 0;
        }
        .print-wrapper table td:not(:first-child), .print-wrapper table th:not(:first-child) {
            text-align: center;
        }
         .print-wrapper table th:first-child {
            text-align: left;
        }
        .clearfix {
            clear: both;
        }
        .store-name {
            font-size: 16px;
            font-weight: bold;
            padding: 5px 0;
            text-align: center;
        }
        .store-address {
            font-size: 14px;
            margin-bottom: 15px;
            text-align: center;
        }
        .bill-date, .bill-number {
            float: right;
            font-size: 14px;
            margin-bottom: 2px;
        }
        .bill-number {
            margin-bottom: 8px;
        }
        .vat_cell, .discount_cell {
            border-right: 0 none !important;
        }
        .vat_cell_val, .discount_cell_val {
            border-left: 0 none !important;
        }
    </style>

    <div class="print-wrapper" style="
         margin-left: auto;
         margin-right: auto;
         width: 350px;
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