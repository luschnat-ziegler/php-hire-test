import {Ingredient} from "./Ingredient";

export interface RecipeIngredient {
  id: number,
  amount: number,
  recipe_id: number,
  ingredient_id: number,
  ingredient: Ingredient
}
