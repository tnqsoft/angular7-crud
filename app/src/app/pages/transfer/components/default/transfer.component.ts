import { Component, OnInit, TemplateRef } from '@angular/core';
import { TransferService } from 'src/app/shared/services/transfer.service';
import { ITransfer } from 'src/app/shared/models/transfer.model';
import { BsModalService, BsModalRef } from 'ngx-bootstrap';
import { ModalConfirmComponent } from 'src/app/shared/components/modal-confirm/modal-confirm.component';
import { ToastrService } from 'ngx-toastr';
import { NgxSpinnerService } from 'ngx-spinner';
import { HttpResponse, HttpHeaders } from '@angular/common/http';
import { Page } from 'src/app/shared/models/page.model';
import { SummaryService } from 'src/app/shared/services/summary.service';

@Component({
  selector: 'app-transfer',
  templateUrl: './transfer.component.html',
  styleUrls: ['./transfer.component.scss']
})
export class TransferComponent implements OnInit {
  public listTransfer: Array<ITransfer> = [];
  public bsModalRef: BsModalRef;
  public currentItem: ITransfer;
  public page: Page = new Page();

  constructor(
    private transferService: TransferService,
    private modalService: BsModalService,
    private toastr: ToastrService,
    private spinner: NgxSpinnerService,
    private summaryService: SummaryService
  ) { }

  ngOnInit() {
    this.getList();
  }

  public deleteConfirm(currentItem: ITransfer) {
    this.currentItem = currentItem;
    // this.modalRef = this.modalService.show(template);
    const initialState = {
      title: 'Delete Confirm',
      question: 'Do you want to delete record with id is "' + currentItem.id + '" ?.'
    };
    this.bsModalRef = this.modalService.show(ModalConfirmComponent, { initialState });
    // this.bsModalRef.content.closeBtnName = 'Close';
    this.bsModalRef.content.action.subscribe((value) => {
      this.delete();
    });
  }

  public getList(pageInfo?: any) {
    if (pageInfo) {
      this.page.pageNumber = pageInfo.offset + 1;
    }
    this.spinner.show();
    this.transferService.getTransferList(this.page).subscribe(
      (response: HttpResponse<any>) => {
        this.listTransfer = response.body;
        const header: HttpHeaders = response.headers;
        // this.page.pageNo = parseInt(header.get('X-Paging-PageNo'), 10);
        // this.page.pageCount = parseInt(header.get('X-Paging-PageCount'), 10);
        // this.page.pageSize = parseInt(header.get('X-Paging-PageSize'), 10);
        // this.page.recordCount = parseInt(header.get('X-Paging-RecordCount'), 10);
        // this.page.recordStart = parseInt(header.get('X-Paging-RecordStart'), 10);
        // this.page.recordEnd = parseInt(header.get('X-Paging-RecordEnd'), 10);
        this.page.totalElements = parseInt(header.get('X-Paging-RecordCount'), 10);
        this.page.pageNumber = parseInt(header.get('X-Paging-PageNo'), 10);
        this.page.size = parseInt(header.get('X-Paging-PageSize'), 10);
        this.page.totalPages = parseInt(header.get('X-Paging-PageCount'), 10);
        // console.log(this.page);
      }, error => {
        console.log(error);
      }
    ).add(() => {
      this.spinner.hide();
    });
  }

  public delete() {
    this.spinner.show();
    this.transferService.deleteTransfer(this.currentItem.id).subscribe(
      () => {
        this.summaryService.updateSummary().subscribe(() => {});
        this.transferService.resetCacheList();
        this.getList();
        this.toastr.info('Delete successful!.', '');
      }, error => {
        console.log(error);
      }
    ).add(() => {
      this.spinner.hide();
    });
  }

}
