<?php

class AuthController extends Controller {

    public $defaultAction = 'login';
    public $layout = 'application.views.layouts.login';

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionlogin() {
        $this->pageTitle = Yii::app()->name . ' | Login';
        
        $model = new User('login');

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo $model->validate();
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];

            if (isset($_POST['User']['rememberMe']) && !empty($_POST['User']['rememberMe'])) {
                $model->rememberMe = $_POST['User']['rememberMe'];
            }

            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                
                $url = Yii::app()->user->returnUrl;
                if($url == '/') {
                    $url = '/product/sale/create';
                }
                
                $this->redirect($url);
            }
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}
