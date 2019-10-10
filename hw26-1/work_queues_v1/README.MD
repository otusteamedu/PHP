### Round-robin dispatching (no acknowledgment)
fourth parameter of basic_consume = true means that acknowledgment is OFF
$channel->basic_consume('hello', '', false, true, false, false, $callback);