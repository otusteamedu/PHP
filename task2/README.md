Мой пакет - форк одного резпозитория, для которого я сделал изменения
```bash
git clone git@github.com:ushakovme/amocrm.git
```

Для того чтобы использовать эту библиотеку у себя в проекте, надо ее правильно добавить в composer.json

```
"repositories": [
        {
            "url": "https://github.com/ushakovme/amocrm",
            "type": "vcs"
        }
    ]
```

Теперь библиотека может быть загружена с гита. 

В качестве примера это есть в папке ``project``. Теперь для загрузки библиотеки запустим composer:
```bash
 composer install
```

И сможем запустить проект
```bash
 php index.php
```
