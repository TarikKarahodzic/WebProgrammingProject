var BarberService = {
    reload_barbers_datatable: function () {
        Utils.get_datatable(
          "tbl_barbers",
            Constants.API_BASE_URL + "get_barbers.php",
            [
                { data: "action" },
                { data: "barber_name" },
                { data: "barber_phoneNumber" },
                { data: "barber_email" },
                { data: "barber_password" },
                { data: "work_start_time" },
                { data: "work_end_time" },
                { data: "days_off" },
            ],
        );
    },
    open_edit_barber_modal : function (barber_id) {
        RestClient.get(
            'get_barber.php?id=' + barber_id,
            function(data) {
                $("#add-barber-modal").modal("toggle");
                $("#add-barber-form input[name='barber_id']").val(data.id);
                $("#add-barber-form input[name='full_name']").val(data.barber_name);
                $("#add-barber-form input[name='phone_number']").val(data.barber_phoneNumber);
                $("#add-barber-form input[name='email']").val(data.barber_email);
                $("#add-barber-form input[name='password']").val(data.barber_password);
                $("#add-barber-form input[name='start_time']").val(data.work_start_time);
                $("#add-barber-form input[name='end_time']").val(data.work_end_time);
                $("#add-barber-form input[name='days_off']").val(data.days_off);
            }
        )
    },
    delete_barber_modal : function (barber_id) {
        if(confirm("Do you want to delete barber with the id " + barber_id + "?") == true) {
            RestClient.delete(
                "delete_barber.php?id=" + barber_id,
                {},
                function(data) {
                    BarberService.reload_barbers_datatable();
                }
            )
        }
    },
};