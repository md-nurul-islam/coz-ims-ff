<?php

/**
 * This is the model class for table "cims_templates".
 *
 * The followings are the available columns in table 'cims_templates':
 * @property integer $id
 * @property string $text
 * @property integer $position
 * @property integer $type
 * @property string $created_date
 * @property string $updated_date
 * @property integer $status
 */
class Configurations extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cims_configurations';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('key, value, created_date, updated_date', 'required'),
            array('store_id, status', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('key, store_id, status', 'safe', 'on' => 'search'),
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
            'Key' => 'Config Key',
            'value' => 'Config Value',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('position', $this->position);
        $criteria->compare('type', $this->type);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Templates the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getPosBillHeader() {

        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $command = Yii::app()->db->createCommand();
        $command->from($this->tableName() . ' t')
                ->andWhere('t.store_id = :sid', array(':sid' => $store_id))
                ->andWhere('t.key = :key', array(':key' => 'posBillHeader'))
        ;
        return $command->queryRow();
    }

    public function getPosBillFooter() {

        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $command = Yii::app()->db->createCommand();
        $command->from($this->tableName() . ' t')
                ->andWhere('t.store_id = :sid', array(':sid' => $store_id))
                ->andWhere('t.key = :key', array(':key' => 'posBillFooter'))
        ;
        return $command->queryRow();
    }

    public function getStoreConfigs($b_all_config = false) {

        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $command = Yii::app()->db->createCommand();
        $command->from($this->tableName() . ' t')
                ->andWhere('store_id = :sid', array(':sid' => $store_id))
        ;
        $config_data = $command->queryAll();

        $fomratted_data = [];
        if (!empty($config_data)) {

            if (!$b_all_config) {
                foreach ($config_data as $config) {
                    $key = array_search($config['key'], Settings::$_bill_header_and_footer_config_keys);

                    $fomratted_data[$key]['id'] = $config['id'];
                    $fomratted_data[$key]['value'] = $config['value'];
                }
            } else {
                foreach ($config_data as $config) {
                    $fomratted_data[$config['key']]['id'] = $config['id'];
                    $fomratted_data[$config['key']]['value'] = $config['value'];
                }
            }
        }

        return $fomratted_data;
    }

    public function getFakeSaleReportLimit() {
        $configs = $this->getStoreConfigs(true);
        
        if(!array_key_exists('fakeSaleReportLimit', $configs)) {
            return false;
        }
        return $configs['fakeSaleReportLimit']['value'];
    }

}
