$(document).ready(function () {
    // AJAX request to fetch data
    $.get("http://localhost/WebProgrammingProject/backend/api/barbers", function (data) {
        console.log(data);
        var barbers = data;
        console.log(barbers);
        barbers.forEach(function (barber) {
            var cardContainerHtml = `
            <article class="postcard light blue">
                <div class="postcard__text t-dark">
                    <h1 class="postcard__title ">${barber.barber_name}</h1>
                    <div class="postcard__bar"></div>
                    <ul>
                        <li><i class="fas fa-tag mr-2"></i>Email: ${barber.barber_email}</li>
                        <li><i class="fas fa-tag mr-2"></i>Phone number: ${barber.barber_phoneNumber}</li>
                        <li><i class="fas fa-tag mr-2"></i>Work Start time: ${barber.work_start_time}</li>
                        <li><i class="fas fa-tag mr-2"></i>Work End time: ${barber.work_end_time}</li>
                        <li><i class="fas fa-tag mr-2"></i>Days off: ${barber.days_off}</li>
                    </ul>
                    <button class="select-barber" data-barber-id="${barber.id}">Select</button>
                    <div id="calendar-${barber.id}" class="calendar" style="display: none;"></div>
                </div>
            </article>
            `;

            $("#barber-container").append(cardContainerHtml);
        })
    })
});

$(document).on('click', '.select-barber', function() {
    var barberId = $(this).attr('data-barber-id');
    var calendarDiv = $("#calendar-" + barberId);
    console.log(barberId);

    if(calendarDiv.is(':visible')) {
        calendarDiv.hide();
    } else {
        fetchAndDisplayCalendar(barberId);
    }
});

function fetchAndDisplayCalendar(barberId) {
    // Fetch appointments for the selected barber from the database
    $.get("http://localhost/WebProgrammingProject/backend/api/appointments?barber_id=" + barberId, function (appointments) {
        var calendarHtml = createWeeklyCalendar(appointments);
        $("#calendar-" + barberId).html(calendarHtml).show();
    });
}

function createWeeklyCalendar(appointments) {
    var days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    var slots = createTimeSlots();
    var calendarHtml = '<div class="calendar">';

    days.forEach(function(day) {
        calendarHtml += '<div class="day"><h2>' + day + '</h2>';
        slots.forEach(function(slot) {
            var isBooked = isSlotBooked(appointments, day, slot);
            var slotClass = isBooked ? 'booking-slot booked' : 'booking-slot';
            calendarHtml += '<div class="time-slot"><button class="' + slotClass + '">' + slot + '</button></div>';
        });
        calendarHtml += '</div>';
    });

    calendarHtml += '</div>';
    return calendarHtml;
}

function createTimeSlots() {
    var slots = [];
    for (var i = 8; i < 16; i++) {
        slots.push(i + ":00");
        slots.push(i + ":30");
    }
    return slots;
}

function isSlotBooked(appointments, day, slot) {
    // Check if the given slot is booked for the specified day
    // Loop through appointments and compare appointment_time with the given day and slot
    for (var i = 0; i < appointments.length; i++) {
        var appointment = appointments[i];
        var appointmentTime = new Date(appointment.appointment_time);
        var appointmentDay = appointmentTime.toLocaleString('en-us', { weekday: 'long' });
        var appointmentSlot = appointmentTime.getHours() + ":" + (appointmentTime.getMinutes() < 10 ? '0' : '') + appointmentTime.getMinutes();
        
        if (appointmentDay === day && appointmentSlot === slot) {
            return true;
        }
    }
    return false;
}

$(document).on('click', '.booking-slot:not(.booked)', function() {
    var slotButton = $(this);
    var barberId = slotButton.closest('.postcard__text').find('.select-barber').data('barber-id');
    var day = slotButton.closest('.day').find('h2').text();
    var slot = slotButton.text();
    console.log("Barber ID:", barberId);
    console.log("Day:", day);
    console.log("Slot:", slot);
    bookAppointment(barberId, day, slot, slotButton);
});

function bookAppointment(barberId, day, slot, slotButton) {
    // AJAX request to book the appointment
    $.post("http://localhost/WebProgrammingProject/backend/api/appointments_add", {
        barber_id: barberId,
        day: day,
        slot: slot
    }, function (response) {
        if (response && response.success) {
            // If booking is successful, mark the slot as booked and gray
            console.log("Booking successful!");
            slotButton.addClass('booked').attr('disabled', true);
        } else {
            // Handle error
            console.error("Failed to book appointment.");
            alert("Failed to book appointment.");
        }
    })
    .fail(function(xhr, status, error) {
        // Handle AJAX request failure
        console.error("AJAX request failed:", error);
        alert("AJAX request failed: " + error);
    });
}
