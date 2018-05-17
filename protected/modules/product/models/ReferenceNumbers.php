<?php

/**
 * This is the model class for table "cims_reference_numbers".
 *
 * The followings are the available columns in table 'cims_reference_numbers':
 * @property string $id
 * @property string $reference_number
 * @property string $purchase_cart_item_id
 * @property integer $product_details_id
 * @property string $created_date
 * @property string $updated_date
 * @property integer $status
 * @property integer $left_number_of_usage
 */
class ReferenceNumbers extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cims_reference_numbers';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, store_id', 'required'),
            array('product_details_id, status, left_number_of_usage', 'numerical', 'integerOnly' => true),
            array('id, purchase_cart_item_id', 'length', 'max' => 20),
            array('reference_number', 'length', 'max' => 12),
            array('created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, reference_number, purchase_cart_item_id, product_details_id, created_date, updated_date, status, left_number_of_usage', 'safe', 'on' => 'search'),
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
            'reference_number' => 'Reference Number',
            'purchase_cart_item_id' => 'Purchase Cart Item',
            'product_details_id' => 'Product Details',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'status' => 'Status',
            'left_number_of_usage' => 'Left Number Of Usage',
            'store_id' => 'Store',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('reference_number', $this->reference_number, true);
        $criteria->compare('purchase_cart_item_id', $this->purchase_cart_item_id, true);
        $criteria->compare('product_details_id', $this->product_details_id);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('left_number_of_usage', $this->left_number_of_usage);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ReferenceNumbers the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getProductStockInfo($prod_id = '', $ref_num = '', $checksum = '', $all = false) {

        $store_id = 1;

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $pre_query = Yii::app()->db->createCommand()
                ->select('t.id, t.purchase_cart_item_id, t.product_details_id')
                ->from($this->tableName() . ' t')
                ->andWhere('reference_number = :ref_num', array(':ref_num' => $ref_num))
//                ->andWhere('checksum_digit = :checksum', array(':checksum' => $checksum))
                ->andWhere('store_id = :sid', array(':sid' => $store_id))
                ->andWhere('status = :status', array(':status' => 1))
                ->queryRow();

        if (empty($pre_query)) {
            return FALSE;
        }

        if (!empty($pre_query['purchase_cart_item_id']) && $pre_query['purchase_cart_item_id'] > 0) {

            $command = Yii::app()->db->createCommand()
                    ->from(PurchaseCartItems::model()->tableName() . ' t')
                    ->join(ProductDetails::model()->tableName() . ' pd', 'pd.id = t.product_details_id')
                    ->join(ProductStockAvail::model()->tableName() . ' psa', 'psa.product_details_id = pd.id')
                    ->leftJoin(ProductColor::model()->tableName() . ' pc', 'pc.product_details_id = pd.id')
                    ->leftJoin(Color::model()->tableName() . ' c', 'pc.color_id = c.id')
                    ->leftJoin(ProductSize::model()->tableName() . ' ps', 'ps.product_details_id = pd.id')
                    ->leftJoin(Sizes::model()->tableName() . ' s', 'ps.size_id = s.id')
                    ->leftJoin(ProductGrade::model()->tableName() . ' pg', 'pg.product_details_id = pd.id')
                    ->leftJoin(Grade::model()->tableName() . ' g', 'pg.grade_id = g.id')
            ;

            $command->andWhere('t.reference_number_id = :ref_num_id', array(':ref_num_id' => $pre_query['id']));

            if (!empty($prod_id)) {
                $command->andWhere('t.product_details_id = :pid', array(':pid' => $prod_id));
            } else {
                $command->group('t.product_details_id');
            }
        } else {
            $command = Yii::app()->db->createCommand()
                    ->from(ProductDetails::model()->tableName() . ' pd')
                    ->join(ProductStockAvail::model()->tableName() . ' psa', 'psa.product_details_id = pd.id')
            ;
            $command->andWhere('pd.id = :pid', array(':pid' => $pre_query['product_details_id']));

            if (!empty($prod_id)) {
                $command->andWhere('pd.id = :pid', array(':pid' => $prod_id));
            } else {
                $command->group('pd.id');
            }
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

        return (!empty($data)) ? $data : false;
    }

    public function getProductStockInfoByName($prod_id = '', $ref_num = '', $checksum = '', $all = false) {

        $store_id = 1;

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $command = Yii::app()->db->createCommand()
                ->select('*, c.name AS color_name, s.name AS size_name, g.name AS grade_name')
                ->from(ProductDetails::model()->tableName() . ' pd')
                ->join(ProductStockAvail::model()->tableName() . ' psa', 'psa.product_details_id = pd.id')
                ->leftJoin(ProductColor::model()->tableName() . ' pc', 'pc.product_details_id = pd.id')
                ->leftJoin(Color::model()->tableName() . ' c', 'pc.color_id = c.id')
                ->leftJoin(ProductSize::model()->tableName() . ' ps', 'ps.product_details_id = pd.id')
                ->leftJoin(Sizes::model()->tableName() . ' s', 'ps.size_id = s.id')
                ->leftJoin(ProductGrade::model()->tableName() . ' pg', 'pg.product_details_id = pd.id')
                ->leftJoin(Grade::model()->tableName() . ' g', 'pg.grade_id = g.id')
        ;
        $command->andWhere('pd.product_name LIKE :p_name', array(':p_name' => $ref_num . '%'));

        $command->group('pd.id');

        $command->andWhere('pd.store_id = :sid', array(':sid' => $store_id));
        $command->andWhere('pd.status = :status', array(':status' => '1'));

        if (!empty($prod_id)) {
            $command->andWhere('pd.id = :pid', array(':pid' => $prod_id));
        } else {
            $command->group('pd.id');
        }

        $command->order('pd.id DESC');

        if (!$all) {
            $command->limit(1);
            $data = $command->queryRow();
        } else {
            $data = $command->queryAll();
        }
        
        return (!empty($data)) ? $data : FALSE;
    }

}
