<?php

/**
 * This is the model class for table "cims_exchange_products".
 *
 * The followings are the available columns in table 'cims_exchange_products':
 * @property integer $id
 * @property string $sales_id
 * @property integer $main_product_details_id
 * @property integer $exchange_product_details_id
 * @property string $grand_total_payable
 * @property string $grand_total_paid
 * @property string $grand_total_balance
 * @property string $due_payment_date
 * @property integer $payment_method
 * @property string $note
 * @property string $dis_amount
 * @property integer $store_id
 *
 * The followings are the available model relations:
 * @property StoreDetails $store
 * @property ProductStockSales $sales
 * @property ProductDetails $mainProductDetails
 * @property ProductDetails $exchangeProductDetails
 */
class ExchangeProducts extends CActiveRecord {

    public $main_product_name;
    public $ex_product_name;
    public $pageSize;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cims_exchange_products';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('exchange_billnumber, cart_id, payment_method, store_id', 'numerical', 'integerOnly' => true),
            array('sales_id', 'length', 'max' => 15),
            array('note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, exchange_billnumber, cart_id, payment_method, note, store_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'store' => array(self::BELONGS_TO, 'StoreDetails', 'store_id'),
            'sales' => array(self::BELONGS_TO, 'ProductStockSales', 'sales_id'),
            'mainProductDetails' => array(self::BELONGS_TO, 'ProductDetails', 'main_product_details_id'),
            'exchangeProductDetails' => array(self::BELONGS_TO, 'ProductDetails', 'exchange_product_details_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'sales_id' => 'Sale ID',
            'cart_id' => 'Cart ID',
            'due_payment_date' => 'Due Date',
            'payment_method' => 'Method',
            'note' => 'Note',
            'store_id' => 'Store',
            'exchange_date' => 'Date',
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
        $criteria->compare('sales_id', $this->sales_id, true);
        $criteria->compare('cart_id', $this->cart_id, true);
        $criteria->compare('payment_method', $this->payment_method);
        $criteria->compare('exchange_date', $this->exchange_date);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('store_id', $this->store_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ExchangeProducts the static model class
     */

    /**
     * New Codes.
     */
    public function getExchange($sale_id = 0, $sale_billnumber = 0, $exchange_id = 0, $exchange_billnumber = 0) {
        $store_id = 1;

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $command = Yii::app()->db->createCommand()
                ->from($this->tableName() . ' t')
                ->join(ExchangeCart::model()->tableName() . ' c', 'c.id = t.cart_id')
                ->join(ExchangeCartItems::model()->tableName() . ' ci', 'c.id = ci.cart_id')
                ->join(ProductDetails::model()->tableName() . ' pd', 'pd.id = ci.product_details_id')
                ->join(ProductStockSales::model()->tableName() . ' pss', 'pss.id = t.sales_id')
                ->join(Cart::model()->tableName() . ' cs', 'cs.id = pss.cart_id')
                ->join(CartItems::model()->tableName() . ' csi', 'cs.id = csi.cart_id')
                ->group('ci.id')
        ;

        $command->andWhere('t.store_id = :store_id', array(':store_id' => $store_id));

        if ($sale_id > 0) {
            $command->andWhere('t.sales_id = :sid', array(':sid' => $sale_id));
        }

        if ($sale_billnumber > 0) {
            $command->andWhere('pss.billnumber = :sbn', array(':sbn' => $sale_billnumber));
        }

        if ($exchange_id > 0) {
            $command->andWhere('t.id = :id', array(':id' => $exchange_id));
        }

        if ($exchange_billnumber > 0) {
            $command->andWhere('t.exchange_billnumber = :bn', array(':bn' => $exchange_billnumber));
        }

        $command->select('
            t.id,
            t.exchange_billnumber,
            t.sales_id,
            t.exchange_date,
            t.payment_method,
            t.note,
            t.cart_id,
            t.store_id,
            pss.billnumber,
            pss.sale_date,
            cs.discount AS sale_discount,
            c.grand_total_bill,
            c.grand_total_returnable,
            c.grand_total_adjustable,
            c.grand_total_paid,
            c.grand_total_balance,
            c.discount,
            c.vat,
            ci.price,
            ci.quantity,
            ci.discount AS item_discount,
            ci.vat AS item_vat,
            ci.sub_total,
            ci.is_returned,
            ci.reference_number,
            pd.id AS product_id,
            pd.product_name');

        $data = $command->queryAll();
        return $data;
    }

    /**
     * @return array for Data Grid Headers customized attribute labels (name=>label)
     * remove the attributes don't needed in the Grid
     */
    public function dataGridHeaders() {
        return array(
            'id' => array('label' => 'ID', 'sortable' => 'true', 'width' => 50),
            'billnumber' => array('label' => 'Sale Bill Number', 'sortable' => 'true', 'width' => 50),
            'exchange_billnumber' => array('label' => 'Ex. Bill Number', 'sortable' => 'true', 'width' => 50),
            'grand_total_bill' => array('label' => 'Bill Amount', 'sortable' => 'true', 'width' => 50),
            'grand_total_returnable' => array('label' => 'Returned Amount', 'sortable' => 'true', 'width' => 50),
            'grand_total_adjustable' => array('label' => 'Adjustable Amount', 'sortable' => 'true', 'width' => 50),
        );
    }

    public function dataGridFilters() {
        return array(
            'billnumber' => array('id' => 'billnumber', 'class' => 'easyui-textbox', 'label' => 'Bill Number: ', 'style' => 'width:80px;'),
            'exchange_billnumber' => array('id' => 'exchange_billnumber', 'class' => 'easyui-textbox', 'label' => 'Ex. Bill Number: ', 'style' => 'width:80px;'),
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
                ->join(ExchangeCart::model()->tableName() . ' c', 'c.id = t.cart_id')
                ->join(ExchangeCartItems::model()->tableName() . ' ci', 'c.id = ci.cart_id')
                ->join(ProductDetails::model()->tableName() . ' pd', 'pd.id = ci.product_details_id')
                ->join(ProductStockSales::model()->tableName() . ' pss', 'pss.id = t.sales_id')
                ->join(Cart::model()->tableName() . ' cs', 'cs.id = pss.cart_id')
                ->join(CartItems::model()->tableName() . ' csi', 'cs.id = csi.cart_id')
                ->offset($offset)
                ->limit($this->pageSize)
                ->order($order)
                ->group('t.cart_id')
        ;

        $sub_command = Yii::app()->db->createCommand()
                ->select('count( DISTINCT t.cart_id )')
                ->from($this->tableName() . ' t')
                ->join(ExchangeCart::model()->tableName() . ' c', 'c.id = t.cart_id')
                ->join(ExchangeCartItems::model()->tableName() . ' ci', 'c.id = ci.cart_id')
                ->join(ProductDetails::model()->tableName() . ' pd', 'pd.id = ci.product_details_id')
                ->join(ProductStockSales::model()->tableName() . ' pss', 'pss.id = t.sales_id')
                ->join(Cart::model()->tableName() . ' cs', 'cs.id = pss.cart_id')
                ->join(CartItems::model()->tableName() . ' csi', 'cs.id = csi.cart_id')
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
            t.exchange_billnumber,
            t.sales_id,
            t.exchange_date,
            t.payment_method,
            t.note,
            t.cart_id,
            t.store_id,
            pss.billnumber,
            pss.sale_date,
            cs.discount AS sale_discount,
            c.grand_total_bill,
            c.grand_total_returnable,
            c.grand_total_adjustable,
            c.grand_total_paid,
            c.grand_total_balance,
            c.discount,
            c.vat,
            ci.price,
            ci.quantity,
            ci.discount AS item_discount,
            ci.vat AS item_vat,
            ci.sub_total,
            ci.is_returned,
            ci.reference_number,
            pd.id AS product_id,
            pd.product_name,
            (' . $sub_command->getText() . ') AS total_rows'
        );

        return $command->queryAll();
    }

    public function getExchangeDataForReport($from_date, $to_date) {

        $store_id = 1;

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $from_date = (!empty($from_date)) ? $from_date : date('Y-m-d', Settings::getBdLocalTime());
        $to_date = (!empty($to_date)) ? $to_date : date('Y-m-d', Settings::getBdLocalTime());

        $order = 't.id DESC';
        $command = Yii::app()->db->createCommand()
                ->from($this->tableName() . ' t')
                ->join(ExchangeCart::model()->tableName() . ' c', 'c.id = t.cart_id')
                ->join(ExchangeCartItems::model()->tableName() . ' ci', 'c.id = ci.cart_id')
                ->join(ProductDetails::model()->tableName() . ' pd', 'pd.id = ci.product_details_id')
                ->join(ProductStockSales::model()->tableName() . ' pss', 'pss.id = t.sales_id')
                ->join(Cart::model()->tableName() . ' cs', 'cs.id = pss.cart_id')
                ->join(CartItems::model()->tableName() . ' csi', 'cs.id = csi.cart_id')
                ->order($order)
                ->group('ci.id, t.id, pd.product_name')
        ;

        $command->andWhere('DATE(t.exchange_date) >= :start', array(':start' => $from_date));
        $command->andWhere('DATE(t.exchange_date) <= :end', array(':end' => $to_date));
        $command->andWhere('t.store_id = :sid', array(':sid' => $store_id));

        $command->select(
                't.id,
            t.exchange_billnumber,
            t.sales_id,
            t.exchange_date,
            t.payment_method,
            t.note,
            t.cart_id,
            t.store_id,
            pss.billnumber,
            pss.sale_date,
            cs.discount AS sale_discount,
            c.grand_total_bill,
            c.grand_total_returnable,
            c.grand_total_adjustable,
            c.grand_total_paid,
            c.grand_total_balance,
            c.discount,
            c.vat,
            ci.price,
            ci.quantity,
            ci.discount AS item_discount,
            ci.vat AS item_vat,
            ci.sub_total,
            ci.is_returned,
            ci.reference_number,
            pd.id AS product_id,
            pd.product_name'
        );

        return $this->prepareExchageReportData($command->queryAll());
    }

    public function prepareExchageReportData($ar_exchange_data) {

        if (empty($ar_exchange_data)) {
            return false;
        }

        $ar_sales_ids = array_map(function ($row) {
            return $row['billnumber'];
        }, $ar_exchange_data);

        $ar_sales_ids = array_unique($ar_sales_ids);

        $grand_sum_exchanged_sub_total = 0.00;
        $grand_real_returned_sub_total = 0.00;
        $grand_sum_adjustable = 0.00;

        foreach ($ar_sales_ids as $sale_id) {

            $_data = array();
            $sum_returned_sub_total = 0.00;
            $sum_exchanged_sub_total = 0.00;
            $real_returned_sub_total = 0.00;
            
            foreach ($ar_exchange_data as $row) {

                if ($sale_id == $row['billnumber']) {

                    if ($row['is_returned'] == 1) {
                        $_data_returned_items['reference_number'] = $row['reference_number'];
                        $_data_returned_items['product_name'] = $row['product_name'];
                        $_data_returned_items['quantity'] = $row['quantity'];
                        $_data_returned_items['price'] = $row['price'];
                        $_data_returned_items['sub_total'] = $row['sub_total'];
                        $sum_returned_sub_total += floatval($row['sub_total']);
                        
                        $_data[$sale_id][$row['exchange_billnumber']]['returned_items'][] = $_data_returned_items;
                    } else {
                        $_data_exchanged_items['reference_number'] = $row['reference_number'];
                        $_data_exchanged_items['product_name'] = $row['product_name'];
                        $_data_exchanged_items['quantity'] = $row['quantity'];
                        $_data_exchanged_items['price'] = $row['price'];
                        $_data_exchanged_items['sub_total'] = $row['sub_total'];
                        $sum_exchanged_sub_total += floatval($row['sub_total']);

                        $_data[$sale_id][$row['exchange_billnumber']]['exchanged_items'][] = $_data_exchanged_items;
                    }
                    $real_returned_sub_total = $sum_returned_sub_total - floatval($row['sale_discount']);
                    $sum_adjustable = $sum_exchanged_sub_total - $real_returned_sub_total;
                }
                
                $_data[$sale_id]['sum_returned_sub_total'] = $real_returned_sub_total;
                $_data[$sale_id]['sum_exchanged_sub_total'] = $sum_exchanged_sub_total;
//                var_dump($row['exchange_billnumber'] . '==' .$sum_exchanged_sub_total);
                $_data[$sale_id]['sum_adjustable'] = $sum_adjustable;
            }
            
            $grand_real_returned_sub_total += $real_returned_sub_total;
            $grand_sum_exchanged_sub_total += $sum_exchanged_sub_total;
            $grand_sum_adjustable += $sum_adjustable;
            
            $response['grand_real_returned_sub_total'] = $grand_real_returned_sub_total;
            $response['grand_sum_exchanged_sub_total'] = $grand_sum_exchanged_sub_total;
            $response['grand_sum_adjustable'] = $grand_sum_adjustable;
            $response[] = $_data;
        }
        
//        echo '<pre>';
//        CVarDumper::dump($response);
//        exit;
//        
        return $response;
    }

    /**
     * New Codes.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function exchangeList() {

        $criteria = new CDbCriteria;
        $criteria->select = 't.sales_id AS id, t.grand_total_payable';
        $criteria->with = array(
            'exchangeProductDetails' => array(
                'select' => 'GROUP_CONCAT(exchangeProductDetails.product_name) as ex_product_name',
            ),
        );

        $criteria->compare('t.sales_id', $this->sales_id);
//        $criteria->compare('main_product_name', $this->main_product_name, true);
        $criteria->addCondition("t.exchange_product_details_id IS NOT NULL");
        $criteria->compare('ex_product_name', $this->ex_product_name, true);

        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('t.store_id', Yii::app()->user->storeId);
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

    public function getExchanges($id, $b_ex = false) {

        $store_id = 1;

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $criteria = new CDbCriteria;

        if ($b_ex) {
            $ar_with = array('exchangeProductDetails');
            $criteria->addCondition("t.exchange_product_details_id IS NOT NULL");
            $criteria->compare('exchangeProductDetails.store_id', $store_id);
        } else {
            $ar_with = array('mainProductDetails');
            $criteria->addCondition("t.main_product_details_id IS NOT NULL");
            $criteria->compare('mainProductDetails.store_id', $store_id);
        }

        $criteria->with = $ar_with;

        $criteria->compare('sales_id', $id);

        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('t.store_id', Yii::app()->user->storeId);
        }

        $criteria->order = 't.id DESC';

        $data = $this->findAll($criteria);
        $data = $this->formatExchangesRecords($data, $b_ex);
        return $data;
    }

    public function formatExchangesRecords($obj_sales, $b_ex = FALSE) {

        $ar_cart = array();

        $key = 'mainProductDetails';
        $qty = 'main_product_quantity';
        $sub_total = 'main_product_subtotal';

        if ($b_ex) {

            $date = date('d-m-Y', strtotime($obj_sales[0]->exchange_date));
            $bill_no = $obj_sales[0]->sales_id;
            $adjust = $obj_sales[0]->exchange_adjust_amount;
            $g_total_payable = $obj_sales[0]->grand_total_payable;
            $g_total_paid = $obj_sales[0]->grand_total_paid;
            $g_total_balance = $obj_sales[0]->grand_total_balance;
            $dis_amount = (!empty($obj_sales[0]->dis_amount) || (floatval($obj_sales[0]->dis_amount) > 0) ) ? floatval($obj_sales[0]->dis_amount) : 0.00;

            $ar_cart['bill_no'] = $bill_no;
            $ar_cart['g_total_payable'] = $g_total_payable;
            $ar_cart['g_total_paid'] = $g_total_paid;
            $ar_cart['g_total_balance'] = $g_total_balance;
            $ar_cart['dis_amount'] = $dis_amount;
            $ar_cart['adjust'] = $adjust;
            $ar_cart['date'] = $date;

            $key = 'exchangeProductDetails';
            $qty = 'exchange_product_quantity';
            $sub_total = 'exchange_product_subtotal';
        }

        foreach ($obj_sales as $row) {

            $_data['prod_name'] = $row->$key->product_name;
            $_data['qty'] = $row->$qty;
            $_data['sub_total'] = $row->$sub_total;

            $ar_cart[] = $_data;
        }

        return $ar_cart;
    }

    public function exchangeReportData($from_date, $to_date, $b_ex = FALSE) {

        $from_date = (!empty($from_date)) ? $from_date : date('Y-m-d', Settings::getBdLocalTime());
        $to_date = (!empty($to_date)) ? $to_date : date('Y-m-d', Settings::getBdLocalTime());

        $criteria = new CDbCriteria;
        $criteria->select = 't.id, t.sales_id, t.main_product_quantity, t.main_product_subtotal, t.exchange_ref_num, t.exchange_product_quantity, t.exchange_product_subtotal, t.dis_amount, t.grand_total_paid, t.grand_total_balance, t.grand_total_payable, t.exchange_adjust_amount';

        if ($b_ex) {
            $ar_with = array('exchangeProductDetails');
            $criteria->addCondition("t.exchange_product_details_id IS NOT NULL");
        } else {
            $ar_with = array('mainProductDetails');
            $criteria->addCondition("t.main_product_details_id IS NOT NULL");
        }

        $criteria->with = $ar_with;

        $criteria->compare('DATE(t.exchange_date) >', $from_date);
        $criteria->compare('DATE(t.exchange_date) <', $to_date);

        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('t.store_id', Yii::app()->user->storeId);
        }

        $criteria->together = true;
        $criteria->order = 't.id DESC';

        $data = $this->findAll($criteria);

        return (!empty($data)) ? $this->formatExchangeReportData($data, $b_ex) : FALSE;
    }

    private function formatExchangeReportData($obj_data, $b_ex = FALSE) {

        $formatted_data = array();

        $key = 'mainProductDetails';
        $qty = 'main_product_quantity';
        $sub_total = 'main_product_subtotal';

        if ($b_ex) {

            $key = 'exchangeProductDetails';
            $qty = 'exchange_product_quantity';
            $sub_total = 'exchange_product_subtotal';
        }

        foreach ($obj_data as $row) {
            $sale_ids[] = $row->sales_id;
        }

        $sale_ids = array_unique($sale_ids);

        foreach ($sale_ids as $sale_id) {

            $_data = array();
            foreach ($obj_data as $row) {

                if ($sale_id == $row->sales_id) {

                    if ($b_ex) {

                        $_data['bill_total'] = ( empty($row->grand_total_payable) || ($row->grand_total_payable <= 0) ) ? 0.00 : $row->grand_total_payable;
                        $_data['amount_given'] = ( empty($row->grand_total_paid) || ($row->grand_total_paid <= 0) ) ? 0.00 : $row->grand_total_paid;
                        $_data['discount'] = ( empty($row->dis_amount) || ($row->dis_amount <= 0) ) ? 0.00 : $row->dis_amount;
                        $_data['balance'] = ( empty($row->grand_total_balance) || ($row->grand_total_balance <= 0) ) ? 0.00 : $row->grand_total_balance;
                        $_data['adjust'] = ( empty($row->exchange_adjust_amount) || ($row->exchange_adjust_amount <= 0) ) ? 0.00 : $row->exchange_adjust_amount;

                        $cart['ref_num'] = $row->exchange_ref_num;
                    }

                    $cart['prod_name'] = $row->$key->product_name;
                    $cart['qty'] = $row->$qty;
                    $cart['item_sub_total'] = $row->$sub_total;

                    $_data[] = $cart;
                }
            }

            if ($b_ex) {
                $formatted_data[$sale_id]['ex_product'] = $_data;
            } else {
                $formatted_data[$sale_id]['main_product'] = $_data;
            }
        }

        return $formatted_data;
    }

}
