<?php

class Ims_menu {

    public static $supplier_menu = array(
        array('label' => 'Add Supplier', 'url' => array('create')),
        array('label' => 'Supplier List', 'url' => array('index')),
    );
    public static $product_menu = array(
        array('label' => 'Add Category', 'url' => array('category/create')),
        array('label' => 'Category List', 'url' => array('category/')),
        array('label' => 'Add Product', 'url' => array('manage/create')),
        array('label' => 'Product List', 'url' => array('manage/')),
        array('label' => 'Generate Barcode', 'url' => array('manage/barcode')),
    );
    public static $customer_menu = array(
        array('label' => 'Add Customer', 'url' => array('create')),
        array('label' => 'Customer List', 'url' => array('index')),
    );
    public static $purchase_menu = array(
        array('label' => 'Purchase Product', 'url' => array('createsingle')),
//    	array('label'=>'Purchase Product', 'url'=>array('create')),
        array('label' => 'Purchase List', 'url' => array('index')),
    );
    public static $sale_menu = array(
        array('label' => 'Sale Product', 'url' => array('create')),
        array('label' => 'Sales List', 'url' => array('index')),
        array('label' => 'Advance Sale', 'url' => array('advance_sale')),
        array('label' => 'Advance Sale List', 'url' => array('advance_sale_list')),
    );
    public static $exchange_menu = array(
        array('label' => 'Exchange Product', 'url' => array('create')),
        array('label' => 'Exchange List', 'url' => array('index')),
    );
    public static $report_menu = array(
        array('label' => 'Sale Report', 'url' => array('/reports/sale')),
        array('label' => 'Advance Sale Report', 'url' => array('/reports/sale/advance_sale')),
        array('label' => 'Purchase Report', 'url' => array('/reports/purchase')),
        array('label' => 'Excheang Report', 'url' => array('/reports/exchange')),
    );

    /** NEW MAIN LAFT MENU * */
    public static $main_left_menu = array(
        array('label' => 'Store', 'url' => '/store/manage/update',),
        array('label' => 'Supplier', 'url' => '#',
            'submenu' => array(
                array('label' => 'Supplier List', 'url' => '/supplier/manage'),
                array('label' => 'Add Supplier', 'url' => '/supplier/manage/create'),
            ),
        ),
        array('label' => 'Customer', 'url' => '#',
            'submenu' => array(
                array('label' => 'Customer List', 'url' => '/customer/manage'),
                array('label' => 'Add Customer', 'url' => '/customer/manage/create'),
            ),
        ),
        array('label' => 'Product', 'url' => '#',
            'submenu' => array(
                array('label' => 'Category List', 'url' => '/product/category/'),
                array('label' => 'Add Category', 'url' => '/product/category/create'),
                array('label' => 'Product List', 'url' => '/product/manage/'),
                array('label' => 'Add Product', 'url' => '/product/manage/create'),
                array('label' => 'Generate Barcode', 'url' => '/product/manage/barcode'),
            ),
        ),
        array('label' => 'Purchase', 'url' => '#',
            'submenu' => array(
                array('label' => 'Purchase List', 'url' => '/product/purchase/'),
                array('label' => 'Purchase Product', 'url' => '/product/purchase/createsingle'),
//    	array('label'=>'Purchase Product', 'url'=>array('create')),
            ),
        ),
        array('label' => 'Sales', 'url' => '#',
            'submenu' => array(
                array('label' => 'Sales List', 'url' => '/product/sale'),
                array('label' => 'Sale Product', 'url' => '/product/sale/create'),
                array('label' => 'Advance Sale List', 'url' => '/product/sale/advance_sale_list'),
                array('label' => 'Advance Sale', 'url' => '/product/sale/advance_sale'),
            ),
        ),
        array('label' => 'Exchange', 'url' => '#',
            'submenu' => array(
                array('label' => 'Exchange List', 'url' => '/product/exchange'),
                array('label' => 'Exchange Product', 'url' => '/product/exchange/create'),
            ),
        ),
        array('label' => 'Reports', 'url' => '#',
            'submenu' => array(
                array('label' => 'Sale Report', 'url' => '/reports/sale'),
                array('label' => 'Advance Sale Report', 'url' => '/reports/sale/advance_sale'),
                array('label' => 'Purchase Report', 'url' => '/reports/purchase'),
                array('label' => 'Excheang Report', 'url' => '/reports/exchange'),
            ),
        ),
    );

}
