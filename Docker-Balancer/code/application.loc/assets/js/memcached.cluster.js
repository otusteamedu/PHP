function requestMemcached($url, $server) {
    let $panel1 = document.getElementById('panel1');
    let $panel2 = document.getElementById('panel2');
    let $server1Status = document.getElementById('server1Status');
    let $server2Status = document.getElementById('server2Status');
    let $error1 = document.getElementById('error1');
    let $error2 = document.getElementById('error2');
    let $putKey1 = document.getElementById('putKey1');
    let $getKey1 = document.getElementById('getKey1');
    let $putKey2 = document.getElementById('putKey2');
    let $getKey2 = document.getElementById('getKey2');
    let $putValue1 = document.getElementById('putValue1');
    let $getValue1 = document.getElementById('getValue1');
    let $putValue2 = document.getElementById('putValue2');
    let $getValue2 = document.getElementById('getValue2');
    let $lastKey1 = document.getElementById('lastKey1');
    let $lastValue1 = document.getElementById('lastValue1');
    let $lastKey2 = document.getElementById('lastKey2');
    let $lastValue2 = document.getElementById('lastValue2');

    let preparedData = ($server === 'memcached-1')
        ? {
           putKey: $putKey1.value,
           putValue: $putValue1.value,
           getKey: $getKey1.value,
           server: $server
        }
        :  {
            putKey: $putKey2.value,
            putValue: $putValue2.value,
            getKey: $getKey2.value,
            server: $server
        }

    $.ajax({
        url: $url,
        type: 'POST',

        data: preparedData,
        dataType: 'html',
        success: function($data) {
            console.log($data);
            let response = JSON.parse($data);
            console.log(response);
            if (response.data.server === 'memcached-1') {
                $server1Status.innerHTML = response.status;
                if (typeof response.data.lastInsertKey !== 'undefined' && response.data.status==='OK') $lastKey1.innerHTML = response.data.lastInsertKey;
                if (typeof response.data.lastInsertValue !== 'undefined' && response.data.status==='OK') $lastValue1.innerHTML = response.data.lastInsertValue;
                if (response.data.method==='Get') $getValue1.value = response.data.value;
                if (response.status === 'error') {
                    $panel1.classList.remove('alert-success');
                    $panel1.classList.add("alert-danger");
                } else {
                    $panel1.classList.remove('alert-danger');
                    $panel1.classList.add("alert-success");
                }
                if (typeof response.data.mistake !== 'undefined') {
                    $error1.innerHTML = "Ошибка: " + response.data.mistake.message;
                } else {
                    $error1.innerHTML = '&nbsp;';
                }
            }
            if (response.data.server === 'memcached-2') {
                $server2Status.innerHTML = response.status;
                if (typeof response.data.lastInsertKey !== 'undefined' && response.data.status==='OK') $lastKey2.innerHTML = response.data.lastInsertKey;
                if (typeof response.data.lastInsertValue !== 'undefined' && response.data.status==='OK') $lastValue2.innerHTML = response.data.lastInsertValue;
                if (response.data.method==='Get') $getValue2.value = response.data.value;
                if (response.status === 'error') {
                    $panel2.classList.remove('alert-success');
                    $panel2.classList.add("alert-danger");
                } else {
                    $panel2.classList.remove('alert-danger');
                    $panel2.classList.add("alert-success");
                }
                if (typeof response.data.mistake !== 'undefined') {
                    $error2.innerHTML = "Ошибка: " + response.data.mistake.message;
                } else {
                    $error2.innerHTML = '&nbsp;';
                }
            }
        }
    });
}

$('#putButton1').on('click', function(){jsoxModal(); requestMemcached('/Memcached/Memcached1/xhrPut', 'memcached-1')})
$('#putButton2').on('click', function(){jsoxModal(); requestMemcached('/Memcached/Memcached2/xhrPut', 'memcached-2')})
$('#getButton1').on('click', function(){jsoxModal(); requestMemcached('/Memcached/Memcached1/xhrGet', 'memcached-1')})
$('#getButton2').on('click', function(){jsoxModal(); requestMemcached('/Memcached/Memcached2/xhrGet', 'memcached-2')})
