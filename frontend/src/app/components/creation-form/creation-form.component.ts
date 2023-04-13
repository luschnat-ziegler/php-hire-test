import {Component} from '@angular/core';
import {PostRecipe} from "../../models/PostRecipe";
import {RecipeService} from "../../services/recipe.service";
import {Router} from "@angular/router";

@Component({
  selector: 'app-creation-form',
  templateUrl: './creation-form.component.html',
  styleUrls: ['./creation-form.component.css']
})
export class CreationFormComponent {
  recipe: PostRecipe = {
    title: "",
    short_description: "",
    instructions: "",
    ingredients: []
  }
  currentIngredientName: string = ""
  currentIngredientAmount: number = 0
  currentIngredientUnit: string = ""

  hasError: boolean = false
  isLoading: boolean = false

  errorMessages: string[] = []

  constructor(private recipeService: RecipeService, private router: Router) {
  }

  onAddIngredientClick(): void {
    if (this.currentIngredientUnit === "" || this.currentIngredientName === "" || this.currentIngredientAmount === 0) {
      return
    }
    if (this.recipe.ingredients.findIndex(ingredient => ingredient.name.toLowerCase() === this.currentIngredientName.toLowerCase()) !== -1) {
      return
    }
    this.recipe.ingredients.push({
      name: this.currentIngredientName,
      amount: this.currentIngredientAmount,
      unit: this.currentIngredientUnit
    })
    this.currentIngredientAmount = 0
    this.currentIngredientUnit = ""
    this.currentIngredientName = ""
  }

  onRemoveIngredientClick(ingredientName: string): void {
    let index = this.recipe.ingredients.findIndex(ingredient => ingredientName === ingredient.name)
    if (index === -1) {
      return
    }
    this.recipe.ingredients.splice(index, 1)
  }

  onSaveClick(): void {
    this.isLoading = true
    this.recipeService.addRecipe(this.recipe).subscribe(
      {
        next: () => {
          this.router.navigate(['/']).then(() => {
          })
        },
        error: (error) => {
          this.errorMessages = []
          if (typeof (error.error) === 'object' && error.error.hasOwnProperty('validationErrors')) {
            this.formatValidationErrors(error)
          } else {
            this.errorMessages.push('Internal server error')
          }
          this.hasError = true
          this.isLoading = false
        }
      }
    )
  }

  private formatValidationErrors(error: any): void {
    for (const value of Object.values(error.error.validationErrors)) {
      if (typeof value === 'object' && value !== null) {
        for (const message of Object.values(value)) {
          if (typeof message === "string") {
            this.errorMessages.push(message)
          }
        }
      }
    }
  }
}
