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
                'actions' => array('update'),
                'expression' => 'Yii::app()->user->isSuperAdmin || Yii::app()->user->isStoreAdmin',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate() {
        $this->pageHeader = 'Update Store';
        $now = date('Y-m-d H:i:s', Settings::getBdLocalTime());
        $model_config_data = [];

        $id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $id = Yii::app()->user->storeId;
        }

        $model = $this->loadModel($id);
        $model_config = new Configurations();
        $model_config_data = $model_config->getStoreConfigs();
        
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['StoreDetails'])) {
            $model->attributes = $_POST['StoreDetails'];
            
            if (isset($_POST['Configurations']) && !empty($_POST['Configurations']) && !empty($_POST['Configurations']['value'])) {
            
                foreach ($_POST['Configurations']['value'] as $key => $value) {
                    
                    if( isset($value['id']) && !empty($value['id']) ) {
                        
                        $config = Configurations::model()->findByAttributes(array('id' => $value['id']));
                    } else {
                        
                        $config = new Configurations;
                        $config->created_date = $now;
                        $config->key = Settings::$_bill_header_and_footer_config_keys[$key];
                        $config->store_id = $id;
                    }
                    
                    $config->updated_date = $now;
                    $config->value = $value['value'];
                    
                    $config->save();
                }
            }

            if ($model->save()) {
                $this->redirect(array('update'));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'model_config' => $model_config,
            'model_config_data' => $model_config_data,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return StoreDetails the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = StoreDetails::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param StoreDetails $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'store-details-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
