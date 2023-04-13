<?php

namespace App\Model\Table;

use App\Model\Entity\Ingredient;
use Cake\ORM\Table;
use Exception;

/*
 * Class IngredientsTable
 *
 * Table class for the Ingredient entity
 *
 * @package App\Model\Table
 */
class IngredientsTable extends Table
{
    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
    }

    /**
     * Function insertIngredients
     *
     * Accepts an array of posted ingredients
     * inserts new ingredients if the respective combination of name and unit not yet present
     *
     * returns and array (key: ingredient_id, value: amount) for further processing
     *
     * @param array $ingredients
     * @return array
     * @throws Exception
     */
    public function insertIngredients(array $ingredients): array
    {
        $returnArray = [];
        foreach ($ingredients as $ingredient) {
            if (! is_array($ingredient) || ! isset($ingredient['name'], $ingredient['amount'], $ingredient['unit'])) {
                throw new Exception('malformed ingredient');
            }
            $existingIngredient = $this->findByNameAndUnit(ucfirst($ingredient['name']), $ingredient['unit'])->limit(1);
            if (!$existingIngredient->isEmpty()) {
                /** @var Ingredient $result */
                $result = $existingIngredient->toArray()[0];
                $returnArray[$result->id] = $ingredient['amount'];
                continue;
            }
            /** @var Ingredient $newIngredient */
            $newIngredient = $this->newEntity([
                'name' => ucfirst($ingredient['name']),
                'unit' => $ingredient['unit']
            ]);
            if (! $this->save($newIngredient)) {
                throw new Exception('save failed for table ' . static::class);
            }
            $returnArray[$newIngredient->id] = $ingredient['amount'];
        }
        return $returnArray;
    }
}
