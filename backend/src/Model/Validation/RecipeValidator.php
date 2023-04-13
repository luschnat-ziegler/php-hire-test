<?php

namespace App\Model\Validation;

use Cake\Validation\Validator;

/**
 * Class RecipeValidator
 *
 * This class can be used to validate posted recipes
 */
class RecipeValidator extends Validator
{
    /**
     * RecipeValidator constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->requirePresence('title')
            ->add('title', [
                'minLength' => [
                    'rule' => ['minLength', 2],
                    'last' => true,
                    'message' => 'Title must have at least 2 characters.'
                ],
                'maxLength' => [
                    'rule' => ['maxLength', 255],
                    'message' => 'Title must not be longer than 255 characters.'
                ]
            ])
            ->requirePresence('short_description')
            ->add('short_description', [
                'minLength' => [
                    'rule' => ['minLength', 2],
                    'last' => true,
                    'message' => 'Short description must have at least 2 characters.'
                ],
                'maxLength' => [
                    'rule' => ['maxLength', 4095],
                    'message' => 'Short description must not be longer than 4095 characters.'
                ]
            ])
            ->requirePresence('instructions')
            ->add('instructions', [
                'minLength' => [
                    'rule' => ['minLength', 10],
                    'last' => true,
                    'message' => 'Instructions must have at least 10 characters.'
                ],
                'maxLength' => [
                    'rule' => ['maxLength', 65535],
                    'message' => 'Instructions must not be longer than 65535 characters.'
                ]
            ])
            ->requirePresence('ingredients')
            ->notEmptyArray('ingredients', 'At least one ingredient is required');
        $this->addIngredientValidation();
    }

    /**
     * Function addIngredientValidation
     *
     * adds validation for the nested ingredients
     *
     * @return void
     */
    private function addIngredientValidation(): void
    {
        $ingredientValidator = new IngredientValidator();
        $this->addNestedMany('ingredients', $ingredientValidator);
    }
}
