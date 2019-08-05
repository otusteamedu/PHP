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
        .appeal.dropdown ul{
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
                        <h3 id="header" class="text-center">Загрузка...</h3>
                        <form id="message" role="form" autocomplete="off" class="form d-none">
                            <input type="hidden" name="csrf_token" value="<?= $token ?>">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                    <textarea name="message" class="form-control message" rows="3" readonly></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                    <textarea name="answer" class="form-control answer" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <select name="status" class="form-control status" id="type">
                                        <option value="2" selected>Обработан</option>
                                        <option value="3">Откланен</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <input id="del" name="del" class="btn btn-lg btn-danger btn-block" value="Удалить" type="button">
                                <input id="send" name="send" class="btn btn-lg btn-primary btn-block" value="Отправить" type="submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
    (function($) {
        let $status = $(".status"),
            $messageBlock =$("#message"),
            $header =$("#header"),
            $messageText = $(".message"),
            $answerText = $(".answer"),
            id = '';

        function getCookie(name) {

            let matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
            return matches ? decodeURIComponent(matches[1]) : undefined
        }

        function clear() {
            $header.text("Загрузка...");
            $messageText.val("");
            $answerText.val("");
            id = '';
            $status.val(2);
            $messageBlock.addClass("d-none");
        }

        function load() {
            $.ajax({
                type: "GET",
                url: '/api/message',
                beforeSend: function(request) {
                    request.setRequestHeader("X-Api-Key", getCookie("user"));
                },
                success: function (data) {

                    if (data.result === null) {
                        $header.text("Нет запросов для обработки");
                        return;
                    }
                    $header.text(data.result.id);
                    id = data.result.id;
                    $messageBlock.removeClass("d-none");

                    if(data.result.message != null) {
                        $messageText.text(data.result.message);
                    }
                },
                error: function () {
                    $header.text("Что-то пошло не так :(");
                }
            });
        }

        $("#del").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "DELETE",
                url: `/api/message/${id}`,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                beforeSend: function (request) {
                    request.setRequestHeader("X-Api-Key", getCookie("user"));
                },
                success: function (data) {
                    if (data.status === "ok") {
                        Swal.fire({
                            title: "Запрос удален",
                            type: "success",
                            confirmButtonText: "ok"
                        });
                        clear();
                        load();
                    } else {
                        Swal.fire({
                            title: "Ошибка",
                            text: "Что-то пошло не так :(",
                            type: "error",
                            confirmButtonText: "ok"
                        })
                    }
                },
                error: function (data) {
                    Swal.fire({
                        title: "Ошибка",
                        text: JSON.parse(data.responseText).message,
                        type: "error",
                        confirmButtonText: "ok"
                    })
                }
            });
        });

        $("#send").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "PUT",
                url: `/api/message/${id}`,
                data: JSON.stringify({"message": $messageText.val(),"answer":$answerText.val(), "status": parseInt($status.val())}),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                beforeSend: function(request) {
                    request.setRequestHeader("X-Api-Key", getCookie("user"));
                },
                success: function (data) {
                    if (data.status === "ok") {
                        Swal.fire({
                            title: "Запрос успешно обработан",
                            type: "success",
                            confirmButtonText: "ok"
                        });
                        clear();
                        load();
                    } else {
                        Swal.fire({
                            title: "Ошибка",
                            text: "Что-то пошло не так :(",
                            type: "error",
                            confirmButtonText: "ok"
                        })
                    }
                },
                error: function (data) {
                    Swal.fire({
                        title: "Ошибка",
                        text: JSON.parse(data.responseText).message,
                        type: "error",
                        confirmButtonText: "ok"
                    })
                }
            });
            return false;
        });
        load();
    })(jQuery);
</script>
</body>
</html>