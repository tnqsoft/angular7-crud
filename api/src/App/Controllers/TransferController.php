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

class TransferController extends RestController
{
    public function getAction(Request $request): Response
    {
        $this->auth->checkAuthentication();

        $dbAccess = DatabaseProvider::getInstance();

        $id = intval($request->getQueryParam('id', 0));

        if ($id === 0) {
            // Get List
            $sql = 'SELECT COUNT(1) FROM `tbl_transfer`';
            $totalRecord = $dbAccess->scalarBySQL($sql);

            $paginator = new Paginator($totalRecord, 10);

            $sql = 'SELECT * FROM `tbl_transfer` t ORDER BY t.`transferDate` DESC ' . $paginator->getLimitSql();
            $data = $dbAccess->findAllBySql($sql);

            $list = array();
            foreach ($data as $record) {
                $list[] = TransferTranform::tranform($record);
            }

            $response = new JsonResponse(200, $list);
            $response->setHeaders(array(
                'X-Paging-PageCount' => $paginator->getMaxPage(),
                'X-Paging-PageNo' => $paginator->getPage(),
                'X-Paging-PageSize' => $paginator->getLimit(),
                'X-Paging-RecordCount' => $paginator->getTotalRecord(),
                'X-Paging-RecordStart' => $paginator->getStartRecord(),
                'X-Paging-RecordEnd' => $paginator->getEndRecord(),
            ));
            return $response;
        } else {
            // Get Detail
            $record = $dbAccess->findOneById('transfer', $id);
            if ($record === null) {
                throw new HttpException(404, "Not found record with id {$id}");
            }

            return new JsonResponse(200, TransferTranform::tranform($record));
        }
    }
    //--------------------------------------------------------------------------
    public function postAction(Request $request): Response
    {
        $this->auth->checkAuthentication();

        $customer = $request->getRequestParam('customer');
        $amount = $request->getRequestParam('amount');
        $transferDate = $request->getRequestParam('transferDate');
        if (!empty($transferDate)) {
            $transferDate = new \DateTime($transferDate);
        } else {
            $transferDate = new \DateTime();
        }
        $transferType = $request->getRequestParam('transferType');
        $note = $request->getRequestParam('note');
        $customerBankName = $request->getRequestParam('customerBankName');
        $customerBankAcount = $request->getRequestParam('customerBankAcount');
        $customerBankId = $request->getRequestParam('customerBankId');

        if (empty($customer)) {
            throw new HttpException(400, "Customer is required");
        }

        if ($amount === null || $amount === '') {
            throw new HttpException(400, "Amount is required");
        }

        if (empty($transferType)) {
            throw new HttpException(400, "Type is required");
        }

        if (empty($note)) {
            throw new HttpException(400, "Note is required");
        }

        $dbAccess = DatabaseProvider::getInstance();

        $record = $dbAccess->save('transfer', array(
            'customer' => $customer,
            'amount' => $amount,
            "transferDate" =>  $transferDate,
            "transferType" => $transferType,
            "note" => $note,
            "customerBankName" => $customerBankName,
            "customerBankAcount" => $customerBankAcount,
            "customerBankId" => $customerBankId,
        ));

        return new JsonResponse(201, TransferTranform::tranform($record));
    }
    //--------------------------------------------------------------------------
    public function putAction(Request $request): Response
    {
        $this->auth->checkAuthentication();

        $customer = $request->getRequestParam('customer');
        $amount = $request->getRequestParam('amount');
        $transferDate = $request->getRequestParam('transferDate');
        if (!empty($transferDate)) {
            $transferDate = new \DateTime($transferDate);
        } else {
            $transferDate = new \DateTime();
        }
        $transferType = $request->getRequestParam('transferType');
        $note = $request->getRequestParam('note');
        $customerBankName = $request->getRequestParam('customerBankName');
        $customerBankAcount = $request->getRequestParam('customerBankAcount');
        $customerBankId = $request->getRequestParam('customerBankId');

        if (empty($customer)) {
            throw new HttpException(400, "Customer is required");
        }

        if ($amount === null || $amount === '') {
            throw new HttpException(400, "Amount is required");
        }

        if (empty($transferType)) {
            throw new HttpException(400, "Type is required");
        }

        if (empty($note)) {
            throw new HttpException(400, "Note is required");
        }

        $id = intval($request->getQueryParam('id'));
        $this->getRecordById($id);
        $dbAccess = DatabaseProvider::getInstance();
        $record = $dbAccess->save('transfer', array(
            'id' => $id,
            'customer' => $customer,
            'amount' => $amount,
            "transferDate" =>  $transferDate,
            "transferType" => $transferType,
            "note" => $note,
            "customerBankName" => $customerBankName,
            "customerBankAcount" => $customerBankAcount,
            "customerBankId" => $customerBankId,
        ), 'id');

        return new JsonResponse(200, TransferTranform::tranform($record));
    }
    //--------------------------------------------------------------------------
    public function deleteAction(Request $request): Response
    {
        $this->auth->checkAuthentication();

        $id = intval($request->getQueryParam('id'));
        $this->getRecordById($id);
        $dbAccess = DatabaseProvider::getInstance();
        $dbAccess->deleteById('transfer', $id);
        return new JsonResponse(204, null);
    }

    private function getRecordById($id)
    {
        if (empty($id)) {
            throw new HttpException(400, "Missing id");
        }

        $dbAccess = DatabaseProvider::getInstance();

        $record = $dbAccess->findOneById('transfer', $id);
        if ($record === null) {
            throw new HttpException(404, "Not found record with id {$id}");
        }

        return $record;
    }
}
