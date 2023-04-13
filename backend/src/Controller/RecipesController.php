<?php

namespace App\Controller;

use App\Model\Validation\RecipeValidator;
use Cake\View\JsonView;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Datasource\ConnectionManager;
use Exception;

/**
 * Class RecipesController
 *
 * This is the controller for the recipes REST API
 */
class RecipesController extends AppController
{
    use LocatorAwareTrait;

    private array $ingredients;

    /**
     * function viewClasses
     *
     * @return string[]
     */
    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    /**
     * Function index
     *
     * This is the controller method to retrieve a list of all recipes
     *
     * @return void
     */
    public function index(): void
    {
        $recipes = $this->Recipes->find()->all();
        $this->set('recipes', $recipes);
        $this->viewBuilder()->setOption('serialize', ['recipes']);
    }

    /**
     * Function view
     *
     * This is the controller method to retrieve one recipe by id including all ingredient entries
     *
     * @param $primary
     * @return void
     */
    public function view($primary): void
    {
        $recipe = $this->Recipes->get($primary, ['contain' => 'RecipeIngredients.Ingredients']);
        $this->set('code', 200);
        $this->set('recipe', $recipe);
        $this->viewBuilder()->setOption('serialize', ['recipe', 'code']);
    }

    /**
     * Function add
     *
     * This is the controller method to add a new recipe
     *
     * @return void
     */
    public function add()
    {
        $this->request->allowMethod(['post', 'put', 'options']);
        $recipe    = $this->request->getData();
        $validator = new RecipeValidator();
        $errors    = $validator->validate($recipe);
        if (! empty($errors)) {
            $this->set('validationErrors', $errors);
            $this->response = $this->response->withStatus(400);
            $this->viewBuilder()->setOption('serialize', ['validationErrors']);
        } else {
            $connection = ConnectionManager::get('default');
            $connection->begin();
            try {
                $ingredientsTable    = $this->fetchTable('Ingredients');
                $insertedIngredients = $ingredientsTable->insertIngredients($recipe['ingredients']);
                $recipeId            = $this->Recipes->insertPostRecipe($recipe);
                $joinTable           = $this->fetchTable('RecipeIngredients');
                $joinTable->insertRecipeIngredients($recipeId, $insertedIngredients);
                $this->set('recipeId', $recipeId);
                $this->viewBuilder()->setOption('serialize', ['recipeId']);
            } catch (Exception $exception) {
                $this->set('error', ['error' => $exception->getMessage()]);
                $this->response = $this->response->withStatus(500);
                $connection->rollback();
                $this->viewBuilder()->setOption('serialize', ['error']);
                return;
            }
            $connection->commit();
        }
    }
}
