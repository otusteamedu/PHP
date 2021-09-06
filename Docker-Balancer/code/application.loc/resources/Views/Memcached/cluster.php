<section id="banner">
    <div class="row">
        <!-- Первый сервер memcached -->
        <div class="col-md-6">
            <form>
                <fieldset id="fieldset1" <?php echo !isset($memcached1)||(!empty($memcached1['error'])) ? 'disabled' : 'enabled'?>>
                    <div id="panel1" class="alert <?php if (!isset($memcached1)) {echo 'alert-secondary';}
                                            elseif (!empty($memcached1['error'])) {echo 'alert-danger';}
                                            else {echo 'alert-success';}?>">
                        <div class="row">
                            <div class="col-md-6">Memcached-1 Server</div>
                            <div class="col-md-6">Статус: <span id="server1Status"><?php echo $memcached1['status'] ?? 'undefined'?></span></div>
                        </div>
                        <b id="error1"><?php echo !isset($memcached1)||(!empty($memcached1['error'])) ? $memcached1['error']['message'] : '&nbsp;'?></b>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Key</span>
                        </div>
                        <input id="putKey1" type="text" class="form-control" placeholder="Ключ" aria-label="Ключ" aria-describedby="basic-addon1">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon2">Val</span>
                        </div>
                        <input id="putValue1" type="text" class="form-control" placeholder="Значение" aria-label="Значение" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button id="putButton1" class="btn btn-outline-primary" type="button">Put</button>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Key</span>
                        </div>
                        <input id="getKey1" type="text" class="form-control" placeholder="Ключ" aria-label="Ключ"  aria-describedby="basic-addon3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon4">Val</span>
                        </div>
                        <input id="getValue1" type="text" class="form-control" aria-label="Значение" aria-describedby="basic-addon4" disabled>
                        <div class="input-group-append">
                            <button id="getButton1" class="btn btn-outline-info" type="button">Get</button>
                        </div>
                    </div>
                    <div class="alert <?php if (!isset($memcached1Status)) {echo 'alert-secondary';}
                                            elseif ($memcached1Status=='error') {echo 'alert-danger';}
                                            else {echo 'alert-success';}?>">
                        <div class="row">
                            <div class="col-md-3">Last insert:</div>
                            <div class="col-md-9" style="text-align: left">
                                <div class="col-md-12">Ключ: <span id="lastKey1"><?php echo $memcached1_key ?? 'undefined'?></span></div>
                                <div class="col-md-12">Значение: <span id="lastValue1"><?php echo $memcached1_value ?? 'undefined'?></span></div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <!-- Второй сервер memcached -->
        <div class="col-md-6">
            <form>
                <fieldset id="fieldset2" <?php echo !isset($memcached2)||(!empty($memcached2['error'])) ? 'disabled' : 'enabled'?>>
                    <div id="panel2" class="alert <?php if (!isset($memcached2)) {echo 'alert-secondary';}
                    elseif (!empty($memcached2['error'])) {echo 'alert-danger';}
                    else {echo 'alert-success';}?>">
                        <div class="row">
                            <div class="col-md-6">Memcached-2 Server</div>
                            <div class="col-md-6">Статус: <span id="server2Status"><?php echo $memcached2['status'] ?? 'undefined'?></span></div>
                        </div>
                        <b id="error2"><?php echo !isset($memcached2)||(!empty($memcached2['error'])) ? $memcached2['error']['message'] : '&nbsp;'?></b>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">Key</span>
                        </div>
                        <input id="putKey2" type="text" class="form-control" placeholder="Ключ" aria-label="Ключ" aria-describedby="basic-addon5">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon6">Val</span>
                        </div>
                        <input id="putValue2" type="text" class="form-control" placeholder="Значение" aria-label="Значение" aria-describedby="basic-addon6">
                        <div class="input-group-append">
                            <button id="putButton2" class="btn btn-outline-primary" type="button">Put</button>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon7">Key</span>
                        </div>
                        <input id="getKey2" type="text" class="form-control" placeholder="Ключ" aria-label="Ключ">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon8">Val</span>
                        </div>
                        <input id="getValue2" type="text" class="form-control" aria-label="Значение" value="" disabled>
                        <div class="input-group-append">
                            <button id="getButton2" class="btn btn-outline-info" type="button">Get</button>
                        </div>
                    </div>
                    <div class="alert <?php if (!isset($memcached2Status)) {echo 'alert-secondary';}
                    elseif ($memcached2Status=='error') {echo 'alert-danger';}
                    else {echo 'alert-success';}?>">
                        <div class="row">
                            <div class="col-md-3">Last insert:</div>
                            <div class="col-md-9" style="text-align: left">
                                <div class="col-md-12">Ключ: <span id="lastKey2"><?php echo $memcached2_key ?? 'undefined'?></span></div>
                                <div class="col-md-12">Значение: <span id="lastValue2"><?php echo $memcached2_value ?? 'undefined'?></span></div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</section>
