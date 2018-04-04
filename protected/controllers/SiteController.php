<?php

class SiteController extends Controller {

    public $defaultAction = 'login';

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    public function actionTest() {
        require_once 'vendor/autoload.php';

        $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        $code = '081231723897';
        echo $generator->getBarcode($code, $generator::TYPE_EAN_13);
        echo '<br />';
        echo $generator->getBarcode($code, $generator::TYPE_EAN_13, 2, 80);
        exit;
    }

    public function actionGetdata() {

        foreach (DataGridHelper::$_ar_non_filterable_vars as $nfv_key => $nfv_var_name) {
            ${$nfv_var_name} = Yii::app()->request->getParam($nfv_key);
        }

        $rows = array();
        $offest = 0;

        if (${DataGridHelper::$_ar_non_filterable_vars['page']} > 1) {
            $offest = (${DataGridHelper::$_ar_non_filterable_vars['page']} - 1) * ${DataGridHelper::$_ar_non_filterable_vars['rows']};
        }

        $productDetails = new ProductDetails();

        $productDetails->pageSize = 20;
        $query_params = array(
            'offset' => $offest,
            'order' => ${DataGridHelper::$_ar_non_filterable_vars['sort']} . ' ' . ${DataGridHelper::$_ar_non_filterable_vars['order']},
            'where' => $_POST,
        );

        $result['rows'] = $productDetails->dataGridRows($query_params);
//        var_dump($result['rows']);exit;
        $result["total"] = 0;

        if (($result['rows'])) {
            $result["total"] = $result['rows'][0]['total_rows'];
        }
        echo CJSON::encode($result);
        Yii::app()->end();
    }

    public function actionGetStatusComboData() {
        echo CJSON::encode(ProductDetails::model()->statusComboData());
    }

    public function actionTest1($param) {
        # mPDF
//        $mPDF1 = Yii::app()->ePdf->mpdf();
        # You can easily override default constructor's params
//        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A5');
        # render (full page)
//        $mPDF1->WriteHTML($this->render('test', array(), true));
        # Load a stylesheet
//        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/main.css');
//        $mPDF1->WriteHTML($stylesheet, 1);
        # renderPartial (only 'view' of current controller)
//        $mPDF1->WriteHTML($this->renderPartial('test', array(), true));
        # Renders image
//        $mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif'));
//        var_dump($mPDF1->Output());exit;
        # Outputs ready PDF
//        $mPDF1->Output();
    }

    public function actionUpdate() {

        $purchase_refs = Yii::app()->db->createCommand()
                ->select('t.id, t.product_details_id, t.reference_number_id, psa.quantity')
                ->from(PurchaseCartItems::model()->tableName() . ' t')
                ->join(ProductDetails::model()->tableName() . ' pd', 'pd.id = t.product_details_id')
                ->join(ProductStockAvail::model()->tableName() . ' psa', 'psa.product_details_id = pd.id')
                ->queryAll();

        $i = 1;
        foreach ($purchase_refs as $row) {

            $now = date('Y-m-d H:i:s', Settings::getBdLocalTime());

            $len_ref = strlen($row['reference_number_id']);
            $checksum = 1;
            if ($len_ref > 12) {
                $checksum = substr($row['reference_number_id'], -1);
                $ref_number = substr($row['reference_number_id'], 0, 12);
            } else {
                $ref_number = $row['reference_number_id'];
            }

            $ref_nums = new ReferenceNumbers;
            $ref_nums->reference_number = $ref_number;
//            $ref_nums->checksum_digit = $checksum;
            $ref_nums->purchase_cart_item_id = $row['id'];
            $ref_nums->created_date = $now;
            $ref_nums->updated_date = $now;
            $ref_nums->status = 1;
            $ref_nums->left_number_of_usage = $row['quantity'];
            $ref_nums->insert();

            $ref_nums_id = $ref_nums->id;

            Yii::app()->db->createCommand()
                    ->update(PurchaseCartItems::model()->tableName(), array(
                        'reference_number_id' => $ref_nums_id
                            ), 'id = :id', array(':id' => $row['id']));
            $i++;
        }

        var_dump($i);
        exit;
    }

    public function actionFixsales() {

        $carts = Cart::model()->findAll();

        $i = 1;
        foreach ($carts as $row) {

            $carts_items = CartItems::model()->findAllByAttributes(array('cart_id' => $row->id));

            $cart_grand_total = 0.00;
            $cart_grand_discount = 0.00;
            $cart_grand_vat = 0.00;

            foreach ($carts_items as $cart) {
                $cart_grand_total += $cart->sub_total;
                $cart_grand_discount += $cart->discount;
                $cart_grand_vat += $cart->vat;
            }

            if (floatval($row->grand_total) != $cart_grand_total) {
                $row->grand_total = $cart_grand_total;

                $row->discount = ($row->discount <= 0) ? $cart_grand_discount : $row->discount;
                $row->vat = ($row->vat <= 0) ? $cart_grand_vat : $row->vat;

                $row->update();
                $i++;
            }
        }

        var_dump($i);
        exit;
    }
    
    public function actionClearCartTmp() {
        Yii::app()->db->createCommand()->truncateTable(TmpCartItems::model()->tableName());
        Yii::app()->db->createCommand()->truncateTable(TmpCart::model()->tableName());
    }

}
