<?php

/**
 * This is the model class for table "cims_product_stock_sales".
 *
 * The followings are the available columns in table 'cims_product_stock_sales':
 * @property integer $id
 * @property string $sales_id
 * @property integer $transaction_id
 * @property string $billnumber
 * @property integer $customer_id
 * @property integer $supplier_id
 * @property integer $category_id
 * @property string $ref_num
 * @property integer $product_details_id
 * @property integer $quantity
 * @property string $item_selling_price
 * @property integer $serial_num
 * @property string $sale_date
 * @property string $item_subtotal
 * @property string $discount_percentage
 * @property string $dis_amount
 * @property string $tax
 * @property string $tax_dis
 * @property string $grand_total_payable
 * @property string $grand_total_paid
 * @property string $grand_total_balance
 * @property string $due_payment_date
 * @property integer $payment_method
 * @property string $note
 *
 * The followings are the available model relations:
 * @property Transactions $transaction
 * @property CustomerDetails $customer
 * @property SupplierDetails $supplier
 * @property CategoryDetails $category
 * @property ProductDetails $productDetails
 */
class ProductStockSales extends CActiveRecord {

    public $product_name;
    public $pageSize = 20;
    public $advance_sale = FALSE;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cims_product_stock_sales';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('billnumber, payment_method, cart_id', 'required'),
            array('billnumber, customer_id, payment_method, cart_id', 'numerical', 'integerOnly' => true),
            array('billnumber', 'length', 'max' => 11),
            array('note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('billnumber, payment_method, customer_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'transaction' => array(self::BELONGS_TO, 'Transactions', 'transaction_id'),
            'customer' => array(self::BELONGS_TO, 'CustomerDetails', 'customer_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'billnumber' => 'Billnumber',
            'customer_id' => 'Customer',
            'due_payment_date' => 'Due Date',
            'payment_method' => 'Payment Type',
            'note' => 'Note',
            'store_id' => 'Store',
            'is_advance' => 'Is Advanced',
            'card_type' => 'Card',
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
        $criteria->compare('billnumber', $this->billnumber, true);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('sale_date', $this->sale_date, true);
        $criteria->compare('due_payment_date', $this->due_payment_date, true);
        $criteria->compare('payment_method', $this->payment_method);

        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('t.store_id', $store_id);
        }

        $criteria->compare('note', $this->note, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductStockSales the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getSales($id) {

        $store_id = 1;

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $criteria = new CDbCriteria;

        $criteria->with = array('productDetails');
        $criteria->compare('sales_id', $id);

        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('productDetails.store_id', $store_id);
            $criteria->compare('t.store_id', $store_id);
        }

        $criteria->order = 't.id DESC';

        $data = $this->findAll($criteria);
        $data = $this->formatSalesRecords($data);
        return $data;
    }

    public function formatSalesRecords($obj_sales) {

        $date = date('d-m-Y', strtotime($obj_sales[0]->sale_date));
        $bill_no = $obj_sales[0]->sales_id;
        $g_total_payable = $obj_sales[0]->grand_total_payable;
        $g_total_paid = $obj_sales[0]->grand_total_paid;
        $g_total_balance = $obj_sales[0]->grand_total_balance;
        $dis_amount = (!empty($obj_sales[0]->dis_amount) || (floatval($obj_sales[0]->dis_amount) > 0) ) ? floatval($obj_sales[0]->dis_amount) : 0.00;

        $ar_cart = array();

        $ar_cart['date'] = $date;
        $ar_cart['bill_no'] = $bill_no;
        $ar_cart['g_total_payable'] = $g_total_payable;
        $ar_cart['g_total_paid'] = $g_total_paid;
        $ar_cart['g_total_balance'] = $g_total_balance;
        $ar_cart['dis_amount'] = $dis_amount;

        foreach ($obj_sales as $row) {
            $_data['prod_name'] = $row->productDetails->product_name;
            $_data['qty'] = $row->quantity;
            $_data['price'] = $row->item_selling_price;
            $_data['sub_total'] = $row->item_subtotal;

            $ar_cart[] = $_data;
        }

        return $ar_cart;
    }

    public function saleList() {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $store_id = 1;

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $criteria = new CDbCriteria;
        //var_dump($this->id);exit;
        $criteria->select = 't.sales_id AS id, t.grand_total_payable';
        $criteria->with = array(
            'productDetails' => array(
                'select' => 'GROUP_CONCAT(productDetails.product_name) as product_name',
            ),
        );

        $criteria->compare('t.sales_id', $this->sales_id, true);
        $criteria->compare('product_name', $this->product_name, true);
        $criteria->compare('t.grand_total_payable', $this->grand_total_payable, true);

        if ($this->advance_sale_list) {
            $criteria->compare('is_advance', 1);
        } else {
            $criteria->compare('is_advance !', 1);
        }

        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('productDetails.store_id', $store_id);
            $criteria->compare('t.store_id', $store_id);
        }

        $criteria->together = true;
        $criteria->group = 't.sales_id';
        $criteria->order = 't.id DESC';

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => $this->pageSize,
            ),
            'criteria' => $criteria,
        ));
    }

    public function saleReportData($from_date, $to_date) {

        $store_id = 1;

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $from_date = (!empty($from_date)) ? $from_date : date('Y-m-d', Settings::getBdLocalTime());
        $to_date = (!empty($to_date)) ? $to_date : date('Y-m-d', Settings::getBdLocalTime());

        $criteria = new CDbCriteria;
        //var_dump($this->id);exit;
        $criteria->select = 't.id, t.sales_id, t.ref_num, t.quantity, t.serial_num, t.item_selling_price, t.item_subtotal, t.dis_amount, t.grand_total_paid, t.grand_total_balance, t.grand_total_payable, t.is_advance';
        $criteria->with = array(
            'productDetails' => array(
                'select' => 'productDetails.product_name',
                'joinType' => 'LEFT JOIN',
            ),
        );

        $criteria->compare('DATE(t.sale_date) >', $from_date);
        $criteria->compare('DATE(t.sale_date) <', $to_date);

        if ($this->advance_sale_list) {
            $criteria->compare('is_advance', 1);
        }

        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('productDetails.store_id', $store_id);
            $criteria->compare('t.store_id', $store_id);
        }

        $criteria->together = true;
        $criteria->order = 't.id DESC';

        $data = $this->findAll($criteria);

        return (!empty($data)) ? $this->formatSaleReportData($data) : FALSE;
    }

    private function formatSaleReportData($obj_data) {

        $formatted_data = array();

        foreach ($obj_data as $row) {
            $sale_ids[] = $row->sales_id;
        }

        $sale_ids = array_unique($sale_ids);

        foreach ($sale_ids as $sale_id) {

            $_data = array();
            foreach ($obj_data as $row) {

                if ($sale_id == $row->sales_id) {

                    $_data['bill_total'] = ( empty($row->grand_total_payable) || ($row->grand_total_payable <= 0) ) ? 0.00 : $row->grand_total_payable;
                    $_data['amount_given'] = ( empty($row->grand_total_paid) || ($row->grand_total_paid <= 0) ) ? 0.00 : $row->grand_total_paid;
                    $_data['discount'] = ( empty($row->dis_amount) || ($row->dis_amount <= 0) ) ? 0.00 : $row->dis_amount;
                    $_data['balance'] = ( empty($row->grand_total_balance) || ($row->grand_total_balance <= 0) ) ? 0.00 : $row->grand_total_balance;

                    $cart['prod_name'] = $row->productDetails->product_name;
                    $cart['is_advance'] = $row->is_advance;
                    $cart['ref_num'] = $row->ref_num;
                    $cart['qty'] = $row->quantity;
                    $cart['price'] = $row->item_selling_price;
                    $cart['item_sub_total'] = $row->item_subtotal;

                    $_data[] = $cart;
                }
            }

            $formatted_data[$sale_id][] = $_data;
        }

        return $formatted_data;
    }

    public function getSalesInfo($id = NULL, $sale_id = NULL, $ref_num = NULL, $prod_id = NULL) {

        $store_id = 1;

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $criteria = new CDbCriteria();

        if (!empty($id)) {
            $criteria->compare('t.id', $id);
        }

        if (!empty($sale_id)) {
            $criteria->compare('t.sales_id', $sale_id);
        }

        if (!empty($ref_num)) {
            $criteria->compare('t.ref_num', $ref_num);
        }

        if (!empty($prod_id)) {
            $criteria->compare('t.product_details_id', $prod_id);
        }

        $criteria->with = array(
            'productDetails' => array(
                'select' => 'productDetails.id, productDetails.product_name',
                'joinType' => 'INNER JOIN',
            ),
        );

        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('productDetails.store_id', $store_id);
            $criteria->compare('t.store_id', $store_id);
        }

        if ((!empty($sale_id) && !empty($ref_num) && !empty($prod_id)) || (!empty($id))) {
            $model = $this->find($criteria);
        } else {
            $model = $this->findAll($criteria);
        }

        return $model;
    }

    /**
     * NEW CODES
     */

    /**
     * @param integer id, if not set then fetch all sales information
     * @return assocciative array of sale and related data
     */
    public function getSaleData($id = 0, $billnumber = 0) {

        $store_id = 1;

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $command = Yii::app()->db->createCommand()
                ->from($this->tableName() . ' t')
                ->join(Cart::model()->tableName() . ' c', 'c.id = t.cart_id')
                ->join(CartItems::model()->tableName() . ' ci', 'c.id = ci.cart_id')
                ->join(ProductDetails::model()->tableName() . ' pd', 'pd.id = ci.product_details_id')
        ;

        $command->andWhere('t.store_id = :store_id', array(':store_id' => $store_id));

        if ($id > 0) {
            $command->andWhere('t.id = :id', array(':id' => $id));
        }

        if ($billnumber > 0) {
            $command->andWhere('t.billnumber = :bn', array(':bn' => $billnumber));
        }

        $command->select('
            t.id, t.billnumber,
            t.sale_date,
            t.store_id ,
            c.discount,
            c.vat,
            c.grand_total,
            c.grand_total_paid,
            c.grand_total_balance,
            c.discount,
            c.vat,
            ci.price,
            ci.quantity,
            ci.discount AS item_discount,
            ci.vat AS item_vat,
            ci.quantity,
            ci.sub_total,
            ci.reference_number,
            pd.id AS product_id,
            pd.product_name');

        $data = $command->queryAll();
        return $data;
    }

    public function getSaleDataForReport($from_date, $to_date) {

        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $from_date = date('Y-m-d', strtotime($from_date));
        $to_date = date('Y-m-d', strtotime($to_date));

        $command = Yii::app()->db->createCommand()
                ->from($this->tableName() . ' t')
                ->join(Cart::model()->tableName() . ' c', 'c.id = t.cart_id')
                ->join(CartItems::model()->tableName() . ' ci', 'c.id = ci.cart_id')
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
        $command->andWhere('DATE(t.sale_date) >= :from_date AND DATE(t.sale_date) <= :to_date', array(
            ':from_date' => $from_date,
            ':to_date' => $to_date,
        ));

        $command->select(
                't.id,
                t.billnumber,
                t.sale_date,
                t.is_advance,
                t.store_id,
                c.discount,
                c.vat,
                c.grand_total,
                c.grand_total_paid,
                c.grand_total_balance,
                ci.reference_number,
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

        $data = $this->formatSaleDataForReport($command->queryAll());
        return $data;
    }

    public function salesReportDataByProduct($product_id, $limit = 10) {

        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $command = Yii::app()->db->createCommand()
                ->from($this->tableName() . ' t')
                ->join(Cart::model()->tableName() . ' c', 'c.id = t.cart_id')
                ->join(CartItems::model()->tableName() . ' ci', 'c.id = ci.cart_id')
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
                t.sale_date,
                t.is_advance,
                t.store_id,
                c.discount,
                c.vat,
                c.grand_total,
                c.grand_total_paid,
                c.grand_total_balance,
                ci.reference_number,
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

        $data = $this->formatSaleDataForReport($command->queryAll());
        return $data;
    }

    private function formatSaleDataForReport($ar_data) {

        $fake_sale_limit = intval(Configurations::model()->getFakeSaleReportLimit());



        $formatted_data = array();
        $sale_ids = array_unique(array_map(function ($row) {
                    return $row['billnumber'];
                }, $ar_data));

        $i = 0;
        foreach ($sale_ids as $sale_id) {

            $_data = array();
            foreach ($ar_data as $row) {

                if ($sale_id == $row['billnumber']) {

                    $_data['bill_total'] = (empty($row['grand_total']) || ($row['grand_total'] <= 0) ) ? 0.00 : $row['grand_total'];
                    $_data['discount'] = (empty($row['discount']) || ($row['discount'] <= 0) ) ? 0.00 : $row['discount'];
                    $_data['vat'] = (empty($row['vat']) || ($row['vat'] <= 0) ) ? 0.00 : $row['vat'];
                    $_data['amount_given'] = ( empty($row['grand_total_paid']) || ($row['grand_total_paid'] <= 0) ) ? 0.00 : $row['grand_total_paid'];
                    $_data['balance'] = ( empty($row['grand_total_balance']) || ($row['grand_total_balance'] <= 0) ) ? 0.00 : $row['grand_total_balance'];
                    $_data['is_advance'] = $row['is_advance'];

                    $cart['prod_name'] = $row['product_name'];
                    $cart['color_name'] = $row['color_name'];
                    $cart['size_name'] = $row['size_name'];
                    $cart['grade_name'] = $row['grade_name'];
                    $cart['ref_num'] = $row['reference_number'];
                    $cart['qty'] = $row['quantity'];
                    $cart['price'] = $row['price'];
                    $cart['item_discount'] = $row['item_discount'];
                    $cart['item_vat'] = $row['item_vat'];
                    $cart['item_sub_total'] = $row['sub_total'];

                    $_data['cart_items'][] = $cart;
                }
                $formatted_data[$sale_id] = $_data;
            }
            $i++;
            if (!Yii::app()->user->isSuperAdmin && !Yii::app()->user->isStoreAdmin && $fake_sale_limit === $i) {
                break;
            }
        }
        return $formatted_data;
    }

    public function getSalePurchaseDataForReport($from_date, $to_date) {

        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $from_date = date('Y-m-d', strtotime($from_date));
        $to_date = date('Y-m-d', strtotime($to_date));

        $sale_query = Yii::app()->db->createCommand()
                ->from($this->tableName() . ' t')
                ->join(Cart::model()->tableName() . ' c', 'c.id = t.cart_id')
                ->join(CartItems::model()->tableName() . ' ci', 'c.id = ci.cart_id')
                ->join(ProductDetails::model()->tableName() . ' pd', 'pd.id = ci.product_details_id')
                ->leftJoin(ProductColor::model()->tableName() . ' pc', 'pd.id = pc.product_details_id')
                ->leftJoin(Color::model()->tableName() . ' cl', 'cl.id = pc.color_id')
                ->leftJoin(ProductSize::model()->tableName() . ' ps', 'pd.id = ps.product_details_id')
                ->leftJoin(Sizes::model()->tableName() . ' s', 's.id = ps.size_id')
                ->leftJoin(ProductGrade::model()->tableName() . ' pg', 'pd.id = pg.product_details_id')
                ->leftJoin(Grade::model()->tableName() . ' g', 'g.id = pg.grade_id')
                ->order('t.id DESC')
                ->group('ci.product_details_id')
        ;

        $sale_query->andWhere('t.store_id = :store_id', array(':store_id' => $store_id));
        $sale_query->andWhere('DATE(t.sale_date) >= :from_date AND DATE(t.sale_date) <= :to_date', array(
            ':from_date' => $from_date,
            ':to_date' => $to_date,
        ));

        $sale_query->select(
                't.is_advance,
                SUM(c.discount) AS toal_discount,
                SUM(c.vat) AS total_vat,
                ci.product_details_id AS sold_product_id,
                ci.price,
                SUM(ci.quantity) AS total_sold_qty,
                SUM(ci.discount) AS toal_item_discount,
                SUM(ci.vat) AS toal_item_vat,
                MAX(ci.price) AS highest_price,
                MIN(ci.price) AS lowest_price,
                SUM(ci.sub_total) AS sold_total,
                pd.product_name,
                pd.purchase_price,
                pd.selling_price,
                cl.name AS color_name,
                s.name AS size_name,
                g.name AS grade_name
                '
        );

        $sale_data = $sale_query->queryAll();

        $sold_product_ids = array_unique(array_map(function ($row) {
                    return $row['sold_product_id'];
                }, $sale_data));

        $purchase_query = Yii::app()->db->createCommand()
                ->from(ProductStockEntries::model()->tableName() . ' pse')
                ->join(PurchaseCartItems::model()->tableName() . ' pci', 'pse.purchase_cart_id = pci.cart_id')
                ->andWhere('pse.store_id = :store_id', array(':store_id' => $store_id))
                ->andWhere('pci.product_details_id > :pid', array(':pid' => 0))
                ->andWhere(array('in', 'pci.product_details_id', $sold_product_ids))
                ->group('pci.product_details_id')
        ;

        $purchase_query->select(
                'pci.product_details_id AS purchased_product_id,
                 MAX(pci.cost) AS highest_cost,
                 MIN(pci.cost) AS lowest_cost,
                sum(pci.quantity) AS purchased_qty,
                sum(pci.sub_total) AS purchased_total
                '
        );
        $purchase_data = $purchase_query->queryAll();

        $data = $this->formatSalePurchaseDataForReport($sale_data, $purchase_data);
        return $data;
    }

    private function formatSalePurchaseDataForReport($sold_data, $purchase_data) {

        $formatted_response = array();

        $sold_product_ids = array_unique(array_map(function ($row) {
                    return $row['sold_product_id'];
                }, $sold_data));

        $_data = array();

        foreach ($sold_data as $sale) {

            if (in_array($sale['sold_product_id'], $sold_product_ids)) {
                $_data[$sale['sold_product_id']]['product_name'] = $sale['product_name'];
                $_data[$sale['sold_product_id']]['color_name'] = $sale['color_name'];
                $_data[$sale['sold_product_id']]['size_name'] = $sale['size_name'];
                $_data[$sale['sold_product_id']]['grade_name'] = $sale['grade_name'];
                $_data[$sale['sold_product_id']]['purchase_price'] = $sale['purchase_price'];
                $_data[$sale['sold_product_id']]['selling_price'] = $sale['selling_price'];
                $_data[$sale['sold_product_id']]['sold_qty'] = $sale['total_sold_qty'];
                $_data[$sale['sold_product_id']]['sold_total'] = $sale['sold_total'];
                $_data[$sale['sold_product_id']]['sold_toal_vat'] = $sale['total_vat'];
                $_data[$sale['sold_product_id']]['sold_total_discount'] = $sale['toal_discount'];
                $_data[$sale['sold_product_id']]['purchased_qty'] = 0;
                $_data[$sale['sold_product_id']]['purchased_total'] = 0.00;
                $_data[$sale['sold_product_id']]['highest_price'] = $sale['highest_price'];
                $_data[$sale['sold_product_id']]['lowest_price'] = $sale['lowest_price'];
            }

            foreach ($purchase_data as $purchase) {
                if (in_array($purchase['purchased_product_id'], $sold_product_ids)) {
                    if ($purchase['purchased_product_id'] == $sale['sold_product_id']) {
                        $_data[$sale['sold_product_id']]['purchased_qty'] = $purchase['purchased_qty'];
                        $_data[$sale['sold_product_id']]['purchased_total'] = $purchase['purchased_total'];
                        $_data[$sale['sold_product_id']]['highest_cost'] = $purchase['highest_cost'];
                        $_data[$sale['sold_product_id']]['lowest_cost'] = $purchase['lowest_cost'];
                    }
                }
            }
        }

        return $formatted_response = $_data;
    }

    /**
     * NEW CODES
     */

    /**
     * @return array for Data Grid Headers customized attribute labels (name=>label)
     * remove the attributes don't needed in the Grid
     */
    public function dataGridHeaders() {
        return array(
            'id' => array('label' => 'ID', 'sortable' => 'true', 'width' => 50),
            'billnumber' => array('label' => 'Bill Number', 'sortable' => 'true', 'width' => 50),
            'product_name' => array('label' => 'Product Name', 'sortable' => 'true', 'width' => 180),
            'grand_total' => array('label' => 'Total', 'sortable' => 'true', 'width' => 50),
            'color_name' => array('label' => 'Color', 'sortable' => 'true', 'width' => 50),
            'size_name' => array('label' => 'Size', 'sortable' => 'true', 'width' => 50),
            'grade_name' => array('label' => 'Grade', 'sortable' => 'true', 'width' => 50),
            'discount' => array('label' => 'Discount', 'sortable' => 'true', 'width' => 50),
            'vat' => array('label' => 'Vat', 'sortable' => 'true', 'width' => 50),
        );
    }

    public function dataGridFilters() {
        return array(
            'billnumber' => array('id' => 'billnumber', 'class' => 'easyui-textbox', 'label' => 'Bill Number: ', 'style' => 'width:80px;'),
            'product_name' => array('id' => 'product_name', 'class' => 'easyui-textbox', 'label' => 'Product: ', 'style' => 'width:80px;'),
            'quantity' => array('id' => 'quantity', 'class' => 'easyui-textbox', 'label' => 'Qty: ', 'style' => 'width:80px;'),
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
                ->join(Cart::model()->tableName() . ' c', 'c.id = t.cart_id')
                ->join(CartItems::model()->tableName() . ' ci', 'c.id = ci.cart_id')
                ->join(ProductDetails::model()->tableName() . ' pd', 'pd.id = ci.product_details_id')
                ->leftJoin(ProductColor::model()->tableName() . ' pc', 'pd.id = pc.product_details_id')
                ->leftJoin(Color::model()->tableName() . ' cl', 'cl.id = pc.color_id')
                ->leftJoin(ProductSize::model()->tableName() . ' ps', 'pd.id = ps.product_details_id')
                ->leftJoin(Sizes::model()->tableName() . ' s', 's.id = ps.size_id')
                ->leftJoin(ProductGrade::model()->tableName() . ' pg', 'pd.id = pg.product_details_id')
                ->leftJoin(Grade::model()->tableName() . ' g', 'g.id = pg.grade_id')
                ->offset($offset)
                ->limit($this->pageSize)
                ->order($order)
                ->group('t.cart_id, t.id')
        ;

        $sub_command = Yii::app()->db->createCommand()
                ->select('count( DISTINCT t.cart_id )')
                ->from($this->tableName() . ' t')
                ->join(Cart::model()->tableName() . ' c', 'c.id = t.cart_id')
                ->join(CartItems::model()->tableName() . ' ci', 'c.id = ci.cart_id')
                ->join(ProductDetails::model()->tableName() . ' pd', 'pd.id = ci.product_details_id')
                ->leftJoin(ProductColor::model()->tableName() . ' pc', 'pd.id = pc.product_details_id')
                ->leftJoin(Color::model()->tableName() . ' cl', 'cl.id = pc.color_id')
                ->leftJoin(ProductSize::model()->tableName() . ' ps', 'pd.id = ps.product_details_id')
                ->leftJoin(Sizes::model()->tableName() . ' s', 's.id = ps.size_id')
                ->leftJoin(ProductGrade::model()->tableName() . ' pg', 'pd.id = pg.product_details_id')
                ->leftJoin(Grade::model()->tableName() . ' g', 'g.id = pg.grade_id')
                ->where('t.cart_id IS NOT NULL')
        ;

        $filter_keys = array_keys($this->dataGridFilters());
        if (isset($params['where']) && !empty($params['where'])) {
            $new_command_objs = DataGridHelper::processFilterableVars($command, $params['where'], $filter_keys, 't', $sub_command);
            $command = $new_command_objs[0];
            $sub_command = $new_command_objs[1];
        }

        $command->select(
                't.id,
                GROUP_CONCAT(pd.product_name) as product_name,
                GROUP_CONCAT(cl.name) as color_name,
                GROUP_CONCAT(g.name) as grade_name,
                GROUP_CONCAT(s.name) as size_name,
                t.billnumber, c.grand_total,
                c.discount, c.vat,
                (' . $sub_command->getText() . ') AS total_rows'
        );

        return $command->queryAll();
    }

}
