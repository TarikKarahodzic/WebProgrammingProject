$(document).ready(function () {
    // AJAX request to fetch data
    $.get("../project.json", function(data) {
        console.log(data);
        var barbers = data.barbers
        console.log(barbers);
        barbers.forEach(function(barber) {
            var cardContainerHtml = `
            <article class="postcard light blue">
				<a class="postcard__img_link">
					<img class="postcard__img" src='${barber.image}' alt="Image Title" />
				</a>
				<div class="postcard__text t-dark">
					<h1 class="postcard__title ">Hasbulla</h1>
					<div class="postcard__bar"></div>
					<ul>
						<li><i class="fas fa-tag mr-2"></i>${barber.name}</li>
						<li><i class="fas fa-tag mr-2"></i>Phone number: ${barber.phoneNumber}</li>
					</ul>
				</div>
			</article>
            `;

            $("#barber-container").append(cardContainerHtml);
        })
    })
});