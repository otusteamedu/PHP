<!DOCTYPE HTML>

<html>
	<head>
		<title><?php echo $title;?></title>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
		<!--<link rel="stylesheet" href="/assets/css/bootstrap.min.css"/>-->
		<link rel="stylesheet" href="/assets/css/main.css"/>
		<link rel="stylesheet" href="/assets/css/style.css?1273455236"/>
		<noscript><link rel="stylesheet" href="/assets/css/noscript.css"/></noscript>
        <!-- Bootstrap CSS (Cloudflare CDN) -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" integrity="sha512-P5MgMn1jBN01asBgU0z60Qk4QxiXo86+wlFahKrsQf37c9cro517WzVSPPV1tDKzhku2iJ2FVgL67wG03SGnNA==" crossorigin="anonymous">

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
                                            <li><a class="scrolly" href="/Memcached/Cluster">MemcachedCluster</a></li>
                                        <?php else:?>
                                            <li><a class="scrolly" href="/Nosql/check?db=memcached">Memcached</a></li>
                                        <?php endif?>
                                    </ul>
                                </li>
							</ul>
						</nav>
                </div>
