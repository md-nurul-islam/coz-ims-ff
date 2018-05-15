<?php

/**
 * This is the model class for table "cims_product_stock_entries".
 *
 * The followings are the available columns in table 'cims_product_stock_entries':
 * @property integer $id
 * @property string $purchase_id
 * @property string $billnumber
 * @property string $ref_num
 * @property integer $supplier_id
 * @property integer $category_id
 * @property integer $product_details_id
 * @property integer $quantity
 * @property string $purchase_price
 * @property string $selling_price
 * @property string $purchase_date
 * @property integer $payment_type
 * @property string $item_subtotal
 * @property string $note
 * @property integer $grand_total_payable
 * @property string $grand_total_paid
 * @property string $grand_total_balance
 * @property string $due_payment_date
 * @property integer $serial_num
 *
 * The followings are the available model relations:
 * @property ProductDetails $productDetais
 * @property SupplierDetails $supplier
 * @property CategoryDetails $category
 */
class ProductStockEntries extends CActiveRecord {

    public $product_name;
    public $pageSize;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cims_product_stock_entries';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('purchase_date, payment_method', 'required'),
            array('payment_method, billnumber', 'numerical', 'integerOnly' => true),
            array('billnumber', 'length', 'max' => 11),
            array('note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('billnumber, purchase_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'productDetails' => array(self::BELONGS_TO, 'ProductDetails', 'product_details_id',
//                'select'=>'productDetails.id, productDetails.product_name',
//                'joinType'=>'INNER JOIN',
                'with' => 'productStockAvails'
            ),
            'supplier' => array(self::BELONGS_TO, 'SupplierDetails', 'supplier_id'),
            'category' => array(self::BELONGS_TO, 'CategoryDetails', 'category_id'),
            'purchaseCart' => array(self::BELONGS_TO, 'PurchaseCart', 'purchase_cart_id',
                    'with' => array('purchaseCartItems'),
                ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'billnumber' => 'Billnumber',
            'purchase_date' => 'Purchase Date',
            'due_payment_date' => 'Due Date',
            'payment_method' => 'Payment Method',
            'note' => 'Note',
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

        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('purchase_id', $this->purchase_id, true);
        $criteria->compare('billnumber', $this->billnumber, true);
        $criteria->compare('ref_num', $this->ref_num, true);
        $criteria->compare('supplier_id', $this->supplier_id);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('product_details_id', $this->product_details_id);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('purchase_price', $this->purchase_price, true);
        $criteria->compare('selling_price', $this->selling_price, true);
        $criteria->compare('purchase_date', $this->purchase_date, true);
        $criteria->compare('payment_type', $this->payment_type);
        $criteria->compare('item_subtotal', $this->item_subtotal, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('grand_total_payable', $this->grand_total_payable);
        $criteria->compare('grand_total_paid', $this->grand_total_paid, true);
        $criteria->compare('grand_total_balance', $this->grand_total_balance, true);
        $criteria->compare('due_payment_date', $this->due_payment_date, true);
        $criteria->compare('serial_num', $this->serial_num);

        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('store_id', $store_id);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductStockEntries the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getProductStockInfo($prod_id = '', $ref_num = '', $all = false) {

        $store_id = 1;

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $criteria = new CDbCriteria;
        $criteria->select = 't.id, t.purchase_price, t.selling_price, t.product_details_id';

        $criteria->with = array(
            'productDetails' => array(
                'select' => 'productDetails.id, productDetails.product_name, productDetails.purchase_price, productDetails.selling_price, productDetails.vat, productDetails.discount',
            ),
        );

        if (!empty($prod_id)) {
            $criteria->compare('t.product_details_id', $prod_id);
        } else {
            $criteria->group = 't.product_details_id';
        }

        if (!empty($ref_num)) {
            $criteria->compare('t.ref_num', $ref_num);
        }

        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('productDetails.store_id', $store_id);
            $criteria->compare('productStockAvails.store_id', $store_id);
            $criteria->compare('t.store_id', $store_id);
        }

        $criteria->compare('productDetails.status', 1);

        $criteria->order = 't.id DESC';

        if (!$all) {
            $criteria->limit = 1;
            $data = $this->find($criteria);
        } else {
            $data = $this->findAll($criteria);
        }

        return (!empty($data)) ? $data : FALSE;
    }

    public function getPurchase($id) {

        $store_id = 1;

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $criteria = new CDbCriteria;

        $criteria->with = array('purchaseCart');
        $criteria->compare('t.id', $id);

        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('productDetails.store_id', $store_id);
            $criteria->compare('productStockAvails.store_id', $store_id);
            $criteria->compare('t.store_id', $store_id);
        }

        $criteria->order = 't.id DESC';
        
        $data = $this->findAll($criteria);
        $data = $this->formatPurchaseRecords($data);
        return $data;
    }

    public function formatPurchaseRecords($obj_purchase) {

        $date = date('d-m-Y', strtotime($obj_purchase[0]->purchase_date));
        $bill_no = $obj_purchase[0]->billnumber;
        $g_total_payable = $obj_purchase[0]->grand_total_payable;
        $g_total_paid = $obj_purchase[0]->grand_total_paid;
        $g_total_balance = $obj_purchase[0]->grand_total_balance;

        $ar_cart = array();

        $ar_cart['date'] = $date;
        $ar_cart['bill_no'] = $bill_no;
        $ar_cart['g_total_payable'] = $g_total_payable;
        $ar_cart['g_total_paid'] = $g_total_paid;
        $ar_cart['g_total_balance'] = $g_total_balance;

        foreach ($obj_purchase as $row) {
            $_data['prod_name'] = $row->productDetails->product_name;
            $_data['qty'] = $row->quantity;
            $_data['cost'] = $row->purchase_price;
            $_data['sub_total'] = $row->item_subtotal;

            $ar_cart[] = $_data;
        }

        return $ar_cart;
    }

    public function purchaseList() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $criteria = new CDbCriteria;
        $criteria->select = 't.purchase_id AS id, t.grand_total_paid';
        $criteria->with = array(
            'productDetails' => array(
                'select' => 'GROUP_CONCAT(productDetails.product_name) as product_name',
            ),
        );

        $criteria->compare('t.purchase_id', $this->purchase_id, true);
        $criteria->compare('product_name', $this->product_name, true);
        $criteria->compare('t.grand_total_paid', $this->grand_total_paid, true);

        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('productDetails.store_id', $store_id);
            $criteria->compare('productStockAvails.store_id', $store_id);
            $criteria->compare('t.store_id', $store_id);
        }

        $criteria->together = true;
        $criteria->group = 't.purchase_id';
        $criteria->order = 't.id DESC';

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => $this->pageSize,
            ),
            'criteria' => $criteria,
        ));
    }

    public function purchaseListForBarcode() {
        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $criteria = new CDbCriteria;
        $criteria->select = 't.id, t.purchase_id, t.product_details_id, t.purchase_date, t.quantity, t.selling_price, t.purchase_price, t.grade_id';
        $criteria->with = array(
            'productDetails' => array(
                'select' => 'productDetails.product_name, productDetails.supplier_id, productDetails.category_id',
                'joinType' => 'INNER JOIN'
            ),
        );

        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('t.store_id', $store_id);
        }

//        $criteria->addCondition('productStockAvails.quantity > 0');
        $criteria->addCondition('t.ref_num IS NULL');
        $criteria->addCondition("t.ref_num = '0'", 'OR');
        $criteria->addCondition("t.ref_num = ''", 'OR');

        $criteria->order = 't.id DESC';
        $criteria->limit = 100;

        $data = $this->findAll($criteria);
        return (!empty($data)) ? $this->formatPurchaseBarcodeData($data) : FALSE;
    }

    public function purchaseReportData($from_date, $to_date) {

        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $from_date = date('Y-m-d', strtotime($from_date));
        $to_date = date('Y-m-d', strtotime($to_date));

        $command = Yii::app()->db->createCommand()
                ->from($this->tableName() . ' t')
                ->join(PurchaseCart::model()->tableName() . ' c', 'c.id = t.purchase_cart_id')
                ->join(PurchaseCartItems::model()->tableName() . ' ci', 'c.id = ci.cart_id')
                ->join(ReferenceNumbers::model()->tableName() . ' rn', 'rn.id = ci.reference_number_id')
                ->join(ProductDetails::model()->tableName() . ' pd', 'pd.id = ci.product_details_id')
                ->leftJoin(ProductColor::model()->tableName() . ' pc', 'pd.id = pc.product_details_id')
                ->leftJoin(Color::model()->tableName() . ' cl', 'cl.id = pc.color_id')
                ->leftJoin(ProductSize::model()->tableName() . ' ps', 'pd.id = ps.product_details_id')
                ->leftJoin(Sizes::model()->tableName() . ' s', 's.id = ps.size_id')
                ->leftJoin(ProductGrade::model()->tableName() . ' pg', 'pd.id = pg.product_details_id')
                ->leftJoin(Grade::model()->tableName() . ' g', 'g.id = pg.grade_id')
                ->order('t.id DESC')
        ;

        $command->andWhere('t.store_id = :store_id', array(':store_id' => $store_id));
        $command->andWhere('DATE(t.purchase_date) >= :from_date AND DATE(t.purchase_date) <= :to_date', array(
            ':from_date' => $from_date,
            ':to_date' => $to_date,
        ));

        $command->select(
                't.id,
                t.billnumber,
                t.purchase_date,
                t.store_id,
                c.discount,
                c.vat,
                c.grand_total,
                rn.reference_number,
                ci.cost,
                ci.price,
                ci.quantity,
                ci.discount AS item_discount,
                ci.vat AS item_vat,
                ci.sub_total,
                pd.product_name,
                cl.name AS color_name,
                s.name AS size_name,
                g.name AS grade_name
                '
        );

        $data = $this->formatPurchaseReportData($command->queryAll());
        return $data;
    }
    
    public function purchaseReportDataByProduct($product_id, $limit = 10) {

        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $command = Yii::app()->db->createCommand()
                ->from($this->tableName() . ' t')
                ->join(PurchaseCart::model()->tableName() . ' c', 'c.id = t.purchase_cart_id')
                ->join(PurchaseCartItems::model()->tableName() . ' ci', 'c.id = ci.cart_id')
                ->join(ReferenceNumbers::model()->tableName() . ' rn', 'rn.id = ci.reference_number_id')
                ->join(ProductDetails::model()->tableName() . ' pd', 'pd.id = ci.product_details_id')
                ->leftJoin(ProductColor::model()->tableName() . ' pc', 'pd.id = pc.product_details_id')
                ->leftJoin(Color::model()->tableName() . ' cl', 'cl.id = pc.color_id')
                ->leftJoin(ProductSize::model()->tableName() . ' ps', 'pd.id = ps.product_details_id')
                ->leftJoin(Sizes::model()->tableName() . ' s', 's.id = ps.size_id')
                ->leftJoin(ProductGrade::model()->tableName() . ' pg', 'pd.id = pg.product_details_id')
                ->leftJoin(Grade::model()->tableName() . ' g', 'g.id = pg.grade_id')
                ->order('t.id DESC')
                ->limit($limit)
        ;

        $command->andWhere('t.store_id = :store_id', array(':store_id' => $store_id));
        $command->andWhere('ci.product_details_id = :pid', array(':pid' => $product_id));
        
        $command->select(
                't.id,
                t.billnumber,
                t.purchase_date,
                t.store_id,
                c.discount,
                c.vat,
                c.grand_total,
                rn.reference_number,
                ci.cost,
                ci.price,
                ci.quantity,
                ci.discount AS item_discount,
                ci.vat AS item_vat,
                ci.sub_total,
                pd.product_name,
                cl.name AS color_name,
                s.name AS size_name,
                g.name AS grade_name
                '
        );
        
        $data = $this->formatPurchaseReportData($command->queryAll());
        return $data;
    }

    private function formatPurchaseReportData($ar_data) {

        $formatted_data = array();

        $purchase_ids = array_unique(array_map(function ($row) {
                    return $row['billnumber'];
                }, $ar_data));

        foreach ($purchase_ids as $purchase_id) {

            $_data = array();
            foreach ($ar_data as $row) {

                if ($purchase_id == $row['billnumber']) {

                    $_data['bill_total'] = (empty($row['grand_total']) || ($row['grand_total'] <= 0) ) ? 0.00 : $row['grand_total'];
                    $_data['discount'] = (empty($row['discount']) || ($row['discount'] <= 0) ) ? 0.00 : $row['discount'];
                    $_data['vat'] = (empty($row['vat']) || ($row['vat'] <= 0) ) ? 0.00 : $row['vat'];
                    $_data['amount_given'] = ( empty($row['grand_total_paid']) || ($row['grand_total_paid'] <= 0) ) ? 0.00 : $row['grand_total_paid'];
                    $_data['balance'] = ( empty($row['grand_total_balance']) || ($row['grand_total_balance'] <= 0) ) ? 0.00 : $row['grand_total_balance'];

                    $cart['prod_name'] = $row['product_name'];
                    $cart['color_name'] = $row['color_name'];
                    $cart['size_name'] = $row['size_name'];
                    $cart['grade_name'] = $row['grade_name'];
                    $cart['ref_num'] = $row['reference_number'];
                    $cart['qty'] = $row['quantity'];
                    $cart['cost'] = $row['cost'];
                    $cart['price'] = $row['price'];
                    $cart['item_discount'] = $row['item_discount'];
                    $cart['item_vat'] = $row['item_vat'];
                    $cart['item_sub_total'] = $row['sub_total'];

                    $_data['cart_items'][] = $cart;
                }
                $formatted_data[$purchase_id] = $_data;
            }
        }

        return $formatted_data;
    }

    private function formatPurchaseBarcodeData($obj_data) {

        $formatted_data = array();
        $date = date('ymd');

        foreach ($obj_data as $row) {

            $cp = $row->id . $row->grade_id;

            $code_prefix = Settings::$_num_zeros_for_barcode[strlen($cp)] . $cp;

            $_data['id'] = $row->id;
//            $_data['code'] = $row->purchase_id . $row->product_details_id;
            $_data['code'] = $date . $code_prefix;
            $_data['purchase_price'] = $row->purchase_price;
            $_data['selling_price'] = $row->selling_price;
            $_data['product_name'] = $row->productDetails->product_name;
            $_data['quantity'] = $row->quantity;
            $_data['purchase_date'] = str_replace('-', '', $row->purchase_date);

            $formatted_data[] = $_data;
        }

        return $formatted_data;
    }

    /**
     * GRID Functions
     */

    /**
     * @return array for Data Grid Headers customized attribute labels (name=>label)
     * remove the attributes don't needed in the Grid
     */
    public function dataGridHeaders() {
        return array(
//            'id' => array('label' => 'ID', 'sortable' => 'true', 'width' => 50),
            'billnumber' => array('label' => 'Bill Number', 'sortable' => 'true', 'width' => 50),
            'product_name' => array('label' => 'Product Name', 'sortable' => 'true', 'width' => 180),
            'quantity' => array('label' => 'Quantity', 'sortable' => 'true', 'width' => 50),
            'color_name' => array('label' => 'Color', 'sortable' => 'true', 'width' => 50),
            'size_name' => array('label' => 'Size', 'sortable' => 'true', 'width' => 50),
            'grade_name' => array('label' => 'Grade', 'sortable' => 'true', 'width' => 50),
            'grand_total' => array('label' => 'Total', 'sortable' => 'true', 'width' => 50),
            'discount' => array('label' => 'Discount', 'sortable' => 'true', 'width' => 50),
            'vat' => array('label' => 'Vat', 'sortable' => 'true', 'width' => 50),
            'action' => array('label' => 'Action', 'sortable' => 'false', 'width' => 50),
        );
    }

    public function dataGridFilters() {
        return array(
            'billnumber' => array('id' => 'billnumber', 'class' => 'easyui-textbox', 'label' => 'Bill Number: ', 'style' => 'width:80px;'),
            'product_name' => array('id' => 'product_name', 'class' => 'easyui-textbox', 'label' => 'Product: ', 'style' => 'width:80px;'),
            'grand_total' => array('id' => 'quantity', 'class' => 'easyui-textbox', 'label' => 'Qty: ', 'style' => 'width:80px;'),
            'quantity' => array('id' => 'quantity', 'class' => 'easyui-textbox', 'label' => 'Qty: ', 'style' => 'width:80px;'),
            'discount' => array('id' => 'quantity', 'class' => 'easyui-textbox', 'label' => 'Qty: ', 'style' => 'width:80px;'),
            'vat' => array('id' => 'quantity', 'class' => 'easyui-textbox', 'label' => 'Qty: ', 'style' => 'width:80px;'),
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
        if (isset($params['order']) && !empty(trim($params['order']))) {
            $order = trim($params['order']);
        }

        $command = Yii::app()->db->createCommand()
                ->from($this->tableName() . ' t')
                ->join(PurchaseCart::model()->tableName() . ' pc', 'pc.id = t.purchase_cart_id')
                ->join(PurchaseCartItems::model()->tableName() . ' pci', 'pc.id = pci.cart_id')
                ->join(ProductDetails::model()->tableName() . ' pd', 'pd.id = pci.product_details_id')
                ->leftJoin(ProductColor::model()->tableName() . ' pcl', 'pd.id = pcl.product_details_id')
                ->leftJoin(Color::model()->tableName() . ' cl', 'cl.id = pcl.color_id')
                ->leftJoin(ProductSize::model()->tableName() . ' ps', 'pd.id = ps.product_details_id')
                ->leftJoin(Sizes::model()->tableName() . ' s', 's.id = ps.size_id')
                ->leftJoin(ProductGrade::model()->tableName() . ' pg', 'pd.id = pg.product_details_id')
                ->leftJoin(Grade::model()->tableName() . ' g', 'g.id = pg.grade_id')
                ->offset($offset)
                ->limit($this->pageSize)
                ->order($order)
                ->group('pci.cart_id, t.id, pci.quantity, cl.name, g.name, s.name')
        ;

        $sub_command = Yii::app()->db->createCommand()
                ->select('count( DISTINCT pci.cart_id )')
                ->from($this->tableName() . ' t')
                ->join(PurchaseCart::model()->tableName() . ' pc', 'pc.id = t.purchase_cart_id')
                ->join(PurchaseCartItems::model()->tableName() . ' pci', 'pc.id = pci.cart_id')
                ->join(ProductDetails::model()->tableName() . ' pd', 'pd.id = pci.product_details_id')
                ->leftJoin(ProductColor::model()->tableName() . ' pcl', 'pd.id = pcl.product_details_id')
                ->leftJoin(Color::model()->tableName() . ' cl', 'cl.id = pcl.color_id')
                ->leftJoin(ProductSize::model()->tableName() . ' ps', 'pd.id = ps.product_details_id')
                ->leftJoin(Sizes::model()->tableName() . ' s', 's.id = ps.size_id')
                ->leftJoin(ProductGrade::model()->tableName() . ' pg', 'pd.id = pg.product_details_id')
                ->leftJoin(Grade::model()->tableName() . ' g', 'g.id = pg.grade_id')
                ->where('pci.cart_id IS NOT NULL')
        ;

        $filter_keys = array_keys($this->dataGridFilters());
        if (isset($params['where']) && !empty($params['where'])) {
            $new_command_objs = DataGridHelper::processFilterableVars($command, $params['where'], $filter_keys, 't', $sub_command);
            $command = $new_command_objs[0];
            $sub_command = $new_command_objs[1];
        }

        $command->select('t.id,
            t.billnumber,
            pci.quantity,
            GROUP_CONCAT(pd.product_name) as product_name,
            pc.grand_total,
            pc.discount, pc.vat,
            cl.name as color_name,
            g.name as grade_name,
            s.name as size_name,
            (' . $sub_command->getText() . ') AS total_rows');

        $data = DataGridHelper::propagateActionLinks($command->queryAll(), array(
                    'view',
                    'edit',
//                    'delete',
        ));

        return $data;
    }

}
