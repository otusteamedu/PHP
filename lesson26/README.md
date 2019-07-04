# Simple API with RabbitMq

###Prepare

Clone or download project and edit env options in .env file.

####Usage
Run containers by command:
`$ docker-compose up --build`

Set local enviroment for POSTGRES and RABBIT like in .env (for consumer local usage) like this(example for MacOS)
`$ export PARAM="PARAM_VALUE"`

Start local consumer:
`$ cd res/code && php consumer.php`

Send message by Postman or curl 
`$ curl -d "message=test" -X POST http://localhost:8080/message/send`

Check message status by url:
`http://127.0.0.1:8080/message/get={message_id}`