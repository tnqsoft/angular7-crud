<?php

namespace Com\Tnqsoft\Entity;

use Com\Tnqsoft\Helper\Utility;

class User
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $fullname;

    /**
     * @var string
     */
    private $email;

    /**
     * @var bool
     */
    private $is_active;

    /**
     * @var \DateTime
     */
    private $last_login;

    public function __construct()
    {
    }

    /**
     * Get the value of Id
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of Id
     * @param integer $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of Username
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of Username
     * @param string $username
     * @return self
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get the value of Password
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of Password
     * @param string $password
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get the value of Fullname
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set the value of Fullname
     * @param string $fullname
     * @return self
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
        return $this;
    }

    /**
     * Get the value of Email
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of Email
     * @param string $email
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get the value of Is Active
     * @return bool
     */
    public function getIsActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Set the value of Is Active
     * @param bool $is_active
     * @return self
     */
    public function setIsActive(bool $is_active)
    {
        $this->is_active = $is_active;
        return $this;
    }

    /**
     * Get the value of Last Login
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->last_login;
    }

    /**
     * Set the value of Last Login
     * @param \DateTime $last_login
     * @return self
     */
    public function setLastLogin(\DateTime $last_login)
    {
        $this->last_login = $last_login;
        return $this;
    }
}
