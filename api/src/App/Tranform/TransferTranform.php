<?php

namespace App\Tranform;

class TransferTranform
{
    public static function tranform($record)
    {
        return array(
            "id" =>  intval($record->id),
            "customer" =>  $record->customer,
            "amount" => doubleval($record->amount),
            "transferDate" =>  $record->transferDate,
            "transferType" => $record->transferType,
            "note" => $record->note,
            "customerBankName" => $record->customerBankName,
            "customerBankAcount" => $record->customerBankAcount,
            "customerBankId" => $record->customerBankId,
        );
    }
}
