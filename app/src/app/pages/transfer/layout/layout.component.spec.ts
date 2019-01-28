import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AlgorithmsLayoutComponent } from './layout.component';

describe('AlgorithmsLayoutComponent', () => {
  let component: AlgorithmsLayoutComponent;
  let fixture: ComponentFixture<AlgorithmsLayoutComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AlgorithmsLayoutComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AlgorithmsLayoutComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
