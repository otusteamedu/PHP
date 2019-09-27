Задача:

Приложение для анализа каналов на Youtube
Создать приложение для анализа каналов на Youtube:
1. Создать структуру/структуры хранения информации о канале и видео канала в mongoDB, описать в виде JSON с указанием типов полей. Описать какие индексы понадобятся в данной структуре?
2. Создать необходимые модели для добавления и удаления данных из коллекций
3. Реализовать класс статистики, который может возвращать:
- Суммарное кол-во лайков и дизлайков для канала по всем его видео
- Топ N каналов с лучшим соотношением кол-во лайков/кол-во дизлайков

4*. Можно создать паука, который будет ходить по Youtube и наполнять базу данными

Для начала получим API клучи для доступа к данным:

идем в консоль гугла: https://console.developers.google.com/apis/api

создаем идентификатор клиента OAuth. Выбираем Веб-приложение в предложенном списке

создаем проект и выбираем Youtube Data API V3 на https://developers.google.com/oauthplayground. выбираем Youtube Data API V3 и жмем Authorize APIs

авторизуете и далее ставим галку на Use Your Own Oauth Credentials, access type ставим = offline

на шаге 2 делаем Exchange Authorization code for tokens

в итоге получим refresh token который потом используем в нашей программе

далле нам нужно указать редирект url на https://developers.google.com/oauthplayground чтоб мы могли использовать refresh токен для получения access токена
для этого нам еще нужно выставить accessType в offline в нашем коде: setAccessType('offline');

не забываем скачать json файл с консоли гугла и потом указываем к нему путь в приложении

I.
В базе данные хранятся в следющем виде:
<pre>
...
{
  'channelId' => string
  'channelTitle' => string
  'channelVideos' => array [
    ...
    [{
        'title' => string
        'publishedAt' => string
        'description' => string
        'thumbnail' => string
        'statistics' => array [{
            'commentCount' => int,
            'dislikeCount' => int,
            'favoriteCount' => int,
            'likeCount' => int,
            'viewCount' => int
    }]
    ...
  }]          
}
...
</pre>   

II.
В классе Model созданы методы deleteOneChannel и deleteManyChannels.
                             
III. Созданы 2 метода: getTopChannels - статистика по всем каналам в базе. getChannelStatByName или getChannelStatById для получения статистики по имени канала и по ид канала. 

IV.
Паук фактически создан, нужно просто запускать по расписанию и все зависит от лимита запросов на API, очень быстро можно достигнуть дневного лимита.
Так же нужно внести малые правки в текущий вариант когда, потому что если мы емеем сейчсас данные в базе, то я запрос не делаю.

P.S. все приложенные ключи рабочие. После какого-то времени я их удалю из консоли.

Посколько запросы на youtube API ограничены в сутки, то были получены следующие данные:
<pre>
ИД кананла, Имя канала, Видео для анализа
UClW4jraMKz6Qj69lJf-tODA YoungBoy Never Broke Again 50
UCa6vGFO9ty8v5KZJXQxdhaw Jimmy Kimmel Live 50
UCPD_bxCRGpmmeQcbe2kpPaA First We Feast 50
UCOsVSkmXD1tc6uiJ2hc0wYQ EA Star Wars 50
UCV9_KinVpV-snHe3C3n1hvA shane 50
UC1sELGmy5jp5fQUugmuYlXQ Minecraft 50
UC1KsxDW7hhfeq5QQmFtInIw julien solomita 50
UC9gFih9rw0zNCK3ZtoKQQyA JennaMarbles 50
UCqFzWxSCi39LnW1JKFR3efg Saturday Night Live 50
UCUKi4zY5ETSqrKAjTBgjM-g sWooZie 50
UCbD8EppRX3ZwJSou-TVo90A Mnet K-POP 50
UCn1XB-jvmd9fXMzhiA6IR0w Domics 50
UCbpMy0Fg74eXXkvxJrtEn3w Bon Appétit 50
UCJHA_jMfCvEnv-3kRjTCQXw Binging with Babish 50
UCsTcErHg8oDvUnTzoqsYeNw Unbox Therapy 50
UCyFZMEnm1il5Wv3a6tPscbA Genius 50
UChirEOpgFCupRAk5etXqPaA Bloomberg TicToc 50
UCiWLfSweyRNmLpgEHekhoAg ESPN 50
UC6ZFN9Tx6xh-skXCuRHCDpQ PBS NewsHour 50
UC4dqLAF7yT-_DqeYisQ001w TheBeatlesVEVO 50
UC4PooiX37Pld1T8J5SYT-SQ Good Mythical Morning 50
UCK6vG-ufb9tHi0t_XWWgXZA The Masked Singer 50
UCte53PewI8_jYpBYn071MqQ Sech 50
UCXIJgqnII2ZOINSWNOGFThA Fox News 50
UC52OnlZcHd_ajoTiqcskrvg PnB Rock 50
UCj_ARBxhCoF5JxUItcEUs7Q DailyDrivenExotics 50
UCBJycsmduvYEL83R_U4JriQ Marques Brownlee 50
UCBlbxksRa-KRSEKLi6foxjQ MARKO 50
UCxSz6JVYmzVhtkraHWZC7HQ Liza Koshy 50
UC1VYb0EKcZuy9rG3q0VR57Q todrickhall 50
UCpIafFPGutTAKOBHMtGen7g Gus Johnson 50
UCzpCc5n9hqiVC7HhPwcIKEg Good Mythical MORE 50
UCV5mGxp-rtsGDAedDYnp7hA OffTheRanch 50
UC9k-yiEpRHMNVOnOi_aQK8w Inside Edition 50
UCXuqSBlHAE6Xw-yeJA0Tunw Linus Tech Tips 50
UC-2Y8dQb0S6DtpxNgAKoJKA PlayStation 50
UCh8f8vssLddD2PbnU3Ag_Bw Cleetus McFarland 50
UCaUwlJEE3Vxsw0eIG15xBiw Jiedel 50
UC8-Th83bH_thdKZDJCrn88g The Tonight Show Starring Jimmy Fallon 50
UCTv-XvfzLX3i4IGWAm4sbmA LaLiga Santander 50
UCKijjvu6bN1c-ZHVwR7-5WA BuzzFeed Unsolved Network 50
UCV61VqLMr2eIhH4f51PV0gA Bloomberg Politics 50
UCJjSDX-jUChzOEyok9XYRJQ Jubilee 50
UCWFKCr40YwOZQx8FHU_ZqqQ JerryRigEverything 50
UCWOA1ZGywLbqmigxE4Qlvuw Netflix 50
UCfE5Cz44GlZVyoaYTHJbuZw Guga Foods 50
UCkS8bfIrm38QCSQeOqRxR4A Hannah Stocking 50
UCcjhYlL1WRBjKaJsMH_h7Lg Epicurious 50
UC7vVhkEfw4nOGp8TyDk7RcQ BostonDynamics 39
UC4qk9TtGhBKCkoWz5qGJcGg Tati 50
</pre>

Далее имеем статистику:

<pre>
YoungBoy Never Broke Again have likes: 22777986 and dislikes: 1024504
Jimmy Kimmel Live have likes: 19181500 and dislikes: 346166
Hannah Stocking have likes: 9526142 and dislikes: 273045
Liza Koshy have likes: 34875864 and dislikes: 260354
TheBeatlesVEVO have likes: 7607838 and dislikes: 210437
Sech have likes: 5911656 and dislikes: 203400
Mnet K-POP have likes: 15882393 and dislikes: 179781
The Tonight Show Starring Jimmy Fallon have likes: 12330896 and dislikes: 165805
shane have likes: 17287757 and dislikes: 147637
EA Star Wars have likes: 2608831 and dislikes: 146995
Unbox Therapy have likes: 4482278 and dislikes: 130334
Netflix have likes: 6625847 and dislikes: 124041
Saturday Night Live have likes: 5697437 and dislikes: 123877
sWooZie have likes: 8473399 and dislikes: 122051
PnB Rock have likes: 3694981 and dislikes: 120001
First We Feast have likes: 7405768 and dislikes: 117605
JennaMarbles have likes: 11332315 and dislikes: 117503
todrickhall have likes: 7014048 and dislikes: 108051
Minecraft have likes: 3476286 and dislikes: 100570
BostonDynamics have likes: 2452650 and dislikes: 97059
Marques Brownlee have likes: 4097171 and dislikes: 95320
Inside Edition have likes: 3222989 and dislikes: 90294
Linus Tech Tips have likes: 3612666 and dislikes: 86981
Jubilee have likes: 5452097 and dislikes: 83151
Good Mythical Morning have likes: 4606406 and dislikes: 79054
Epicurious have likes: 1776064 and dislikes: 78227
Domics have likes: 8601828 and dislikes: 71880
Tati have likes: 4831936 and dislikes: 68843
JerryRigEverything have likes: 2529319 and dislikes: 62987
MARKO have likes: 3566016 and dislikes: 54663
BuzzFeed Unsolved Network have likes: 4271064 and dislikes: 54329
Binging with Babish have likes: 4709826 and dislikes: 52662
Genius have likes: 4460272 and dislikes: 52174
PlayStation have likes: 2835996 and dislikes: 52024
Gus Johnson have likes: 4137960 and dislikes: 36209
Bon Appétit have likes: 2111366 and dislikes: 34421
ESPN have likes: 1006440 and dislikes: 30180
Fox News have likes: 858418 and dislikes: 27451
Guga Foods have likes: 975582 and dislikes: 27061
DailyDrivenExotics have likes: 1073358 and dislikes: 24774
OffTheRanch have likes: 1546030 and dislikes: 23808
PBS NewsHour have likes: 469305 and dislikes: 23773
julien solomita have likes: 3209975 and dislikes: 21107
LaLiga Santander have likes: 364402 and dislikes: 21004
Cleetus McFarland have likes: 1219251 and dislikes: 17331
Good Mythical MORE have likes: 1038752 and dislikes: 13341
Bloomberg Politics have likes: 103362 and dislikes: 11219
Jiedel have likes: 588521 and dislikes: 8860
The Masked Singer have likes: 172807 and dislikes: 7189
Bloomberg TicToc have likes: 66492 and dislikes: 6688
<br>

Data for channel with name "YoungBoy Never Broke Again"
likes: 22777986
dislikes: 1024504
comments: 960452
view: 3310943960
</pre>
