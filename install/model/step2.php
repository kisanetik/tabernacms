<?php
return array(
    'php_version' => array(
        'label' => self::lang('php_version'),
        'error' => false,
        'download' => false
    ),
    'gd' => array(
        'label' => self::lang('gd'),
        'error' => false,
        'download' => 'http://www.php.net/manual/ru/book.image.php'
    ),
    'pdo' => array(
        'label' => self::lang('pdo'),
        'error' => false,
        'download' => 'http://php.net/pdo'
    ),
    'pdo_mysql' => array(
        'label' => self::lang('pdo_mysql'),
        'error' => false,
        'download' => 'http://php.net/manual/en/ref.pdo-mysql.php'
    ),
    'mb' => array(
        'label' => self::lang('mb'),
        'error' => false,
        'download' => 'http://php.net/mbstring'
    ),
    'root' => array(
        'label' => self::lang('root'),
        'error' => false,
        'download' => false
    ),
    'compiled' => array(
        'label' => self::lang('folder').'syscache/compiled',
        'error' => false,
        'download' => false
    ),
    'cached' => array(
        'label' => self::lang('folder').'syscache/cached',
        'error' => false,
        'download' => false
    ),
    'img' => array(
        'label' => self::lang('folder').'cache',
        'error' => false,
        'download' => false
    ),
);