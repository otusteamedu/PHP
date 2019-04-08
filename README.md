> docker-compose pull
> docker-compose up --build -d

Клиент соединяется, и шлёт следующий HTTP-запрос:

POST / HTTP/1.1
Content-Type: application/x-www-form-urlencoded 
Content-Length: 48

string=(()()()()))((((()()()))(()()()(((()))))))


> curl -d "string=(()()()()))((((()()()))(()()()(((()))))))" -H "Content-Type: application/x-www-form-urlencoded" -X POST http://localhost:8000/
