<?php
// .phpstorm.meta.php

namespace PHPSTORM_META {

    override(
        \Psr\Container\ContainerInterface::get(0),
        map([
            '' => '@',
        ])
    );

    override(
        \App\Support\Config::get(0),
        map([
            'slim.debug'      => 'bool',
            'templates.dir'   => 'string|false',
            'templates.cache' => 'string|false',
        ])
    );
}