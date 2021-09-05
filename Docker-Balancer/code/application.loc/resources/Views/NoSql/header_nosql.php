<section id="banner">
    <div class="row">
        <div class="choose1 col-md-3">
            <form class="was-validated" method="get" action="/NoSql/check">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <select name="db" class="custom-select" required>
                            <option value="">Выберите сервер</option>
                            <option <?php if (isset($db)&&$db==='redis') echo "selected"?> value="redis">Redis</option>
                            <option <?php if (isset($db)&&$db==='elasticsearch') echo "selected"?> value="elasticsearch">Elasticsearch</option>
                            <?php if (isset($memcachedCluster)&&($memcachedCluster == 'true' || $memcachedCluster == 1)):?>
                                <option <?php if (isset($db)&&$db==='memcachedCluster') echo "selected"?> value="memcachedCluster">MemcachedCluster</option>
                            <?php else:?>
                                <option <?php if (isset($db)&&$db==='memcached') echo "selected"?> value="memcached">Memcached</option>
                            <?php endif?>
                            <option <?php if (isset($db)&&$db==='all') echo "selected"?> value="all">Все</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Проверить</button>
            </form>
        </div>
        <div class="infospace col-md-9">