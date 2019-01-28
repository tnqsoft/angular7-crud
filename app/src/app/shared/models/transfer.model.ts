export interface ITransfer {
  id?: number;
  customer: string;
  amount: number;
  transferDate: string;
  transferType: string;
  note: string;
  customerBankName?: string;
  customerBankAcount?: string;
  customerBankId?: string;
}

export class TransferModel implements ITransfer {
  public id: number;
  public customer: string;
  public amount: number;
  public transferDate: string;
  public transferType: string;
  public note: string;
  public customerBankName?: string;
  public customerBankAcount?: string;
  public customerBankId?: string;

  constructor() {}

  public getTransferDate() {
    return 'Date: ' + this.transferDate;
  }
}
