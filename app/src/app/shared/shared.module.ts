import { NgModule, ModuleWithProviders } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { RouterModule } from '@angular/router';
import { TabsModule, CollapseModule, BsDatepickerModule, ModalModule } from 'ngx-bootstrap';
import { TransferService } from './services/transfer.service';
import { ToastrModule } from 'ngx-toastr';
import { ModalConfirmComponent } from './components/modal-confirm/modal-confirm.component';
import { NgxSpinnerModule } from 'ngx-spinner';
import { NgxDatatableModule } from '@swimlane/ngx-datatable';
import { FormatCurrencyPipe } from './pipes/format-currency.pipe';

// https://angular.io/styleguide#!#04-10
@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    ReactiveFormsModule,
    NgxSpinnerModule,
    TabsModule.forRoot(),
    CollapseModule.forRoot(),
    BsDatepickerModule.forRoot(),
    ModalModule.forRoot(),
    ToastrModule.forRoot({
      timeOut: 4000,
      positionClass: 'toast-bottom-right',
      preventDuplicates: true,
    }),
    NgxDatatableModule,
  ],
  providers: [
    TransferService,
  ],
  declarations: [
    ModalConfirmComponent,
    FormatCurrencyPipe,
  ],
  exports: [
    CommonModule,
    FormsModule,
    ReactiveFormsModule,
    NgxSpinnerModule,
    RouterModule,
    TabsModule,
    CollapseModule,
    BsDatepickerModule,
    ModalConfirmComponent,
    NgxDatatableModule,
    FormatCurrencyPipe,
  ],
  entryComponents: [
    ModalConfirmComponent
  ],
})

// https://github.com/ocombe/ng2-translate/issues/209
export class SharedModule {
  static forRoot(): ModuleWithProviders {
    return {
      ngModule: SharedModule
    };
  }
}
