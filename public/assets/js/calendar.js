"use strict";
$(document).ready(function () {
    $('#external-events .fc-event').each(function () {
        $(this).data('event', {
            title: $.trim($(this).text()),
            stick: true
        });
        $(this).draggable({
            zIndex: 999,
            revert: true,
            revertDuration: 0
        });
    });

    $('[href="#holidays"]').on('click', function () {
        setTimeout(function () {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listMonth'
                },
                defaultDate:  new Date(),
                navLinks: true,
                businessHours: true,
                editable: true,
                droppable: true,
                drop: function (date, jsEvent, ui) {
                    var originalEventObject = $(this).data('event');
                    var copiedEventObject = $.extend({}, originalEventObject);

                    copiedEventObject.start = date.format();

                    $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                    var eventName = copiedEventObject.title;
                     var eventDate = moment(copiedEventObject.start).format('YYYY-MM-DDTHH:mm:ss'); // Correct format

                    // AJAX call to save the event name and date
                    $.ajax({
                        url: 'http://localhost/hadmin-1/public/save-event',
                        method: 'POST',
                        data: {
                            eventName: eventName,
                            eventDate: eventDate,
                             _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                        },
                        success: function (response) {
                            alert('Event saved successfully.');
                        },
                        error: function () {
                            alert('Error saving event.');
                        }
                    });

                    if ($('#checkbox2').is(':checked')) {
                        $(this).remove();
                    }
                },
                events: [
                    // Your predefined events here...
                ]
            });
        }, 350);
    });

    // Event click functionality
    $('#external-events').on('click', '.fc-event', function () {
        var $this = $(this);
        var currentText = $this.text().trim();
        $this.html(`<input type="text" class="edit-event-input" value="${currentText}"> <button class="save-event-button">Save</button>`);

        $this.find('.save-event-button').on('click', function () {
            var newEventName = $this.find('.edit-event-input').val().trim();
            if (newEventName === '') {
                alert('Event name cannot be empty.');
                return;
            }

            $this.text(newEventName); // Update the text of the event
        });
    });
});

