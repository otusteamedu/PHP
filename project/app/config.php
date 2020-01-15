<?php

return [
    'server_socket_file_path' => sys_get_temp_dir() . '/server.sock',
    'client_socket_file_path' => sys_get_temp_dir() . '/client.sock',
    'message_length' => 64 * 1024,
];
