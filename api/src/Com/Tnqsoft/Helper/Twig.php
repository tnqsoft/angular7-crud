<?php

namespace Com\Tnqsoft\Helper;

use \Twig_Environment;
use \Twig_Filter;
use \Twig_Function;

use Com\Tnqsoft\Helper\Utility;

class Twig
{
    private $twig;

    public function __construct(Twig_Environment &$twig)
    {
        $this->twig = $twig;
        $this->addFilters();
        $this->addFunctions();
    }

    public function addGlobal($key, $value)
    {
        $this->twig->addGlobal($key, $value);
    }

    public function addFilters()
    {
        $this->twig->addFilter(new Twig_Filter('demoFilter', function ($string) {
            return $string.'Demo filter here';
        }));
    }

    public function addFunctions()
    {
        $this->twig->addFunction(new Twig_Function('path', function ($controller, $action = '', array $params = []) {
            $url = "/?controller={$controller}";
            if (!empty($action)) {
                $url .= "&action={$action}";
            }
            if (!empty($params)) {
                $url .= '&'.http_build_query($params);
            }

            return $url;
        }));

        $this->twig->addFunction(new Twig_Function('appDomain', function () {
            if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||  isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
                $protocol = 'https://';
            } else {
                $protocol = 'http://';
            }
            $hostName = $_SERVER['SERVER_NAME'];

            return $protocol.$hostName;
        }));
    }
}
