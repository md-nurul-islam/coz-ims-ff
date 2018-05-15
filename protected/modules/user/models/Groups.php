<?php

/**
 * This is the model class for table "cims_grade".
 *
 * The followings are the available columns in table 'cims_grade':
 * @property integer $id
 * @property string $name
 * @property integer $status
 */
class Groups extends CActiveRecord {

    public $pageSize = 20;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cims_groups';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('group_name', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('group_name', 'length', 'max' => 40),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('group_name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'group_name' => 'Group Name',
            'status' => 'Status',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Grade the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return array for Data Grid Headers customized attribute labels (name=>label)
     * remove the attributes don't needed in the Grid
     */
    public function dataGridHeaders() {
        return array(
            'group_name' => array('label' => 'Group Name', 'sortable' => 'true', 'width' => 80),
//            'store' => array('label' => 'Store', 'sortable' => 'true', 'width' => 80),
            'status' => array('label' => 'Status', 'sortable' => 'true', 'width' => 80),
            'action' => array('label' => 'Action', 'sortable' => 'false', 'width' => 50),
        );
    }

    public function dataGridFilters() {
        return array(
            'group_name' => array('id' => 'name', 'class' => 'easyui-textbox', 'label' => 'Name: ', 'style' => 'width:80px;'),
            'status' => array('id' => 'status', 'class' => 'easyui-combobox', 'label' => 'Status',
                'data-options' => "valueField: 'id', textField: 'text', url: '/user/group/getStatusComboData' ",
                'panelHeight' => 70,
                'style' => 'width:80px; cursor: pointer;'),
        );
    }

    public function statusComboData() {

        return array(
            array(
                'id' => '',
                'text' => 'Select',
            ),
            array(
                'id' => '1',
                'text' => 'Active',
            ),
            array(
                'id' => '0',
                'text' => 'Inactive',
            ),
        );
    }

    public function dataGridRows($params = array()) {

        $offset = 0;
        if (isset($params['offset']) && $params['offset'] > 0) {
            $offset = $params['offset'];
        }

        $order = 'id DESC';
        if (isset($params['order']) && !empty(trim($params['order']))) {
            $order = trim($params['order']);
        }

        $command = Yii::app()->db->createCommand()
                ->from($this->tableName() . ' t')
                ->offset($offset)
                ->limit($this->pageSize)
                ->order($order)
        ;

        $sub_command = Yii::app()->db->createCommand()
                ->select('count(t.id)')
                ->from($this->tableName() . ' t')
        ;

        $filter_keys = array_keys($this->dataGridFilters());
        if (isset($params['where']) && !empty($params['where'])) {
            $new_command_objs = DataGridHelper::processFilterableVars($command, $params['where'], $filter_keys, 't', $sub_command);
            $command = $new_command_objs[0];
            $sub_command = $new_command_objs[1];
        }

        $command->select('
            t.id,
            t.group_name,
            CASE t.status WHEN "1" THEN "Active" ELSE "Inactive" END AS `status`,
            (' . $sub_command->getText() . ') AS total_rows
        ');

        $data = DataGridHelper::propagateActionLinks($command->queryAll(), array(
//            'view',
                    'update',
//            'delete'
        ));

        return $data;
    }

}
