#### Пакет на github

- Скачивание через Git:    
    git clone https://github.com/websys-forever/getTextImg.git    
- Установка через Composer. Сначала создаем пустой файл composer.json, потом добавляем репозиторий с github и затем устанавливаем:    
    echo '{}' > composer.json && \
    composer config repositories.websys-forever vcs https://github.com/websys-forever/getTextImg.git && \
    composer require websys-forever/gettextimg:dev-master 