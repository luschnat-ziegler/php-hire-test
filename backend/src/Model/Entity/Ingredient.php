<?php

namespace App\Model\Entity;

use \Cake\ORM\Entity;

class Ingredient extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
