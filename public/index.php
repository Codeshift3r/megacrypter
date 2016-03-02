<?php

error_reporting(E_ALL ^ E_NOTICE); //Not required
ini_set('display_errors', 'off'); //R-E-Q-U-I-R-E-D

//date_default_timezone_set('Europe/Madrid');
require_once __DIR__ . '/../application/config/paths.php';
require_once APP_PATH . 'autoload.php';
require_once CONFIG_PATH . 'miscellaneous.php';
require_once LOCALE_PATH . 'locale.php';

try {

    $request = new Utils_Request();

    $controller_class = class_exists(($c = 'Controller_' . ucfirst($request->getVar('controller')) . 'Controller')) ? $c : 'Controller_DefaultController';

    $controller = new $controller_class($request);

    /* Let's dance */
    $controller->dispatch();
    
} catch (Exception $exception) {
    if (ERROR_LOG) {
        error_log(!is_null($exception->getMessage()) ? $exception->getMessage() : __METHOD__ . ' ' . get_class($exception) . ' code ' . $exception->getCode());
    }

    header('Location: /');
}
