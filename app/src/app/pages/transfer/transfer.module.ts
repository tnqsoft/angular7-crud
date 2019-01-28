import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SharedModule } from 'src/app/shared/shared.module';
import { RouterModule, Routes } from '@angular/router';
import { TransferLayoutComponent } from './layout/layout.component';
import { TransferComponent } from './components/default/transfer.component';
import { NewTransferComponent } from './components/crud-transfer/crud-transfer.component';
import { AuthGuard } from 'src/app/shared/services/auth.guard';

const routes: Routes = [
  {
    path: '',
    component: TransferLayoutComponent,
    children: [
      { path: '', redirectTo: 'list', pathMatch: 'full' },
      { path: 'list', component: TransferComponent, canActivate: [AuthGuard] },
      { path: 'add', component: NewTransferComponent, canActivate: [AuthGuard] },
      { path: ':id', component: NewTransferComponent, canActivate: [AuthGuard] },
    ]
  }
];

@NgModule({
  declarations: [
    TransferLayoutComponent,
    TransferComponent,
    NewTransferComponent,
  ],
  imports: [
    SharedModule,
    RouterModule.forChild(routes)
  ],
  exports: [
    RouterModule,
    SharedModule,
    TransferLayoutComponent
  ]
})
export class TransferModule { }
