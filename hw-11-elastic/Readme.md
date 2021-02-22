### Переключение между хранилищами

`hw-11-elastic/app/config.ini`

### Список id каналов, которые будут обработаны

`hw-11-elastic/app/files/channels.txt`

### Запуск в режиме граббера

`php index.php grab`

### Запрос статистики по каналам

`php index.php stats`

### Статистика с поиском по elastic

```
{"channelId":"UCMCgOm8GZkHp8zJ6l7_hIuA","likeSum":20322609,"dislikeSum":1978805,"viewSum":597672498,"commentSum":2807145,"likesPlusDislikesSum":22301414,"likeWeight":10.27}
{"channelId":"UCeObZv89Stb2xLtjLJ0De3Q","likeSum":185644,"dislikeSum":8382,"viewSum":4403613,"commentSum":24780,"likesPlusDislikesSum":194026,"likeWeight":22.15}
{"channelId":"UCTW0FUhT0m-Bqg2trTbSs0g","likeSum":62167,"dislikeSum":1277,"viewSum":920531,"commentSum":8368,"likesPlusDislikesSum":63444,"likeWeight":48.68}
{"channelId":"UC_Q1vhf7wcR_zGlc5ahAg0A","likeSum":380160,"dislikeSum":20022,"viewSum":5254841,"commentSum":31657,"likesPlusDislikesSum":400182,"likeWeight":18.99}
{"channelId":"UClI9aidW3X044NeB4QS-yxw","likeSum":8871676,"dislikeSum":147573,"viewSum":289662617,"commentSum":532957,"likesPlusDislikesSum":9019249,"likeWeight":60.12}
{"channelId":"UCoRAnB8KixJiszlSpMHa-SA","likeSum":4472413,"dislikeSum":81527,"viewSum":77565148,"commentSum":361918,"likesPlusDislikesSum":4553940,"likeWeight":54.86}
```

### Статистика с поиском по mongo

```
{"channelId":"UCMCgOm8GZkHp8zJ6l7_hIuA","likeSum":20322646,"dislikeSum":1978816,"viewSum":597674512,"commentSum":2807151,"likesPlusDislikesSum":22301462,"likeWeight":10.27}
{"channelId":"UCeObZv89Stb2xLtjLJ0De3Q","likeSum":185647,"dislikeSum":8382,"viewSum":4403622,"commentSum":24780,"likesPlusDislikesSum":194029,"likeWeight":22.15}
{"channelId":"UCTW0FUhT0m-Bqg2trTbSs0g","likeSum":62167,"dislikeSum":1277,"viewSum":920532,"commentSum":8368,"likesPlusDislikesSum":63444,"likeWeight":48.68}
{"channelId":"UC_Q1vhf7wcR_zGlc5ahAg0A","likeSum":380167,"dislikeSum":20022,"viewSum":5255001,"commentSum":31657,"likesPlusDislikesSum":400189,"likeWeight":18.99}
{"channelId":"UClI9aidW3X044NeB4QS-yxw","likeSum":8871702,"dislikeSum":147573,"viewSum":289663584,"commentSum":532957,"likesPlusDislikesSum":9019275,"likeWeight":60.12}
{"channelId":"UCoRAnB8KixJiszlSpMHa-SA","likeSum":4472413,"dislikeSum":81527,"viewSum":77565227,"commentSum":361918,"likesPlusDislikesSum":4553940,"likeWeight":54.86}
```