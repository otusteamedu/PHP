<section id="banner">
    <div class="row">
        <div class="choose1 col-md-3">
            <form class="was-validated" method="get" action="/Sql/check">
                <div class="form-row">
                    <div class="custom-control custom-checkbox col-md-12 mb-3">
                        <input <?php if (isset($pdo)&&$pdo==='on') echo "checked"?> name="pdo" type="checkbox" class="custom-control-input" id="customControlValidation1">
                        <label class="custom-control-label" for="customControlValidation1">Использовать драйвер PDO</label>
                    </div>
                    <div class="form-group col-md-12">
                        <select name="db" class="custom-select" required>
                            <option value="">Выберите сервер</option>
                            <option <?php if (isset($db)&&$db==='mysql-master') echo "selected"?> value="mysql-master">Mysql Master</option>
                            <option <?php if (isset($db)&&$db==='mysql-slave') echo "selected"?> value="mysql-slave">Mysql Slave</option>
                            <option <?php if (isset($db)&&$db==='postgres') echo "selected"?> value="postgres">Postgres</option>
                            <option <?php if (isset($db)&&$db==='all') echo "selected"?> value="all">Все</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Проверить</button>
            </form>
        </div>
        <div class="infospace col-md-9">