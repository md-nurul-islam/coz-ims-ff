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
            array('product_details_id, reference_number_id, quantity, product_color_id, product_size_id, product_grade_id', 'numerical', 'integerOnly' => true),
            array('cart_id', 'length', 'max' => 10),
            array('cost, price, sub_total, discount, vat', 'length', 'max' => 13),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, cart_id, product_details_id, reference_number_id, cost, price, quantity, sub_total, product_color_id, product_size_id, product_grade_id, discount, vat', 'safe', 'on' => 'search'),
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
            'cart_id' => 'Cart',
            'product_details_id' => 'Product Details',
            'reference_number_id' => 'Reference Number',
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
        $criteria->compare('reference_number_id', $this->reference_number_id);
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

    public function itemListForBarcode() {

        $command = Yii::app()->db->createCommand()
                ->from($this->tableName() . ' t')
                ->join(ProductDetails::model()->tableName() . ' pd', 'pd.id = t.product_details_id')
                ->join(ProductStockEntries::model()->tableName() . ' pse', 'pse.purchase_cart_id = t.cart_id')
                ->limit(100)
        ;

        $command->select('t.id, t.product_details_id, pd.product_name, t.reference_number_id, t.cost, t.price, t.quantity, pse.purchase_date');

        $command->where('reference_number_id = 0 OR reference_number_id = "" OR reference_number_id IS NULL');
        $data = $command->queryAll();

        $itemList = $this->formatPurchaseBarcodeData($data);

//        echo '<pre>';
//        var_dump($itemList);
//        exit;

        return $itemList;
    }

    private function formatPurchaseBarcodeData($ar_data) {

        $formatted_data = array();
        $num_column_break = Settings::$_num_barcode_column_per_page;

        foreach ($ar_data as $row) {

            for ($i = 0; $i < $row['quantity']; $i++) {
                $_data['id'] = $row['id'];
                $_data['product_details_id'] = $row['product_details_id'];

                $_data['code'] = (empty($row['reference_number'])) ? Settings::getUniqueId($_data['id']) : $row['reference_number'];
                $_data['purchase_price'] = $row['cost'];
                $_data['selling_price'] = $row['price'];
                $_data['product_name'] = $row['product_name'];
                $_data['quantity'] = $row['quantity'];
                $_data['purchase_date'] = str_replace('-', '', $row['purchase_date']);

                $formatted_data[] = $_data;
            }

//            $this->setReferenceNumber($_data);
        }

        return array_chunk($formatted_data, $num_column_break);
    }

    private function setReferenceNumber($data) {

        $now = date('Y-m-d H:i:s', Settings::getBdLocalTime());

        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $ref_numbers = new ReferenceNumbers;
        $ref_numbers->reference_number = $data['code'];
        $ref_numbers->purchase_cart_item_id = $data['id'];
        $ref_numbers->store_id = $store_id;
        $ref_numbers->created_date = $now;
        $ref_numbers->updated_date = $now;
        $ref_numbers->status = 1;

        if ($ref_numbers->insert()) {
            $command = Yii::app()->db->createCommand();
            $command->update(PurchaseCartItems::model()->tableName(), array(
                'reference_number_id' => $ref_numbers->id,
                    ), 'id=:id', array(':id' => $data['id']));
            return TRUE;
        }
        return FALSE;
    }

}
