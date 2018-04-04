<?php

class GroupController extends Controller {

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
                    'create',
                    'getdata',
                    'getStatusComboData'
                ),
                'expression' => '(!Yii::app()->user->isGuest && Yii::app()->user->isSuperAdmin)',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    
    public function actionIndex() {
        $this->render('index');
    }

    public function actionCreate() {

        $model = new Groups;
        
//        $this->performAjaxValidation($model);

        if (isset($_POST['Groups'])) {

            $model->attributes = $_POST['Groups'];
            if ($model->validate()) {
                $model->salt = $model->getPasswordSalt();
                $model->hashed_password = $model->getPassword($model->salt, $model->new_password);

                if ($model->save()) {
                    Yii::app()->user->setFlash('success', 'New Password successfully set.');
//                    $this->redirect(array('print', 'sales_id' => $model->sales_id));
                    $this->redirect('changePassword');
                }
            }
        }

        $this->render('create', array(
            'model' => $model
        ));
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

        $Groups = new Groups();
        $Groups->pageSize = 20;
        $query_params = array(
            'offset' => $offest,
            'order' => ${DataGridHelper::$_ar_non_filterable_vars['sort']} . ' ' . ${DataGridHelper::$_ar_non_filterable_vars['order']},
            'where' => $_POST,
        );

        $result['rows'] = $Groups->dataGridRows($query_params);
//        var_dump($result['rows']);exit;
        $result["total"] = 0;

        if (($result['rows'])) {
            $result["total"] = $result['rows'][0]['total_rows'];
        }
        echo CJSON::encode($result);
        Yii::app()->end();
    }

    public function actionGetStatusComboData() {
        echo CJSON::encode(Groups::model()->statusComboData());
    }

    /**
     * Performs the AJAX validation.
     * @param ProductDetails $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'change-password-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
