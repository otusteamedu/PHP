function sendForm(form) {
    $(".msg-box").text("...");
    $.post("/", $(form).serialize(), function (data) {
        $(".msg-box").text(data);
        form.reset();
    });
}

function cleanMsgBox() {
    $(".msg-box").text("");
}