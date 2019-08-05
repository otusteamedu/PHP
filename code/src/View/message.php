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
                        <img src="/img/question.png" border="0">
                        <h2 class="text-center">Нужна помошь?</h2>
                        <p>Напишите нам</p>
                        <form id="message" role="form" autocomplete="off" class="form" method="post" onsubmit="false">
                            <input type="hidden" name="csrf_token" value="<?= $token ?>">
                            <div class="form-group">
                                <div class="input-group">
                                    <select name="type" class="form-control" id="type">
                                        <option selected="true" disabled="disabled">Выберете категорию</option>
                                        <option value="1">Отзыв о фильме</option>
                                        <option value="2">Отзыв о работе кинотеатра</option>
                                        <option value="3">Жалоба</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                    <textarea name="message" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
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
    function getCookie(name) {

        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined
    }
    $("#send").click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/api/message",
            data: JSON.stringify({message: $("#message textarea").val(), 'type': parseInt($('#type').val())}),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            beforeSend: function(request) {
                request.setRequestHeader("X-Api-Key", getCookie("user"));
            },
            success: function (data) {
                if (data.status == "ok") {
                    Swal.fire({
                        title: "Код вашего запроса",
                        html: `<code>${data.result}</code>`,
                        type: "success",
                        confirmButtonText: "ok"
                    });
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
</script>
</body>
</html>