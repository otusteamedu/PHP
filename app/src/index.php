<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>
<body>

<div>
    <h3>Отправить заявку</h3>
    <form id="send_form">
        <textarea name="message" cols="100" rows="5"></textarea><br />
        <button>Отправить</button>
    </form>
</div>

<hr />

<div>
    <h3>Узнать состояние заявки</h3>
    <form id="get_form">
        <input type="text" name="code" /><br />
        <button>Запросить</button>
    </form>
</div>


<script>
    $("#send_form button").click(function() {
        $.ajax({
            type: "POST",
            url: "/api/send",
            data: JSON.stringify({ message: $("#send_form textarea").val() }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data){
                if (data.status == 'ok') {
                    $("#send_form").replaceWith('Код вашего запроса: ' + data.message);
                } else {
                    alert('Error. Code: ' + data.code + ', message:' + data.message);
                }
            }
        });

        return false;
    });

    $("#get_form button").click(function() {
        $.ajax({
            type: "POST",
            url: "/api/get",
            data: JSON.stringify({ code: $("#get_form input").val() }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data){
                if (data.status == 'ok') {
                    $("#get_form").replaceWith(data.message);
                } else {
                    alert('Error. Code: ' + data.code + ', message:' + data.message);
                }
            }
        });

        return false;
    });
</script>

</body>
</html>