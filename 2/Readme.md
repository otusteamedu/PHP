# Команда для Git
```sh
$ git clone git@github.com:mar4ehk0/first_component.git
```
# Composer
У вас должен быть composer.json с таким содержимым
```json
{
    "require": {
        "php":">=7.1.0",
        "mar4ehk0/first_component": "dev-master" 
    },
    "repositories":[
        {
            "type":"git",
            "url":"https://github.com/mar4ehk0/first_component"
        }
    ]
}
```

В папке с этим файлом выполнить команду
```sh
$ composer install
```
