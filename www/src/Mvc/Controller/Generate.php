<?php

namespace Tirei01\Hw12\Mvc\Controller;

use Tirei01\Hw12\Mvc\Controller;

class Generate extends Controller
{
    public function index()
    {
        $obPropMapper = new \Tirei01\Hw12\Storage\Mapper\Property();
        $obCategoryMapper = new \Tirei01\Hw12\Storage\Mapper\Category();
        $categoriesCol = $obCategoryMapper->findAll();
        $obElemMapper = new \Tirei01\Hw12\Storage\Mapper\Element();
        foreach ($categoriesCol as $category) {
            for ($i = 0 ; $i < 1000; $i++) {
                $propCollect = $obPropMapper->findByCategory($category);
                $faker = Faker\Factory::create();
                $obELem = new \Tirei01\Hw12\Storage\Element(
                    0, $faker->name, $category, $faker->randomDigit, $faker->shuffleString('zxcvbgfdsaqwertyuioplkjhnm')
                );
                $obElemMapper->insert($obELem);
                /** @var \Tirei01\Hw12\Storage\Property $propery */
                foreach ($propCollect as $propery) {
                    $value = null;
                    $faker = Faker\Factory::create();
                    switch ($propery->getType()) {
                        case 'integer':
                            $value = rand(1000, 9999);
                            break;
                        case 'text':
                            $value = $faker->name;
                            break;
                        case 'date':
                            $value = '2020-0' . rand(1, 9) . '-' . rand(10, 28);
                            break;
                        case 'bool':
                            $value = rand(1, 2) == 2 ? true : false;
                            break;
                        case 'float':
                            $value = $faker->randomFloat();
                            break;
                    }
                    $obValue = new \Tirei01\Hw12\Storage\Value(
                        0, $propery, $obELem, $value, $category
                    );
                    $obValueMapper = new \Tirei01\Hw12\Storage\Mapper\Value();
                    $obValueMapper->insert($obValue);
                }
            }
        }
    }
}