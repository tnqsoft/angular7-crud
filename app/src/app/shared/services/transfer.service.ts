import { Injectable } from '@angular/core';
import { Observable, of, throwError } from 'rxjs';
import { environment } from '../../../environments/environment';
import { HttpClient, HttpErrorResponse, HttpHeaders, HttpResponse } from '@angular/common/http';
import { catchError, tap, map } from 'rxjs/operators';
import { ITransfer, TransferModel } from '../models/transfer.model';
import { Page } from '../models/page.model';

const API_URL = environment.api_url;

const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type': 'application/json',
  })
};

@Injectable({
  providedIn: 'root'
})
export class TransferService {

  // private page: Page;
  // private list: Array<ITransfer>;

  constructor(
    private httpClient: HttpClient
  ) { }

  public getTransferList(page: Page): Observable<HttpResponse<Array<ITransfer>>> {
    // if (this.list) {
    //   return Observable.create(observer => {
    //     observer.next(this.list);
    //     observer.complete();
    //   });
    // }

    const url = API_URL + `transfer?page=${page.pageNumber}&limit=${page.size}`;
    return this.httpClient
      // .get<HttpResponse<Array<ITransfer>>>(url, httpOptions)
      .get<HttpResponse<Array<ITransfer>>>(url, { observe: 'response' })
      .pipe(
        tap(
          (response: HttpResponse<any>) => {
            // console.log(response.headers.get('x-paging-pageno'));
            // console.log(response);
            // this.list = response;
            return response;
          },
          () => catchError(this.handleError)
        )
      );
  }

  public getTransfer(id: number): Observable<ITransfer> {
    const url = API_URL + 'transfer?id=' + id;
    return this.httpClient
      .get<ITransfer>(url, httpOptions)
      .pipe(
        tap(
          response => {
            return response;
          },
          () => catchError(this.handleError)
        )
      );
  }

  public addTransfer(transferModel: TransferModel): Observable<any> {
    const url = API_URL + 'transfer';
    return this.httpClient
      .post(url, transferModel, httpOptions)
      .pipe(
        catchError(this.handleError)
      );
  }

  public editTransfer(id: number, transferModel: TransferModel): Observable<any> {
    const url = API_URL + 'transfer?id=' + id;
    return this.httpClient
      .put(url, transferModel, httpOptions)
      .pipe(
        catchError(this.handleError)
      );
  }

  public deleteTransfer(id: number): Observable<any> {
    const url = API_URL + 'transfer?id=' + id;
    return this.httpClient
      .delete(url, httpOptions)
      .pipe(
        catchError(this.handleError)
      );
  }

  public resetCacheList(): void {
    // this.list = null;
  }

  private handleError(error: HttpErrorResponse) {
    return throwError(error);
  }
}
