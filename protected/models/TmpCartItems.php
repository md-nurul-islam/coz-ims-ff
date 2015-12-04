<?php

/**
 * This is the model class for table "cims_tmp_cart_items".
 *
 * The followings are the available columns in table 'cims_tmp_cart_items':
 * @property integer $id
 * @property string $cart_id
 * @property integer $product_details_id
 * @property integer $quantity
 * @property string $sub_total
 * @property string $discount
 * @property string $vat
 */
class TmpCartItems extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cims_tmp_cart_items';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cart_id, product_details_id, quantity, sub_total', 'required'),
            array('product_details_id, quantity', 'numerical', 'integerOnly' => true),
            array('cart_id', 'length', 'max' => 10),
            array('sub_total, discount, vat', 'length', 'max' => 13),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, cart_id, product_details_id, quantity, sub_total, discount, vat', 'safe', 'on' => 'search'),
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
            'quantity' => 'Quantity',
            'sub_total' => 'Sub Total',
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
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('sub_total', $this->sub_total, true);
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
     * @return TmpCartItems the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
