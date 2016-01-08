<?php

/**
 * This is the model class for table "cims_exchange_cart".
 *
 * The followings are the available columns in table 'cims_exchange_cart':
 * @property integer $id
 * @property string $grand_total_returnable
 * @property string $grand_total_adjustable
 * @property string $discount
 * @property string $vat
 */
class ExchangeCart extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cims_exchange_cart';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('grand_total_returnable, grand_total_adjustable, discount, vat', 'length', 'max' => 13),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, grand_total_returnable, grand_total_adjustable, discount, vat', 'safe', 'on' => 'search'),
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
            'grand_total_returnable' => 'Grand Total Returnable',
            'grand_total_adjustable' => 'Grand Total Adjustable',
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
        $criteria->compare('grand_total_returnable', $this->grand_total_returnable, true);
        $criteria->compare('grand_total_adjustable', $this->grand_total_adjustable, true);
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
     * @return ExchangeCart the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
