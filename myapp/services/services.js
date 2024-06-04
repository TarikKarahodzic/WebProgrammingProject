var ServiceService = {
    reload_services_datatable: function () {
        $('#tbl_services').DataTable({
            ajax: {
                url: Constants.API_BASE_URL + "services",
                dataSrc: function (json) {
                    // Directly return the array if the response is an array of objects
                    if (Array.isArray(json)) {
                        return json;
                    } else {
                        console.error('Invalid data format:', json);
                        return [];
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
                { data: "service_type" },
                { data: "service_description" },
                { data: "service_price" }
            ],
            destroy: true // To allow reinitialization of the DataTable
        });
    },
    open_edit_service_modal : function (id) {
        RestClient.get(
            Constants.API_BASE_URL + "services/" + id,
            function(data) {
                $("#add-service-modal").modal("toggle");
                $("#add-service-form input[name='id']").val(data.id);
                $("#add-service-form input[name='service_type']").val(data.service_type);
                $("#add-service-form input[name='service_description']").val(data.service_description);
                $("#add-service-form input[name='service_price']").val(data.service_price);
            }
        );
    },
    delete_service_modal : function (service_id) {
        if(confirm("Do you want to delete service with the id " + service_id + "?") == true) {
            RestClient.delete(
                Constants.API_BASE_URL + "services/" + service_id,
                {},
                function(data) {
                    ServiceService.reload_services_datatable();
                }
            )
        };
    },
};