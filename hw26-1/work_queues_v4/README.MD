### Fair dispatch

1.use the basic_qos method with the prefetch_count = 1 setting (use in worker)
$channel->basic_qos(null, 1, null);