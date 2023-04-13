<?php

namespace App\Model\Validation;

use Cake\Validation\Validator;

class IngredientValidator extends Validator
{
    public function __construct()
    {
        parent::__construct();
        $this
            ->requirePresence('name')
            ->add('name', [
                'minLength' => [
                    'rule' => ['minLength', 2],
                    'last' => true,
                    'message' => 'name must have at least 2 characters.'
                ],
                'maxLength' => [
                    'rule' => ['maxLength', 4095],
                    'message' => 'name must not be longer than 4095 characters.'
                ]
            ])
            ->requirePresence('unit')
            ->add('unit', [
                'minLength' => [
                    'rule' => ['minLength', 1],
                    'last' => true,
                    'message' => 'name must have at least 1 character.'
                ],
                'maxLength' => [
                    'rule' => ['maxLength', 255],
                    'message' => 'name must not be longer than 255 characters.'
                ]
            ])
            ->requirePresence('amount')
            ->numeric('amount')
            ->range('amount', [0, 3.402823466 * pow(10, 38)], 'amount not in allowed range.');
    }
}
