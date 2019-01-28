<?php

namespace Com\Tnqsoft\Helper;

use Com\Tnqsoft\Helper\Utility;
use Com\Tnqsoft\Helper\Sessions;
use Com\Tnqsoft\Entity\User;
use Com\Tnqsoft\Exceptions\HttpException;
use Com\Tnqsoft\Providers\DatabaseProvider;

class Auth
{
    /**
     * @var User
     */
    private $user;

    private $logined = false;

    private $session;

    const COOKIE_TIMEOUT = 2592000; // 30 Day

    public function __construct()
    {
        $this->session = new Sessions();

        $this->getUserFromSession();
    }

    public function getUserFromSession()
    {
        $token = $this->session->getCookie(COOKIE_LOGINED);

        if (!$this->session->hasKey(SESSION_LOGINED) && empty($token)) {
            $this->logined = false;
            return;
        }

        $this->logined = true;
        $username = $this->session->getSesion(SESSION_LOGINED);

        $dbAccess = DatabaseProvider::getInstance();
        $criteria = [
            'username' => $username
        ];
        if (!empty($token)) {
            $criteria = [
                'token' => $token
            ];
        }
        $record = $dbAccess->findOneBy('user', $criteria);

        if ($record === null) {
            $this->logout();
            throw new HttpException(404, "Not found user with username {$username}");
        }

        $user = new User();
        $user->setId($record->id)
             ->setUsername($record->username)
             ->setPassword($record->pass)
             ->setFullname($record->fullname)
             ->setEmail($record->email)
             ->setIsActive($record->is_active)
             ->setLastLogin(new \DateTime($record->last_login));

        $this->user = $user;
    }

    public function login($username, $token)
    {
        $this->session->setSesion(SESSION_LOGINED, $username);

        if (!empty($token)) {
            $this->session->setCookie(COOKIE_LOGINED, $token, static::COOKIE_TIMEOUT);
        }

        $this->getUserFromSession();
    }

    public function logout()
    {
        $this->session->setCookie(COOKIE_LOGINED, '', 0);
        $this->session->clearSesion();
    }

	/**
	 * Get the value of User
	 * @return User
	 */
	public function getUser(): User {
		return $this->user;
	}

	/**
	 * Get the value of Logined
	 * @return mixed
	 */
	public function isLogined(): bool {
		return $this->logined;
	}
}
