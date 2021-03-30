### Конфигурация

Скопировать `hw-11-elastic/app/config.example.yaml` в `hw-11-elastic/app/config.yaml` и прописать валидный `youtube_api_key`

### Переключение между хранилищами

```
storage_mode: 'elasticsearch'
db_host: 'elasticsearch:9200'
#storage_mode: 'mongo'
#db_host: 'mongodb://root:example@mongo:27017'
```

### Папка со структурами в json

`hw-11-elastic/app/files/structures`

### Список id каналов, которые будут обработаны

`channels_for_grabbing_list` в `config.yaml`

### Лог

`hw-11-youtube-analyzer/app/log/app.log`

### Запуск в режиме граббера

`php index.php grab`

### Запрос статистики по каналам

`php index.php stats`

### Статистика с поиском по elastic

```
{"channelId":"UCMCgOm8GZkHp8zJ6l7_hIuA","likeSum":20995852,"dislikeSum":1657333,"viewSum":604632726,"commentSum":2767812,"likesPlusDislikesSum":22653185,"likeWeight":12.67}
{"channelId":"UCeObZv89Stb2xLtjLJ0De3Q","likeSum":199353,"dislikeSum":8881,"viewSum":4815610,"commentSum":26262,"likesPlusDislikesSum":208234,"likeWeight":22.45}
{"channelId":"UCTW0FUhT0m-Bqg2trTbSs0g","likeSum":66009,"dislikeSum":1317,"viewSum":995712,"commentSum":8720,"likesPlusDislikesSum":67326,"likeWeight":50.12}
{"channelId":"UC_Q1vhf7wcR_zGlc5ahAg0A","likeSum":385686,"dislikeSum":18825,"viewSum":5239559,"commentSum":29917,"likesPlusDislikesSum":404511,"likeWeight":20.49}
{"channelId":"UClI9aidW3X044NeB4QS-yxw","likeSum":9512477,"dislikeSum":158637,"viewSum":318250476,"commentSum":573440,"likesPlusDislikesSum":9671114,"likeWeight":59.96}
{"channelId":"UCoRAnB8KixJiszlSpMHa-SA","likeSum":4351401,"dislikeSum":83532,"viewSum":76505223,"commentSum":344051,"likesPlusDislikesSum":4434933,"likeWeight":52.09}
```

### Статистика с поиском по mongo

```
{"channelId":"UCMCgOm8GZkHp8zJ6l7_hIuA","likeSum":20995890,"dislikeSum":1657334,"viewSum":604633456,"commentSum":2767808,"likesPlusDislikesSum":22653224,"likeWeight":12.67}
{"channelId":"UCeObZv89Stb2xLtjLJ0De3Q","likeSum":199354,"dislikeSum":8881,"viewSum":4815627,"commentSum":26263,"likesPlusDislikesSum":208235,"likeWeight":22.45}
{"channelId":"UCTW0FUhT0m-Bqg2trTbSs0g","likeSum":66009,"dislikeSum":1317,"viewSum":995717,"commentSum":8720,"likesPlusDislikesSum":67326,"likeWeight":50.12}
{"channelId":"UC_Q1vhf7wcR_zGlc5ahAg0A","likeSum":385690,"dislikeSum":18825,"viewSum":5239628,"commentSum":29917,"likesPlusDislikesSum":404515,"likeWeight":20.49}
{"channelId":"UClI9aidW3X044NeB4QS-yxw","likeSum":9512498,"dislikeSum":158638,"viewSum":318251650,"commentSum":573444,"likesPlusDislikesSum":9671136,"likeWeight":59.96}
{"channelId":"UCoRAnB8KixJiszlSpMHa-SA","likeSum":4351405,"dislikeSum":83532,"viewSum":76505279,"commentSum":344051,"likesPlusDislikesSum":4434937,"likeWeight":52.09}
```