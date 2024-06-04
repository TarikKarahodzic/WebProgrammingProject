var AppointmentService = {
    reload_appointments_datatable: function () {
        $('#tbl_appointments').DataTable({
            ajax: {
                url: Constants.API_BASE_URL + "appointments",
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
                    render: function(data, type, row) {
                        return '<button class="edit-btn" data-id="' + row.id + '">Edit</button><button class="delete-btn" data-id="' + row.id + '">Delete</button>';
                    },
                    orderable: false
                },
                { data: "user_id" },
                { data: "barber_id" },
                { data: "service_id" },
                { data: "appointment_time" },
            ],
            destroy: true // To allow reinitialization of the DataTable
        });
    },
    open_edit_appointment_modal : function (id) {
        RestClient.get(
            Constants.API_BASE_URL + "appointments/" + id,
            function(data) {
                $("#add-barber-modal").modal("toggle");
                $("#add-barber-form input[name='id']").val(data.id);
                $("#add-barber-form input[name='user_id']").val(data.user_id);
                $("#add-barber-form input[name='barber_id']").val(data.barber_id);
                $("#add-barber-form input[name='service_id']").val(data.service_id);
                $("#add-barber-form input[name='appointment_time']").val(data.appointment_time);
            }
        )
    },
    delete_appointment_modal : function (appointment_id) {
        if(confirm("Do you want to delete appointment with the id " + appointment_id + "?") == true) {
            RestClient.delete(
                Constants.API_BASE_URL + "appointments/" + appointment_id,
                {},
                function(data) {
                    AppointmentService.reload_appointments_datatable();
                }
            )
        }
    },
};