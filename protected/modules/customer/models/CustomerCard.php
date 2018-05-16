<?php

/**
 * This is the model class for table "cims_customer_details".
 *
 * The followings are the available columns in table 'cims_customer_details':
 * @property integer $id
 * @property string $customer_name
 * @property string $customer_address
 * @property string $customer_contact1
 * @property string $customer_contact2
 * @property integer $balance
 *
 * The followings are the available model relations:
 * @property ProductStockSales[] $productStockSales
 * @property Transactions[] $transactions
 */
class CustomerCard extends CActiveRecord {

    public $pageSize = 20;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cims_customer_card';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('customer_id, card_type, card_number', 'required'),
            array('card_cvc', 'max' => 4),
            array('id, customer_id, card_type, card_number', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'customerDetails' => array(self::BELONGS_TO, 'CustomerDetails', 'customer_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'customer_id' => 'Customer Name',
            'card_type' => 'Card Povider',
            'card_number' => 'Card Number',
            'card_cvc' => 'Card CVC',
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
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function create($data) {
        $this->customer_id = $data['customer_id'];
        $this->card_type = $data['card_type'];
        $this->card_number = $data['card_number'];
        if (isset($data['card_cvc'])) {
            $this->card_cvc = $data['card_cvc'];
        }
        $this->status = 1;
        return $this->insert();
    }

}
