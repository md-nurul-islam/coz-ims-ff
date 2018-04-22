<div id="exchangePaymentModal" class="modal fade" role="dialog">

    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Exchange Payment</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal">

                    <input type="hidden" id="exchange_payment_cart_row_id_container" value="" />

                    <div class="col-md-12 panel panel-info">
                        <table class="payment table table-hover table-bordered table-responsive table-condensed">

                            <tbody id="payment-cart-row">
                                <tr>
                                    <th class="col-sm-6">
                                        <span class="pull-left">Total Items Returned</span>
                                        <span class="pull-right" id="returned-total-items"></span>
                                    </th>
                                    <th class="col-sm-6">
                                        <span class="pull-left">Total Amount</span>
                                        <span class="pull-right" id="payment-total-amount"></span>
                                    </th>
                                </tr>
                                
                                <tr>
                                    <th class="col-sm-6">
                                        <span class="pull-left">Total Items Exchanged</span>
                                        <span class="pull-right" id="payment-total-items"></span>
                                    </th>
                                    <th class="col-sm-6">
                                        <span class="pull-left">Total Adjustable</span>
                                        <span class="pull-right" id="payment-total-adjustable"></span>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="2" class="col-sm-6">
                                        <span class="pull-left">Discount</span>
                                        <span class="pull-right" id="payment-total-discount"></span>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="2" class="col-sm-6">
                                        <span class="pull-left">Total Payable</span>
                                        <span class="pull-right" id="payment-total-payable"></span>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="col-sm-6">
                                        <span class="pull-left">Total Paying</span>
                                        <span class="pull-right" id="payment-total-paying"></span>
                                    </th>
                                    <th class="col-sm-6">
                                        <span class="pull-left">Total Change</span>
                                        <span class="pull-right" id="payment-total-balance"></span>
                                    </th>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                    
                    <div class="clearfix"></div>

                    <div class="form-group">
                        <div class="col-lg-12">
                            <?php
                            echo CHtml::textArea('note', '', array(
                                'class' => 'form-control',
                                'placeholder' => 'Note'
                            ));
                            ?>
                        </div>
                    </div>
                    
                    <div class="clearfix"></div>

                    <div class="form-group">
                        <div class="col-lg-6">
                            <?php
                            echo CHtml::textField('paying_amount', '', array(
                                'class' => 'form-control',
                                'placeholder' => 'Amount',
                                'id' => 'paying_amount'
                            ));
                            ?>
                        </div>
                        <div class="col-lg-6">
                            <?php
                            echo CHtml::dropDownList('paying_mode', '', Settings::$_available_payment_options, array(
                                'class' => 'form-control select2 col-lg-12',
                                'id' => 'payment_mode'
                            ));
                            ?>
                        </div>
                    </div>
                    
                    <div class="form-group card_information">
                        
                        <div class="col-lg-3">
                            <?php
                            echo CHtml::dropDownList('card_option', '', Settings::$_available_card_options, array(
                                'class' => 'form-control select2 col-lg-12',
                            ));
                            ?>
                        </div>
                        <div class="col-lg-6">
                            <?php
                            echo CHtml::textField('card_number', '', array(
                                'class' => 'form-control',
                                'placeholder' => 'Card Number'
                            ));
                            ?>
                        </div>
                        <div class="col-lg-3">
                            <?php
                            echo CHtml::textField('card_cvc', '', array(
                                'class' => 'form-control',
                                'placeholder' => 'CVC'
                            ));
                            ?>
                        </div>
                        
                    </div>


                </form>

            </div>

            <div class="modal-footer">
                <div class="col-md-12">
                    <button id="paymetn-btn-paid" type="button" class="btn btn-success btn-flat col-md-4 pull-right">Paid</button>
                </div>
            </div>
        </div>

    </div>
</div>
