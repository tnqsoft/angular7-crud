<?php

namespace Com\Tnqsoft\Controllers;

use Com\Tnqsoft\Helper\Response;
use Com\Tnqsoft\Helper\Request;
use Com\Tnqsoft\Exceptions\HttpException;
use Com\Tnqsoft\Helper\AuthJwt;

abstract class RestController implements RestInterface
{
    protected $auth;

    private $request;

    public function __construct()
    {
        $this->request = new Request();
        $this->auth = new AuthJwt($this->request);
    }

    public function handleRequest()
    {
        $response = null;
        $action = $this->request->getQueryParam('action');

        if ($action !== null && method_exists($this, $action.'Action')) {
            $response = $this->{$action.'Action'}($this->request);
        } elseif ($this->request->isRequestGet()) {
            $response = $this->getAction($this->request);
        } elseif ($this->request->isRequestPost()) {
            $response = $this->postAction($this->request);
        }  elseif ($this->request->isRequestPut()) {
            $response = $this->putAction($this->request);
        } elseif ($this->request->isRequestDelete()) {
            $response = $this->deleteAction($this->request);
        } else {
            throw new HttpException(405, "Not allow method " . $this->request->getCurrentRequestMethod());
        }
//        $response->setAllowDomains('*')
//            ->setHeaders(['*'])
//            ->setAllowMethods('*');
        $response->response();
    }

}
