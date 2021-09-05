function jsoxModal(message, title = null) {
        $('.modal-container').css("display","flex");
        $('.modal-container').click( function() {
            $('.modal-container').fadeOut(400, function(){
                $('.modal-container').css("display","none");
            })
        });
        $(".modal-show").show("slow");
        
        $('.modal-show').click(function() {
                event.stopPropagation();
            });
        $('btn-close').click(function() {
        	$('.modal-show').fadeOut(400, function(){
                        $('.modal-container').css("display","none");
                        $('.modal-show').css("display","none");
            })
        });
         $('.modal-show').append($('<a>', {
                style: 'cursor: pointer; position: absolute;top: -12.5px;right: -12.5px;display: block;width: 30px;height: 30px;text-indent: -9999px;background-size: contain;background-repeat: no-repeat;background-position: center center;background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAAAAXNSR0IArs4c6QAAA3hJREFUaAXlm8+K00Acx7MiCIJH/yw+gA9g25O49SL4AO3Bp1jw5NvktC+wF88qevK4BU97EmzxUBCEolK/n5gp3W6TTJPfpNPNF37MNsl85/vN/DaTmU6PknC4K+pniqeKJ3k8UnkvDxXJzzy+q/yaxxeVHxW/FNHjgRSeKt4rFoplzaAuHHDBGR2eS9G54reirsmienDCTRt7xwsp+KAoEmt9nLaGitZxrBbPFNaGfPloGw2t4JVamSt8xYW6Dg1oCYo3Yv+rCGViV160oMkcd8SYKnYV1Nb1aEOjCe6L5ZOiLfF120EjWhuBu3YIZt1NQmujnk5F4MgOpURzLfAwOBSTmzp3fpDxuI/pabxpqOoz2r2HLAb0GMbZKlNV5/Hg9XJypguryA7lPF5KMdTZQzHjqxNPhWhzIuAruOl1eNqKEx1tSh5rfbxdw7mOxCq4qS68ZTjKS1YVvilu559vWvFHhh4rZrdyZ69Vmpgdj8fJbDZLJpNJ0uv1cnr/gjrUhQMuI+ANjyuwftQ0bbL6Erp0mM/ny8Fg4M3LtdRxgMtKl3jwmIHVxYXChFy94/Rmpa/pTbNUhstKV+4Rr8lLQ9KlUvJKLyG8yvQ2s9SBy1Jb7jV5a0yapfF6apaZLjLLcWtd4sNrmJUMHyM+1xibTjH82Zh01TNlhsrOhdKTe00uAzZQmN6+KW+sDa/JD2PSVQ873m29yf+1Q9VDzfEYlHi1G5LKBBWZbtEsHbFwb1oYDwr1ZiF/2bnCSg1OBE/pfr9/bWx26UxJL3ONPISOLKUvQza0LZUxSKyjpdTGa/vDEr25rddbMM0Q3O6Lx3rqFvU+x6UrRKQY7tyrZecmD9FODy8uLizTmilwNj0kraNcAJhOp5aGVwsAGD5VmJBrWWbJSgWT9zrzWepQF47RaGSiKfeGx6Szi3gzmX/HHbihwBser4B9UJYpFBNX4R6vTn3VQnez0SymnrHQMsRYGTr1dSk34ljRqS/EMd2pLQ8YBp3a1PLfcqCpo8gtHkZFHKkTX6fs3MY0blKnth66rKCnU0VRGu37ONrQaA4eZDFtWAu2fXj9zjFkxTBOo8F7t926gTp/83Kyzzcy2kZD6xiqxTYnHLRFm3vHiRSwNSjkz3hoIzo8lCKWUlg/YtGs7tObunDAZfpDLbfEI15zsEIY3U/x/gHHc/G1zltnAgAAAABJRU5ErkJggg==)',
                click: function() {
                    $('.modal-show').fadeOut(400, function(){
                        $('.modal-container').css("display","none");
                        $('.modal-show').css("display","none");
                    })
                }
            }));
        
};

function request($url, $postParameter) {
    let $imgSuccess= '/images/main/client-server.gif';
    let $imgError= '/images/main/server-error.gif';
    let $imgWait= '/images/main/client-server.gif';
    let Title = document.getElementById('serverTitle');
    let Success = document.getElementById('serverSuccess');
    let Text = document.getElementById('serverData');
    let Img = document.getElementById('modalImage');
    let Alert = document.getElementById('alert');

    Alert.classList.remove('alert-success', 'alert-danger');
    Alert.classList.add("alert-warning");
    Title.innerHTML  = 'Trying to connect';
    Text.innerHTML  = 'Please wait...';
    Success.innerHTML = '';

    Img.src = $imgWait;
    $.ajax({
        url: $url,
        type: 'POST',
        data: {
            data: $postParameter
        },
        dataType: 'html',
        success: function($data) {
            let response = JSON.parse($data);
            let data = response.data;
            if (typeof data.title !== 'undefined') {
                Title.innerHTML = data.title;
            } else {
                data.innerHTML = ''
            }
            if (typeof response.status !== 'undefined' && response.status === 'error') {
                Alert.classList.remove('alert-warning');
                Alert.classList.add("alert-danger");
                Text.innerHTML  = data.error.message + "<p>Error code:" + data.error.code + "</p>";
                Img.src = $imgError;
            } else if (typeof response.status !== 'undefined' && response.status === 'success' && response.message !== 'sysinfo') {
                Alert.classList.remove('alert-warning');
                Alert.classList.add("alert-success");
                Text.innerHTML  = data.info.serverInfo;
                Success.innerHTML = 'Success';
                Img.src = $imgSuccess;
            }
            if (typeof response.message !== 'undefined' && response.message === 'sysinfo') {
                Alert.classList.remove('alert-warning');
                Alert.classList.add("alert-success");
                Text.innerHTML  = "<p>Webserver IP: " + data.webserverIp.info + "</p>"
                    + "<p>Node IP: " + data.nodeIp.info + "</p>"
                    + "<p>Тип интерфейса: " +data.sapi.info + "</p>";
                Img.src = $imgSuccess;
            }
        }
    });
}

$('#popup_server_ip').on('click', function(){jsoxModal(); request('/Sysinfo/xhrGetServerAddress')})
$('#popup_node_ip').on('click', function(){jsoxModal(); request('/Sysinfo/xhrGetNodeAddress')})
$('#popup_sapi').on('click', function(){jsoxModal(); request('/Sysinfo/xhrGetSapi')})
$('#popup_sysinfo').on('click', function(){jsoxModal(); request('/Sysinfo/xhrGetInfo')})
$('#popup_postgres_pdo').on('click', function(){jsoxModal(); request('/Postgres/xhrCheckPdoConnection', 'postgres')})
$('#popup_postgres_pg').on('click', function(){jsoxModal(); request('/Postgres/xhrCheckPgConnection', 'postgres')})
$('#popup_mysql_pdo_master').on('click', function(){jsoxModal(); request('/Mysql/xhrCheckPdoConnection', 'Master')})
$('#popup_mysql_pdo_slave').on('click', function(){jsoxModal(); request('/Mysql/xhrCheckPdoConnection', 'Slave')})
$('#popup_mysqli_master').on('click', function(){jsoxModal(); request('/Mysql/xhrCheckMysqliConnection', 'Master')})
$('#popup_mysqli_slave').on('click', function(){jsoxModal(); request('/Mysql/xhrCheckMysqliConnection', 'Slave')})
$('#popup_redis').on('click', function(){jsoxModal(); request('/Redis/xhrCheckConnection')})
$('#popup_elastic').on('click', function(){jsoxModal(); request('/Elasticsearch/xhrCheckConnection')})
$('#popup_memcached').on('click', function(){jsoxModal(); request('/MemCached/AloneMemcached/xhrCheckConnection')})

$('.btn-close').click(function() {
                    $('.modal-show').fadeOut(400, function(){
                        $('.modal-container').css("display","none");
                        $('.modal-show').css("display","none");
                    });
});

