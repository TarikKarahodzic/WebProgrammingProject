var BarberService = {
    reload_barbers_datatable: function () {
        $('#tbl_barbers').DataTable({
            ajax: {
                url: Constants.API_BASE_URL + "barbers",
                dataSrc: function (json) {
                    // Directly return the array if the response is an array of objects
                    if (Array.isArray(json)) {
                        return json;
                    } else {
                        console.error('Invalid data format:', json);
                        return []; // Return an empty array if the format is incorrect
                    }
                }
            },
            columns: [
                {
                    data: null, // Use null to generate custom content for this column
                    render: function (data, type, row) {
                        return '<button class="edit-btn" data-id="' + row.id + '">Edit</button><button class="delete-btn" data-id="' + row.id + '">Delete</button>';
                    },
                    orderable: false
                },
                { data: "barber_name" },
                { data: "barber_phoneNumber" },
                { data: "barber_email" },
                { data: "barber_password" },
                { data: "work_start_time" },
                { data: "work_end_time" },
                { data: "days_off" }
            ],
            destroy: true // To allow reinitialization of the DataTable
        });
        $('#tbl_barbers tbody').off('click', '.edit-btn').on('click', '.edit-btn', function () {
            var id = $(this).data('id');
            BarberService.open_edit_barber_modal(id);
        });

        $('#tbl_barbers tbody').off('click', '.delete-btn').on('click', '.delete-btn', function () {
            var id = $(this).data('id');
            BarberService.delete_barber_modal(id);
        });
    },
    open_edit_barber_modal: function (id) {
        RestClient.get(Constants.API_BASE_URL + "barbers/" + id, function (data) {
            $("#add-barber-modal").modal("toggle");
            $("#add-barber-form input[name='id']").val(data.id);
            $("#add-barber-form input[name='barber_fullName']").val(data.barber_name);
            $("#add-barber-form input[name='barber_phonenumber']").val(data.barber_phoneNumber);
            $("#add-barber-form input[name='barber_email']").val(data.barber_email);
            $("#add-barber-form input[name='barber_password']").val(data.barber_password);
            $("#add-barber-form input[name='work_start_time']").val(data.work_start_time);
            $("#add-barber-form input[name='work_end_time']").val(data.work_end_time);
            $("#add-barber-form input[name='days_off']").val(data.days_off);
        });
    },
    delete_barber_modal: function (barber_id) {
        if (confirm("Do you want to delete barber with the id " + barber_id + "?") == true) {
            RestClient.delete(
                Constants.API_BASE_URL + "barbers/" + barber_id,
                {},
                function (data) {
                    BarberService.reload_barbers_datatable();
                },
                function (xhr, status, error) {
                    console.error("Delete failed for barber ID:", barber_id, "Error:", error);
                }
            );
        }
    }
};