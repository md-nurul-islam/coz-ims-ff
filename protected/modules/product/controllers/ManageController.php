<?php

class ManageController extends Controller {

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
                    'index',
                    'view',
                    'create',
                    'update',
                    'autocomplete',
                    'getdata',
                    'getStatusComboData'
                ),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('update_stock', 'delete', 'barcode', 'downloadBarcode', 'barcodeFileList'),
                'expression' => '(!Yii::app()->user->isGuest) && (Yii::app()->user->isSuperAdmin || Yii::app()->user->isStoreAdmin)',
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
        $this->pageTitle = Yii::app()->name . ' - Product Details';

        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $now = date('Y-m-d H:i:s', Settings::getBdLocalTime());
        $this->pageTitle = Yii::app()->name . ' - Add Product';
        $this->pageHeader = 'Add Product';
        $edit = false;

        $model = new ProductDetails;
        $category_name = '';
        $supplier_name = '';
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        } else {
            $store_id = 1;
        }

        $grades = Grade::model()->findAll();
        $sizes = Sizes::model()->findAll();
        $colors = Color::model()->findAll();

        if (isset($_POST['ProductDetails'])) {

            $model->attributes = $_POST['ProductDetails'];

            $model->store_id = $store_id;
            $model->create_date = $now;
            $model->update_date = $now;

            $product_grade = 0;
            $product_size = 0;
            $product_color = 0;

            if ($model->save()) {

                if (isset($_POST['ProductGrade']['grade_id']) && !empty($_POST['ProductGrade']['grade_id'])) {
                    $product_grade = $_POST['ProductGrade']['grade_id'];
                }

                if (isset($_POST['ProductSize']['size_id']) && !empty($_POST['ProductSize']['size_id'])) {
                    $product_size = $_POST['ProductSize']['size_id'];
                }

                if (isset($_POST['ProductColor']['color_id']) && !empty($_POST['ProductColor']['color_id'])) {
                    $product_color = $_POST['ProductColor']['color_id'];
                }

                $obj_pg = new ProductGrade();
                $obj_pg->product_details_id = $model->id;
                $obj_pg->grade_id = $product_grade;
                $obj_pg->save();

                $obj_ps = new ProductSize();
                $obj_ps->product_details_id = $model->id;
                $obj_ps->size_id = $product_size;
                $obj_ps->save();

                $obj_pc = new ProductColor();
                $obj_pc->product_details_id = $model->id;
                $obj_pc->color_id = $product_color;
                $obj_pc->save();

                $obj_p_stock = new ProductStockAvail();
                $obj_p_stock->product_details_id = $model->id;
                $obj_p_stock->quantity = 0;
                $obj_p_stock->store_id = $store_id;
                $obj_p_stock->product_grade_id = $obj_pg->id;
                $obj_p_stock->product_size_id = $obj_ps->id;
                $obj_p_stock->product_color_id = $obj_pc->id;
                $obj_p_stock->insert();

                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'category_name' => $category_name,
            'supplier_name' => $supplier_name,
            'grades' => $grades,
            'sizes' => $sizes,
            'colors' => $colors,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {

        $now = date('Y-m-d H:i:s', Settings::getBdLocalTime());
        $this->pageTitle = Yii::app()->name . ' - Update Product';
        $this->pageHeader = 'Update Product';
        $done = FALSE;
        
        $model = ProductDetails::model()->getDetails($id);
        
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        } else {
            $store_id = 1;
        }
        
        $grades = Grade::model()->findAll();
        $sizes = Sizes::model()->findAll();
        $colors = Color::model()->findAll();
        
        if( isset($_POST) && !empty($_POST['product_details_id']) ) {
            
            $id = $_POST['product_details_id'];
            
            $prod_model =  ProductDetails::model()->findByAttributes(array('id' => $id));
            
            $prod_model->category_id = $_POST['category_id'];
            $prod_model->supplier_id = $_POST['supplier_id'];
            $prod_model->product_name = $_POST['product_name'];
            $prod_model->purchase_price = $_POST['purchase_price'];
            $prod_model->selling_price = $_POST['selling_price'];
            $prod_model->update_date = $now;
            $prod_model->status = $_POST['status'];
            $prod_model->vat = 0.00;
            $prod_model->discount = 0.00;
            
            $color_model = ProductColor::model()->findByAttributes(array('product_details_id' => $id));
            $color_model->color_id = $_POST['color_id'];
            
            $size_model = ProductSize::model()->findByAttributes(array('product_details_id' => $id));
            $size_model->size_id = $_POST['size_id'];
            
            $grade_model = ProductGrade::model()->findByAttributes(array('product_details_id' => $id));
            $grade_model->grade_id = $_POST['grade_id'];
            
            $transaction = Yii::app()->db->beginTransaction();
            
            try {
                
                $prod_model->update();
                $color_model->update();
                $size_model->update();
                $grade_model->update();
                
                $transaction->commit();
                $done = TRUE;
                
            } catch (CDbException $exc) {
                $transaction->rollback();
            }
            
            if($done) {
                Yii::app()->user->setFlash('success', 'Product successfully updated.');
                $this->redirect(array('manage/'));
            }
        }
        
        $this->render('update', array(
            'model' => $model,
            'grades' => $grades,
            'sizes' => $sizes,
            'colors' => $colors,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (!Yii::app()->request->isAjaxRequest) {
            throw new CHttpException(400, 'Bad Request.');
        }

        $model = $this->loadModel($id);
        $model->status = 0;
        $model->update();
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new ProductDetails('search');

        $this->pageTitle = Yii::app()->name . ' - Product List';
        $this->pageHeader = 'Product List';
        $pageSize = 0;

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductDetails'])) {
            $model->attributes = $_GET['ProductDetails'];
        }

        if (isset($_GET['ProductDetails']['current_stock'])) {
            $model->current_stock = $_GET['ProductDetails']['current_stock'];
        }

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            $model->pageSize = $pageSize;
            unset($_GET['pageSize']);
        }

        if (!Yii::app()->user->isSuperAdmin) {
            $model->store_id = Yii::app()->user->storeId;
        } else {
            $model->store_id = 1;
        }

        $this->render('index', array(
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    public function actionBarcode() {

        ini_set('max_execution_time', 0);
        
        $modPurchase = new PurchaseCartItems();
        $purchaseRecords = $modPurchase->itemListForBarcode();
        
        $barcode['filetype'] = 'PNG';
        $barcode['dpi'] = 300;
        $barcode['scale'] = 1;
        $barcode['rotation'] = 0;
        $barcode['font_family'] = 'Arial.ttf';
        $barcode['font_size'] = 7;
        $barcode['thickness'] = 35;
        $barcode['codetype'] = 'BCGean13';
        
        $mPDF1 = Yii::app()->ePdf->mpdf();
        
        $this->render('barcode', array(
            'purchaseRecords' => ($purchaseRecords) ? $purchaseRecords : array(),
            'pdf' => $mPDF1,
            'barcode' => $barcode,
        ));
    }

    public function actionDownloadBarcode() {

        $webroot = Yii::getPathOfAlias('webroot');
        $pdfs_path = $webroot . DIRECTORY_SEPARATOR . 'barcode_pdfs' . DIRECTORY_SEPARATOR;
        $name = Yii::app()->request->getParam('barcode');

        if (file_exists($pdfs_path . $name)) {
            Yii::app()->getRequest()->sendFile($name, file_get_contents($pdfs_path . $name));
        } else {
            throw new CException(404, 'File not found.');
        }
    }

    public function actionBarcodeFileList() {

        $webroot = Yii::getPathOfAlias('webroot');
        $pdfs_path = $webroot . DIRECTORY_SEPARATOR . 'barcode_pdfs';

        $files = CFileHelper::findFiles($pdfs_path);

        $response = array();
        if (!empty($files)) {
            foreach ($files as $file) {
                $ar_file_name = explode('/', $file);
                $response[] = end($ar_file_name);
            }
        }
        echo json_encode($response);
        Yii::app()->end();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ProductDetails the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {

        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $criteria = new CDbCriteria();
        $criteria->compare('t.id', $id);
        $criteria->compare('t.store_id', $store_id);

        $model = ProductDetails::model()->with(array('category', 'supplier', 'productGrade'))->find($criteria);

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

            $str_store_condition = "";
            if (!Yii::app()->user->isSuperAdmin) {
                $str_store_condition = " AND pd.store_id = '" . Yii::app()->user->storeId . "'";
            }

            if ((!Yii::app()->user->isGuest) && (Yii::app()->request->isAjaxRequest) && !empty($term)) {
                $ar_result = Yii::app()->db->createCommand()->select('id, product_name')->from('cims_product_details pd')->where("pd.product_name like '%" . $term . "%' AND status = '1'" . $str_store_condition)->limit(50)->queryAll();
            }

            $return_array = array();
            foreach ($ar_result as $result) {
                $return_array[] = array(
                    'id' => $result['id'],
                    'value' => $result['product_name'],
                );
            }

            echo CJSON::encode($return_array);
        }
    }

    public function actionUpdate_stock($id) {

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        } else {
            $store_id = 1;
        }

        $model = new ProductStockAvail;
        $model = $model->getStockByProdId($id, $store_id);

        if (isset($_POST['ProductStockAvail'])) {
            $model->attributes = $_POST['ProductStockAvail'];

            $model->store_id = $store_id;

            if ($model->validate()) {
                if ($model->update()) {
                    Yii::app()->user->setFlash('success', 'Stock Successfully Updated.');
                } else {
                    Yii::app()->user->setFlash('error', 'Stock Could Not Be Updated.');
                }
            }
        }

        $this->render('update_stock', array('model' => $model));
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

        $ProductDetails = new ProductDetails();

        $ProductDetails->pageSize = 20;
        $query_params = array(
            'offset' => $offest,
            'order' => ${DataGridHelper::$_ar_non_filterable_vars['sort']} . ' ' . ${DataGridHelper::$_ar_non_filterable_vars['order']},
            'where' => $_POST,
        );

        $result['rows'] = $ProductDetails->dataGridRows($query_params);
//        var_dump($result['rows']);exit;
        $result["total"] = 0;

        if (($result['rows'])) {
            $result["total"] = $result['rows'][0]['total_rows'];
        }
        echo CJSON::encode($result);
        Yii::app()->end();
    }

    public function actionGetStatusComboData() {
        echo CJSON::encode(CategoryDetails::model()->statusComboData());
    }

    /**
     * Performs the AJAX validation.
     * @param ProductDetails $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-details-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
