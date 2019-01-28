import { Component, OnInit, Output, EventEmitter } from '@angular/core';
import { BsModalRef } from 'ngx-bootstrap';

@Component({
  selector: 'app-modal-confirm',
  templateUrl: './modal-confirm.component.html',
})
export class ModalConfirmComponent implements OnInit {
  title: string;
  question: string;
  btnOkCaption = 'Yes';
  btnCloseCaption = 'No';

  @Output() public action = new EventEmitter();

  constructor(public bsModalRef: BsModalRef) {}

  ngOnInit() {
  }

  public onOk() {
    this.onCancel();
    this.action.emit(true);
  }

  public onCancel() {
    this.bsModalRef.hide();
  }
}
