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
                    if (result.client_request_id > 0) {
                        self.refresh = true;
                        self.clientRequestId = result.client_request_id;
                    } else {
                        self.refresh = false;
                        self.showDBError();
                    }
                });
            });

            // regular sync status by server
            setInterval(function() {
                self.statusUpdate();
            }, 1000);
        },

        statusUpdate: function () {
            let self = this;

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
                    self.showStatus(result.client_request_id, text);
                });
            }
        },

        showDBError: function () {
            $('.alert-danger').removeClass('d-none');
        },

        showStatus: function (requestId, statusText) {
            $('.request-id').text(requestId);
            $('.request-status').text(statusText);
        }
    };

    OTUS.init();

});