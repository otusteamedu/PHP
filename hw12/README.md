# Домашнеее задание №12

Паттерн _**Active Record**_ реализован 
в моделях **ActiveRecordEntity**, **User**, **Article**

Паттерн _**Lazy Load**_ реализован в  модели **Article** путем отложенной загрузки геттером _getAuthor()_, 
связанных записей в классе **User**.

Метод массового получения и записи информации таблиц, результат которого возвращается в виде коллекции, реализован в методах
_getAll(), getById(int $id), update(array $mappedProperties), insert(array $mappedProperties)_ абстрактного класса **ActiveRecordEntity** 
