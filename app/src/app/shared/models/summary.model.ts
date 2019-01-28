export interface ISummary {
  startMoney: number;
  transferMoney: number;
  collectMoney: number;
}

export class Summary implements ISummary {
  public startMoney: number;
  public transferMoney: number;
  public collectMoney: number;

  constructor(startMoney?: number, transferMoney?: number, collectMoney?: number) {
    this.startMoney = startMoney;
    this.transferMoney = transferMoney;
    this.collectMoney = collectMoney;
  }
}
