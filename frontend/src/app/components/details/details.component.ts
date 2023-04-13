import {Component} from '@angular/core';
import {ActivatedRoute} from "@angular/router";
import {RecipeService} from "../../services/recipe.service";
import {Recipe} from "../../models/Recipe";

@Component({
  selector: 'app-details',
  templateUrl: './details.component.html',
  styleUrls: ['./details.component.css']
})
export class DetailsComponent {
  recipe: Recipe
  message: string
  hasError: boolean = false
  isLoading: boolean = true

  constructor(private route: ActivatedRoute, private recipeService: RecipeService) {
  }

  ngOnInit() {
    this.route.params.subscribe((params) => {
      const id = parseInt(params['id'])
      this.recipeService.getRecipe(id).subscribe({
        next: response => {
          this.recipe = response.recipe
          this.isLoading = false
        },
        error: err => {
          this.hasError = true
          this.message = err.status
          this.isLoading = false
        }
      })
    })
  }

  getFormattedDate(dateString: string): string {
    const date = new Date(dateString)
    return date.toLocaleDateString("de-De", { // you can use undefined as first argument
      year: "numeric",
      month: "2-digit",
      day: "2-digit",
    })
  }
}
