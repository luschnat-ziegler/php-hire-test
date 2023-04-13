import {RecipeIngredient} from "./RecipeIngredient";

export interface Recipe {
  id: number,
  title: string,
  short_description: string,
  instructions: string,
  created: string,
  modified: string
  recipe_ingredients?: RecipeIngredient[]
}
