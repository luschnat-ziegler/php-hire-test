import {Component} from '@angular/core';
import {Recipe} from '../../models/Recipe';
import {RecipeService} from "../../services/recipe.service";
import {IconName, IconNamesEnum} from "ngx-bootstrap-icons";

@Component({
  selector: 'app-recipes',
  templateUrl: './recipes.component.html',
  styleUrls: ['./recipes.component.css']
})
export class RecipesComponent {
  recipes: Recipe[] = []
  displayCreationForm: boolean = false
  _filterText: string = ""
  filteredRecipes: Recipe[]

  sortDirection: string = 'none'

  get filterText() {
    return this._filterText
  }

  set filterText(value) {
    this._filterText = value
    this.filteredRecipes = this.filterRecipesByName(value)
  }

  constructor(private recipeService: RecipeService) {
  }

  ngOnInit(): void {
    this.recipeService.getRecipes().subscribe((recipes) => {
      this.recipes = recipes.recipes
      this.filteredRecipes = recipes.recipes
    })
  }

  sortByTitle(): void {
    if (this.sortDirection === 'none') {
      this.sortDirection = 'desc'
      this.filteredRecipes = this.filteredRecipes.sort((a, b) => a.title < b.title ? -1 : a.title > b.title ? 1 : 0);
    } else if (this.sortDirection === 'desc') {
      this.sortDirection = 'asc'
      this.filteredRecipes = this.filteredRecipes.sort((a, b) => a.title > b.title ? -1 : a.title < b.title ? 1 : 0);
    } else if (this.sortDirection === 'asc') {
      this.sortDirection = 'none'
      this.filteredRecipes = this.filteredRecipes.sort((a, b) => a.id < b.id ? -1 : a.id > b.id ? 1 : 0);
    }
  }

  filterRecipesByName(filterTerm: string): Recipe[] {
    if (this.recipes.length === 0 || filterTerm === '') {
      return this.recipes
    }
    return this.recipes.filter((recipe) => recipe.title.toLowerCase().includes(filterTerm.toLowerCase()))
  }
}
