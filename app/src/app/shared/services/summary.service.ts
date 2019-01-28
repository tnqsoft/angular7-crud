import { Injectable } from '@angular/core';
import { Observable, of, throwError } from 'rxjs';
import { environment } from '../../../environments/environment';
import { HttpClient, HttpErrorResponse, HttpHeaders, HttpResponse } from '@angular/common/http';
import { catchError, tap, map } from 'rxjs/operators';
import { ISummary } from '../models/summary.model';
import { Subject } from 'rxjs';

const API_URL = environment.api_url;

const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type': 'application/json',
  })
};

@Injectable({
  providedIn: 'root'
})
export class SummaryService {
  private summarySubject = new Subject<ISummary>();
  public summary = this.summarySubject.asObservable();

  constructor(
    private httpClient: HttpClient
  ) { }

  private updateSummaryHolder(summary: ISummary) {
    this.summarySubject.next(<ISummary> summary);
  }

  public getSummary(): Observable<ISummary> {
    const url = API_URL + 'summary';
    return this.httpClient
      .get<ISummary>(url, httpOptions)
      .pipe(
        tap(
          response => {
            this.updateSummaryHolder(response);
            return response;
          },
          () => catchError(this.handleError)
        )
      );
  }

  public updateSummary(): Observable<ISummary> {
    const url = API_URL + 'summary';
    return this.httpClient
      .put<ISummary>(url, null, httpOptions)
      .pipe(
        tap(
          response => {
            this.updateSummaryHolder(response);
            return response;
          },
          () => catchError(this.handleError)
        )
      );
  }

  private handleError(error: HttpErrorResponse) {
    return throwError(error);
  }
}
