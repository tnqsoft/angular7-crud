import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import * as moment from 'moment';
import { TransferModel, ITransfer } from 'src/app/shared/models/transfer.model';
import { TransferService } from 'src/app/shared/services/transfer.service';
import { Router, ActivatedRoute } from '@angular/router';
import { Observable } from 'rxjs';
import { ToastrService } from 'ngx-toastr';
import { NgxSpinnerService } from 'ngx-spinner';
import { SummaryService } from 'src/app/shared/services/summary.service';

@Component({
  selector: 'app-new-transfer',
  templateUrl: './crud-transfer.component.html',
  styleUrls: ['./crud-transfer.component.scss']
})
export class NewTransferComponent implements OnInit {

  public form: FormGroup;
  public isFormCheck = false;
  public listType: Array<string> = ['Transfer', 'Collect'];
  public bsInlineValue: Date = new Date();
  public id: number;
  public transfer: TransferModel;

  constructor(
    private transferService: TransferService,
    private route: ActivatedRoute,
    private router: Router,
    private toastr: ToastrService,
    private spinner: NgxSpinnerService,
    private summaryService: SummaryService
  ) {
    this.id = this.route.snapshot.params['id'];
  }

  ngOnInit() {
    this.form = new FormGroup({
      id: new FormControl(''),
      customer: new FormControl('', [Validators.required]),
      amount: new FormControl(0, [Validators.required]),
      transferDate: new FormControl(''),
      transferType: new FormControl('Transfer', [Validators.required]),
      note: new FormControl('', [Validators.required]),
      customerBankName: new FormControl(''),
      customerBankAcount: new FormControl(''),
      customerBankId: new FormControl(''),
    });
    this.form.valueChanges.subscribe(
      result => {
        this.isFormCheck = false;
      }
    );

    if (this.id) {
      this.spinner.show();
      this.transferService.getTransfer(this.id).subscribe(
        response => {
          this.transfer = Object.assign(new TransferModel(), response);
          this.bsInlineValue = moment(this.transfer.transferDate).toDate();
          this.form.setValue(this.transfer);
        }, error => {
          console.log(error);
        }
      ).add(() => {
        this.spinner.hide();
      });
    }
  }

  public changeDate(payload) {
    this.form.get('transferDate').setValue(moment(payload).format('YYYY-MM-DD h:mm:ss'));
  }

  public onSubmit(): void {
    this.isFormCheck = true;
    if (this.form.valid) {
      const transferModel: TransferModel = this.prepareData();
      let handler$: Observable<any>;
      if (this.id) {
        handler$ = this.transferService.editTransfer(this.id, transferModel);
      } else {
        handler$ = this.transferService.addTransfer(transferModel);
      }
      this.spinner.show();
      handler$.subscribe(
        () => {
          this.summaryService.updateSummary().subscribe(() => {});
          this.transferService.resetCacheList();
          if (this.id) {
            // Display popup.
            this.isFormCheck = false;
            this.toastr.info('Update successful!.', '');
          } else {
            this.router.navigate(['/transfer/list']);
            this.toastr.success('Add successful!.', '');
          }
        }, error => {
          console.log(error);
        }
      ).add(() => {
        this.spinner.hide();
      });
    }
  }

  private prepareData() {
    const transferModel: TransferModel = new TransferModel();
    transferModel.customer = this.form.get('customer').value;
    transferModel.amount = this.form.get('amount').value;
    transferModel.transferDate = this.form.get('transferDate').value;
    transferModel.transferType = this.form.get('transferType').value;
    transferModel.note = this.form.get('note').value;
    transferModel.customerBankName = this.form.get('customerBankName').value;
    transferModel.customerBankAcount = this.form.get('customerBankAcount').value;
    transferModel.customerBankId = this.form.get('customerBankId').value;
    return transferModel;
  }
}
