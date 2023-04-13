import { ComponentFixture, TestBed } from '@angular/core/testing';

import { RecipeTitleEntryComponent } from './recipe-title-entry.component';

describe('RecipeTitleEntryComponent', () => {
  let component: RecipeTitleEntryComponent;
  let fixture: ComponentFixture<RecipeTitleEntryComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ RecipeTitleEntryComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(RecipeTitleEntryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
