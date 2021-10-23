# Домашняя работа по Паттернам

### Требования
1. PHP >=8.0
2. Composer
3. Набор серверов (установленные сервера Redis)

### Используются библиотеки
1. "vlucas/phpdotenv": "^5.1",
2. "monolog/monolog": "2.x-dev",
3. "illuminate/container": "9.x-dev"

### Задание
1. Абстрактная фабрика будет отвечать за генерацию базового продукта-прототипа: бургер, сэндвич или хот-дог
2. При готовке каждого типа продукта Декоратор будет добавлять составляющие к базовому продукту либо по рецепту, либо по пожеланию клиента (салат, лук, перец и т.д.)
3. Наблюдатель подписывается на статус приготовления и отправляет оповещения о том, что изменился статус приготовления продукта.
4. Прокси используется для навешивание пре и пост событий на процесс готовки. Например, если бургер не соответствует стандарту, пост событие утилизирует его.
5. Стратегия будет отвечать за то, что нужно приготовить.
6. Все сущности должны по максимуму генерироваться через DI.

### Описание проекта
Реализованные паттерны:
1) Абстрактная фабрика
[app/Services/Factories/ProductFactory](app/Services/Factories/ProductFactory) - абстрактная фабрика. 
AbstractProductFactory.php - класс, используемый в качестве интерфейса для фабрики
[BurgerFactory.php](app/Services/Factories/ProductFactory/BurgerFactory.php) - реальная фабрика для Бургеров, 
[HotDogFactory.php](app/Services/Factories/ProductFactory/HotDogFactory.php) - реальная фабрика для Хот-догов,
[SandwichFactory.php](app/Services/Factories/ProductFactory/SandwichFactory.php) - реальная фабрика для Сэндвичей

2) Декоратор
    [IIngredient.php](app/Services/Factories/ProductFactory/IIngredient.php) - контракт для Ингредиентов
    [ISauce.php](app/Services/Factories/ProductFactory/ISauce.php) - контракт для Соусов
    В каждой реальной фабрике например BurgerFactory.php есть класс реализованный абстрактный метод `createIngredients()`
На основании слияния массива с рецептом (набор ингредиентов запрашивается в статическом методе `BurgerRecipe::getIngredient()`)
и пожелания заказчика (`customIngredientsList[]`) формируется Декоратор состоящий из нужных ингредиентов.
В дальнейшем используются методы из базового класса [IIngredient.php](app/Services/Products/Ingredients/Ingredient.php),
которые проходят по всей цепочке ингредиентов. Так же работает и механизм для Соусов.

3) Наблюдатель
[Observer](app/Services/Observer)
Определяем подписчика на события [ProductObserver.php](app/Services/Observer/ProductObserver.php), 
где реализовываем метод реакции на событие `update(SplSubject $object)`. Вызов этого метода для подписчиков происходит из базового издателя
например [Ingredients.php](app/Services/Products/Ingredients/Ingredient.php), в котором реализован интерфейс SplSubject. 
В нем так же для всех дочерних классов формируются события с помощью вызова метода `$this->notify()` 
В свою очередь метод `notify()` передается всем дочерним классам конкретных ингредиентов входящих в декоратор.
Список подписчиков хранится в свойстве `protected SplObjectStorage $observerList;` и слушатели подключаются в [ProductOrder.php](app/Services/Orders/ProductOrder.php)
   `$this->ingredients->attach($this->observer);`

4) Заместитель
Используя обертку [ProxyProductOrder.php](./app/Services/Orders/ProxyProductOrder.php) создается заказ, 
в котором вызываются методы основного класса [ProductOrder.php](./app/Services/Orders/ProductOrder.php)
и осуществляется анализ созданного продукта синтетическим методом определения качества продукта на основе параметра 'PROBABILITY_PRODUCT_DEFECT' из файла .env
определяющего вероятность. Базово установлено 50% - что продукт будет надлежащего качества.

5) Стратегия
[Strategy](./app/Services/Strategy)
С помощью данного паттерна выбирается стратегия приготовления стейков для бургеров разной прожарки. В классе Steak.php определен метод `setStrategy()`. 
Вызов этого метода осуществляется из заказа `ProductOrder.php`. В момент когда вызывается метод prepare() для стейка,
то в нем вызывается метод $this->strategy->prepare(); $this->strategy - хранит класс который должен быть вызван при нужной стратегии. 
Таких классов три:
[SteakHard.php](./app/Services/Strategy/CookingTechnology/SteakHard.php)
[SteakMiddle.php](./app/Services/Strategy/CookingTechnology/SteakMiddle.php)
[SteakSoft.php](./app/Services/Strategy/CookingTechnology/SteakSoft.php)

[Helpers/Recipes/](app/Services/Helpers/Recipes) - рецепты продуктов
[Orders](app/Services/Orders) - Заказ продукта, в котором формируется продукт из составляющих

Создание заказа осуществляется в классе [App\Services\Orders\ProductOrder](app/Services/Orders/ProductOrder.php), 
через заместитель [App\Services\Orders\ProxyProductOrder](app/Services/Orders/ProxyProductOrder.php), 
в который передается фабрика продукта на основе абстрактного класса[ App\Services\Factories\ProductFactory\AbstractProductFactory.php](app/Services/Factories/ProductFactory/AbstractProductFactory.php).
В заказе формируется составляющие продукта c помощью public function createProduct(). Готовится заказ prepareProduct(). И выводится результат getProduct()
Для каждого продукта реализован свой метод в контроллере [FastFoodController.php](app/Http/Controllers/FastFoodController.php)
В них происходит связывание реальной фабрики с абстрактным классом и определение метода оповещения о состоянии заказа для использования контейнера DI
Для этого используется метод `bind()` в базовом контроллере [BaseController](app/Http/Controllers/BaseController.php).
и дальше создается модель использую контейнер из пакета 'illuminate/container'
$this->model = $this->container->make(FastFoodModel::class);