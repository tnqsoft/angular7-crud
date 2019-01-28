<?php

namespace App\Controllers;

use Com\Tnqsoft\Helper\Response;
use Com\Tnqsoft\Helper\JsonResponse;
use Com\Tnqsoft\Helper\Request;
use Com\Tnqsoft\Helper\Paginator;
use Com\Tnqsoft\Exceptions\HttpException;
use Com\Tnqsoft\Controllers\RestController;
use Com\Tnqsoft\Providers\DatabaseProvider;
use App\Tranform\TransferTranform;
use \Firebase\JWT\JWT;
use Com\Tnqsoft\Helper\Utility;

class LoginController extends RestController
{
    public function getAction(Request $request): Response
    {
        return new JsonResponse(204, null);
    }
    //--------------------------------------------------------------------------
    public function postAction(Request $request): Response
    {
        $login = $request->getRequestParam('login');
        $password = $request->getRequestParam('password');
        if (empty($login)) {
            throw new HttpException(400, "Login is required");
        }
        if (empty($password)) {
            throw new HttpException(400, "Password is required");
        }

        $dbAccess = DatabaseProvider::getInstance();
        $record = $dbAccess->findOneBy('user', [
            'username' => $login
        ]);
        if (null === $record) {
            throw new HttpException(401, "Username is wrong.");
        }
        if ($record->pass !== md5($password)) {
            throw new HttpException(401, "Password is wrong.");
        }
        if (intval($record->is_active) !== 1) {
            throw new HttpException(401, "User is baned.");
        }

        // Generate JWT token
        $now = new \DateTime();
        $exp = new \DateTime();
        $exp->modify('+1 day');
        $token = array(
            "user_id" => $record->id,
            "user_name" => $record->username,
            "iat" => $now->getTimestamp(),
            "exp" => $exp->getTimestamp(),
            "ip" => Utility::getIp()
        );
        $jwt = JWT::encode($token, SECRET);

        return new JsonResponse(200, ['token' => $jwt]);
    }
    //--------------------------------------------------------------------------
    public function putAction(Request $request): Response
    {
        return new JsonResponse(204, null);
    }
    //--------------------------------------------------------------------------
    public function deleteAction(Request $request): Response
    {
        return new JsonResponse(204, null);
    }
}
