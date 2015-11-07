<?php

//Yii::import('zii.widgets.CPortlet');

class DataGrid extends CWidget {

    public $model;
    public $headers = array();
    public $rows = array();
    public $enableFilter = true;
    public $enablePagination = true;
    public $pageSize;
    public $numTotalRows;
    public $module = '';
    public $controller = '';
    public $action = '';
    public $url = '';

    public function init() {
        $this->model = new $this->model;
        $this->setHeaders();
        $this->setController();
        $this->setAction();
        $this->setUrl();
    }

    public function run() {
        $this->render('dataGrid');
    }

    private function setHeaders() {
        if (empty($this->headers)) {
            $this->headers = $this->model->dataGridHeaders();
        }
    }

    private function setController() {
        $this->controller = (!empty($this->controller)) ? $this->controller : Yii::app()->controller->id;
    }

    private function setAction() {
        $this->action = (!empty($this->action)) ? $this->action : Yii::app()->controller->action->id;
    }

    private function setUrl() {
        $this->url = '/';
        $this->url .= (!empty($this->module)) ? $this->module . '/' : $this->controller . '/' . $this->action;
    }

}