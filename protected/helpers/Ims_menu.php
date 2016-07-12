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
                array('label' => 'Supplier List', 'url' => '/supplier/manage', 'adminOnly' => false),
                array('label' => 'Add Supplier', 'url' => '/supplier/manage/create', 'adminOnly' => false),
            ),
        ),
        array(
            'label' => 'Customer',
            'url' => '#',
            'icon' => '<i class="glyphicon glyphicon-user"></i>',
            'submenu' => array(
                array('label' => 'Customer List', 'url' => '/customer/manage', 'adminOnly' => false),
                array('label' => 'Add Customer', 'url' => '/customer/manage/create', 'adminOnly' => false),
            ),
        ),
        array(
            'label' => 'Product',
            'url' => '#',
            'icon' => '<i class="fa fa-th-list"></i>',
            'submenu' => array(
                array('label' => 'Category List', 'url' => '/product/category', 'adminOnly' => false),
                array('label' => 'Add Category', 'url' => '/product/category/create', 'adminOnly' => false),
                array('label' => 'Product List', 'url' => '/product/manage', 'adminOnly' => false),
                array('label' => 'Add Product', 'url' => '/product/manage/create', 'adminOnly' => false),
            ),
        ),
        array(
            'label' => 'Purchase',
            'url' => '#',
            'icon' => '<i class="glyphicon glyphicon-save"></i>',
            'submenu' => array(
                array('label' => 'Purchase List', 'url' => '/product/purchase', 'adminOnly' => false),
                array('label' => 'Purchase Product', 'url' => '/product/purchase/createsingle', 'adminOnly' => false),
//    	array('label'=>'Purchase Product', 'url'=>array('create')),
            ),
        ),
        array(
            'label' => 'Sales',
            'url' => '#',
            'icon' => '<i class="fa fa-shopping-cart"></i>',
            'submenu' => array(
                array('label' => 'Sales List', 'url' => '/product/sale', 'adminOnly' => false),
                array('label' => 'Sale Product', 'url' => '/product/sale/create', 'adminOnly' => false),
                array('label' => 'Advance Sale List', 'url' => '/product/sale/advance_sale_list', 'adminOnly' => false),
                array('label' => 'Advance Sale', 'url' => '/product/sale/advance_sale', 'adminOnly' => false),
            ),
        ),
        array(
            'label' => 'Exchange',
            'url' => '#',
            'icon' => '<i class="fa fa-exchange"></i>',
            'submenu' => array(
                array('label' => 'Exchange List', 'url' => '/product/exchange', 'adminOnly' => false),
                array('label' => 'Exchange Product', 'url' => '/product/exchange/create', 'adminOnly' => false),
            ),
        ),
        array(
            'label' => 'Reports',
            'url' => '#',
            'icon' => '<i class="fa fa-bar-chart-o"></i>',
            'submenu' => array(
                array('label' => 'Sale Report', 'url' => '/reports/sale', 'adminOnly' => false),
                array('label' => 'Sale / Purchase Report', 'url' => '/reports/sale/purchase_sale', 'adminOnly' => true),
                array('label' => 'Cumulative Report', 'url' => '/reports/sale/cumulative', 'adminOnly' => true),
                array('label' => 'Stock Report', 'url' => '/reports/stock', 'adminOnly' => false),
                array('label' => 'Differential Report', 'url' => '/reports/differential', 'adminOnly' => true),
                array('label' => 'Advance Sale Report', 'url' => '/reports/sale/advance_sale', 'adminOnly' => false),
                array('label' => 'Purchase Report', 'url' => '/reports/purchase', 'adminOnly' => false),
                array('label' => 'Excheang Report', 'url' => '/reports/exchange', 'adminOnly' => false),
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
                array('label' => 'Color List', 'url' => '/configuration/colors', 'adminOnly' => false),
                array('label' => 'Add Color', 'url' => '/configuration/colors/create', 'adminOnly' => false),
            ),
        ),
        array(
            'label' => 'Sizes',
            'url' => '#',
            'icon' => '<i class="fa fa-upload"></i>',
            'submenu' => array(
                array('label' => 'Size List', 'url' => '/configuration/size', 'adminOnly' => false),
                array('label' => 'Add Size', 'url' => '/configuration/size/create', 'adminOnly' => false),
            ),
        ),
        array(
            'label' => 'Qualities',
            'url' => '#',
            'icon' => '<i class="fa fa-upload"></i>',
            'submenu' => array(
                array('label' => 'Quality List', 'url' => '/configuration/qualities', 'adminOnly' => false),
                array('label' => 'Add Quality', 'url' => '/configuration/qualities/create', 'adminOnly' => false),
            ),
        ),
    );
    
    public static $admin_left_menu = array(
        
        array(
            'label' => 'Groups',
            'url' => '#',
            'icon' => '<i class="fa fa-upload"></i>',
            'submenu' => array(
                array('label' => 'Groups', 'url' => '/user/group/', 'adminOnly' => true),
                array('label' => 'Add Group', 'url' => '/user/group/create', 'adminOnly' => true),
            ),
        ),
        array(
            'label' => 'Sizes',
            'url' => '#',
            'icon' => '<i class="fa fa-upload"></i>',
            'submenu' => array(
                array('label' => 'Size List', 'url' => '/configuration/size', 'adminOnly' => true),
                array('label' => 'Add Size', 'url' => '/configuration/size/create', 'adminOnly' => true),
            ),
        ),
        array(
            'label' => 'Qualities',
            'url' => '#',
            'icon' => '<i class="fa fa-upload"></i>',
            'submenu' => array(
                array('label' => 'Quality List', 'url' => '/configuration/qualities', 'adminOnly' => true),
                array('label' => 'Add Quality', 'url' => '/configuration/qualities/create', 'adminOnly' => true),
            ),
        ),
    );

}
