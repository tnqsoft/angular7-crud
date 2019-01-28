import { Component, OnInit } from '@angular/core';
import { SummaryService } from 'src/app/shared/services/summary.service';
import { ISummary, Summary } from 'src/app/shared/models/summary.model';
import { Subscription } from 'rxjs';

@Component({
  selector: 'app-algorithms-layout',
  templateUrl: './layout.component.html',
  styleUrls: ['./layout.component.scss']
})
export class TransferLayoutComponent implements OnInit {
  private subscription: Subscription;
  public summary: ISummary;
  public error = false;
  public loading = false;
  constructor(private summaryService: SummaryService) { }

  ngOnInit() {
    this.subscription = this.summaryService.summary
      .subscribe((summary: ISummary) => {
        this.summary = summary;
      });
    this.summaryService.getSummary().subscribe(
      () => {}, err => {
        this.error = true;
      }
    );
  }

  public updateSummary() {
    this.loading = true;
    this.summaryService.updateSummary().subscribe(
      () => {}, error => {
        this.error = true;
      }
    ).add(() => {
      this.loading = false;
    });
  }

}
