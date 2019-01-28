<?php

namespace Com\Tnqsoft\Helper;

use Com\Tnqsoft\Helper\Utility;
use Com\Tnqsoft\Helper\Sessions;
use Com\Tnqsoft\Helper\Request;
use Com\Tnqsoft\Entity\User;
use Com\Tnqsoft\Exceptions\HttpException;
use Com\Tnqsoft\Providers\DatabaseProvider;
use \Firebase\JWT\JWT;

class AuthJwt
{
    /**
     * @var User
     */
    private $user;

    private $userid;

    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function checkAuthentication()
    {
        $token = '';
        $param = $this->request->getHeaderParam('Authorization');
        if (preg_match('/^Bearer (.*)$/', $param, $regs)) {
            $token = $regs[1];
        } else {
            throw new HttpException(403, "Token invalid.");
        }

        try {
            $decoded = JWT::decode($token, SECRET, array('HS256'));
            if (time() > $decoded->exp) {
                throw new HttpException(403, "Token expired.");
            }
            if (Utility::getIp() !== $decoded->ip) {
                throw new HttpException(403, "Token invalid. Ip ".$decoded->ip." is blocked.");
            }
            $this->userid = $decoded->user_id;
        } catch (\Exception $e) {
            if (!($e instanceof HttpException)) {
                throw new HttpException(403, "Token invalid.");
            }
            throw $e;
        }
    }

    public function getUser()
    {
        if (null === $this->userid) {
            return;
        }

        $dbAccess = DatabaseProvider::getInstance();

        $record = $dbAccess->findOneById('user', $this->userid);
        if ($record === null) {
            throw new HttpException(404, "Not found record with id {$this->userid}");
        }

        return $record;
    }
}