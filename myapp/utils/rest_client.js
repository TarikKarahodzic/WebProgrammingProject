var RestClient = {
    get: function (url, callback, error_callback) {
        $.ajax({
            url: Constants.API_BASE_URL + url,
            type: "GET",
            success: function (response) {
                if (callback) callback(response);
            },
            fail: function (jqXHR, textStatus, errorThrown) {
                if (error_callback) error_callback(jqXHR);
            },
        });
    },
    request: function (url, method, data, callback, error_callback) {
        $.ajax({
            url: Constants.API_BASE_URL + url,
            type: method,
            data: data,
        })
            .done(function (response, status, jqXHR) {
                if (callback) callback(response);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                if (error_callback) {
                    error_callback(jqXHR);
                } else {
                    if(jqXHR.responseJSON !== undefined && jqXHR.responseJSON.message !== undefined) {
                        toastr.error(jqXHR.responseJSON.message);
                    } else {
                        toastr.error("An unexpected error occured");
                    }
                }
            });
    },
    post: function (url, data, callback, error_callback) {
        RestClient.request(url, "POST", data, callback, error_callback);
    },
    delete: function (url, data, callback, error_callback) {
        RestClient.request(url, "DELETE", data, callback, error_callback);
    },
    put: function (url, data, callback, error_callback) {
        RestClient.request(url, "PUT", data, callback, error_callback);
    },
};