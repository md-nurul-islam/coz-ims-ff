<?php

/**
 * This is the model class for table "cims_supplier_details".
 *
 * The followings are the available columns in table 'cims_supplier_details':
 * @property integer $id
 * @property string $supplier_name
 * @property string $supplier_address
 * @property string $supplier_contact1
 * @property string $supplier_contact2
 * @property integer $balance
 *
 * The followings are the available model relations:
 * @property ProductDetails[] $productDetails
 * @property ProductStockEntries[] $productStockEntries
 * @property ProductStockSales[] $productStockSales
 * @property Transactions[] $transactions
 */
class SupplierDetails extends CActiveRecord {

    public $pageSize = 20;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cims_supplier_details';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('supplier_name', 'required'),
            array('supplier_name', 'unique'),
            array('balance', 'numerical', 'integerOnly' => true),
            array('supplier_name', 'length', 'max' => 255),
            array('supplier_contact1, supplier_contact2', 'length', 'max' => 100),
            array('supplier_address', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, supplier_name, supplier_address, supplier_contact1, balance', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'productDetails' => array(self::HAS_MANY, 'ProductDetails', 'supplier_id'),
            'productStockEntries' => array(self::HAS_MANY, 'ProductStockEntries', 'supplier_id'),
            'productStockSales' => array(self::HAS_MANY, 'ProductStockSales', 'supplier_id'),
            'transactions' => array(self::HAS_MANY, 'Transactions', 'supplier_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'supplier_name' => 'Name',
            'supplier_address' => 'Address',
            'supplier_contact1' => 'Contact1',
            'supplier_contact2' => 'Contact2',
            'balance' => 'Balance',
            'is_default' => 'Default',
            'status' => 'Status',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->select = 'id, supplier_name, supplier_address, supplier_contact1, balance';

        $criteria->compare('id', $this->id);
        $criteria->compare('supplier_name', $this->supplier_name, true);
        $criteria->compare('supplier_address', $this->supplier_address, true);
        $criteria->compare('supplier_contact1', $this->supplier_contact1, true);
        $criteria->compare('balance', $this->balance);
        $criteria->compare('status', 1);

        /* if (!Yii::app()->user->isSuperAdmin) {
          $criteria->compare('store_id', Yii::app()->user->storeId);
          } */

        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SupplierDetails the static model class
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
            'supplier_name' => array('label' => 'Name', 'sortable' => 'true', 'width' => 80),
            'supplier_address' => array('label' => 'Address', 'sortable' => 'true', 'width' => 180),
            'supplier_contact1' => array('label' => 'Contact 1', 'sortable' => 'true', 'width' => 80),
            'supplier_contact2' => array('label' => 'Contact 2', 'sortable' => 'true', 'width' => 80),
            'balance' => array('label' => 'Balance', 'sortable' => 'true', 'width' => 80),
            'status' => array('label' => 'Status', 'sortable' => 'true', 'width' => 80),
        );
    }

    public function dataGridFilters() {
        return array(
            'supplier_name' => array('id' => 'supplier_name', 'class' => 'easyui-textbox form-control', 'label' => 'Name: ', 'style' => 'width:80px;'),
            'supplier_address' => array('id' => 'supplier_address', 'class' => 'easyui-textbox', 'label' => 'Address: ', 'style' => 'width:80px;'),
            'supplier_contact1' => array('id' => 'supplier_contact1', 'class' => 'easyui-textbox', 'label' => 'Contact 1: ', 'style' => 'width:80px;'),
            'supplier_contact2' => array('id' => 'supplier_contact2', 'class' => 'easyui-textbox', 'label' => 'Contact 2: ', 'style' => 'width:80px;'),
            'balance' => array('id' => 'balance', 'class' => 'easyui-textbox', 'label' => 'Balance: ', 'style' => 'width:80px;'),
            'status' => array('id' => 'status', 'class' => 'easyui-combobox', 'label' => 'Status',
                'data-options' => "valueField: 'id', textField: 'text', url: '/supplier/manage/getStatusComboData' ",
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
        if (isset($params['order']) && !empty($params['order'])) {
            $order = $params['order'];
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

        $command->select(
            't.id,
            t.supplier_name,
            t.supplier_address,
            t.supplier_contact1,
            t.supplier_contact2,
            CASE t.status WHEN "1" THEN "Active" ELSE "Inactive" END AS `status`,
            (' . $sub_command->getText() . ') AS total_rows,
            t.balance'
        );

        return $command->queryAll();
    }

}
