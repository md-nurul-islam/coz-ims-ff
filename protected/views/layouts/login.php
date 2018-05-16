<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="/css/bootstrap/css/bootstrap.min.css?v=<?php echo ASSET_VERSION; ?>">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css?v=<?php echo ASSET_VERSION; ?>">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css?v=<?php echo ASSET_VERSION; ?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="/css/dist/css/AdminLTE.min.css?v=<?php echo ASSET_VERSION; ?>">
        <!-- iCheck -->
        <link rel="stylesheet" href="/js/plugins/iCheck/square/orange.css?v=<?php echo ASSET_VERSION; ?>">


        <link rel="stylesheet" href="/css/login.css?v=<?php echo ASSET_VERSION; ?>" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <body class="wrapper hold-transition login-page">

        <div class="login-box container">

            <?php echo $content; ?>

        </div><!-- /.login-box -->

        <ul class="bg-bubbles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>

        <div class="clearfix"></div>

        <!-- FOOTER START -->
        <?php include 'footer.php'; ?>
        <!-- FOOTER END -->

        <!-- jQuery 2.1.4 -->
        <script src="/js/plugins/jQuery/jQuery-2.1.4.min.js?v=<?php echo ASSET_VERSION; ?>"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="/css/bootstrap/js/bootstrap.min.js?v=<?php echo ASSET_VERSION; ?>"></script>
        <!-- iCheck -->
        <script src="/js/plugins/iCheck/icheck.min.js?v=<?php echo ASSET_VERSION; ?>"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-orange',
                    radioClass: 'iradio_square-orange',
                    increaseArea: '20%' // optional
                });
            });
        </script>

        <style type="text/css">
            .main-footer {
                bottom: 0;
                float: left;
                margin-left: 0;
                position: absolute;
                width: 100%;
            }
        </style>
    </body>
</html>
