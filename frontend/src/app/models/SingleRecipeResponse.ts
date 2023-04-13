import {Recipe} from "./Recipe";

export interface SingleRecipeResponse {
  recipe: Recipe,
  code: number,
  message?: string
}
