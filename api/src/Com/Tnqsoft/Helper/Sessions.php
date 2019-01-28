<?php

namespace Com\Tnqsoft\Helper;

use Com\Tnqsoft\Helper\Utility;

class Sessions
{
    /**
     * Kiểm tra flash message có tồn tại hay không
     *
     * @param string $key Mã của flash message
     * @return boolean
     */
    public function checkFlashMessage($key)
    {
        return $this->hasKey('flash_'.$key);
    }

    /**
     * Sét giá trị cho flash message
     *
     * @param string $key Mã của message
     * @param string $message Nội dung của message
     */
    public function setFlashMessage($key, $message)
    {
        $this->setSesion('flash_'.$key, $message);
    }

    /**
     * Trả về nội dung của message
     *
     * @param string $key Mã của message
     * @return string
     */
    public function getFlashMessage($key)
    {
        $message = $this->getSesion('flash_'.$key);
        //Sau khi lấy ra nội dung, thì xóa đi ngay
        $this->removeSesion('flash_'.$key);
        return $message;
    }

    /**
     * Xóa tất cả các flash message
     */
    public function clearAllFlashMessage()
    {
        if (!empty($_SESSION)) {
            foreach ($_SESSION as $key => $value) {
                if (preg_match('/flash_(.*)/', $key)) {
                    $this->removeSesion($key);
                }
            }
        }
    }

    public function hasKey($key)
    {
        return isset($_SESSION[$key]);
    }

    public function setSesion($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function clearSesion()
    {
        session_destroy();
    }

    /**
     * Lấy giá trị từ biến SESSION
     *
     * @param string $key Tên biến
     * @return string
     */
    public function getSesion($key, $default = null)
    {
        if ($this->hasKey($key)) {
            return $_SESSION[$key];
        }
        return $default;
    }

    /**
     * Xóa biến SESSION
     *
     * @param type $key Tên biến
     */
    public function removeSesion($key)
    {
        if ($this->hasKey($key)) {
            unset($_SESSION[$key]);
        }
    }

    public function setCookie($key, $value, $timeout = 86400, $path = '/')
    {
        setcookie($key, $value, time() + $timeout, $path);
    }

    public function getCookie($key, $default = null)
    {
        if (isset($_COOKIE[$key])) {
            return $_COOKIE[$key];
        }

        return $default;
    }
}
