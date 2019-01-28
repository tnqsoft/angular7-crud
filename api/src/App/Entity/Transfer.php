<?php

namespace App\Entity;

use Com\Tnqsoft\Helper\Utility;

class Transfer
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $customer;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var \DateTime
     */
    private $transferDate;

    /**
     * @var string
     */
    private $transferTy;

    /**
     * @var string
     */
    private $note;

    /**
     * @var string
     */
    private $customerBankName;

    /**
     * @var string
     */
    private $customerBankAcount;

    /**
     * @var string
     */
    private $customerBankId;

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
     * @return string
     */
    public function getCustomer(): string
    {
        return $this->customer;
    }

    /**
     * @param string $customer
     * @return Transfer
     */
    public function setCustomer(string $customer): Transfer
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return Transfer
     */
    public function setAmount(float $amount): Transfer
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTransferDate(): \DateTime
    {
        return $this->transferDate;
    }

    /**
     * @param \DateTime $transferDate
     * @return Transfer
     */
    public function setTransferDate(\DateTime $transferDate): Transfer
    {
        $this->transferDate = $transferDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getTransferTy(): string
    {
        return $this->transferTy;
    }

    /**
     * @param string $transferTy
     * @return Transfer
     */
    public function setTransferTy(string $transferTy): Transfer
    {
        $this->transferTy = $transferTy;
        return $this;
    }

    /**
     * @return string
     */
    public function getNote(): string
    {
        return $this->note;
    }

    /**
     * @param string $note
     * @return Transfer
     */
    public function setNote(string $note): Transfer
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerBankName()
    {
        return $this->customerBankName;
    }

    /**
     * @param string $customerBankName
     * @return Transfer
     */
    public function setCustomerBankName(string $customerBankName): Transfer
    {
        $this->customerBankName = $customerBankName;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerBankAcount()
    {
        return $this->customerBankAcount;
    }

    /**
     * @param string $customerBankAcount
     * @return Transfer
     */
    public function setCustomerBankAcount(string $customerBankAcount): Transfer
    {
        $this->customerBankAcount = $customerBankAcount;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerBankId()
    {
        return $this->customerBankId;
    }

    /**
     * @param string $customerBankId
     * @return Transfer
     */
    public function setCustomerBankId(string $customerBankId): Transfer
    {
        $this->customerBankId = $customerBankId;
        return $this;
    }

}
