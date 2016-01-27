<?php

class StockController extends Controller {

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
                'actions' => array('index',),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {

        $msg = '';

        $this->pageTitle = Yii::app()->name . ' - Stock Report';
        $this->pageHeader = 'Stock Report';
        
        $model = ProductStockAvail::model()->getStockReportData();
        
        if (!$model) {
            $msg = 'No data found.';
        }

        $this->render('index', array(
            'model' => $model,
            'msg' => $msg,
        ));
    }

}
