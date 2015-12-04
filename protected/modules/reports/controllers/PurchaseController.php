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
                'actions' => array('index'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {

        $model = false;
        $msg = '';

        $this->pageTitle = Yii::app()->name . ' - Purchase Report';
        $this->pageHeader = 'Purchase Report';

        $today = date('Y-m-d', Settings::getBdLocalTime());
        $from_date = $today;
        $to_date = $today;

        if (Yii::app()->request->isPostRequest && !empty($_POST)) {

            $from_date = Yii::app()->request->getPost('from_date');
            $to_date = Yii::app()->request->getPost('to_date');

            $model = new ProductStockEntries;
            $model = $model->purchaseReportData($from_date, $to_date);

            if (!$model) {
                $msg = 'No data found in the given date range.';
            }
        }

        $this->render('index', array(
            'model' => $model,
            'msg' => $msg,
            'advance_sale_list' => FALSE,
            'today' => $today,
            'from_date' => $from_date,
            'to_date' => $to_date,
        ));
    }

}
