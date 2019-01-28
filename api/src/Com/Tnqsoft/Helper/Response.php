<?php

namespace Com\Tnqsoft\Helper;

class Response
{
    /**
     * @var integer
     */
    private $statusCode;

    /**
     * @var mixed
     */
    private $content;

    /**
     * @var string
     */
    private $contentType;

    /**
     * @var mixed
     */
    private $allowDomains;

    /**
     * @var array
     */
    private $allowMethods;

    /**
     * @var array
     */
    private $headers;

    public function __construct($statusCode, $content, $contentType = 'text/html;charset=UTF-8', $headers = array())
    {
        $this->statusCode = $statusCode;
        $this->content = $content;
        $this->contentType = $contentType;
        $this->allowMethods = array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS', 'HEAD');
        $this->headers = $headers;
    }

    public function response()
    {
        $this->buildAllowOrigin();
        header('Content-Type: '.$this->contentType);
		http_response_code($this->statusCode);
        echo $this->content;
    }

    public function __toString()
    {
        $this->buildAllowOrigin();
        header('Content-Type: '.$this->contentType);
        http_response_code($this->statusCode);
        return $this->content;
    }

    public function buildAllowOrigin()
    {
//        if (!empty($this->allowDomains)) {
//            header('Access-Control-Allow-Origin: ' . (is_array($this->allowDomains)?implode(",", $this->allowDomains):$this->allowDomains));
//        }
//
        if (!empty($this->headers)) {
//            $headers = implode(",", array_keys($this->headers));
//            header('Access-Control-Allow-Headers: ' . $headers);
            foreach ($this->headers as $key => $value) {
                header("{$key}: {$value}");
            }
        }
//
//        if (!empty($this->allowMethods)) {
//            header('Access-Control-Allow-Methods: ' . implode(",", $this->allowMethods));
//        }
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
            header('Access-Control-Allow-Headers: token, Content-Type, x-correlation-id, apikey');
            header('Access-Control-Max-Age: 1728000');
            header('Content-Length: 0');
            header('Content-Type: text/plain');
            die();
        }

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
        header('Access-Control-Allow-Headers: *');
        header('Access-Control-Expose-Headers: *');
        header("Access-Control-Allow-Credentials: true");
    }

	/**
	 * Get the value of Status Code
	 * @return integer
	 */
	public function getStatusCode() {
		return $this->statusCode;
	}

	/**
	 * Set the value of Status Code
	 * @param integer $statusCode
	 * @return self
	 */
	public function setStatusCode($statusCode) {
		$this->statusCode = $statusCode;
		return $this;
	}

	/**
	 * Get the value of Content
	 * @return mixed
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * Set the value of Content
	 * @param mixed $content
	 * @return self
	 */
	public function setContent($content) {
		$this->content = $content;
		return $this;
	}

	/**
	 * Get the value of Content Type
	 * @return string
	 */
	public function getContentType() {
		return $this->contentType;
	}

	/**
	 * Set the value of Content Type
	 * @param string $contentType
	 * @return self
	 */
	public function setContentType($contentType) {
		$this->contentType = $contentType;
		return $this;
	}

	/**
	 * Get the value of Allow Domains
	 * @return mixed
	 */
	public function getAllowDomains() {
		return $this->allowDomains;
	}

	/**
	 * Set the value of Allow Domains
	 * @param mixed $allowDomains
	 * @return self
	 */
	public function setAllowDomains($allowDomains) {
		$this->allowDomains = $allowDomains;
		return $this;
	}

	/**
	 * Get the value of Allow Methods
	 * @return array
	 */
	public function getAllowMethods() {
		return $this->allowMethods;
	}

	/**
	 * Set the value of Allow Methods
	 * @param array $allowMethods
	 * @return self
	 */
	public function setAllowMethods(array $allowMethods) {
		$this->allowMethods = $allowMethods;
		return $this;
	}

	/**
	 * Get the value of Headers
	 * @return array
	 */
	public function getHeaders() {
		return $this->headers;
	}

	/**
	 * Set the value of Headers
	 * @param array $headers
	 * @return self
	 */
	public function setHeaders(array $headers) {
		$this->headers = $headers;
		return $this;
	}

}
