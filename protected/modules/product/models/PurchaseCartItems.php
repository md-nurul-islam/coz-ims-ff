<?php

/**
 * This is the model class for table "cims_purchase_cart_items".
 *
 * The followings are the available columns in table 'cims_purchase_cart_items':
 * @property integer $id
 * @property string $cart_id
 * @property integer $product_details_id
 * @property integer $reference_number
 * @property string $cost
 * @property string $price
 * @property integer $quantity
 * @property string $sub_total
 * @property integer $product_color_id
 * @property integer $product_size_id
 * @property integer $product_grade_id
 * @property string $discount
 * @property string $vat
 */
class PurchaseCartItems extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cims_purchase_cart_items';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cart_id, product_details_id, cost, price, quantity, product_color_id, product_size_id, product_grade_id', 'required'),
            array('product_details_id, reference_number, quantity, product_color_id, product_size_id, product_grade_id', 'numerical', 'integerOnly' => true),
            array('cart_id', 'length', 'max' => 10),
            array('cost, price, sub_total, discount, vat', 'length', 'max' => 13),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, cart_id, product_details_id, reference_number, cost, price, quantity, sub_total, product_color_id, product_size_id, product_grade_id, discount, vat', 'safe', 'on' => 'search'),
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
            'cart_id' => 'Cart',
            'product_details_id' => 'Product Details',
            'reference_number' => 'Reference Number',
            'cost' => 'Cost',
            'price' => 'Price',
            'quantity' => 'Quantity',
            'sub_total' => 'Sub Total',
            'product_color_id' => 'Product Color',
            'product_size_id' => 'Product Size',
            'product_grade_id' => 'Product Grade',
            'discount' => 'Discount',
            'vat' => 'Vat',
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
        $criteria->compare('cart_id', $this->cart_id, true);
        $criteria->compare('product_details_id', $this->product_details_id);
        $criteria->compare('reference_number', $this->reference_number);
        $criteria->compare('cost', $this->cost, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('sub_total', $this->sub_total, true);
        $criteria->compare('product_color_id', $this->product_color_id);
        $criteria->compare('product_size_id', $this->product_size_id);
        $criteria->compare('product_grade_id', $this->product_grade_id);
        $criteria->compare('discount', $this->discount, true);
        $criteria->compare('vat', $this->vat, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PurchaseCartItems the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getProductStockInfo($prod_id = '', $ref_num = '', $all = false) {

        $store_id = 1;

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $command = Yii::app()->db->createCommand()
                ->from($this->tableName() . ' t')
                ->join(ProductDetails::model()->tableName() . ' pd', 'pd.id = t.product_details_id')
                ->join(ProductStockAvail::model()->tableName() . ' psa', 'psa.product_details_id = pd.id')
        ;
        
        if (!empty($prod_id)) {
            $command->andWhere('t.product_details_id = :pid', array(':pid' => $prod_id));
        } else {
            $command->group('t.product_details_id');
        }
        
        if (!empty($ref_num)) {
            $command->andWhere('t.reference_number = :ref_num', array(':ref_num' => $ref_num));
        }

        $command->andWhere('pd.store_id = :sid', array(':sid' => $store_id));
        $command->andWhere('pd.status = :status', array(':status' => '1'));
        
        $command->order('pd.id DESC');
        
        if (!$all) {
            $command->limit(1);
            $data = $command->queryRow();
        } else {
            $data = $command->queryAll();
        }

        return (!empty($data)) ? $data : FALSE;
    }

    public function itemListForBarcode() {

        $command = Yii::app()->db->createCommand()
                ->from($this->tableName() . ' t')
                ->join(ProductDetails::model()->tableName() . ' pd', 'pd.id = t.product_details_id')
                ->join(ProductStockEntries::model()->tableName() . ' pse', 'pse.purchase_cart_id = t.cart_id')
                ->limit(100)
        ;

        $command->select('t.id, pd.product_name, t.reference_number, t.cost, t.price, t.quantity, pse.purchase_date');

        $command->where('reference_number = 0 OR reference_number = "" OR reference_number IS NULL');
        $itemList = $this->formatPurchaseBarcodeData($command->queryAll());

        return $itemList;
    }

    private function formatPurchaseBarcodeData($ar_data) {

        $formatted_data = array();
        $date = date('ymd');

        foreach ($ar_data as $row) {

            $_data['id'] = $row['id'];
            $_data['code'] = (empty($row['reference_number'])) ? Settings::getToken(12, FALSE) : $row['reference_number'];

            $code_length = strlen($_data['code']);
            $num_zeros = 0;
            if (strlen($_data['code']) < 12) {
                $num_zeros = 12 - $code_length;
            }

            for ($i = 1; $i <= $num_zeros; $i++) {
                $_data['code'] .= '1';
            }

            $_data['purchase_price'] = $row['cost'];
            $_data['selling_price'] = $row['price'];
            $_data['product_name'] = $row['product_name'];
            $_data['quantity'] = $row['quantity'];
            $_data['purchase_date'] = str_replace('-', '', $row['purchase_date']);

            $formatted_data[] = $_data;
        }

        return $formatted_data;
    }

}
