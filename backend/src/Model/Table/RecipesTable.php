<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Exception;

/*
 * Class RecipesTable
 *
 * Table class for the Recipe entity
 *
 * @package App\Model\Table
 */
class RecipesTable extends Table
{
    /**
     * Function initialize
     *
     * This function adds timestamp behaviour and sets up relations
     *
     * @param array $config
     * @return void
     */
    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->hasMany('RecipeIngredients');
    }

    /**
     * Function insertPostedRecipe
     *
     * accepts a posted recipe and inserts id
     * returns recipe_id for further processing
     *
     * @throws Exception
     */
    public function insertPostRecipe(array $recipe): int
    {
        if (! isset($recipe['title'], $recipe['short_description'], $recipe['instructions'])) {
            throw new Exception('malformed recipe');
        }
        $newRecipe = $this->newEntity([
            'title'             => $recipe['title'],
            'short_description' => $recipe['short_description'],
            'instructions'      => $recipe['instructions']
        ]);
        if (! $this->save($newRecipe)) {
            throw new Exception('save failed for table ' . static::class);
        }
        return $newRecipe->id;
    }
}
