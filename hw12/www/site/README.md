### добавил Lazy Load для категории в получении постов

### скопировать .env.example в .env

## Добавить начальные таблицы 
   http://site.test/generate-data GET 


## вернуть все посты 

  http://site.test/posts GET 

## вернуть все категории постов вместе с постами

  http://site.test/categories GET


## добавить пост

  http://site.test/post POST
```
{
	"title": 1,
	"text": 2,
	"category_id": 1
}
```
  
## удалить пост

http://site.test/post?id= DELETE


## изменить пост

http://site.test/post?id= PATH

```
{
	"title": 1,
	"text": 2,
	"category_id": 1
}
```


## добавить категорию

  http://site.test/category POST
```
{
	"title": 1,
}
```
  
## удалить категорию

http://site.test/category?id= DELETE


## изменить категорию

http://site.test/category?id= PATH

```
{
	"title": 1,
}
```