<?php

namespace Com\Tnqsoft\Helper;

use Com\Tnqsoft\Helper\Utility;

class Request
{
    private $query;

    private $request;

    private $headers;

    public function __construct()
    {
        $this->getQuery();
        $this->getRequest();
        $this->getHeaders();
    }

    public function isRequestGet()
    {
        return $this->getCurrentRequestMethod() == 'GET';
    }

    public function isRequestPost()
    {
        return $this->getCurrentRequestMethod() == 'POST';
    }

    public function isRequestPut()
    {
        return $this->getCurrentRequestMethod() == 'PUT';
    }

    public function isRequestDelete()
    {
        return $this->getCurrentRequestMethod() == 'DELETE';
    }

    public function getCurrentRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getQuery()
    {
        $this->query = $_GET;

        return $this->query;
    }

    public function getRequest()
    {
        $this->request = $_POST;
        $raw = json_decode(file_get_contents("php://input"), true);
        if ($raw !== null) {
            $this->request = array_merge($this->request, $raw);
        }

        return $this->request;
    }

    public function getHeaders()
    {
        foreach (getallheaders() as $name => $value) {
            $this->headers[$name] = $value;
        }
    }

    public function getQueryParam($name, $default = null)
    {
        // if (!isset($this->query[$name])) {
        //     return $default;
        // }
        //
        // return $this->query[$name];
        return Utility::getArrayValue($name, $this->query, $default);
    }

    public function getRequestParam($name, $default = null)
    {
        // if (!isset($this->request[$name])) {
        //     return $default;
        // }
        //
        // return $this->request[$name];
        return Utility::getArrayValue($name, $this->request, $default);
    }

    public function getHeaderParam($name, $default = null)
    {
        return Utility::getArrayValue($name, $this->headers, $default);
    }
}
