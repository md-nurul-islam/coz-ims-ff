<?php

class SizeController extends Controller {

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
                'actions' => array('create', 'update', 'index', 'view', 'getdata', 'getStatusComboData'),
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
        $this->pageTitle = Yii::app()->name . ' - Size Details';
        $this->pageHeader = 'Size Details';
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Sizes;

        $this->pageHeader = 'Add Size';
        $this->pageTitle = Yii::app()->name . ' - Add Size';

        if (isset($_POST['Sizes'])) {
            $model->attributes = $_POST['Sizes'];
            $model->name = ucfirst(trim($model->name));

            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Sizes successfully added.');
                $this->redirect(array('create'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->pageTitle = Yii::app()->name . ' - Update Size';
        $this->pageHeader = 'Update Size';

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Sizes'])) {
            $model->attributes = $_POST['Sizes'];
            $model->name = ucfirst($model->name);

            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Sizes successfully updated.');
                $this->redirect(array('update', 'id' => $model->id));
            }
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
        $this->pageTitle = Yii::app()->name . ' - Size List';
        $this->pageHeader = 'Size List';
        $this->render('index');
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CustomerDetails the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Sizes::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
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

        $Sizes = new Sizes();
        $Sizes->pageSize = 20;
        $query_params = array(
            'offset' => $offest,
            'order' => ${DataGridHelper::$_ar_non_filterable_vars['sort']} . ' ' . ${DataGridHelper::$_ar_non_filterable_vars['order']},
            'where' => $_POST,
        );

        $result['rows'] = $Sizes->dataGridRows($query_params);
//        var_dump($result['rows']);exit;
        $result["total"] = 0;

        if (($result['rows'])) {
            $result["total"] = $result['rows'][0]['total_rows'];
        }
        echo CJSON::encode($result);
        Yii::app()->end();
    }

    public function actionGetStatusComboData() {
        echo CJSON::encode(Sizes::model()->statusComboData());
    }

    /**
     * Performs the AJAX validation.
     * @param CustomerDetails $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'customer-details-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
