<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <!--            <div class="pull-left image">
                            <img src="/css/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                        </div>-->
            <div class="pull-left info">

                <?php if (!Yii::app()->user->isGuest && !Yii::app()->user->isSuperAdmin) { ?>
                    <p><?php echo CHtml::encode(Yii::app()->user->storeName); ?></p>
                    <p><?php echo CHtml::encode(Yii::app()->user->storeAddress); ?></p>
                <?php } ?>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!--<div class="clearfix"></div>-->
        <!-- search form -->
        <!--        <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>-->
        <!-- /.search form -->


        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN</li>

            <?php
            $main_menus = Ims_menu::$main_left_menu;
            foreach ($main_menus as $menu) {
                ?>
                <li class="treeview">
                    <a href="<?php echo $menu['url']; ?>">

                        <?php if (isset($menu['icon']) && !empty($menu['icon'])) { ?>
                            <?php echo $menu['icon']; ?>
                        <?php } else { ?>
                            <i class="fa fa-pie-chart"></i>
                        <?php } ?>
                        <span><?php echo $menu['label']; ?></span>
                        <?php if (isset($menu['submenu']) && !empty($menu['submenu'])) { ?>
                            <i class="fa fa-angle-left pull-right"></i>
                        <?php } ?>
                    </a>
                    <?php if (isset($menu['submenu']) && !empty($menu['submenu'])) { ?>
                        <ul class="treeview-menu">
                            <?php foreach ($menu['submenu'] as $sub_menu) {
                                ?>
                                <?php
                                if ((!Yii::app()->user->isGuest) && (!$sub_menu['adminOnly'])
                                ) {
                                    ?>
                                    <li><a href="<?php echo $sub_menu['url']; ?>"><i class="fa fa-circle-o"></i> <?php echo $sub_menu['label']; ?></a></li>
                                <?php } ?>

                                <?php
                                if ((!Yii::app()->user->isGuest) &&
                                        (Yii::app()->user->isSuperAdmin || Yii::app()->user->isStoreAdmin) &&
                                        ($sub_menu['adminOnly'])
                                ) {
                                    ?>
                                    <li><a href="<?php echo $sub_menu['url']; ?>"><i class="fa fa-circle-o"></i> <?php echo $sub_menu['label']; ?></a></li>
                                <?php } ?>

                            <?php } ?>
                        </ul>
                    <?php } ?>
                </li>
            <?php } ?>

            <li class="header">SETTINGS</li>

            <?php
            $main_menus = Ims_menu::$settings_left_menu;
            foreach ($main_menus as $menu) {
                ?>
                <li class="treeview">
                    <a href="<?php echo $menu['url']; ?>">

                        <?php if (isset($menu['icon']) && !empty($menu['icon'])) { ?>
                            <?php echo $menu['icon']; ?>
                        <?php } else { ?>
                            <i class="fa fa-pie-chart"></i>
                        <?php } ?>
                        <span><?php echo $menu['label']; ?></span>
                        <?php if (isset($menu['submenu']) && !empty($menu['submenu'])) { ?>
                            <i class="fa fa-angle-left pull-right"></i>
                        <?php } ?>
                    </a>
                    <?php if (isset($menu['submenu']) && !empty($menu['submenu'])) { ?>
                        <ul class="treeview-menu">
                            <?php foreach ($menu['submenu'] as $sub_menu) {
                                ?>
                                <li><a href="<?php echo $sub_menu['url']; ?>"><i class="fa fa-circle-o"></i> <?php echo $sub_menu['label']; ?></a></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </li>
            <?php } ?>

            <?php if (!Yii::app()->user->isGuest && Yii::app()->user->isSuperAdmin) { ?>


                <li class="header">ADMIN</li>

                <?php
                $main_menus = Ims_menu::$admin_left_menu;
                foreach ($main_menus as $menu) {
                    ?>
                    <li class="treeview">
                        <a href="<?php echo $menu['url']; ?>">

                            <?php if (isset($menu['icon']) && !empty($menu['icon'])) { ?>
                                <?php echo $menu['icon']; ?>
                            <?php } else { ?>
                                <i class="fa fa-pie-chart"></i>
                            <?php } ?>
                            <span><?php echo $menu['label']; ?></span>
                            <?php if (isset($menu['submenu']) && !empty($menu['submenu'])) { ?>
                                <i class="fa fa-angle-left pull-right"></i>
                            <?php } ?>
                        </a>
                        <?php if (isset($menu['submenu']) && !empty($menu['submenu'])) { ?>
                            <ul class="treeview-menu">
                                <?php foreach ($menu['submenu'] as $sub_menu) {
                                    ?>
                                    <li><a href="<?php echo $sub_menu['url']; ?>"><i class="fa fa-circle-o"></i> <?php echo $sub_menu['label']; ?></a></li>
                                    <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>

            <?php } ?>
    </section>
</aside>