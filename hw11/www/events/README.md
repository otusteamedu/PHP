## добавление события  
   http://events.test/events POST 
   ```
{
   	"priority": 5000,
   	"conditions": 
   	{
   		"param1" : 1
   	},
   	"event": {
   		"test": "test2"
   	}
   }
```

## очищать все доступные события

   http://events.test/events DELETE 

## отвечать на запрос пользователя наиболее подходящим событием

   http://events.test/events GET 
   
```
{
	"params" : {
		"param1":1,
		"param2": 2
	}
}

```