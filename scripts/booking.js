$(document).ready(function() {
    const bookedDates = []; // Array to store booked dates

    // Initialize the calendar
    $('#calendar').fullCalendar({
        selectable: true,
        selectHelper: true,
        select: function(start, end) {
            const date = moment(start).format('YYYY-MM-DD');
            const isSelected = bookedDates.includes(date);

            if (isSelected) {
                // Date is already booked, deselect it
                const index = bookedDates.indexOf(date);
                if (index > -1) {
                    bookedDates.splice(index, 1);
                }
                $(`.fc-day[data-date="${date}"]`).css('background-color', '');
            } else {
                // Date is not booked, select it
                bookedDates.push(date);
                $(`.fc-day[data-date="${date}"]`).css('background-color', '#0f9d58');
            }
            
            $('#date').val(bookedDates.join(',')); // Update hidden input with selected dates
            $('#booking-form').show();
            $('#calendar').fullCalendar('unselect');
        },
        // Render booked dates on calendar
        events: bookedDates.map(date => ({
            start: date,
            end: date,
            rendering: 'background',
            color: '#0f9d58'
        }))
    });

    $('#booking-form').on('submit', function(event) {
        event.preventDefault();
        const name = $('#name').val();
        const email = $('#email').val();
        const dates = $('#date').val().split(',');

        // Process each selected date
        dates.forEach(date => {
            const time = $('#time').val();
            const tour = $('#tour').val();

            $.ajax({
                type: 'POST',
                url: 'booking.php', // Ensure this URL matches your PHP script
                data: { name, email, date, time, tour },
                success: function(response) {
                    if (response === 'success') {
                        $('#success-message').fadeIn().delay(3000).fadeOut(); // Show success message
                        bookedDates.push(date);
                        $('#calendar').fullCalendar('renderEvent', {
                            start: date,
                            end: date,
                            rendering: 'background',
                            color: '#0f9d58'
                        }, true); // True to update the event
                    } else {
                        alert('Tour request failed. Please try again.');
                    }
                },
                error: function() {
                    alert('Tour request failed. Please try again.');
                }
            });
        });

        $('#booking-form')[0].reset(); // Reset form
        $('#booking-form').hide(); // Hide form after submission
        $('.fc-day').css('background-color', ''); // Reset background color of calendar dates
    });

    // Console log for debugging
    console.log('Script loaded');
});
