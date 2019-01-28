import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PolishNotationComponent } from './crud-transfer.component';

describe('PolishNotationComponent', () => {
  let component: PolishNotationComponent;
  let fixture: ComponentFixture<PolishNotationComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PolishNotationComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PolishNotationComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
