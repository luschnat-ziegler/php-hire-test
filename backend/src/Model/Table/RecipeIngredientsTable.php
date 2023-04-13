<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Exception;

/*
 * Class RecipeIngredientsTable
 *
 * Table class for the RecipeIngredient entity
 *
 * @package App\Model\Table
 */
class RecipeIngredientsTable extends Table
{
    /**
     * Function initialize
     *
     * This function sets up relations to the recipes and ingredient entities
     *
     * @param array $config
     * @return void
     */
    public function initialize(array $config): void
    {
        $this->belongsTo('Recipes');
        $this->hasOne('Ingredients')->setForeignKey('id')->setBindingKey('ingredient_id');
    }

    /**
     * Function insertRecipeIngredients
     *
     * @param int $recipeId
     * @param array $ingredients
     * @return void
     * @throws Exception
     */
    public function insertRecipeIngredients(int $recipeId, array $ingredients): array
    {
        $return = [];
        foreach ($ingredients as $id => $amount) {
            $newRecipeIngredient = $this->newEntity([
                'recipe_id'     => $recipeId,
                'ingredient_id' => $id,
                'amount'        => $amount
            ]);
            if (!$this->save($newRecipeIngredient)) {
                throw new Exception('Internal Exception');
            }
            $return[] = $newRecipeIngredient;
        }
        return $return;
    }
}
