<?php

/*
  'db'=>array(
  'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
  ), */
// uncomment the following to use a MySQL database
$db = array(
    'connectionString' => 'mysql:host=localhost;dbname=coz_ims_ff_db',
    'enableParamLogging' => true,
    'emulatePrepare' => true,
    'username' => 'root',
    'password' => '123456',
    'charset' => 'utf8',
);
