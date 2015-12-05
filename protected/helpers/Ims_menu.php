<?php

class Ims_menu {

    /** NEW MAIN LAFT MENU * */
    public static $main_left_menu = array(
        array(
            'label' => 'Store',
            'url' => '/store/manage/update',
            'icon' => '<i class="fa fa-institution"></i>',
        ),
        array(
            'label' => 'Supplier',
            'url' => '#',
            'icon' => '<i class="fa fa-upload"></i>',
            'submenu' => array(
                array('label' => 'Supplier List', 'url' => '/supplier/manage'),
                array('label' => 'Add Supplier', 'url' => '/supplier/manage/create'),
            ),
        ),
        array(
            'label' => 'Customer',
            'url' => '#',
            'icon' => '<i class="glyphicon glyphicon-user"></i>',
            'submenu' => array(
                array('label' => 'Customer List', 'url' => '/customer/manage'),
                array('label' => 'Add Customer', 'url' => '/customer/manage/create'),
            ),
        ),
        array(
            'label' => 'Product',
            'url' => '#',
            'icon' => '<i class="fa fa-th-list"></i>',
            'submenu' => array(
                array('label' => 'Category List', 'url' => '/product/category'),
                array('label' => 'Add Category', 'url' => '/product/category/create'),
                array('label' => 'Product List', 'url' => '/product/manage'),
                array('label' => 'Add Product', 'url' => '/product/manage/create'),
            ),
        ),
        array(
            'label' => 'Purchase',
            'url' => '#',
            'icon' => '<i class="glyphicon glyphicon-save"></i>',
            'submenu' => array(
                array('label' => 'Purchase List', 'url' => '/product/purchase'),
                array('label' => 'Purchase Product', 'url' => '/product/purchase/createsingle'),
//    	array('label'=>'Purchase Product', 'url'=>array('create')),
            ),
        ),
        array(
            'label' => 'Sales',
            'url' => '#',
            'icon' => '<i class="fa fa-shopping-cart"></i>',
            'submenu' => array(
                array('label' => 'Sales List', 'url' => '/product/sale'),
                array('label' => 'Sale Product', 'url' => '/product/sale/create'),
                array('label' => 'Advance Sale List', 'url' => '/product/sale/advance_sale_list'),
                array('label' => 'Advance Sale', 'url' => '/product/sale/advance_sale'),
            ),
        ),
        array(
            'label' => 'Exchange',
            'url' => '#',
            'icon' => '<i class="fa fa-exchange"></i>',
            'submenu' => array(
                array('label' => 'Exchange List', 'url' => '/product/exchange'),
                array('label' => 'Exchange Product', 'url' => '/product/exchange/create'),
            ),
        ),
        array(
            'label' => 'Reports',
            'url' => '#',
            'icon' => '<i class="fa fa-bar-chart-o"></i>',
            'submenu' => array(
                array('label' => 'Sale Report', 'url' => '/reports/sale'),
                array('label' => 'Advance Sale Report', 'url' => '/reports/sale/advance_sale'),
                array('label' => 'Purchase Report', 'url' => '/reports/purchase'),
                array('label' => 'Excheang Report', 'url' => '/reports/exchange'),
            ),
        ),
        array(
            'label' => 'Generate Barcode',
            'url' => '/product/manage/barcode',
            'icon' => '<i class="fa fa-barcode"></i>',
        ),
    );
    
    public static $settings_left_menu = array(
        
        array(
            'label' => 'Colors',
            'url' => '#',
            'icon' => '<i class="fa fa-upload"></i>',
            'submenu' => array(
                array('label' => 'Color List', 'url' => '/configuration/colors'),
                array('label' => 'Add Color', 'url' => '/configuration/colors/create'),
            ),
        ),
        array(
            'label' => 'Sizes',
            'url' => '#',
            'icon' => '<i class="fa fa-upload"></i>',
            'submenu' => array(
                array('label' => 'Size List', 'url' => '/configuration/size'),
                array('label' => 'Add Size', 'url' => '/configuration/size/create'),
            ),
        ),
        array(
            'label' => 'Qualities',
            'url' => '#',
            'icon' => '<i class="fa fa-upload"></i>',
            'submenu' => array(
                array('label' => 'Quality List', 'url' => '/configuration/qualities'),
                array('label' => 'Add Quality', 'url' => '/configuration/qualities/create'),
            ),
        ),
    );

}
