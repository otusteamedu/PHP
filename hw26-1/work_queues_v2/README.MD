### Message acknowledgment
fourth parameter of basic_consume = false means that acknowledgment is ON
$channel->basic_consume('hello', '', false, false, false, false, $callback);