###Homework 10

Были подготовлен список из 6 запросов к БД (Файл `requests.sql`).

Планы выполнения при 10 000 записей:

![План выполнения при 10 000 записей. Часть 1](https://s219sas.storage.yandex.net/rdisk/8400cee79492057efe055709b6ec68fc480227e8e365c83d308718e6d5d67cb4/5f90845c/1dSmsQcqg_B6WO20ED0xQZqsL2HTtVnO3MA-RX8dOrMgvcdiEuJekhP49GLZAagzxIahoMGpyCJXQWtMjx3-rg==?uid=195427551&filename=explain_10k_1.png&disposition=inline&hash=&limit=0&content_type=image%2Fpng&owner_uid=195427551&fsize=207080&hid=dcfa7a644fcbc1a48127ae4f66a0daf8&media_type=image&tknv=v2&etag=c60d35a0e813258c08c08811ff7452ca&rtoken=MowLWVXOgYVl&force_default=yes&ycrid=na-ca6f6fd5883f3ae39eb9c10a4ddbe58b-downloader12e&ts=5b232e7a4cf00&s=4b849afa36ecc6ce184c1a1e8e1bbc21c6e29df8d742857bbd746b3e619a1642&pb=U2FsdGVkX1-jX06_sdwdB9gbinGMKHqmahAeWCsBfJMtfGhhvx3xZgy7uybi2x9ekLP-dgM0IAm4pIFJ7Hwq8xPT2w_e45VQOePB2GFHk3Y)
![План выполнения при 10 000 записей. Часть 2](https://s195i.storage.yandex.net/rdisk/e85f47efd167f2fbabc13b280dda74f651524907aa9e4784c7da017e84543362/5f908470/1dSmsQcqg_B6WO20ED0xQSucIg8CJPtvgPq1--fGYy1P2L3RP8kIve9PhViuCqk4BHx7xMBjxlmXEFaWKj_NGA==?uid=195427551&filename=explain_10k_2.png&disposition=inline&hash=&limit=0&content_type=image%2Fpng&owner_uid=195427551&fsize=237373&hid=5e51976a87534f991b0cf79f224dde9b&media_type=image&tknv=v2&etag=f2327de38199ed49f2bc0fdf1d5836e9&rtoken=D1sWEnsvSVUV&force_default=yes&ycrid=na-a87e43846a0c6c64a7a9424d5b1c6391-downloader12e&ts=5b232e8d5fc00&s=9ab93a0523fa95f920f8f6c195ea3227fd0b92b9b9f21dac698ad5415b5771c3&pb=U2FsdGVkX19NfB6EX3qjCPCqvy8hoSzoi6cX65n2VbzP9-X4KEEg5f7xc_RtdMXiH-5mna7v5PEuQG-bPO6cUTucP8t8hTGTwGXEoQtzSuo)

Планы выполнения при 10 000 000 записей:

![План выполнения при 10кк записей. Часть 1](https://s99vla.storage.yandex.net/rdisk/1b1c1d7d1e804974b7b217f2183807c26215f901c51611294ccd5e46920dde93/5f908497/1dSmsQcqg_B6WO20ED0xQcPNlAM-GY7hTuP8qgJpmfCYttaVkdc_CSU714OTzmRp2rHDxcl67WjiOi-SW3zgsA==?uid=195427551&filename=explain_10kk_1.png&disposition=inline&hash=&limit=0&content_type=image%2Fpng&owner_uid=195427551&fsize=136257&hid=d347577f1d22646003df2fa4e4699148&media_type=image&tknv=v2&etag=f12c2a6adba3b22cf985b0ce521bc685&rtoken=mTGKcxLwYIiU&force_default=yes&ycrid=na-82c9eaf0abf616e2e968dd824362874a-downloader12e&ts=5b232eb2913c0&s=66b044872737ac28fdc60b2ef578154dc3c4ec4b0b215c368bc5cc934c00b99b&pb=U2FsdGVkX18LkJFk2TqAG6t7KFuMvzNF17vr2G8VtqOLoNPiAD9EssBqyEsVajGntOxfmsJcIJsw24wmV-Sv7MmrARcOSto-FBgBP1MzI1I)
![План выполнения при 10кк записей. Часть 2](https://s254sas.storage.yandex.net/rdisk/b8976bc83107c3ea8ed9024954bfde2091f94773353c410f62cbf69b5b34f4e6/5f9084a8/1dSmsQcqg_B6WO20ED0xQX_ynei7HijZipXnE-gnr237qbbOpFkHK2QycWrIJj6QlYSz0xRggkOd0GH5QEiTyg==?uid=195427551&filename=explain_10kk_2.png&disposition=inline&hash=&limit=0&content_type=image%2Fpng&owner_uid=195427551&fsize=170557&hid=74b025b1fa31ce1687be6b4bfbbf1cff&media_type=image&tknv=v2&etag=b3a6b8c1dc5a08c4683f03ee64592b54&rtoken=npBq4y67jBkD&force_default=yes&ycrid=na-1301536fd5b754f2d447c61b3e7396d0-downloader12e&ts=5b232ec2c7a00&s=00db5b9688481794bd681870f2b7acf15e2d510c6f1a7cf404073c0c4a8504ed&pb=U2FsdGVkX1_QeMFY1KsmIYnABe_AW7e2_3l4nGshoJHw0cJ-AXP6PwzTeOaTcUrbDtbLTJ4Kc6DHnQUpAp2oRUgw8igpUSwd5627mPyx3LY)

#####Оптимизация

Был оптимизирован запрос 
```postgresql
EXPLAIN ANALYZE SELECT  ch.title,
         (
            SELECT AVG(count) FROM
            (
                SELECT COUNT(*) as count FROM film_sessions fs
                JOIN tickets t ON t.session_id = fs.id
                WHERE fs.hall_id = ch.id
                GROUP BY fs.id
            ) AS count_tickets_for_each_session
         ) AS avg_count_of_tickets
FROM cinema_halls ch;
```
путем добавления индекса 
`CREATE INDEX film_sessions_hall_id_indx ON film_sessions (hall_id);`

Время выполнения запроса сократилось в два раза:

![](https://s65vla.storage.yandex.net/rdisk/aba3c352942577da25a786651e1807bbd7bdd8938813c9f53ae14c6766228e64/5f90a167/1dSmsQcqg_B6WO20ED0xQb1Z7j4ZyhvCrU9J2ALZWNm63kKuInCe9A4an0urJ2zIal2BEz1H_0VG3jLNiMlmLQ==?uid=195427551&filename=explain_opt_req_1.png&disposition=inline&hash=&limit=0&content_type=image%2Fpng&owner_uid=195427551&fsize=130762&hid=7d09d295f660a0098c436dbbc3ebca3e&media_type=image&tknv=v2&etag=248b728a9d43a646dc7fb76ea6202b61&rtoken=2ne8iIH8XiuU&force_default=yes&ycrid=na-d833193e7bb3e3ca833906ea0f955e72-downloader20e&ts=5b234a2cde7c0&s=2eeb54fe22b49bc24b52df508090670f07b552cf0f563c1c6dc460f456cd3e28&pb=U2FsdGVkX1-GahNBArbjMWtGfIUX4nRdwoaIsbsFfPRTrmwDAryNd14xeCE8m6fU2-vzBv7ZR983AWcYRUqKcvBBJjfDotn63jvkMyDUBBU)

Так же добавлен индекс:
```postgresql
CREATE INDEX orders_client_id_indx ON orders (client_id);
```

![](https://s260vla.storage.yandex.net/rdisk/335ad5138849bdfc118a50e092bf0d0680484114ec5d013e19864a5891595368/5f90a4a7/1dSmsQcqg_B6WO20ED0xQYpvKFY3cWitRJb7Cm8Z7jNY9josvJJg35k_inet7qBF9DvjxA58yzFlS3C620e6iw==?uid=195427551&filename=explain_opt_req_2.png&disposition=inline&hash=&limit=0&content_type=image%2Fpng&owner_uid=195427551&fsize=70389&hid=77e142c4ef49f3f47253a5a81cba0fc8&media_type=image&tknv=v2&etag=d5a6cfa3cf4f60b5aa477cf7acbe12bb&rtoken=Hxj8gj9K9V97&force_default=yes&ycrid=na-87470e3690cbc602a7dc1a128c025b68-downloader14f&ts=5b234d46537c0&s=58c7e79956d1e48829104ed9e421a5ba39372a2cab0771d786bf8a6112d42479&pb=U2FsdGVkX19i0v4GyH8gnb1OpbvdJiYjN0JB9_9Ezg5vdvwNiIfCUqYFcjOdovxyzyHFVCxuDYKc32N5pKSvAtGq8d_mNiHTvBQDL0N2Xd4)

Экспериментальным путем было выявлено что добавление индексов 
```postgresql
CREATE INDEX orders_amount_indx ON orders (amount);
CREATE INDEX film_sessions_durations_indx ON film_sessions (duration);
```
не приводит к ожидаемому результату.