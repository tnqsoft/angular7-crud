<?php

namespace Com\Tnqsoft\Exceptions;

use \Twig_Loader_Filesystem;
use \Twig_Environment;
use Com\Tnqsoft\Helper\JsonResponse;

/**
 * HttpException class
 *
 * Ý tưởng: Tạo ra một đối tượng exception tùy chỉnh, và hiển thị dưới dạng mã lỗi
 * http code 500 về cho người client
 *
 * @author Nguyễn Như Tuấn <tuanquynh0508@gmail.com>
 * @link https://github.com/tuanquynh0508/phpstore
 * @copyright 2015 I-Designer
 * @license https://github.com/tuanquynh0508/phpstore/license/
 * @package classes
 * @see Exception
 * @since 1.0
 */
class HttpException extends \Exception
{

	/**
	 * {@inheritdoc}
	 */
	public function __construct($code = 0, $message, Exception $previous = null)
	{
		set_exception_handler(array("Com\Tnqsoft\Exceptions\HttpException", "getStaticException"));
		parent::__construct($message, $code, $previous);
	}

	/**
	 * __toString
	 *
	 * {@inheritdoc}
	 *
	 * @return string
	 */
	public function __toString()
	{
        $response = new JsonResponse($this->getCode(), [
            'code' => $this->getCode(),
            'message' => $this->getMessage()
        ]);
        return $response->__toString();
	}

	/**
	 * Trả về Exception
	 */
	public function getException()
	{
		print $this;
	}

	/**
	 * Trả về đối tượng Exception tĩnh
	 *
	 * @param Exception $exception
	 */
	public static function getStaticException($exception)
	{
		$exception->getException();
	}

}
