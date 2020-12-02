docker-compose up -d
echo "Ожидание запуска RabbitMQ..."
while ! curl -s http://localhost:15672 >/dev/null; do sleep 1; done
php ./receiver/receiver.php