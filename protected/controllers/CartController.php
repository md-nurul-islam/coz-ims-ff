<?php

class CartController extends Controller {

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('add', 'edit', 'add_items', 'remove_item', 'payment'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('PaymentTest'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionAdd() {
        $cart_id = Yii::app()->request->getParam('cart_id');

        if (!Yii::app()->request->isAjaxRequest || $cart_id > 0) {
            throw new CHttpException(400, 'Bad Request.');
        }

        $grand_total = Yii::app()->request->getParam('grand_total');
        $discount = Yii::app()->request->getParam('discount');
        $type = Yii::app()->request->getParam('type');
        $vat = Yii::app()->request->getParam('vat');

        $tmp_cart = new TmpCart;
        $tmp_cart->grand_total = $grand_total;
        $tmp_cart->cart_type = Settings::$_cart_types[$type];
        $tmp_cart->discount = $discount;
        $tmp_cart->vat = $vat;
        $tmp_cart->insert();

        $response['cart_id'] = $tmp_cart->id;
        echo CJSON::encode($response);
        Yii::app()->end();
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionEdit() {
        $cart_id = Yii::app()->request->getParam('cart_id');

        if (!Yii::app()->request->isAjaxRequest || $cart_id < 1) {
            throw new CHttpException(400, 'Bad Request.');
        }

        $grand_total = Yii::app()->request->getParam('grand_total');
        $discount = Yii::app()->request->getParam('discount');
        $type = Yii::app()->request->getParam('type');
        $vat = Yii::app()->request->getParam('vat');

        $tmp_cart = TmpCart::model()->findByPk($cart_id);

        if (!empty($tmp_cart)) {
            $tmp_cart->grand_total = $grand_total;
            $tmp_cart->cart_type = Settings::$_cart_types[$type];
            $tmp_cart->discount = $discount;
            $tmp_cart->vat = $vat;
            $tmp_cart->update();
        }
        $response['cart_id'] = $tmp_cart->id;
        echo CJSON::encode($response);
        Yii::app()->end();
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionAdd_items() {
        $cart_id = Yii::app()->request->getParam('cart_id');

        if (!Yii::app()->request->isAjaxRequest || $cart_id < 1) {
            throw new CHttpException(400, 'Bad Request.');
        }
        $cart_iems = Yii::app()->request->getParam('post_data');

        Yii::app()->db->createCommand()->delete(TmpCartItems::model()->tableName(), 'cart_id=:cart_id AND product_details_id = :item_id', array(':cart_id' => $cart_id, ':item_id' => $cart_iems['item_id']));

        $tmp_cart_item = new TmpCartItems;
        $tmp_cart_item->cart_id = $cart_id;
        $tmp_cart_item->product_details_id = $cart_iems['item_id'];
        $tmp_cart_item->reference_number = $cart_iems['reference_number'];
        $tmp_cart_item->quantity = $cart_iems['qty'];
        $tmp_cart_item->sub_total = $cart_iems['sub_total'];
        $tmp_cart_item->price = $cart_iems['price'];
        $tmp_cart_item->insert();

        $response['cart_item_id'] = $tmp_cart_item->id;
        echo CJSON::encode($response);
        Yii::app()->end();
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionRemove_item() {
        $cart_id = Yii::app()->request->getParam('cart_id');

        if (!Yii::app()->request->isAjaxRequest || $cart_id < 1) {
            throw new CHttpException(400, 'Bad Request.');
        }
        $cart_iems = Yii::app()->request->getParam('post_data');

        if (Yii::app()->db->createCommand()->delete(TmpCartItems::model()->tableName(), 'cart_id=:cart_id AND product_details_id = :item_id', array(':cart_id' => $cart_id, ':item_id' => $cart_iems['item_id']))) {
            $response['success'] = TRUE;
            $response['errors'] = [];
        } else {
            $response['success'] = FALSE;
            $response['errors'][] = 'Not Deleted';
        }

        echo CJSON::encode($response);
        Yii::app()->end();
    }

    public function actionPaymentTest() {

        $cart_id = 49;
        $cart_type = 'exchange';

        $post_data = Yii::app()->request->getParam('post_data');

        /** Transaction Ends * */
        $response['data'] = ExchangeProducts::model()->getExchange(53, 0, 19);

//        var_dump($response['data']);exit;

        echo $this->renderPartial('//cart/_exchange_bill', $response, TRUE, true);
    }

    public function actionPayment() {

        $cart_id = Yii::app()->request->getParam('cart_id');

        if (!Yii::app()->request->isAjaxRequest || $cart_id < 1) {
            throw new CHttpException(400, 'Bad Request.');
        }

        $post_data = Yii::app()->request->getParam('post_data');
        $cart_type = ucfirst($post_data['type']);

        $data = call_user_func_array(array($this, 'proccess' . $cart_type), array($cart_id, $post_data));
        
        echo CJSON::encode($data);
        Yii::app()->end();
    }

    private function proccessSale($cart_id, $post_data) {

        $customer_id = null;

        $customer = new CustomerDetails();
        $found_customer = false;
        if (isset($post_data['contact_number']) && !empty($post_data['contact_number'])) {
            $mobile_number = $post_data['contact_number'];
            $customer_data = $customer->hasCustomerByMobileNumber($mobile_number);
            if ($customer_data !== false) {
                $customer_id = $customer_data['id'];
                $found_customer = true;
            }
        }

        if (!$found_customer) {
            $customer->create($post_data);
        }

        $response = [];
        $tmp_cart = new TmpCart;
        $tmp_cart_data = $tmp_cart->getCart($cart_id);

        $cart_grand_total = (floatval($tmp_cart_data[0]['grand_total']) + floatval($tmp_cart_data[0]['total_discount'])) - floatval($tmp_cart_data[0]['total_vat']);

        $cart = new Cart;
        $cart->grand_total = $cart_grand_total;
        $cart->grand_total_paid = $post_data['payment_amount'];
        $cart->discount = $tmp_cart_data[0]['total_discount'];
        $cart->vat = $tmp_cart_data[0]['total_vat'];

        $bill_number = $post_data['bill_number'];
        $sale_date = date('Y-m-d', strtotime($post_data['sale_date']));
        $due_payment_date = date('Y-m-d', strtotime($post_data['due_payment_date']));
        $payment_method = $post_data['payment_method'];
        $note = $post_data['note'];
        $store_id = Yii::app()->user->storeId;
        $card_type = $post_data['card_type'];

        if (empty($bill_number)) {
            $bill_number = Settings::getToken(5, FALSE);
        }

        if ($cart->insert()) {

            $sales = new ProductStockSales;
            $sales->cart_id = $cart->id;
            $sales->customer_id = $customer_id;
            $sales->billnumber = $bill_number . $cart->id;
            $sales->sale_date = $sale_date;
            $sales->due_payment_date = $due_payment_date;
            $sales->payment_method = $payment_method;
            $sales->store_id = $store_id;
            $sales->card_type = $card_type;

            $sales->insert();
        }

        $i = 1;

        $sum_of_sub_totals = 0.00;
        $sum_of_sub_discount = 0.00;
        $sum_of_sub_vat = 0.00;
        foreach ($tmp_cart_data as $tmp_cart) {

            $cart_item = new CartItems;
            $cart_item->cart_id = $cart->id;
            $cart_item->product_details_id = $tmp_cart['product_details_id'];
            $cart_item->reference_number = $tmp_cart['reference_number'];
            $cart_item->price = $tmp_cart['price'];
            $cart_item->quantity = $tmp_cart['quantity'];
            $cart_item->sub_total = $tmp_cart['sub_total'];
            $cart_item->discount = $tmp_cart['item_discount'];
            $cart_item->vat = $tmp_cart['item_vat'];

            $sum_of_sub_totals += floatval($tmp_cart['sub_total']);
            $sum_of_sub_discount += floatval($tmp_cart['item_discount']);
            $sum_of_sub_vat += floatval($tmp_cart['item_vat']);

            $cart_item->insert();
            $i++;

            $stock_info = ProductStockAvail::model()->findByAttributes(array(
                'product_details_id' => $cart_item->product_details_id
            ));

            $stock_info->quantity = ((int) $stock_info->quantity - (int) $tmp_cart['quantity']);
            $stock_info->update();
        }

        $cart->grand_total = $sum_of_sub_totals;
        if ($cart->discount <= 0) {
            $cart->discount = $sum_of_sub_discount;
        }

        if ($cart->vat <= 0) {
            $cart->vat = $sum_of_sub_vat;
        }

        $cart->grand_total_balance = $cart->grand_total_paid - (($cart->grand_total + $cart->vat) - $cart->discount);
        $cart->update();

        $sold_data = new ProductStockSales;
        $response['data'] = $sold_data->getSaleData($sales->id);

        if (!empty($response['data'])) {
            $respons['success'] = TRUE;
            $respons['message'] = 'Successfully paid.';
            $respons['html'] = $this->renderPartial('//cart/_bill', $response, TRUE, true);
        } else {
            $respons['success'] = FALSE;
            $respons['message'] = 'Payment failed.';
        }

        return $respons;
    }

    private function proccessAdvanceSale($cart_id, $post_data) {

        $customer_id = null;
        if ($post_data['customer_name']) {
            $customer = new CustomerDetails();
            $customer->create($post_data);
            $customer_id = $customer->id;
        }

        $response = [];
        $tmp_cart = new TmpCart;
        $tmp_cart_data = $tmp_cart->getCart($cart_id);

        $cart_grand_total = (floatval($tmp_cart_data[0]['grand_total']) + floatval($tmp_cart_data[0]['total_discount'])) - floatval($tmp_cart_data[0]['total_vat']);

        $cart = new Cart;
        $cart->grand_total = $cart_grand_total;
        $cart->grand_total_paid = $post_data['payment_amount'];
        $cart->discount = $tmp_cart_data[0]['total_discount'];
        $cart->vat = $tmp_cart_data[0]['total_vat'];

        $bill_number = $post_data['bill_number'];
        $sale_date = date('Y-m-d', strtotime($post_data['sale_date']));
        $due_payment_date = date('Y-m-d', strtotime($post_data['due_payment_date']));
        $payment_method = $post_data['payment_method'];
        $note = $post_data['note'];
        $store_id = Yii::app()->user->storeId;
        $card_type = $post_data['card_type'];

        if (empty($bill_number)) {
            $bill_number = Settings::getToken(5, FALSE);
        }

        if ($cart->insert()) {

            $sales = new ProductStockSales;
            $sales->cart_id = $cart->id;
            $sales->customer_id = $customer_id;
            $sales->billnumber = $bill_number . $cart->id;
            $sales->sale_date = $sale_date;
            $sales->due_payment_date = $due_payment_date;
            $sales->payment_method = $payment_method;
            $sales->store_id = $store_id;
            $sales->card_type = $card_type;

            if ($sales->insert()) {

//                Yii::app()->db->createCommand()
//                        ->delete(TmpCart::model()->tableName(), 'id = :id', array(':id' => $cart_id));
            }
        }

        $i = 1;

        $sum_of_sub_totals = 0.00;
        $sum_of_sub_discount = 0.00;
        $sum_of_sub_vat = 0.00;
        foreach ($tmp_cart_data as $tmp_cart) {

            $cart_item = new CartItems;
            $cart_item->cart_id = $cart->id;
            $cart_item->product_details_id = $tmp_cart['product_details_id'];
            $cart_item->reference_number = $tmp_cart['reference_number'];
            $cart_item->price = $tmp_cart['price'];
            $cart_item->quantity = $tmp_cart['quantity'];
            $cart_item->sub_total = $tmp_cart['sub_total'];
            $cart_item->discount = $tmp_cart['item_discount'];
            $cart_item->vat = $tmp_cart['item_vat'];

            $sum_of_sub_totals += floatval($tmp_cart['sub_total']);
            $sum_of_sub_discount += floatval($tmp_cart['item_discount']);
            $sum_of_sub_vat += floatval($tmp_cart['item_vat']);

            $cart_item->insert();
            $i++;

            $stock_info = ProductStockAvail::model()->findByAttributes(array(
                'product_details_id' => $cart_item->product_details_id
            ));

            $stock_info->quantity = ((int) $stock_info->quantity - (int) $tmp_cart['quantity']);
            $stock_info->update();
        }

        $cart->grand_total = $sum_of_sub_totals;
        if ($cart->discount <= 0) {
            $cart->discount = $sum_of_sub_discount;
        }

        if ($cart->vat <= 0) {
            $cart->vat = $sum_of_sub_vat;
        }

        $cart->grand_total_balance = $cart->grand_total_paid - (($cart->grand_total + $cart->vat) - $cart->discount) - $post_data['payment_advance'];

        var_dump($cart->attributes);
        exit;

        $cart->update();

//        Yii::app()->db->createCommand()
//                ->delete(TmpCartItems::model()->tableName(), 'cart_id = :cid', array(':cid' => $cart_id));

        $sold_data = new ProductStockSales;
        $response['data'] = $sold_data->getSaleData($sales->id);

        if (!empty($response['data'])) {
            $respons['success'] = TRUE;
            $respons['message'] = 'Successfully paid.';
            $respons['html'] = $this->renderPartial('//cart/_advance_bill', $response, TRUE, true);
        } else {
            $respons['success'] = FALSE;
            $respons['message'] = 'Payment failed.';
        }

        return $respons;
    }

    private function proccessPurchase($cart_id) {
        
    }

    private function proccessExchange($cart_id, $post_data) {

        $response = [];
        $done = false;
        $error = '';

        $tmp_cart = new TmpCart;
        $tmp_cart_data = $tmp_cart->getCart($cart_id, $post_data['type']);

        $sales_data = ProductStockSales::model()->getSaleData(0, $post_data['bill_number']);

        $grand_total_bill = 0.00;
        $grand_total_returnable = 0.00;
        $grand_total_adjustable = 0.00;
        $grand_total_paid = 0.00;
        $grand_total_balance = 0.00;

        foreach ($sales_data as $sale) {

            if (isset($post_data['exchange_data'][$sale['product_id']])) {
                $grand_total_returnable += floatval($sale['price']) * intval($post_data['exchange_data'][$sale['product_id']]['exchanging_quantity']);
            }
        }

        $grand_total_returnable = $grand_total_returnable - floatval($sales_data[0]['discount']);
        $grand_total_bill = (floatval($tmp_cart_data[0]['grand_total']) + floatval($tmp_cart_data[0]['total_discount'])) - floatval($tmp_cart_data[0]['total_vat']);
        $grand_total_adjustable = $grand_total_bill - $grand_total_returnable;
        $grand_total_paid = floatval($post_data['payment_amount']);
        $grand_total_balance = $grand_total_paid - $grand_total_adjustable;

        $cart = new ExchangeCart;
        $cart->grand_total_bill = $grand_total_bill;
        $cart->grand_total_returnable = $grand_total_returnable;
        $cart->grand_total_adjustable = $grand_total_adjustable;
        $cart->grand_total_paid = $grand_total_paid;
        $cart->grand_total_balance = $grand_total_balance;
        $cart->discount = $tmp_cart_data[0]['total_discount'];
        $cart->vat = $tmp_cart_data[0]['total_vat'];

        $sales_id = $sales_data[0]['id'];
        $payment_method = $post_data['payment_method'];
        $note = $post_data['note'];

        $store_id = Yii::app()->user->storeId;
        $card_type = $post_data['card_type'];

        $exchange_billnumber = Settings::getUniqueId(0, 5);

        $transaction = Yii::app()->db->beginTransaction();

        /** Transaction Starts * */
        try {

            $cart->insert();

            $exchange = new ExchangeProducts;
            $exchange->exchange_billnumber = $exchange_billnumber;
            $exchange->sales_id = $sales_id;
            $exchange->cart_id = $cart->id;
            $exchange->exchange_date = date('Y-m-d H:i:s', Settings::getBdLocalTime());
            $exchange->payment_method = $payment_method;
            $exchange->store_id = $store_id;
            $exchange->note = $note;
            $exchange->card_type = $card_type;

            $exchange->insert();

            Yii::app()->db->createCommand()
                    ->delete(TmpCart::model()->tableName(), 'id = :id', array(':id' => $cart_id));

            foreach ($sales_data as $sale) {
                if (isset($post_data['exchange_data'][$sale['product_id']])) {

                    $qty = intval($post_data['exchange_data'][$sale['product_id']]['exchanging_quantity']);

                    $cart_item_return = new ExchangeCartItems;
                    $cart_item_return->cart_id = $cart->id;
                    $cart_item_return->product_details_id = $sale['product_id'];
                    $cart_item_return->reference_number = $sale['reference_number'];
                    $cart_item_return->price = floatval($sale['price']);
                    $cart_item_return->quantity = $qty;
                    $cart_item_return->sub_total = floatval($sale['price']) * $qty;
                    $cart_item_return->is_returned = 1;

                    $cart_item_return->insert();

                    $stock_info = ProductStockAvail::model()->findByAttributes(array(
                        'product_details_id' => $cart_item_return->product_details_id
                    ));

                    $stock_info->quantity = ((int) $stock_info->quantity + $qty);
                    $stock_info->update();
                }
            }

            $i = 1;
            $sum_of_sub_totals = 0.00;
            $sum_of_sub_discount = 0.00;
            $sum_of_sub_vat = 0.00;

            foreach ($tmp_cart_data as $tmp_cart_row) {

                $cart_item = new ExchangeCartItems;
                $cart_item->cart_id = $cart->id;
                $cart_item->product_details_id = $tmp_cart_row['product_details_id'];
                $cart_item->reference_number = $tmp_cart_row['reference_number'];
                $cart_item->price = $tmp_cart_row['price'];
                $cart_item->quantity = $tmp_cart_row['quantity'];
                $cart_item->sub_total = $tmp_cart_row['sub_total'];
                $cart_item->discount = $tmp_cart_row['item_discount'];
                $cart_item->vat = $tmp_cart_row['item_vat'];
                $cart_item->is_returned = 0;

                $sum_of_sub_totals += floatval($tmp_cart_row['sub_total']);
                $sum_of_sub_discount += floatval($tmp_cart_row['item_discount']);
                $sum_of_sub_vat += floatval($tmp_cart_row['item_vat']);

                $cart_item->insert();
                $i++;

                $stock_info = ProductStockAvail::model()->findByAttributes(array(
                    'product_details_id' => $cart_item->product_details_id
                ));

                $stock_info->quantity = ((int) $stock_info->quantity - (int) $tmp_cart_row['quantity']);
                $stock_info->update();
            }

            $cart->grand_total_bill = $sum_of_sub_totals;

            if ($cart->discount <= 0) {
                $cart->discount = $sum_of_sub_discount;
            }

            if ($cart->vat <= 0) {
                $cart->vat = $sum_of_sub_vat;
            }

            $cart->update();

            Yii::app()->db->createCommand()
                    ->delete(TmpCartItems::model()->tableName(), 'cart_id = :cid', array(':cid' => $cart_id));

            $transaction->commit();
            $done = TRUE;
        } catch (CDbException $exc) {
            $transaction->rollback();
            $error = $exc->getMessage();
        }

        /** Transaction Ends * */
        $response['data'] = ExchangeProducts::model()->getExchange($sales_id, 0, $exchange->id);

        if (!empty($response['data'])) {
            $respons['success'] = TRUE;
            $respons['message'] = 'Successfully paid.';
            $respons['html'] = $this->renderPartial('//cart/_exchange_bill', $response, TRUE, true);
        } else {
            $respons['success'] = FALSE;
            $respons['message'] = $error;
        }

        return $respons;
    }

}
