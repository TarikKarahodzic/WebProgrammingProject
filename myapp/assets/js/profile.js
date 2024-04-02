$(document).ready(function () {
    // AJAX request to fetch data
    $.get("../project.json", function(data) {
        console.log(data);
        var users = data.users
        console.log(users);
        users.forEach(function(user) {
            var cardContainerHtml = `
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-6 mb-4 mb-lg-0">
                    <div class="card mb-3" style="border-radius: .5rem;">
                        <div class="row g-0">
                            <div class="col-md-4 gradient-custom text-center text-white"
                                style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem; text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.7);">
                                <img src="${user.image}"
                                    alt="Avatar" class="img-fluid my-5" id="profile-picture"/>
                                <h5>${user.name}</h5>
                                <i class="far fa-edit mb-5"></i>
                            </div>
                            <div class="col-md-8 text-dark">
                                <div class="card-body p-4">
                                    <h6>Information</h6>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-6 mb-3">
                                            <h6>Username</h6>
                                            <p class="text-muted">${user.username}</p>
                                        </div>
                                    </div>
                                    <div class="row pt-1">
                                        <div class="col-6 mb-3">
                                            <h6>Email</h6>
                                            <p class="text-muted">${user.email}</p>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <h6>Phone</h6>
                                            <p class="text-muted">${user.phoneNumber}</p>
                                        </div>
                                    </div>
                                    <div class="row pt-1">
                                        <div class="col-6 mb-3">
                                            <h6>Password</h6>
                                            <p class="text-muted">${user.password}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;

            $("#profileContainer").append(cardContainerHtml);
        })
    })
});