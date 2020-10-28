require('./bootstrap');


$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    const form = document.getElementById('getYouTubeLink');
    if (form) {
        form.onsubmit = (e) => {
            e.preventDefault();
            const $errBlock = $('.form-error-message');
            $errBlock.hide();
            const data = new FormData(form);
            $.ajax({
                url: '/YouTube-spider/getInfo',
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('#searchResult').html($(data));
                },
                error: function(e) {
                   $errBlock.show();
                }
            });
        }
    }
});
