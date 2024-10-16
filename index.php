<?php

session_start();

require_once __DIR__.'/config/config.php';

if (DEV_MODE == true){

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
}else{
    error_reporting(0);
    ini_set('error_reporting', false);
}

foreach (glob( BASEDIR . '/helpers/*.php') as $filename) {
    require $filename;
}



$config['route'][0] = 'home';
$config['lang'] = 'tr';

    if (isset($_GET['route'])) {

        preg_match('@(?<lang>\b[a-z]{2}\b)?/?(?<route>(.+))/?@', $_GET['route'], $result);

    }

    if (isset($result['lang'])) {

        if (file_exists(__DIR__.'/language/' . $result['lang'] . '.php')) {
            $config['lang'] = $result['lang'];
        }else{
            $config['lang'] = 'tr';
        }

        require_once BASEDIR.'/language/' . $config['lang'] . '.php';
    }


    if (isset($result['route'])) {
        $config['route'] = explode('/', $result['route']);
    }

require_once BASEDIR.'/language/' . $config['lang'] . '.php';

    if (file_exists(BASEDIR.'/Controller/' . $config['route'][0] . '.php')) {
        require_once BASEDIR.'/Controller/' . $config['route'][0] . '.php';
    }else{
        echo 'Sayfa Bulunamadı';
    }

if (isset($_SESSION['error'])) $_SESSION['error'] = null;
if (isset($_SESSION['post'])) $_SESSION['post'] = null;