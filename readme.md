Задача:\
Балансировка при помощи NGINX  

Требования:  
Создать 3 контейнера:
1. балансировщик (папка nginx_balancer)
2. два контейнера с nginx-php (папки nginx_php_1/2)

Информация:  
в каждой папке содержится файл docker-compose.yml\
сначала запускаю контейнеры с php командой  
docker-compose up -d

если все запустилось ОК, то смотрю IP адреса контейнеров командой\
docker inspect [containerNameOrId] | grep '"IPAddress"' | head -n 1  
узнаю containerNameOrId командой docker ps  

затем эти адреса указываю в конфиге nginx.conf балансировщика  
upstream myapp1 {\
&nbsp;&nbsp;&nbsp;&nbsp;server 172.17.0.5;\
&nbsp;&nbsp;&nbsp;&nbsp;server 172.17.0.3;\
}

в папке с балансером имеем nginx.conf чтоб переписать nginx.conf дефолтный\
и index.html чтоб понять, если переадресации не произошло и мы видим nginx балансировщика
    






