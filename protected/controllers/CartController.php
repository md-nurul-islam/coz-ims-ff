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

    public function actionPayment() {

        $cart_id = Yii::app()->request->getParam('cart_id');

        if (!Yii::app()->request->isAjaxRequest || $cart_id < 1) {
            throw new CHttpException(400, 'Bad Request.');
        }

        $post_data = Yii::app()->request->getParam('post_data');
        $cart_type = $post_data['type'];

        $data = call_user_func_array(array($this, 'proccess' . $cart_type), array($cart_id, $post_data));

        if (!empty($data)) {

            $respons['success'] = TRUE;
            $respons['message'] = 'Successfully paid.';
            $respons['html'] = $this->renderPartial('//cart/_bill', $data, TRUE, true);
        } else {
            $respons['success'] = FALSE;
            $respons['message'] = 'Payment failed.';
        }

        echo CJSON::encode($respons);
        Yii::app()->end();
    }

    private function proccessSale($cart_id, $post_data) {

        $response = [];
        $tmp_cart = new TmpCart;
        $tmp_cart_data = $tmp_cart->getCart($cart_id);
        
        $cart = new Cart;
        $cart->grand_total = $tmp_cart_data[0]['grand_total'];
        $cart->discount = $tmp_cart_data[0]['discount'];
        $cart->vat = $tmp_cart_data[0]['vat'];
        
        $cart->grand_total = floatval($cart->grand_total) - floatval($cart->vat);
        $cart->grand_total = floatval($cart->grand_total) + floatval($cart->discount);
        
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
            $sales->billnumber = $bill_number . $cart->id;
            $sales->sale_date = $sale_date;
            $sales->due_payment_date = $due_payment_date;
            $sales->payment_method = $payment_method;
            $sales->store_id = $store_id;
            $sales->card_type = $card_type;

            if ($sales->insert()) {

                Yii::app()->db->createCommand()
                        ->delete(TmpCart::model()->tableName(), 'id = :id', array(':id' => $cart_id));
            }
        }

        $i = 1;
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
            
            $cart_item->insert();
            $i++;
            
            $stock_info = ProductStockAvail::model()->findByAttributes(array(
                'product_details_id' => $cart_item->product_details_id
            ));
            
            $stock_info->quantity = ((int) $stock_info->quantity - (int) $tmp_cart['quantity']);
            $stock_info->update();
        }

        Yii::app()->db->createCommand()
                ->delete(TmpCartItems::model()->tableName(), 'cart_id = :cid', array(':cid' => $cart_id));

        $sold_data = new ProductStockSales;
        $response['data'] = $sold_data->getSaleData($sales->id);

        return $response;
    }

    private function proccessPurchase($cart_id) {
        
    }

}
