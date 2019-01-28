<?php

namespace Com\Tnqsoft\Controllers;

use Com\Tnqsoft\Helper\Request;
use Com\Tnqsoft\Helper\Response;

interface RestInterface
{
    public function getAction(Request $request): Response;
    public function postAction(Request $request): Response;
    public function putAction(Request $request): Response;
    public function deleteAction(Request $request): Response;
    public function handleRequest();
}
