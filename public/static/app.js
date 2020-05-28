$(function () {

    let OTUS = {
        urlAddRequest: '/acyncadd',
        urlStatusRequest: '/status',
        rowsCount: 300000,
        clientRequestId: null,
        refresh: false,

        init: function () {
            let self = this;

            $('.send-request').click(function (e) {
                $(this).prop('disabled', 'true');
                $.ajax({
                    url: `${self.urlAddRequest}/${self.rowsCount}`,
                    dataType: "json",
                    type: "post"
                }).done(function (result) {
                    self.clientRequestId = result.client_request_id;
                    self.refresh = true;
                    self.statusUpdate();
                });
            });

            // regular sync status by server
            setInterval(function() {
                self.statusUpdate();
            }, 1000);
        },

        statusUpdate: function () {
            let self = this;
            console.log(self.clientRequestId);

            if (self.refresh) {
                $.ajax({
                    url: `${self.urlStatusRequest}/${self.clientRequestId}`,
                    dateType: "json",
                    type: "get"
                }).done(function (result) {
                    let text = null;

                    if (result.client_request_status == 0) {
                        text = 'free';
                    } else if (result.client_request_status == 1) {
                        text = 'in process';
                    } else if (result.client_request_status == 2) {
                        text = 'success';
                        self.refresh = false;
                        $('.send-request').prop('disabled', null);
                    } else if (result.client_request_status == 3) {
                        text = 'error';
                    } else {
                        text = 'undefined';
                    }
                    $('.request-id').text(result.client_request_id);
                    $('.request-status').text(text);
                });
            }
        }
    };

    OTUS.init();

});