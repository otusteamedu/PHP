<html>
<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <style>
        body{
            background:#f3c538;
        }
        .forget-pwd > a{
            color: #dc3545;
            font-weight: 500;
        }
        .appeal .panel-default{
            padding: 31%;
            margin-top: -27%;
        }
        .appeal .panel-body{
            padding: 15%;
            margin-bottom: -50%;
            background: #fff;
            border-radius: 5px;
            -webkit-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        img{
            width:40%;
            margin-bottom:10%;
        }

        .appeal .dropdown{
            width: 100%;
            border: 1px solid #ced4da;
            border-radius: .25rem;
        }
        .appeal .dropdown button{
            width: 100%;
        }
        .appeal .dropdown ul{
            width: 100%;
        }
    </style>
</head>
<body>
<div class="container appeal">
    <div class="row">
        <div class="col-md-12 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="text-center">
                        <h3 id="status" class="text-center">Загрузка...</h3>
                    </div>
                    <div id="message" class="d-none">
                        <dl>
                            <dt>Сообщение</dt>
                            <dd><pre class="message"></pre></dd>
                        </dl>
                        <dl id="answer" class="d-none">
                            <dt>Ответ</dt>
                            <dd><pre class="answer"></pre></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    (function($) {
        const IN_PROGRESS = '1';
        const PROCESSED = '2';
        const CANCELED = '3';

        let urlAux = window.location.href.split('/'),
            $status = $('#status'),
            $messageBlock =$('#message'),
            $answerBlock = $('#answer'),
            $messageText = $('.message'),
            $answerText = $('.answer');

        function getCookie(name) {

            let matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
            return matches ? decodeURIComponent(matches[1]) : undefined
        }

        $.ajax({
            type: "GET",
            url: `/api/message/${urlAux[urlAux.length - 1]}`,
            beforeSend: function(request) {
                request.setRequestHeader("X-Api-Key", getCookie("user"));
            },
            success: function (data) {

                if (data.result === null) {
                    $status.text('Запрос не найден :(');
                    return;
                }

                switch (data.result.status) {
                    case CANCELED:
                        $status.text('Запрос откланен');
                        break;
                    case PROCESSED:
                        $status.text('Запрос обработан');
                        break;
                    case IN_PROGRESS:
                    default:
                        $status.text('Запрос в обработке');
                }
                if(data.result.message != null) {
                    $messageText.text(data.result.message);
                    $messageBlock.removeClass('d-none');
                }

                if(data.result.answer != null){
                    $answerText.text(data.result.answer);
                    $answerBlock.removeClass('d-none');
                }
            }
        });
    })(jQuery);
</script>
</body>
</html>