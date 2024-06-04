function serializeForm(form) {
    var serialized = $(form).serializeArray();
    var data = {};
    serialized.forEach(function(item) {
        data[item.name] = item.value;
    });
    return data;
}

function addUser(data) {
    $.ajax({
        url: "http://localhost/WebProgrammingProject/backend/api/users",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(data),
        success: function (response) {
            console.log(response);
            window.location.href = "#login";
        },
        error: function (error) {
            console.log(error);
            alert("Error occured while trying to register!");
        },
    });
}

$("#register_form").validate({
    rules: {
        user_name: {
            required: true,
        },
        user_email: {
            required: true,
            email: true
        },
        user_phoneNumber: {
            required: true,
        },
        user_password: {
            required: true,
            minlength: 6
        }
    },
    messages: {
        user_fullName: "Please enter your full name",
        user_password: {
            required: "Please enter your password!",
            minlength: "Your password should be at least 6 characters!",
        }
    },
    submitHandler: function (form, event) {
        event.preventDefault();
        Utils.block_ui("#register-form");
        serializeForm(form);

        var user_name = $('#user_name').val();
        var user_email = $('#user_email').val();
        var user_phoneNumber = $('#user_phoneNumber').val();
        var user_password = $('#user_password').val();

        var userData = {
            user_name: user_name,
            user_email: user_email,
            user_phoneNumber: user_phoneNumber,
            user_password: user_password
        };

        addUser(userData);
        console.log(userData);
        Utils.unblock_ui('#register-form');
    },
});

$('#login_form').validate({
    rules: {
        user_email: {
            required: true,
            email: true
        },
        user_password: {
            required: true,
            minlength: 6
        }
    },
    messages: {
        user_email: {
            required: "Please enter your email!",
            email: "Invalid email!",
        },
        user_password: {
            required: "Please enter your password!",
            minlength: "Your password should be at least 6 characters!",
        },
    },
    submitHandler: function (form, event) {
        event.preventDefault();
        Utils.block_ui("#login_form");

        var user_email = $('#user_email').val();
        var user_password = $('#user_password').val();

        $.ajax({
            url: "http://localhost/WebProgrammingProject/backend/auth/login",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({
                user_email: user_email,
                user_password: user_password,
            }),
            success: function (response) {
                var userData = {
                    user_name: response.data.user_name,
                    user_email: response.data.user_email,
                    user_phoneNumber: response.data.user_phoneNumber,
                    user_password: response.data.user_password,
                    token: response.data.token
                }
                localStorage.setItem('user', JSON.stringify(userData))
                
                Utils.unblock_ui('#login_form');
                window.location.href = "#landing";
            },
            error: function (error) {
                Utils.unblock_ui('#login_form');
                alert("Invalid credentials!");
            }
        });
    },
});