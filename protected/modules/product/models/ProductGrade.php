<?php

/**
 * This is the model class for table "cims_product_grade".
 *
 * The followings are the available columns in table 'cims_product_grade':
 * @property integer $id
 * @property integer $product_details_id
 * @property integer $grade_id
 */
class ProductGrade extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cims_product_grade';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_details_id, grade_id', 'required'),
            array('product_details_id, grade_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, product_details_id, grade_id', 'safe', 'on' => 'search'),
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
            'grade' => array(self::BELONGS_TO, 'Grade', 'grade_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'product_details_id' => 'Product Details',
            'grade_id' => 'Grade',
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
        $criteria->compare('grade_id', $this->grade_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductGrade the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getGrades($prod_id = 0, $grade_id = 0, $all = TRUE) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->with = array(
            'grade' => array(
                'select' => 'grade.id, grade.name',
            ),
        );

        if ($prod_id > 0) {
            $criteria->compare('t.product_details_id', $prod_id);
        }
        if ($grade_id > 0) {
            $criteria->compare('t.grade_id', $grade_id);
        }

        if (!$all) {
            $criteria->limit = 1;
            $data = $this->find($criteria);
        } else {
            $data = $this->findAll($criteria);
        }

        return (!empty($data)) ? $data : FALSE;
    }

}
