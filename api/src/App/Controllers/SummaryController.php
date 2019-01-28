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

class SummaryController extends RestController
{
    public function getAction(Request $request): Response
    {
        $this->auth->checkAuthentication();

        $dbAccess = DatabaseProvider::getInstance();
        $record = $dbAccess->findOneById('summary', 1);
        return new JsonResponse(200, [
            'startMoney' => doubleval($record->start_money),
            'transferMoney' => doubleval($record->transfer_money),
            'collectMoney' => doubleval($record->collect_money),
        ]);
    }
    //--------------------------------------------------------------------------
    public function postAction(Request $request): Response
    {
        return new JsonResponse(204, null);
    }
    //--------------------------------------------------------------------------
    public function putAction(Request $request): Response
    {
        $this->auth->checkAuthentication();

        $dbAccess = DatabaseProvider::getInstance();
        $sql = 'SELECT SUM(t.amount) FROM `tbl_transfer` AS t WHERE t.`transferType`=\'Transfer\'';
        $trasnferMoney = $dbAccess->scalarBySQL($sql);
        $sql = 'SELECT SUM(t.amount) FROM `tbl_transfer` AS t WHERE t.`transferType`=\'Collect\'';
        $collectMoney = $dbAccess->scalarBySQL($sql);
        $record = $dbAccess->save('summary', array(
            'id' => 1,
            'transfer_money' => $trasnferMoney,
            'collect_money' => $collectMoney,
        ), 'id');
        return new JsonResponse(200, [
            'startMoney' => doubleval($record->start_money),
            'transferMoney' => doubleval($record->transfer_money),
            'collectMoney' => doubleval($record->collect_money),
        ]);
    }
    //--------------------------------------------------------------------------
    public function deleteAction(Request $request): Response
    {
        return new JsonResponse(204, null);
    }
}
