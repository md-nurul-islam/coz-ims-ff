<?php

/**
 * This is the model class for table "cims_product_stock_avail".
 *
 * The followings are the available columns in table 'cims_product_stock_avail':
 * @property integer $id
 * @property integer $product_details_id
 * @property string $quantity
 *
 * The followings are the available model relations:
 * @property ProductDetails $productDetails
 */
class ProductStockAvail extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cims_product_stock_avail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_details_id, quantity', 'required'),
            array('product_details_id', 'numerical', 'integerOnly' => true),
            array('quantity', 'numerical', 'min' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, product_details_id, quantity', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'productDetails' => array(self::BELONGS_TO, 'ProductDetails', 'product_details_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'product_details_id' => 'Product Details',
            'quantity' => 'Quantity',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('product_details_id', $this->product_details_id);
        $criteria->compare('quantity', $this->quantity, true);

        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('t.store_id', Yii::app()->user->storeId);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductStockAvail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getStockByProdId($prod_id, $store_id = 1, $grade_id = 0) {

        $criteria = new CDbCriteria;

        $criteria->compare('t.product_details_id', $prod_id);

        $criteria->compare('t.store_id', $store_id);

        if ($grade_id > 0) {
            $criteria->compare('t.grade_id', $grade_id);
        }

        $criteria->compare('productDetails.store_id', $store_id);

        $criteria->order = 't.id DESC';
        $criteria->limit = 1;
        $criteria->with = array('productDetails');

        $data = $this->find($criteria);
        return (!empty($data)) ? $data : FALSE;
    }

    /**
     * NEW CODES
     */
    public function getStockReportData() {

        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $sub_command_sold_qty = Yii::app()->db->createCommand()
                ->select('SUM(ci.quantity)')
                ->from(CartItems::model()->tableName() . ' ci')
                ->where('ci.product_details_id = psa.id')
        ;

        $sub_command_purchased_qty = Yii::app()->db->createCommand()
                ->select('SUM(pci.quantity)')
                ->from(PurchaseCartItems::model()->tableName() . ' pci')
                ->where('pci.product_details_id = psa.id')
        ;

        $sub_command_table_name = Yii::app()->db->createCommand()
                ->select('id, product_details_id, quantity, store_id')
                ->from(ProductStockAvail::model()->tableName() . ' psa')
                ->group('psa.product_details_id')
        ;

        $sub_command_join = Yii::app()->db->createCommand()
                ->select('pd.id, pd.product_name')
                ->from(ProductDetails::model()->tableName() . ' pd')
                ->group('pd.id')
        ;

        $command = Yii::app()->db->createCommand();
        $command->select(
                "
                pd.product_name,
                psa.quantity AS current_quantity,
                ({$sub_command_sold_qty->getText()}) AS sold_quantity,
                ({$sub_command_purchased_qty->getText()}) AS purchased_quantity
                "
        );
        $command->from("({$sub_command_table_name->getText()}) psa");
        $command->join("({$sub_command_join->getText()}) pd", 'psa.product_details_id = pd.id');
        $command->where('psa.store_id = :sid', array(':sid' => $store_id));
        $data = $command->queryAll();
        
        
        return (!empty($data)) ? $data : false;
    }

    /**
     * NEW CODES
     */
}
