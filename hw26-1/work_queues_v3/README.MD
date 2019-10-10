### Message durability

1.third parameter to queue_declare as true (!!!needs to be applied to both the producer and consumer code!!!):
$channel->queue_declare('hello', false, true, false, false);

2.configure messages with delivery_mode = 2
$msg = new AMQPMessage($data, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);