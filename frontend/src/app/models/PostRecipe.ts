import {PostIngredient} from "./PostIngredient";

export interface PostRecipe {
  title: string,
  short_description: string,
  instructions: string,
  ingredients: PostIngredient[]
}
