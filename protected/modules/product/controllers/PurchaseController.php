<?php

class PurchaseController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

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
                'actions' => array(
                    'getStatusComboData',
                    'getdata',
                    'getlatestprice',
                    'getproductcolorgradesize',
                    'index',
                    'print',
                    'view',
                    'create',
                    'update',
                    'product_stock_info',
                    'createsingle',
                    'autocomplete'
                ),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->redirect(array('print', 'purchase_id' => $id));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new ProductStockEntries;

        $this->pageTitle = Yii::app()->name . ' - Purchase Product';

        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $ar_cart = array();

        if (isset($_POST['ProductStockEntries'])) {
            $stock_info = new ProductStockAvail;

            $bill_number = $_POST['ProductStockEntries']['billnumber'];
            $purchase_date = date('Y-m-d', strtotime($_POST['ProductStockEntries']['purchase_date']));
            $supplier_id = $_POST['ProductStockEntries']['supplier_id'];
            $grand_total_payable = $_POST['ProductStockEntries']['grand_total_payable'];
            $grand_total_paid = $_POST['ProductStockEntries']['grand_total_paid'];
            $grand_total_balance = $_POST['ProductStockEntries']['grand_total_balance'];
            $due_payment_date = date('Y-m-d', strtotime($_POST['ProductStockEntries']['due_payment_date']));
            $payment_type = $_POST['ProductStockEntries']['payment_type'];
            $note = $_POST['ProductStockEntries']['note'];
            $purchase_id = $this->generatePurchaseId();

            $ar_product_details_id = array();
            $ar_product_details_name = array();
            $ar_ref_num = array();
            $ar_quantity = array();
            $ar_purchase_price = array();
            $ar_selling_price = array();
            $ar_item_subtotal = array();
            $ar_serial_num = array();
            $ar_cur_stock = array();

            $limit = sizeof($_POST['ProductStockEntries']['product_details_id']);
            $count = 0;

            for ($i = 0; $i < $limit; $i++) {

                $model = new ProductStockEntries;

                $model->billnumber = $bill_number;
                $model->purchase_date = $purchase_date;
                $model->supplier_id = (!empty($supplier_id)) ? $supplier_id : NULL;
                $model->grand_total_payable = $grand_total_payable;
                $model->grand_total_paid = $grand_total_paid;
                $model->grand_total_balance = $grand_total_balance;
                $model->due_payment_date = $due_payment_date;
                $model->payment_type = $payment_type;
                $model->note = $note;
                $model->purchase_id = $purchase_id;
                $model->store_id = $store_id;

                $model->product_details_id = $_POST['ProductStockEntries']['product_details_id'][$i];
                $model->ref_num = $_POST['ProductStockEntries']['ref_num'][$i];
                $model->quantity = intval($_POST['ProductStockEntries']['quantity'][$i]);
                $model->purchase_price = $_POST['ProductStockEntries']['purchase_price'][$i];
                $model->selling_price = $_POST['ProductStockEntries']['selling_price'][$i];
                $model->item_subtotal = $_POST['ProductStockEntries']['item_subtotal'][$i];
                $model->serial_num = $i;

                if (!$model->validate()) {
                    $ar_product_details_id[] = $model->product_details_id;
                    $ar_product_details_name[] = $_POST['ProductStockEntries']['product_details_name'][$i];
                    $ar_ref_num[] = $model->ref_num;
                    $ar_quantity[] = $model->quantity;
                    $ar_purchase_price[] = $model->purchase_price;
                    $ar_selling_price[] = $model->selling_price;
                    $ar_item_subtotal[] = $model->item_subtotal;
                    $ar_serial_num[] = $model->serial_num;
                    $ar_cur_stock[] = $_POST['cur_stock'][$i];
                } else {

                    $stock_info = $stock_info->getStockByProdId((int) $model->product_details_id, $store_id);

                    if (!$stock_info) {

                        $stock_info = new ProductStockAvail;
                        $stock_info->quantity = $model->quantity;
                        $stock_info->product_details_id = $model->product_details_id;
                        $stock_info->store_id = $store_id;
                        $stock_info->insert();
                    } else {

                        $cur_stock = intval($stock_info->quantity);
                        $new_stock = $cur_stock + $model->quantity;

                        $stock_info->quantity = $new_stock;
                        $stock_info->update();

                        $criteria = new CDbCriteria;
                        $criteria->compare('t.id', $model->product_details_id);
                        $criteria->compare('t.store_id', $store_id);

                        $prod_details = ProductDetails::model()->find($criteria);
                        $prod_details->purchase_price = $model->purchase_price;
                        $prod_details->selling_price = $model->selling_price;
                        $prod_details->update_date = date('Y-m-d H:i:s', time());
                        $prod_details->update();
                    }

                    if ($model->insert()) {
                        $count++;
                    }
                }
            }

            if ($count == $limit) {
                Yii::app()->user->setFlash('success', 'Products successfully added to stock.');
                $this->redirect(array('create'));
            }

            $ar_cart['product_details_id'] = $ar_product_details_id;
            $ar_cart['product_details_name'] = $ar_product_details_name;
            $ar_cart['ref_num'] = $ar_ref_num;
            $ar_cart['quantity'] = $ar_quantity;
            $ar_cart['purchase_price'] = $ar_purchase_price;
            $ar_cart['selling_price'] = $ar_selling_price;
            $ar_cart['item_subtotal'] = $ar_item_subtotal;
            $ar_cart['serial_num'] = $ar_serial_num;
            $ar_cart['cur_stock'] = $ar_cur_stock;
        }

        $this->render('create', array(
            'model' => $model,
            'ar_cart' => $ar_cart,
        ));
    }

    public function actionCreatesingle() {

        $model = new ProductStockEntries;
        $now = date('Y-m-d');

        $this->pageTitle = Yii::app()->name . ' - Purchase Product';
        $this->pageHeader = 'Purchase Product';

        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $ar_cart = array();
        $ar_cart['errors'] = array();

        if (isset($_POST['ProductStockEntries'])) {

            if (empty($_POST['quantity'])) {
                $ar_cart['errors'][] = 'Quanity is required';
            }

            if (empty($_POST['total'])) {
                $ar_cart['errors'][] = 'Total is required';
            }

            $product_id = $_POST['product_details_id'];

            $new_cost = $_POST['n_cost'];
            $new_price = $_POST['n_price'];

            $stock_info = ProductStockAvail::model()->findByAttributes(array(
                'product_details_id' => $product_id
            ));

            $bill_number = (empty($_POST['ProductStockEntries']['billnumber'])) ? Settings::getToken(8, FALSE) : $_POST['ProductStockEntries']['billnumber'];
            $purchase_date = (empty($_POST['ProductStockEntries']['purchase_date'])) ? $now : date('Y-m-d', strtotime($_POST['ProductStockEntries']['purchase_date']));
            $due_payment_date = (empty($_POST['ProductStockEntries']['due_payment_date'])) ? $now : date('Y-m-d', strtotime($_POST['ProductStockEntries']['due_payment_date']));
            $payment_method = 1;
//            $payment_method = $_POST['ProductStockEntries']['payment_method'];
            $note = $_POST['ProductStockEntries']['note'];

            if (empty($ar_cart['errors'])) {

                $purchase_cart = new PurchaseCart;
                $purchase_cart->grand_total = $_POST['total'];
                $purchase_cart->insert();

                $model->billnumber = $bill_number;
                $model->purchase_date = $purchase_date;
                $model->due_payment_date = $due_payment_date;
                $model->payment_method = $payment_method;
                $model->note = $note;
                $model->store_id = $store_id;
                $model->purchase_cart_id = $purchase_cart->id;
                $model->insert();
                
                $sub_total = intval($_POST['quantity']) * floatval($new_cost);
                
                $purchase_cart_items = new PurchaseCartItems;
                $purchase_cart_items->cart_id = $purchase_cart->id;
                $purchase_cart_items->product_details_id = $product_id;
                $purchase_cart_items->cost = $new_cost;
                $purchase_cart_items->price = $new_price;
                $purchase_cart_items->quantity = $_POST['quantity'];
                $purchase_cart_items->sub_total = floatval($sub_total);
                $purchase_cart_items->insert();

                $stock_info->quantity = ((int) $stock_info->quantity + (int) $_POST['quantity']);

                $ProductDetails = ProductDetails::model()->findByAttributes(array('id' => $product_id));

                $ProductDetails->purchase_price = $new_cost;
                $ProductDetails->selling_price = $new_price;
                $ProductDetails->update();

                if ($stock_info->update()) {
                    Yii::app()->user->setFlash('success', 'Products successfully added to stock.');
                    $this->redirect(array('createsingle'));
                }
            } else {

                $ar_cart['purchase_date'] = $purchase_date;
                $ar_cart['due_payment_date'] = $due_payment_date;
                $ar_cart['product_name'] = $_POST['product_name'];
                $ar_cart['product_details_id'] = $_POST['product_details_id'];
                $ar_cart['note'] = $note;
                $ar_cart['stock'] = $_POST['stock'];
                $ar_cart['cost'] = $_POST['cost'];
                $ar_cart['price'] = $_POST['price'];
                $ar_cart['n_cost'] = $new_cost;
                $ar_cart['n_price'] = $new_price;
                $ar_cart['quantity'] = $_POST['quantity'];
                $ar_cart['total'] = $_POST['total'];
                $ar_cart['payment_method'] = $payment_method;
            }
        }

        $this->render('create', array(
            'model' => $model,
            'ar_cart' => $ar_cart,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        } else {
            $store_id = 1;
        }

        if (isset($_POST['ProductStockEntries'])) {
            $model->attributes = $_POST['ProductStockEntries'];

            $model->store_id = $store_id;

            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionPrint() {

        $id = Yii::app()->request->getParam('purchase_id');

        $model = new ProductStockEntries;
        $model = $model->getPurchase($id);

        $this->render('print', array(
            'model' => $model,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $this->pageHeader = 'Purchase List';

        $model = new ProductStockEntries();
        $pageSize = 0;

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        } else {
            $store_id = 1;
        }

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductStockEntries'])) {
            if (isset($_GET['ProductStockEntries'])) {
                if (isset($_GET['ProductStockEntries']['id']) && !empty($_GET['ProductStockEntries']['id'])) {
                    $model->purchase_id = $_GET['ProductStockEntries']['id'];
                }

                if (isset($_GET['ProductStockEntries']['product_name']) && !empty($_GET['ProductStockEntries']['product_name'])) {
                    $model->product_name = $_GET['ProductStockEntries']['product_name'];
                }

                if (isset($_GET['ProductStockEntries']['grand_total_paid']) && !empty($_GET['ProductStockEntries']['grand_total_paid'])) {
                    $model->grand_total_paid = $_GET['ProductStockEntries']['grand_total_paid'];
                }
            }
        }

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            $model->pageSize = $pageSize;
            unset($_GET['pageSize']);
        }

        $model->store_id = $store_id;

        $this->render('index', array(
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ProductStockEntries the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ProductStockEntries::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs Autocomplte.
     * @param CategoryDetails $model the model to be validated
     */
    public function actionAutocomplete() {

        if (isset($_GET['term'])) {
            $term = $_GET['term'];

            $ar_result = array();

            $store_id = 1;
            if (!Yii::app()->user->isSuperAdmin) {
                $store_id = Yii::app()->user->storeId;
            }

            if ((!Yii::app()->user->isGuest) && (Yii::app()->request->isAjaxRequest) && !empty($term)) {

                $command = Yii::app()->db->createCommand()
                        ->from(ProductDetails::model()->tableName() . ' t')
                        ->join(SupplierDetails::model()->tableName() . ' s', 's.id = t.supplier_id')
                        ->leftJoin(ProductColor::model()->tableName() . ' pc', 't.id = pc.product_details_id')
                        ->leftJoin(Color::model()->tableName() . ' cl', 'pc.color_id = cl.id')
                        ->leftJoin(ProductGrade::model()->tableName() . ' pg', 't.id = pg.product_details_id')
                        ->leftJoin(Grade::model()->tableName() . ' gr', 'pg.grade_id = gr.id')
                        ->leftJoin(ProductSize::model()->tableName() . ' psz', 't.id = psz.product_details_id')
                        ->leftJoin(Sizes::model()->tableName() . ' sz', 'psz.size_id = sz.id')
                        ->limit(50)
                ;
            }

            $command->select('t.id, t.product_name, cl.name AS color_name, gr.name AS grade_name, sz.name AS size_name, s.supplier_name');

            $command->andWhere('t.store_id = :sid', array(':sid' => $store_id));
            $command->andWhere('t.product_name LIKE :p_name', array(':p_name' => '%' . $term . '%'));

            $ar_result = $command->queryAll();

            $return_array = array();
            foreach ($ar_result as $result) {
                $return_array[] = array(
                    'id' => $result['id'],
                    'value' => $result['product_name'] . '-' . $result['color_name'] . '-' . $result['grade_name'] . '-' . $result['size_name'] . '-' . $result['supplier_name'],
                );
            }

            echo CJSON::encode($return_array);
        }
    }

    public function actionGetlatestprice() {

        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        if (isset($_POST['product_details_id'])) {
            $product_details_id = $_POST['product_details_id'];

            if ((!Yii::app()->user->isGuest) && (Yii::app()->request->isAjaxRequest) && !empty($product_details_id)) {
                $command = Yii::app()->db->createCommand()
                        ->from(ProductDetails::model()->tableName() . ' t')
                        ->join(ProductStockAvail::model()->tableName() . ' psa', 't.id = psa.product_details_id')
                        ->limit(1)
                ;
            }

            $command->select('t.id, t.purchase_price , t.selling_price, psa.quantity');

            if (!Yii::app()->user->isSuperAdmin) {
                $command->andWhere('t.store_id = :sid', array(':sid' => $store_id));
            }

            $command->andWhere('t.id = :pid', array(':pid' => $product_details_id));

            $data = $command->queryRow();

            $response['stock'] = $data['quantity'];
            $response['cost'] = $data['purchase_price'];
            $response['price'] = $data['selling_price'];

            echo CJSON::encode($response);
            Yii::app()->end();
        }
    }

    public function actionGetproductcolorgradesize() {

        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        if (isset($_POST['product_details_id'])) {
            $product_details_id = $_POST['product_details_id'];

            if ((!Yii::app()->user->isGuest) && (Yii::app()->request->isAjaxRequest) && !empty($product_details_id)) {
                $command = Yii::app()->db->createCommand()
                        ->from(ProductDetails::model()->tableName() . ' t')
                        ->join(SupplierDetails::model()->tableName() . ' s', 's.id = t.supplier_id')
                        ->join(ProductStockAvail::model()->tableName() . ' ps', 't.id = ps.product_details_id')
                        ->join(ProductColor::model()->tableName() . ' pc', 't.id = pc.product_details_id')
                        ->join(Color::model()->tableName() . ' cl', 'pc.color_id = cl.id')
                        ->join(ProductGrade::model()->tableName() . ' pg', 't.id = pg.product_details_id')
                        ->join(Grade::model()->tableName() . ' gr', 'pg.grade_id = gr.id')
                        ->join(ProductSize::model()->tableName() . ' psz', 't.id = psz.product_details_id')
                        ->join(Sizes::model()->tableName() . ' sz', 'psz.size_id = sz.id')
                        ->limit(1)
                ;
            }

            if (!Yii::app()->user->isSuperAdmin) {
                $command->andWhere('t.store_id = :sid', array(':sid' => $store_id));
            }

            $command->andWhere('t.id = :pid', array(':pid' => $product_details_id));

            $data['data'] = $command->queryAll();

            $response['stock'] = '';
            $response['supplier']['name'] = '';
            $response['supplier']['id'] = '';
            $response['color_grade_size_html'] = $this->renderPartial('_color_grade_size', $data, TRUE, FALSE);

            echo CJSON::encode($html);
            Yii::app()->end();
        }
    }

    /**
     * Performs the AJAX validation.
     * @param ProductStockEntries $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-stock-entries-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * gets product stock information and latest cost and selling price.
     */
    public function actionProduct_stock_info() {

        if ((Yii::app()->user->isGuest) || (!Yii::app()->request->isAjaxRequest)) {
            throw new CHttpException(403, 'Access Forbidden.');
        }

        $prod_id = Yii::app()->request->getParam('prod_id');
        $ref_num = Yii::app()->request->getParam('ref_num');

        $cost = 0;
        $price = 0;
        $cur_stock = 0;

        $model = new ProductStockEntries();
        $model = $model->getProductStockInfo($prod_id, $ref_num);

        $prod_available_grades = new ProductGrade();
        $obj_prod_available_grades = $prod_available_grades->getGrades($prod_id, 0, TRUE);

        $ar_grades = array();
        $i = 0;
        foreach ($obj_prod_available_grades as $pad) {
            $ar_grades[$i]['id'] = $pad->grade_id;
            $ar_grades[$i]['name'] = $pad->grade->name;
            $i++;
        }

        if (!empty($model)) {
            $cost = ( empty($model['productDetails']->purchase_price) || ($model['productDetails']->purchase_price <= 0 ) ) ? $model->purchase_price : $model['productDetails']->purchase_price;
            $price = ( empty($model['productDetails']->selling_price) || ($model['productDetails']->selling_price <= 0 ) ) ? $model->selling_price : $model['productDetails']->selling_price;
            $cur_stock = $model['productDetails']['productStockAvails']->quantity;
        }

        $response['cost'] = $cost;
        $response['price'] = $price;
        $response['cur_stock'] = $cur_stock;
        $response['grades'] = $ar_grades;

        echo CJSON::encode($response);
        exit;
    }

    /*
     * Grid functions
     */

    public function actionGetdata() {

        foreach (DataGridHelper::$_ar_non_filterable_vars as $nfv_key => $nfv_var_name) {
            ${$nfv_var_name} = Yii::app()->request->getParam($nfv_key);
        }

        $rows = array();
        $offest = 0;

        if (${DataGridHelper::$_ar_non_filterable_vars['page']} > 1) {
            $offest = (${DataGridHelper::$_ar_non_filterable_vars['page']} - 1) * ${DataGridHelper::$_ar_non_filterable_vars['rows']};
        }

        $ProductStockEntries = new ProductStockEntries();

        $ProductStockEntries->pageSize = 20;
        $query_params = array(
            'offset' => $offest,
            'order' => ${DataGridHelper::$_ar_non_filterable_vars['sort']} . ' ' . ${DataGridHelper::$_ar_non_filterable_vars['order']},
            'where' => $_POST,
        );

        $result['rows'] = $ProductStockEntries->dataGridRows($query_params);
//        var_dump($result['rows']);exit;
        $result["total"] = 0;

        if (($result['rows'])) {
            $result["total"] = $result['rows'][0]['total_rows'];
        }
        echo CJSON::encode($result);
        Yii::app()->end();
    }

    public function actionGetStatusComboData() {
        echo CJSON::encode(ProductStockEntries::model()->statusComboData());
    }

    private function generatePurchaseId() {

        $data = Yii::app()->db->createCommand()->select('MAX(id) AS id')->from('cims_product_stock_entries')->queryRow();

        $max_id = (strlen($data['id']) < 2) ? '0' . ($data['id'] + 1) : ($data['id'] + 1);

        return $max_id = 'PD' . $max_id;
    }

}
