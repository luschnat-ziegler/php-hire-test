<?php

namespace App\Model\Entity;

use \Cake\ORM\Entity;

class RecipeIngredient extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
