<?php

/**
 * This is the model class for table "cims_product_details".
 *
 * The followings are the available columns in table 'cims_product_details':
 * @property integer $id
 * @property integer $category_id
 * @property integer $supplier_id
 * @property string $product_name
 * @property string $purchase_price
 * @property string $selling_price
 * @property string $create_date
 * @property string $update_date
 * @property string $uom
 *
 * The followings are the available model relations:
 * @property CategoryDetails $category
 * @property SupplierDetails $supplier
 * @property ProductStockAvail[] $productStockAvails
 * @property ProductStockEntries[] $productStockEntries
 * @property ProductStockSales[] $productStockSales
 */
class ProductDetails extends CActiveRecord {

    public $pageSize = 20;
    public $current_stock;
    public $main_product_name;
    public $ex_product_name;
    public $category_name;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cims_product_details';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('category_id, supplier_id, product_name, create_date', 'required'),
            array('category_id, supplier_id', 'numerical', 'integerOnly' => true),
            array('purchase_price, selling_price', 'numerical'),
            array('product_name', 'length', 'max' => 255),
            array('purchase_price, selling_price', 'length', 'max' => 12),
            array('update_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, category_id, supplier_id, product_name, purchase_price, selling_price, create_date, update_date, uom', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'category' => array(self::BELONGS_TO, 'CategoryDetails', 'category_id', 'joinType' => 'INNER JOIN'),
            'supplier' => array(self::BELONGS_TO, 'SupplierDetails', 'supplier_id', 'select' => 'id, supplier_name', 'joinType' => 'INNER JOIN'),
            'productStockAvails' => array(self::HAS_ONE, 'ProductStockAvail', 'product_details_id',
                'select' => 'productStockAvails.id, productStockAvails.quantity',
                'joinType' => 'INNER JOIN',
            ),
            'productStockEntries' => array(self::HAS_MANY, 'ProductStockEntries', 'product_details_id'),
            'productStockSales' => array(self::HAS_MANY, 'ProductStockSales', 'product_details_id'),
            'productGrade' => array(self::HAS_MANY, 'ProductGrade', 'product_details_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'category_id' => 'Category Name',
            'supplier_id' => 'Supplier Name',
            'product_name' => 'Product Name',
            'purchase_price' => 'Last Purchase Price',
            'selling_price' => 'Current Selling Price',
            'create_date' => 'Created Date',
            'update_date' => 'Last Update Date',
            'status' => 'Status',
        );
    }

    /**
     * @return array for Data Grid Headers customized attribute labels (name=>label)
     * remove the attributes don't needed in the Grid
     */
    public function dataGridHeaders() {
        return array(
            'id' => array('label' => 'ID', 'sortable' => 'true', 'width' => 50),
            'category_name' => array('label' => 'Category Name', 'sortable' => 'true', 'width' => 80),
            'supplier_name' => array('label' => 'Supplier Name', 'sortable' => 'true', 'width' => 80),
            'product_name' => array('label' => 'Product Name', 'sortable' => 'true', 'width' => 180),
            'color_name' => array('label' => 'Color', 'sortable' => 'true', 'width' => 80),
            'grade_name' => array('label' => 'Grade', 'sortable' => 'true', 'width' => 80),
            'size_name' => array('label' => 'Size', 'sortable' => 'true', 'width' => 80),
            'quantity' => array('label' => 'Stock', 'sortable' => 'true', 'width' => 50),
            'purchase_price' => array('label' => 'Cost', 'sortable' => 'true', 'width' => 50),
            'selling_price' => array('label' => 'Price', 'sortable' => 'true', 'width' => 50),
            'status' => array('label' => 'Status', 'sortable' => 'true', 'width' => 80)
        );
    }

    public function dataGridFilters() {
        return array(
            'category_name' => array('id' => 'category_name', 'class' => 'easyui-textbox', 'label' => 'Category: ', 'style' => 'width:80px;'),
            'supplier_name' => array('id' => 'supplier_name', 'class' => 'easyui-textbox', 'label' => 'Supplier: ', 'style' => 'width:80px;'),
            'product_name' => array('id' => 'product_name', 'class' => 'easyui-textbox', 'label' => 'Product: ', 'style' => 'width:80px;'),
            'color_name' => array('id' => 'color_name', 'class' => 'easyui-textbox', 'label' => 'Color: ', 'style' => 'width:80px;'),
            'grade_name' => array('id' => 'grade_name', 'class' => 'easyui-textbox', 'label' => 'Grade: ', 'style' => 'width:80px;'),
            'size_name' => array('id' => 'size_name', 'class' => 'easyui-textbox', 'label' => 'Size: ', 'style' => 'width:80px;'),
            'quantity' => array('id' => 'quantity', 'class' => 'easyui-textbox', 'label' => 'Qty: ', 'style' => 'width:80px;'),
            'purchase_price' => array('id' => 'purchase_price', 'class' => 'easyui-textbox', 'label' => 'Cost: ', 'style' => 'width:80px;'),
            'selling_price' => array('id' => 'selling_price', 'class' => 'easyui-textbox', 'label' => 'Price: ', 'style' => 'width:80px;'),
            'status' => array('id' => 'status', 'class' => 'easyui-combobox', 'label' => 'Status',
                'data-options' => "valueField: 'id', textField: 'text', url: '/product/manage/getStatusComboData' ",
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
                ->join(CategoryDetails::model()->tableName() . ' c', 'c.id = t.category_id')
                ->join(SupplierDetails::model()->tableName() . ' s', 's.id = t.supplier_id')
                ->join(ProductStockAvail::model()->tableName() . ' ps', 't.id = ps.product_details_id')
                ->leftJoin(ProductColor::model()->tableName() . ' pc', 't.id = pc.product_details_id')
                ->leftJoin(Color::model()->tableName() . ' cl', 'pc.color_id = cl.id')
                ->leftJoin(ProductGrade::model()->tableName() . ' pg', 't.id = pg.product_details_id')
                ->leftJoin(Grade::model()->tableName() . ' gr', 'pg.grade_id = gr.id')
                ->leftJoin(ProductSize::model()->tableName() . ' psz', 't.id = psz.product_details_id')
                ->leftJoin(Sizes::model()->tableName() . ' sz', 'psz.size_id = sz.id')
                ->offset($offset)
                ->limit($this->pageSize)
                ->order($order)
        ;
        
        $sub_command = Yii::app()->db->createCommand()
                ->select('count(t.id)')
                ->from($this->tableName() . ' t')
                ->join(CategoryDetails::model()->tableName() . ' c', 'c.id=t.category_id')
                ->join(SupplierDetails::model()->tableName() . ' s', 's.id=t.supplier_id')
                ->join(ProductStockAvail::model()->tableName() . ' ps', 't.id=ps.product_details_id')
                ->leftJoin(ProductColor::model()->tableName() . ' pc', 't.id = pc.product_details_id')
                ->leftJoin(Color::model()->tableName() . ' cl', 'pc.color_id = cl.id')
                ->leftJoin(ProductGrade::model()->tableName() . ' pg', 't.id = pg.product_details_id')
                ->leftJoin(Grade::model()->tableName() . ' gr', 'pg.grade_id = gr.id')
                ->leftJoin(ProductSize::model()->tableName() . ' psz', 't.id = psz.product_details_id')
                ->leftJoin(Sizes::model()->tableName() . ' sz', 'psz.size_id = sz.id')
        ;
        
        $filter_keys = array_keys($this->dataGridFilters());
        if (isset($params['where']) && !empty($params['where'])) {
            $new_command_objs = DataGridHelper::processFilterableVars($command, $params['where'], $filter_keys, 't', $sub_command);
            $command = $new_command_objs[0];
            $sub_command = $new_command_objs[1];
        }
        
        $command->select(
            't.id,
            t.product_name,
            t.purchase_price,
            t.selling_price,
            CASE t.status WHEN "1" THEN "Active" ELSE "Inactive" END AS `status`,
            c.category_name,
            s.supplier_name,
            ps.quantity,
            (' . $sub_command->getText() . ') AS total_rows,
            cl.name as color_name,
            gr.name as grade_name,
            sz.name as size_name'
        );
        
        return $command->queryAll();
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

        $criteria->with = array(
            'category' => array(
                'select' => 'category.id, category.category_name as category_name',
            ),
            'supplier',
            'productStockAvails'
        );
        $criteria->compare('t.id', $this->id);
        $criteria->compare('category.category_name', $this->category_name, true);
        $criteria->compare('supplier.supplier_name', $this->supplier_id, true);
        $criteria->compare('product_name', $this->product_name, true);
        $criteria->compare('purchase_price', $this->purchase_price, true);
        $criteria->compare('selling_price', $this->selling_price, true);
        $criteria->compare('category.category_name', $this->category_id, true);
        $criteria->compare('productStockAvails.quantity', $this->current_stock, true);
        $criteria->compare('t.store_id', Yii::app()->user->storeId);

        $criteria->compare('t.status', 1);
        $criteria->order = 't.id DESC';
        $criteria->together = true;

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => $this->pageSize,
            ),
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductDetails the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
