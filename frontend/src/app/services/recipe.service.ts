import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http'
import {Observable} from 'rxjs'
import {RecipeResponse} from "../models/RecipeResponse";
import {SingleRecipeResponse} from "../models/SingleRecipeResponse";
import {PostRecipe} from "../models/PostRecipe";
import {AddRecipeResponse} from "../models/AddRecipeResponse";

const httpOptions = new HttpHeaders({
  "Content-Type": "application/json"
})

@Injectable({
  providedIn: 'root'
})
export class RecipeService {

  private apiUrl: string = 'http://localhost:8500/api/recipes/'

  constructor(private http:HttpClient) { }

  getRecipes(): Observable<RecipeResponse> {
    return this.http.get<RecipeResponse>(this.apiUrl)
  }

  getRecipe(id: Number): Observable<SingleRecipeResponse> {
    return this.http.get<SingleRecipeResponse>(this.apiUrl + id)
  }

  addRecipe(recipe: PostRecipe): Observable<AddRecipeResponse> {
    // @ts-ignore
    return this.http.post<AddRecipeResponse>('http://localhost:8500/api/recipes', recipe, httpOptions)
  }
}
