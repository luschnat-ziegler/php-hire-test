import {Routes} from "@angular/router";
import {RecipesComponent} from "./components/recipes/recipes.component";
import {CreationFormComponent} from "./components/creation-form/creation-form.component";
import {DetailsComponent} from "./components/details/details.component";

export const appRoutes: Routes = [
  {path: '', component: RecipesComponent},
  {path: 'create', component: CreationFormComponent},
  {path: 'details/:id', component: DetailsComponent}
]
