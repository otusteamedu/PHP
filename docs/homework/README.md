## Как публиковать домашки

## Обозначения

 - `{username}` - ваш **username** в git-е
 - `{num}` - **номер** занятия
 - `{x}` - **номер** домашки

### 1. Создаем мастер-ветку, этот шаг выполняем ***только один раз***

Переходим на ветку **master**:

```sh
$ git checkout master
```

Создаем свою мастер-ветку

```sh
$ git checkout -b {username}/master
```

Пушим нашу ветку в **git**

```sh
$ git push --set-upstream origin {username}/master
```

### 2. Создаем ветку с номером домашки и номером задания

Чекаут с вашей мастер-ветки:

```sh
$ git checkout -b {username}/hw{num}-{x}
```

После того, как выполнили дз, пушим

```sh
$ git push --set-upstream origin {username}/hw{num}-{x}
```

### 3. Создаем pull-request в вашу мастер-ветку и назначаем проверяющего

---

### Пример

1. Создаем мастер-ветку
    ```sh
    $ git checkout -b nnikitos95/master
    ```
    
2. Пушим нашу ветку в **git**
   
   ```sh
   $ git push --set-upstream origin nnikitos95/master
   ```
   
3. Чекаут с вашей мастер-ветки:

    ```sh
    $ git checkout -b nnikitos95/hw0-0
    ```
4. После того, как выполнили дз, пушим
   
   ```sh
   $ git push --set-upstream origin nnikitos95/hw0-0
   ```
5. Создаем pull-request в вашу мастер-ветку и назначаем проверяющего