<?php

class SaleController extends Controller {

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
                'actions' => array('cumulative', 'purchase_sale'),
                'expression' => '(!Yii::app()->user->isGuest) && (Yii::app()->user->isSuperAdmin || Yii::app()->user->isStoreAdmin)',
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'advance_sale'),
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
        
        $this->pageTitle = Yii::app()->name . ' - Sale Report';
        $this->pageHeader = 'Sale Report';
        
        $today = date('Y-m-d', Settings::getBdLocalTime());
        $from_date = $today;
        $to_date = $today;
        
        if( Yii::app()->request->isPostRequest && !empty($_POST) ){
            
            $from_date = Yii::app()->request->getPost('from_date');
            $to_date = Yii::app()->request->getPost('to_date');
            
            $model = new ProductStockSales;
            $model = $model->getSaleDataForReport($from_date, $to_date);
            
            if(!$model){
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
            'partial' => '_data_table',
        ));
    }
    
    public function actionCumulative() {
        
        $model = false;
        $msg = '';
        
        $this->pageTitle = Yii::app()->name . ' - Sale Report';
        $this->pageHeader = 'Cumulative Report';
        
        $today = date('Y-m-d', Settings::getBdLocalTime());
        $from_date = $today;
        $to_date = $today;
        
        if( Yii::app()->request->isPostRequest && !empty($_POST) ){
            
            $from_date = Yii::app()->request->getPost('from_date');
            $to_date = Yii::app()->request->getPost('to_date');
            
            $model = new ProductStockSales;
            $model = $model->getSalePurchaseDataForReport($from_date, $to_date);
            
            if(!$model){
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
            'partial' => '_cumulative',
        ));
    }
    
    public function actionPurchase_sale() {
        
        $model = false;
        $msg = '';
        
        $this->pageTitle = Yii::app()->name . ' - Sale Report';
        $this->pageHeader = 'Sale / Purchase Report';
        
        $today = date('Y-m-d', Settings::getBdLocalTime());
        $from_date = $today;
        $to_date = $today;
        
        if( Yii::app()->request->isPostRequest && !empty($_POST) ){
            
            $from_date = Yii::app()->request->getPost('from_date');
            $to_date = Yii::app()->request->getPost('to_date');
            
            $model = new ProductStockSales;
            $model = $model->getSalePurchaseDataForReport($from_date, $to_date);
            
            if(!$model){
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
            'partial' => '_sale_purchase',
        ));
    }
    
    public function actionAdvance_sale() {
        
        $model = false;
        
        $this->pageTitle = Yii::app()->name . ' - Advance Sale Report';
        $this->pageHeader = 'Advance Sale Report';
        
        $today = date('Y-m-d', Settings::getBdLocalTime());
        $from_date = $today;
        $to_date = $today;
        $msg = "Advance Sales Report Starting from {$from_date} till {$to_date}";
        
        if( Yii::app()->request->isPostRequest && !empty($_POST) ){
            
            $from_date = Yii::app()->request->getPost('from_date');
            
            $to_date = Yii::app()->request->getPost('to_date');
            
            $model = new ProductStockSales;
            $model->advance_sale = TRUE;
            $model = $model->getSaleDataForReport($from_date, $to_date);
            
            if(!$model){
                $msg = 'No Record Found in the given date rang.';
            }
            
        }
        
        $this->render('index', array(
            'model' => $model,
            'msg' => $msg,
            'advance_sale_list' => TRUE,
            'today' => $today,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'partial' => '_data_table',
        ));
    }

}
