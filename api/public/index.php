<?php

session_start();

require '../src/kernel.php';

use Com\Tnqsoft\Helper\Request;
use Com\Tnqsoft\Exceptions\HttpException;

$request = new Request();
$controller = $request->getQueryParam('controller', 'default');
if ($controller === 'index.php') {
    $controller = 'default';
}
try {
    $reflection = new \ReflectionClass('App\\Controllers\\'.ucfirst($controller).'Controller');
    $controller = $reflection->newInstance();
    $controller->handleRequest();
} catch(\ReflectionException $e) {
    throw new HttpException(404, "Can not found controller {$controller}");
}
