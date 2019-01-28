<?php

namespace Com\Tnqsoft\Controllers;

use \Twig_Loader_Filesystem;
use \Twig_Environment;

use Com\Tnqsoft\Helper\Response;
use Com\Tnqsoft\Helper\JsonResponse;
use Com\Tnqsoft\Helper\Request;
use Com\Tnqsoft\Helper\Auth;
use Com\Tnqsoft\Helper\Sessions;
use Com\Tnqsoft\Exceptions\HttpException;
use Com\Tnqsoft\Providers\DatabaseProvider;
use Com\Tnqsoft\Providers\AuthProvider;
use Com\Tnqsoft\Providers\TwigProvider;

class Controller implements ControllerInterface
{
    private $request;
    private $twig;
    private $twigProvider;
    private $auth;
    private $session;

    public function __construct()
    {
        $this->session = new Sessions();
        $this->request = new Request();
        $loader = new Twig_Loader_Filesystem(VIEWS_DIR);
        $this->twig = new Twig_Environment($loader);
        $this->auth = AuthProvider::getInstance();
        $this->twigProvider = TwigProvider::getInstance($this->twig);

        if ($this->session->checkFlashMessage('success')) {
            $this->twigProvider->addGlobal('flash_message_success', $this->session->getFlashMessage('success'));
        }
        if ($this->session->checkFlashMessage('error')) {
            $this->twigProvider->addGlobal('flash_message_error', $this->session->getFlashMessage('error'));
        }

        if ($this->getAuth()->isLogined()) {
            $this->twigProvider->addGlobal('current_user', $this->getAuth()->getUser());
            $this->twigProvider->addGlobal('isLogined', true);
        } else {
            $this->twigProvider->addGlobal('isLogined', false);
        }
    }

    public function render(String $template, array $params = []): Response
    {
        return new Response(200, $this->twig->render($template, $params));
    }

    public function redirect($controller, $action = '', array $params = [])
    {
        $url = "/?controller={$controller}";
        if (!empty($action)) {
            $url .= "&action={$action}";
        }
        if (!empty($params)) {
            $url .= '&'.http_build_query($params);
        }
        header("Location: ".$url);
        die();
    }

    public function handleRequest()
    {
        $response = null;
        $action = $this->request->getQueryParam('action', 'index');

        if ($action !== null && method_exists($this, $action.'Action')) {
            $response = $this->{$action.'Action'}($this->request);
        } else {
            throw new HttpException(404, "Can not found action {$action}");
        }

        $response->setAllowDomains('*');
        $response->response();
    }

	/**
	 * Get the value of Request
	 * @return mixed
	 */
	public function getRequest() {
		return $this->request;
	}

	/**
	 * Get the value of Twig
	 * @return mixed
	 */
	public function getTwig() {
		return $this->twig;
	}

	/**
	 * Get the value of Auth
	 * @return mixed
	 */
	public function getAuth(): Auth {
		return $this->auth;
	}

	/**
	 * Get the value of Session
	 * @return mixed
	 */
	public function getSession() {
		return $this->session;
	}

}
