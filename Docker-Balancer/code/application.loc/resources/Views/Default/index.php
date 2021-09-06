<!DOCTYPE HTML>

<html>
<head>
    <title><?php echo $title;?></title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/assets/css/main.css"/>
    <link rel="stylesheet" href="/assets/css/style.css?1273455236"/>
    <noscript><link rel="stylesheet" href="/assets/css/noscript.css"/></noscript>

</head>
<body class="<?php echo $page_class;?>">
<div id="page-wrapper">
    <!-- Header -->
    <div id="header">
        <!-- Nav -->
        <nav id="nav">
            <ul>
                <li><a href="/">Главная</a></li>
                <li>
                    <a href="/Sysinfo">System Info</a>
                    <ul>
                        <li><a class="scrolly" href="/Sysinfo/ServerAddress">Адрес сервера</a></li>
                        <li><a class="scrolly" href="/Sysinfo/NodeAddress">Адрес ноды</a></li>
                        <li><a class="scrolly" href="/Sysinfo/Sapi">Тип Интерфейса</a></li>
                    </ul>
                </li>
                <li>
                    <a href="/Sql">Базы SQL</a>
                    <ul>
                        <li><a class="scrolly" href="/Sql/check?pdo=on&db=postgres">PDO Postgres</a></li>
                        <li><a class="scrolly" href="/Sql/check?db=postgres">pgConnect</a></li>
                        <li><a class="scrolly" href="/Sql/check?pdo=on&db=mysql-master">PDO MySQL master</a></li>
                        <li><a class="scrolly" href="/Sql/check?pdo=on&db=mysql-slave">PDO MySQL slave</a></li>
                        <li><a class="scrolly" href="/Sql/check?db=mysql-master">Mysqli master</a></li>
                        <li><a class="scrolly" href="/Sql/check?db=mysql-slave">Mysqli slave</a></li>
                    </ul>
                </li>
                <li>
                    <a href="/Nosql">NO SQL</a>
                    <ul>
                        <li><a class="scrolly" href="/Nosql/check?db=redis">Redis</a></li>
                        <li><a class="scrolly" href="/Nosql/check?db=elasticsearch">Elasticsearch</a></li>
                        <?php if (isset($memcachedCluster)&&($memcachedCluster == 'true' || $memcachedCluster == 1)):?>
                            <li><a class="scrolly" href="/NoSql/memcachedCluster">MemcachedCluster</a></li>
                        <?php else:?>
                            <li><a class="scrolly" href="/Nosql/check?db=memcached">Memcached</a></li>
                        <?php endif?>
                    </ul>
                </li>
            </ul>
        </nav>

    <!-- Inner -->
    <div class="inner">
        <div>
            <!--<button type="button" id="popup_server_ip" class="button" data-modal="modal_1">Web-Server</button>-->
            <!--<button type="button" id="popup_node_ip" class="button" data-modal="modal_1">Node-Ip</button>-->
            <button type="button" id="popup_sysinfo" class="button" data-modal="modal_1">SysInfo</button>
            <button type="button" id="popup_postgres_pdo" class="button" data-modal="modal_1">Psgl-PDO</button>
            <button type="button" id="popup_postgres_pg" class="button" data-modal="modal_1">PgConn</button>
            <button type="button" id="popup_mysql_pdo_master" class="button" data-modal="modal_1">MysqlPdoM</button>
            <button type="button" id="popup_mysql_pdo_slave" class="button" data-modal="modal_1">MysqlPdoS</button>
            <button type="button" id="popup_mysqli_master" class="button" data-modal="modal_1">Mysqli-M</button>
            <button type="button" id="popup_mysqli_slave" class="button" data-modal="modal_1">Mysqli-S</button>
            <button type="button" id="popup_redis" class="button" data-modal="modal_1">Redis</button>
            <button type="button" id="popup_elastic" class="button" data-modal="modal_1">Elastic</button>
            <button type="button" id="popup_memcached" class="button" data-modal="modal_1">Memcache</button>
            <!-- Модальное окно -->
            <div class="modal-container">
                <div class="modal-show">
                    <div class="row">
                        <div class="col-3 col-12-mobile">
                            <img id="modalImage" width="100%" src="/images/main/client-server.gif" alt="Connect...">
                        </div>
                        <div class="col-9 col-12-mobile">
                            <div id="alert" class="alert-warning alert">
                                <h3 id="serverTitle"></h3>
                                <h4 id="serverSuccess"></h4>
                                <p id="serverData"></p>
                            </div>
                            <div style="text-align: right;">
                                <a class="btn btn-sm btn-danger btn-close">закрыть</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <header>
            <div class="sysinfo">
                <div class="row">
                    <div>
                        <p>WebServer IP:</p>
                        <p>Node IP:</p>
                        <p>Тип Интерфейса запуска</p>
                    </div>
                    <div>
                        <p><?php echo $serverIp['info']?></p>
                        <p><?php echo $nodeIp['info']?></p>
                        <p><?php echo $sapi['info']?></p>
                    </div>
                </div>
            </div>
        </header>
        <footer>
            <!--<button onclick="document.location = '#banner';" type="button" class="button circled scrolly">PHP Info</button>-->
            <a href="#banner" class="button circled scrolly">PHP Info</a>
        </footer>
    </div>
</div>
<section id="banner">
    <?php phpinfo(); ?>
</section>
