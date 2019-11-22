#### Запуск проекта

    docker-compose up -d && docker-compose exec php composer install

Протестировать пакет можно так:    
    
    http://localhost:8081/?text=Tes&x=150&y=200
     
text = Текст который будет добавлен на картинку    
x = ширина изображения    
y = высота изображения    
