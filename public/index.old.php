<?php
require __DIR__ . '/vendor/autoload.php';

use Otus\ActiveRecord\Products;
$config = parse_ini_file(__DIR__ . '/config.ini', true);

$pdo = new \PDO(
    $config['database']['driver'] .':host=' . $config['database']['host'] . ';dbname=' . $config['database']['dbname'],
    $config['database']['username'],
    $config['database']['password']
);


/** Case #1 */
/*$newProduct = new Products($pdo);
$newProduct->setName('New test product')->setDescription('Test description')->setCategoryId(4);

if ( $newProduct->insert() ) {
    print 'New product added with id: ' . $newProduct->getId() . '<br />';
} else {
    print 'Error: can not add new product<br />';
}*/

/** Case #2 */
/*$delProduct = new Products($pdo);
$delProduct->setId(2);
$delProduct->delete();*/

/** Case #3 */
/*$updProduct = new Products($pdo);
$updProduct->setId(3)->setName('Updated')->setDescription('Updated...')->setCategoryId(50);
$updProduct->update();*/

/** Case #4 */
print '<br />--------<br />';
$objPageProduct = Products::getById($pdo, 1);
print '<h1>' . $objPageProduct->getPageTitle() . '</h1><br />';
print '<p>' . $objPageProduct->getSeoText() . '</p>';

/** Case #5 */
print '<br />--------<br />';
$productsCollection = Products::getList($pdo);
//dump($productsCollection);

foreach ($productsCollection as $product) {
    print '<p>' . $product->getId() . ': ' . $product->getName() . '</p>';
}
