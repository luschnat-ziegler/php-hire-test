import { Component, Input } from '@angular/core';
import {Recipe} from "../../models/Recipe";

@Component({
  selector: 'app-recipe-title-entry',
  templateUrl: './recipe-title-entry.component.html',
  styleUrls: ['./recipe-title-entry.component.css']
})
export class RecipeTitleEntryComponent {
  @Input() recipe: Recipe

}
