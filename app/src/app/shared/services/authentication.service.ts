import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { BehaviorSubject, Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { User } from '../models/user.model';
import { ActivatedRoute, Router } from '@angular/router';
import { environment } from '../../../environments/environment';
import * as jwt_decode from 'jwt-decode';
import * as moment from 'moment';

const API_URL = environment.api_url;

@Injectable({ providedIn: 'root' })
export class AuthenticationService {
  private currentUserSubject: BehaviorSubject<User>;
  public currentUser: Observable<User>;

  constructor(
    private http: HttpClient,
    private route: ActivatedRoute,
    private router: Router,
  ) {
    this.currentUserSubject = new BehaviorSubject<User>(this.getUserFromToken());
    this.currentUser = this.currentUserSubject.asObservable();
  }

  public get currentUserValue(): User {
    return this.currentUserSubject.value;
  }

  private getUserFromToken(): User {
    const token = localStorage.getItem('token');
    if (token) {
      const decoded: any = jwt_decode(token);
      if (moment.unix(decoded.exp).toDate() < moment().toDate()) {
        return null;
      }
      return new User(decoded.user_id, decoded.user_name, localStorage.getItem('token'));
    }
    return null;
  }

  login(username: string, password: string) {
    const url: string = API_URL + 'login';
    const params = { login: username, password: password };
    return this.http.post<any>(url, params)
      .pipe(map(user => {
        // login successful if there's a jwt token in the response
        if (user && user.token) {
          // store user details and jwt token in local storage to keep user logged in between page refreshes
          localStorage.setItem('token', user.token);
          this.currentUserSubject.next(this.getUserFromToken());
        }
        return this.getUserFromToken();
      }));
  }

  logout() {
    // remove user from local storage to log user out
    localStorage.removeItem('token');
    this.currentUserSubject.next(null);
    this.router.navigate(['login']);
  }
}
