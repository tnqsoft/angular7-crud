<?php

namespace Com\Tnqsoft\Controllers;

use Com\Tnqsoft\Helper\Request;
use Com\Tnqsoft\Helper\Response;

interface ControllerInterface
{
    public function render(String $template, array $params = []): Response;
    public function handleRequest();
    public function redirect($controller, $action, array $params = []);
}
